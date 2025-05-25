<?php

namespace App\Traits;


trait Tracker
{

    public function getTrackMapArray($cons)
    {
        
        try {
            switch ($cons->checkpoint) {

                case 1:
                    return $this->initalChinaMapArr($cons);
                    break;

                case 2:
                    return $this->dispatchChinaMapArr($cons);
                    break;

                case 3:
                    return $this->arrivalAtTransitPortMapArr($cons);
                    break;

                case 4:
                    return $this->departTransitPortMapArr($cons);
                    break;

                case 5:
                    return $this->arrivalLocalPortMapArr($cons);
                    break;

                case 6:
                    return $this->finalMapArr($cons);
                    break;
                default:
                    return [];
                    break;
            }
        } catch (\Throwable $th) {
            dd($th);
            // if ($th->getMessage() === 'Attempt to read property "checkpoint" on null') {
            //     session()->flash('error', 'This shipment could not be found in any Consignment');
            // } else {
            //     session()->flash('error', 'An error occurred: ' . $th->getMessage());
            // }


        }

    }

    public function initalChinaMapArr($cons)
    {
        return [
            ['Parcel received and is being processed', $cons->created_at],
        ];
    }

    public function dispatchChinaMapArr($cons)
    {
        $checkdate = json_decode($cons->checkpoint_date);
        return [
            ['Parcel received and is being processed', $cons->created_at],
            ['Parcel dispatched from China', $checkdate[0]],
        ];
    }

    public function arrivalAtTransitPortMapArr($cons)
    {
        $checkdate = json_decode($cons->checkpoint_date);
        return [
            ['Parcel received and is being processed', $cons->created_at],
            ['Parcel dispatched from China', $checkdate[0]],
            ['Parcel has arrived at the transit Airport', $checkdate[1]],
        ];
    }

    public function departTransitPortMapArr($cons)
    {
        return [
            ['Parcel received and is being processed', $cons->created_at],
            ['Parcel dispatched from China',  $checkdate[0]],
            ['Parcel has arrived at the transit Airport',  $checkdate[1]],
            ['Parcel has departed from the Transit Airport to Lusaka Airport',  $checkdate[2]],
        ];
    }

    public function arrivalLocalPortMapArr($cons)
    {
        $checkdate = json_decode($cons->checkpoint_date);
        return [
            ['Parcel received and is being processed', $cons->created_at],
            ['Parcel dispatched from China',  $checkdate[0]],
            ['Parcel has arrived at the transit Airport',  $checkdate[1]],
            ['Parcel has departed from the Transit Airport to Lusaka Airport',  $checkdate[2] ],
            ['Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress', $checkdate[3]],
        ];
    }

    public function finalMapArr($cons)
    {
        return [
            ['Parcel received and is being processed', $cons->created_at],
            ['Parcel dispatched from China',  $checkdate[0]],
            ['Parcel has arrived at the transit Airport',  $checkdate[1]],
            ['Parcel has departed from the Transit Airport to Lusaka Airport',  $checkdate[2] ],
            ['Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress', $checkdate[3]],
            ['Parcel is now ready for collection in Lusaka at the Main Branch', $checkdate[4]],
        ];
    }
}