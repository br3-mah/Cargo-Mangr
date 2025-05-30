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