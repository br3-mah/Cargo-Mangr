<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Cargo\Entities\Shipment;

class NwcReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'receipt_number',
        'rate',
        'bill_usd',
        'bill_kwacha',
        'method_of_payment',
        'discount_type',
        'discount_value',
    ];

    protected $casts = [
        'rate'           => 'float',
        'bill_usd'       => 'float',
        'bill_kwacha'    => 'float',
        'discount_value' => 'float',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
