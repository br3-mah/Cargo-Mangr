<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingStage extends Model
{
    protected $fillable = [
        'name',
        'description',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    public function trackingHistory()
    {
        return $this->hasMany(ConsignmentTrackingHistory::class);
    }
} 