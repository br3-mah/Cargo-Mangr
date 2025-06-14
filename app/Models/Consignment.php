<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Cargo\Entities\Shipment;
use Carbon\Carbon;

class Consignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'checkpoint',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : 'N/A';
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : 'N/A';
    }

    public function getFormattedEtaAttribute()
    {
        return $this->eta ? $this->eta->format('Y-m-d H:i:s') : 'N/A';
    }

    public function getFormattedCargoDateAttribute()
    {
        return $this->cargo_date ? $this->cargo_date->format('Y-m-d H:i:s') : 'N/A';
    }

    public function getFormattedArrivalDateAttribute()
    {
        return $this->arrival_date ? $this->arrival_date->format('Y-m-d H:i:s') : 'N/A';
    }

    public function getFormattedDepartureDateAttribute()
    {
        return $this->departure_date ? $this->departure_date->format('Y-m-d H:i:s') : 'N/A';
    }

    public function getShipmentCountAttribute()
    {
        return $this->shipments()->count();
    }

    /**
     * Get the shipments for the consignment.
     */
    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function trackingHistory()
    {
        return $this->hasMany(ConsignmentTrackingHistory::class);
    }

    public function getTrackingStages()
    {
        return [
            1 => 'Parcel received and is being processed',
            2 => 'Parcel dispatched from China',
            3 => 'Parcel has arrived at the transit Airport',
            4 => 'Parcel has departed from the Transit Airport to Lusaka Airport',
            5 => 'Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress',
            6 => 'Parcel is now ready for collection in Lusaka at the Main Branch'
        ];
    }

    public function getCurrentStage()
    {
        return $this->checkpoint ?? 0;
    }

    public function getCurrentStageName()
    {
        $stages = $this->getTrackingStages();
        return $stages[$this->checkpoint] ?? 'Unknown';
    }

    public function updateCheckpoint($stageId)
    {
        if ($stageId < 1 || $stageId > 6) {
            return false;
        }

        $this->checkpoint = $stageId;
        
        // Update status based on checkpoint
        if ($stageId > 1) {
            $this->status = 'in_transit';
        }
        if ($stageId > 5) {
            $this->status = 'delivered';
        }

        return $this->save();
    }

    public function updateTrackingStage($stageId, $data = [])
    {
        try {
            // If moving to an earlier stage, ensure we don't have duplicate entries
            $existingEntry = $this->trackingHistory()
                ->where('stage_id', $stageId)
                ->first();

            if ($existingEntry) {
                // Update existing entry
                $existingEntry->update([
                    'status' => 'completed',
                    'notes' => $data['notes'] ?? $existingEntry->notes,
                    'location' => $data['location'] ?? $existingEntry->location,
                    'updated_by' => auth()->id(),
                    'completed_at' => isset($data['completed_at']) ? Carbon::parse($data['completed_at']) : Carbon::now()
                ]);
            } else {
                // Create new tracking history entry
                $this->trackingHistory()->create([
                    'stage_id' => $stageId,
                    'status' => 'completed',
                    'notes' => $data['notes'] ?? null,
                    'location' => $data['location'] ?? null,
                    'updated_by' => auth()->id(),
                    'completed_at' => isset($data['completed_at']) ? Carbon::parse($data['completed_at']) : Carbon::now()
                ]);
            }

            // Update checkpoint
            $this->checkpoint = $stageId;
            
            // Update status based on checkpoint
            if ($stageId > 1) {
                $this->status = 'in_transit';
            }
            if ($stageId > 5) {
                $this->status = 'delivered';
            }
            
            $this->save();

            return true;
        } catch (\Exception $e) {
            \Log::error('Error updating tracking stage: ' . $e->getMessage());
            return false;
        }
    }
}