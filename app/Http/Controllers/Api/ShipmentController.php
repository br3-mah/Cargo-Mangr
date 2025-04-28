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

    

    public function getShipmentsForConsignment($consignmentId)
    {
        // API endpoint to get shipments for a specific consignment
        $consignment = Consignment::with('shipments')->findOrFail($consignmentId);
        return response()->json($consignment->shipments);
    }

    public function removeShipment($id)
    {
        $shipment = Shipment::where('id',$id)->first();
        if (!$shipment) {
            return response()->json(['success' => false, 'message' => 'Shipment not found'], 404);
        }

        $shipment->delete();

        return response()->json(['success' => true, 'message' => 'Shipment removed successfully']);
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