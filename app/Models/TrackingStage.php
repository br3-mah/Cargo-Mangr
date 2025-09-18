<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingStage extends Model
{
    protected $fillable = [
        'name',
        'description',
        'cargo_type',
        'order',
        'status',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    public function trackingHistory()
    {
        return $this->hasMany(ConsignmentTrackingHistory::class, 'stage_id');
    }

    public static function getStagesByCargoType($cargoType)
    {
        return self::where('cargo_type', $cargoType)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }
}