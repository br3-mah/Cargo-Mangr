<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Cargo\Entities\Shipment;
use App\Models\NwcReceipt;

class Transxn extends Model
{
    use HasFactory;
    protected $fillable = [
        'shipment_id',
        'receipt_number',
        'discount_type',
        'discount_value',
        'total',
        'status',
        'refunded_at',
        'refund_reason',
    ];

    protected $casts = [
        'refunded_at' => 'datetime',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function nwcReceipt()
    {
        return $this->hasOne(NwcReceipt::class, 'shipment_id', 'shipment_id');
    }

    public function isRefunded()
    {
        return $this->status === 'refunded';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}
