<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transxn extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'receipt_number',
        'discount_type',
        'discount_value',
        'total',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}