<?php

namespace App\Traits;

use App\Models\Consignment;
use Carbon\Carbon;

trait Tracker
{
    public function getTrackMapArray($cons)
    {
        if (!$cons) {
            return $this->getFallbackTrackMap();
        }

        try {
            $stages = $cons->getTrackingStages();
            $map = [];
            
            // Get tracking history for this consignment
            $trackingHistory = $cons->trackingHistory()
                ->orderBy('stage_id', 'asc')
                ->get()
                ->keyBy('stage_id');

            foreach ($stages as $stageId => $stageName) {
                $map[] = [
                    $stageName,
                    $trackingHistory->has($stageId) ? $trackingHistory[$stageId]->completed_at : null
                ];
            }

            return $map;
        } catch (\Exception $e) {
            \Log::error('Error in getTrackMapArray: ' . $e->getMessage());
            return $this->getFallbackTrackMap();
        }
    }

    private function getFallbackTrackMap()
    {
        return [
            ['Parcel received and is being processed', null],
            ['Parcel dispatched from China', null],
            ['Parcel has arrived at the transit Airport', null],
            ['Parcel has departed from the Transit Airport to Lusaka Airport', null],
            ['Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress', null],
            ['Parcel is now ready for collection in Lusaka at the Main Branch', null]
        ];
    }
}