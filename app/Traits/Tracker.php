<?php

namespace App\Traits;

use Carbon\Carbon;

trait Tracker
{
    public function getTrackMapArray($cons)
    {
        if (!$cons) {
            return [];
        }

        try {
            // Validate checkpoint dates
            if ($cons->checkpoint > 1) {
                $checkpointDates = json_decode($cons->checkpoint_date, true);
                if (!is_array($checkpointDates)) {
                    // Initialize checkpoint dates if not set
                    $checkpointDates = [];
                    for ($i = 0; $i < $cons->checkpoint; $i++) {
                        $checkpointDates[] = [
                            'date' => $cons->created_at,
                            'status' => 'created'
                        ];
                    }
                    $cons->checkpoint_date = json_encode($checkpointDates);
                    $cons->save();
                }
                
                // Ensure we have enough checkpoint dates
                while (count($checkpointDates) < $cons->checkpoint) {
                    $checkpointDates[] = [
                        'date' => $cons->created_at,
                        'status' => 'created'
                    ];
                }
                
                // Update checkpoint dates if needed
                $cons->checkpoint_date = json_encode($checkpointDates);
                $cons->save();
            }

            // Map checkpoint to tracking stages
            switch ($cons->checkpoint) {
                case 1:
                    return $this->initalChinaMapArr($cons);
                case 2:
                    return $this->dispatchChinaMapArr($cons);
                case 3:
                    return $this->arrivalAtTransitPortMapArr($cons);
                case 4:
                    return $this->departTransitPortMapArr($cons);
                case 5:
                    return $this->arrivalLocalPortMapArr($cons);
                case 6:
                    return $this->finalMapArr($cons);
                default:
                    // If checkpoint is invalid but consignment exists, return initial stage
                    return $this->initalChinaMapArr($cons);
            }
        } catch (\Throwable $th) {
            \Log::error('Tracking error: ' . $th->getMessage(), [
                'consignment_id' => $cons->id ?? 'unknown',
                'trace' => $th->getTraceAsString()
            ]);
            // If consignment exists but error occurs, return initial stage instead of fallback
            return $this->initalChinaMapArr($cons);
        }
    }

    protected function getFallbackTrackMap($cons)
    {
        // Only use fallback if consignment is null
        if (!$cons) {
            return [
                ['Shipment registered in system', Carbon::now()],
                ['Tracking information is being updated', Carbon::now()]
            ];
        }
        // Otherwise return initial stage
        return $this->initalChinaMapArr($cons);
    }

    protected function validateDate($date)
    {
        if (!$date) return Carbon::now();
        return Carbon::parse($date);
    }

    public function initalChinaMapArr($cons)
    {
        return [
            ['Parcel received and is being processed', $this->validateDate($cons->created_at)],
        ];
    }

    public function dispatchChinaMapArr($cons)
    {
        $checkdate = json_decode($cons->checkpoint_date, true);
        return [
            ['Parcel received and is being processed', $this->validateDate($cons->created_at)],
            ['Parcel dispatched from China', $this->validateDate($checkdate[0]['date'] ?? $this->validateDate($cons->created_at))],
        ];
    }

    public function arrivalAtTransitPortMapArr($cons)
    {
        $checkdate = json_decode($cons->checkpoint_date, true);
        return [
            ['Parcel received and is being processed', $this->validateDate($cons->created_at)],
            ['Parcel dispatched from China', $this->validateDate($checkdate[0]['date'] ?? $this->validateDate($cons->created_at))],
            ['Parcel has arrived at the transit Airport', $this->validateDate($checkdate[1]['date'] ?? null)],
        ];
    }

    public function departTransitPortMapArr($cons)
    {
        $checkdate = json_decode($cons->checkpoint_date, true);
        return [
            ['Parcel received and is being processed', $this->validateDate($cons->created_at)],
            ['Parcel dispatched from China', $this->validateDate($checkdate[0]['date'] ?? $this->validateDate($cons->created_at))],
            ['Parcel has arrived at the transit Airport', $this->validateDate($checkdate[1]['date'] ?? null)],
            ['Parcel has departed from the Transit Airport to Lusaka Airport', $this->validateDate($checkdate[2]['date'] ?? null)],
        ];
    }

    public function arrivalLocalPortMapArr($cons)
    {
        $checkdate = json_decode($cons->checkpoint_date, true);
        return [
            ['Parcel received and is being processed', $this->validateDate($cons->created_at)],
            ['Parcel dispatched from China', $this->validateDate($checkdate[0]['date'] ?? $this->validateDate($cons->created_at))],
            ['Parcel has arrived at the transit Airport', $this->validateDate($checkdate[1]['date'] ?? null)],
            ['Parcel has departed from the Transit Airport to Lusaka Airport', $this->validateDate($checkdate[2]['date'] ?? null)],
            ['Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress', $this->validateDate($checkdate[3]['date'] ?? null)],
        ];
    }

    public function finalMapArr($cons)
    {
        $checkdate = json_decode($cons->checkpoint_date, true);
        return [
            ['Parcel received and is being processed', $this->validateDate($cons->created_at)],
            ['Parcel dispatched from China', $this->validateDate($checkdate[0]['date'] ?? $this->validateDate($cons->created_at))],
            ['Parcel has arrived at the transit Airport', $this->validateDate($checkdate[1]['date'] ?? null)],
            ['Parcel has departed from the Transit Airport to Lusaka Airport', $this->validateDate($checkdate[2]['date'] ?? null)],
            ['Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress', $this->validateDate($checkdate[3]['date'] ?? null)],
            ['Parcel is now ready for collection in Lusaka at the Main Branch', $this->validateDate($checkdate[4]['date'] ?? null)],
        ];
    }
}