<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignmentTrackingHistory extends Model
{
    protected $table = 'consignment_tracking_history';

    protected $fillable = [
        'consignment_id',
        'stage_id',
        'status',
        'notes',
        'location',
        'updated_by',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime'
    ];

    public function consignment()
    {
        return $this->belongsTo(Consignment::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
} 