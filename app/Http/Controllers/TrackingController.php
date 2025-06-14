<?php

namespace App\Http\Controllers;

use App\Models\Consignment;
use App\Traits\Tracker;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    use Tracker;

    public function track(Request $request)
    {
        try {
            $code = $request->get('code');
            
            if (!$code) {
                return view('cargo::adminLte.pages.shipments.tracking', [
                    'error' => 'Please enter a tracking code'
                ]);
            }

            // First try to find by shipment code
            $consignment = Consignment::where('shipment_code', $code)
                ->orWhere('code', $code)
                ->first();

            if (!$consignment) {
                return view('cargo::adminLte.pages.shipments.tracking', [
                    'error' => 'No shipment found with the provided tracking code'
                ]);
            }

            $track_map = $this->getTrackMapArray($consignment);

            return view('cargo::adminLte.pages.shipments.tracking', [
                'model' => $consignment,
                'track_map' => $track_map
            ]);

        } catch (\Exception $e) {
            \Log::error('Tracking error: ' . $e->getMessage());
            return view('cargo::adminLte.pages.shipments.tracking', [
                'error' => 'An error occurred while tracking your shipment. Please try again.'
            ]);
        }
    }
}
