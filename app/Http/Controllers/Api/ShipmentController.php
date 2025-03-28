<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consignment;
use Illuminate\Http\Request;
use Modules\Cargo\Entities\Shipment;

class ShipmentController extends Controller
{


    public function search(Request $request)
    {
        $query = $request->input('query');
        $shipments = Shipment::where('code', 'LIKE', "%{$query}%")->limit(10)->get();
        return response()->json($shipments);
    }

    public function submit(Request $request)
    {;
        $shipmentIds = json_decode($request->input('shipment_id')[0], true);
        // dd($shipmentIds);

        if (!$shipmentIds || !is_array($shipmentIds)) {
            return back()->with('error', 'No shipments selected.');
        }
    
        // Update each shipment's consignment_id
        foreach ($shipmentIds as $shipmentId) {
            $shipment = Shipment::find($shipmentId);
            if ($shipment) {
                $shipment->consignment_id = $request->input('consignment_id'); // Ensure this is sent from the form
                $shipment->save();
            }
        }
        // Handle the selected shipments (e.g., save to DB, process further)
        return back()->with('success', 'Shipments successfully submitted!');
    }

    public function getShipmentsForConsignment($consignmentId)
    {
        // API endpoint to get shipments for a specific consignment
        $consignment = Consignment::with('shipments')->findOrFail($consignmentId);
        return response()->json($consignment->shipments);
    }

//     public function getShipmentsForConsignment($consignmentId)
// {
//     try {
//         $consignment = Consignment::with('shipments')
//             ->findOrFail($consignmentId);

//         return response()->json([
//             'status' => 'success',
//             'consignment_code' => $consignment->consignment_code,
//             'shipments' => $consignment->shipments->map(function ($shipment) {
//                 return [
//                     'id' => $shipment->id,
//                     'shipment_code' => $shipment->shipment_code,
//                     'origin' => $shipment->origin,
//                     'destination' => $shipment->destination,
//                     'weight' => $shipment->weight,
//                     'status' => $shipment->status,
//                     'tracking_number' => $shipment->tracking_number
//                 ];
//             })
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Unable to retrieve shipments',
//             'error' => $e->getMessage()
//         ], 404);
//     }
// }
}