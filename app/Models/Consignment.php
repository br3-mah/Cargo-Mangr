<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Cargo\Entities\Shipment;

class Consignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'consignment_code',
        'name',
        'desc',
        'source',
        'destination',
        'status',
        'tracker',
        'consignee',
        'job_num',
        'mawb_num',
        'handler',
        'eta',
        'cargo_date',
        'cargo_type',
        'eta_dar',
        'eta_nak',
        'eta_lun',
        'voyage_no',
        'date',
        'departure_date',
        'shipping_line',
        'arrival_date'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'eta',
        'cargo_date',
        'eta_dar',
        'eta_nak',
        'eta_lun',
        'date',
        'departure_date',
        'arrival_date'
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
        return $this->eta ? $this->eta->format('Y-m-d') : 'N/A';
    }

    public function getFormattedCargoDateAttribute()
    {
        return $this->cargo_date ? $this->cargo_date->format('Y-m-d') : 'N/A';
    }

    public function getFormattedArrivalDateAttribute()
    {
        return $this->arrival_date ? $this->arrival_date->format('Y-m-d') : 'N/A';
    }

    public function getFormattedDepartureDateAttribute()
    {
        return $this->departure_date ? $this->departure_date->format('Y-m-d') : 'N/A';
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
}