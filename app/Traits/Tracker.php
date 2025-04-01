<?php

namespace App\Traits;


trait Tracker
{

    public function getTrackMapArray($id)
    {
        try {
            switch ($id) {

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
                    return $this->arrivalLocalPortMapArr();
                    break;

                case 6:
                    return $this->finalMapArr();
                    break;
                default:
                    return $this->initalChinaMapArr();
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

    public function arrivalLocalPortMapArr()
    {
        return [
            ['Parcel received and is being processed', '2025-05-25'],
            ['Parcel dispatched from China', '2025-05-25'],
            ['Parcel has arrived at the transit Airport', '2025-05-25'],
            ['Parcel has departed from the Transit Airport to Lusaka Airport', '2025-05-25'],
            ['Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress', '2025-05-25'],
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