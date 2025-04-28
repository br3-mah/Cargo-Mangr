<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consignment;
use Illuminate\Http\Request;
use Modules\Cargo\Entities\Shipment;

class ConsignmentController extends Controller
{
    public function searchConsignments(Request $request)
    {
        $query = $request->query('query');
        $results = Consignment::where('consignment_code', 'LIKE', "%{$query}%")
                              ->orWhere('name', 'LIKE', "%{$query}%")
                              ->limit(10)
                              ->get(['id', 'consignment_code as code', 'name']);

        return response()->json($results);
    }



    /**
     * Add shipments to a consignment
     */
    public function addShipmentsToConsignment(Request $request)
    {
        $shipmentIds = $request->input('shipment_ids');
        $consignmentId = $request->input('consignment_id');
        $consignment = Consignment::findOrFail($consignmentId);

        try {
            // Update the consignment_id for all selected shipments
            foreach ($shipmentIds as $shipmentId) {
                $shipment = Shipment::find($shipmentId);
                if ($shipment) {
                    $shipment->consignment_id = $consignmentId; // Ensure this is sent from the form
                    $shipment->save();
                }
            }
            return response()->json([
                'success' => true,
                'message' => count($shipmentIds) . ' shipments added to the consignment successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding shipments: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove a shipment from a consignment
     */
    public function removeShipmentFromConsignment($consignmentId, $shipmentId)
    {
        try {
            // Find the shipment and remove it from the consignment
            $shipment = Shipment::where('id', $shipmentId)
                ->where('consignment_id', $consignmentId)
                ->firstOrFail();

            // Remove association with consignment
            $shipment->consignment_id = null;
            $shipment->save();

            return response()->json([
                'success' => true,
                'message' => 'Shipment removed from consignment successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing shipment: ' . $e->getMessage()
            ]);
        }
    }

}