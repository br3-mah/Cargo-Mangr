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
        'consignment_code',
        'name',
        'desc',
        'source',
        'destination',
        'released_by',
        'tracker',
        'voyage_no',
        'date',
        'departure_date',
        'shipping_line',
        'arrival_date',
        'eta_dar',
        'eta_lun',
        'cargo_type',
        'consignee',
        'job_num',
        'mawb_num',
        'hawb_num',
        'eta',
        'cargo_date',
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
        if ($this->cargo_type === 'sea') {
            return [
                1 => 'Parcel received and is being processed',
                2 => 'Parcel dispatched from China',
                3 => 'The Parcel has arrived at the transit Sea port',
                4 => 'The parcel has departed from the transit Sea port headed for Dar Es Salaam',
                5 => 'The parcel has arrived at the port in Dar es Salaam',
                6 => 'The parcel has left the port headed for the Nakonde Border',
                7 => 'The Parcel has arrived at the Nakonde Border, waiting for clearance',
                8 => 'The Parcel has been cleared from Nakonde and is headed for Lusaka',
                9 => 'The Parcel is now ready for collection in Lusaka at our warehouse'
            ];
        } else {
            // Default to air stages if cargo_type is 'air' or null/unspecified
            return [
                1 => 'Parcel received and is being processed',
                2 => 'Parcel dispatched from China',
                3 => 'Parcel has arrived at the transit Airport',
                4 => 'Parcel has departed from the Transit Airport to Lusaka Airport',
                5 => 'Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress',
                6 => 'Parcel is now ready for collection in Lusaka at the Main Branch'
            ];
        }
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
        $maxStage = count($this->getTrackingStages());
        if ($stageId < 1 || $stageId > $maxStage) {
            return false;
        }

        $this->checkpoint = $stageId;
        
        // Update status based on checkpoint for air and sea stages
        if ($this->cargo_type === 'sea') {
            if ($stageId > 1) {
                $this->status = 'in_transit';
            }
            if ($stageId > 8) {
                $this->status = 'delivered';
            }
        } else {
            // Air cargo type logic
            if ($stageId > 1) {
                $this->status = 'in_transit';
            }
            if ($stageId > 5) {
                $this->status = 'delivered';
            }
        }

        return $this->save();
    }

    public function updateTrackingStage($stageId, $data = [])
    {
        try {
            $maxStage = count($this->getTrackingStages());
            if ($stageId < 1 || $stageId > $maxStage) {
                throw new \Exception('Invalid stage ID for ' . $this->cargo_type . ' cargo type.');
            }
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
            if ($this->cargo_type === 'sea') {
                if ($stageId > 1) {
                    $this->status = 'in_transit';
                }
                if ($stageId > 8) {
                    $this->status = 'delivered';
                }
            } else {
                // Air cargo type logic
                if ($stageId > 1) {
                    $this->status = 'in_transit';
                }
                if ($stageId > 5) {
                    $this->status = 'delivered';
                }
            }
            
            $this->save();

            return true;
        } catch (\Exception $e) {
            \Log::error('Error updating tracking stage: ' . $e->getMessage());
            return false;
        }
    }
}