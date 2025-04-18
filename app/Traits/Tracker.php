<?php

namespace App\Traits;


trait Tracker
{

    public function getTrackMapArray($cons)
    {

        try {
            switch ($cons->checkpoint) {

                case 1:
                    return $this->initalChinaMapArr();
                    break;

                case 2:
                    return $this->dispatchChinaMapArr();
                    break;

                case 3:
                    return $this->arrivalAtTransitPortMapArr();
                    break;

                case 4:
                    return $this->departTransitPortMapArr();
                    break;

                case 5:
                    return $this->arrivalLocalPortMapArr($cons);
                    break;

                case 6:
                    return $this->finalMapArr();
                    break;
                default:
                    return [];
                    break;
            }
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function initalChinaMapArr()
    {
        return [
            ['Parcel received and is being processed', '2025-05-25'],
        ];
    }

    public function dispatchChinaMapArr()
    {
        return [
            ['Parcel received and is being processed', '2025-05-25'],
            ['Parcel dispatched from China', '2025-05-25'],
        ];
    }

    public function arrivalAtTransitPortMapArr()
    {
        return [
            ['Parcel received and is being processed', '2025-05-25'],
            ['Parcel dispatched from China', '2025-05-25'],
            ['Parcel has arrived at the transit Airport', '2025-05-25'],
        ];
    }

    public function departTransitPortMapArr()
    {
        return [
            ['Parcel received and is being processed', '2025-05-25'],
            ['Parcel dispatched from China', '2025-05-25'],
            ['Parcel has arrived at the transit Airport', '2025-05-25'],
            ['Parcel has departed from the Transit Airport to Lusaka Airport', '2025-05-25'],
        ];
    }

    public function arrivalLocalPortMapArr($cons)
    {
        $data = json_decode($cons->checkpoint_date);
        return [
            ['Parcel received and is being processed', $cons->created_at->toFormattedDateString() ??''],
            ['Parcel dispatched from China', $data[0]??''],
            ['Parcel has arrived at the transit Airport', $data[1]??''],
            ['Parcel has departed from the Transit Airport to Lusaka Airport', $data[2]??'' ],
            ['Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress', $data[3]??''],
        ];
    }

    public function finalMapArr()
    {
        return [
            ['Parcel received and is being processed', '2025-05-25'],
            ['Parcel dispatched from China', '2025-05-25'],
            ['Parcel has arrived at the transit Airport', '2025-05-25'],
            ['Parcel has departed from the Transit Airport to Lusaka Airport', '2025-05-25'],
            ['Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress', '2025-05-25'],
            ['Parcel is now ready for collection in Lusaka at the Main Branch', '2025-05-25'],
        ];
    }
}