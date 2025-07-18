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

    /**
     * Get consignment info and all parcels/shipments under it
     * GET /api/consignments/{consignment_id}
     */
    public function getConsignmentWithParcels($id)
    {
        $consignment = Consignment::with(['shipments.client', 'shipments' => function($q) {
            $q->with('consignment');
        }])->findOrFail($id);
        
        $shipments = $consignment->shipments->map(function ($shipment) {
            return [
                'shipment_id' => $shipment->id,
                'tracking_number' => $shipment->code,
                'customer_id' => $shipment->client_id,
                'weight' => $shipment->total_weight,
                'declared_value' => $shipment->amount_to_be_collected,
                'status' => $shipment->status_id,
                'customer' => $shipment->client ? [
                    'id' => $shipment->client->id,
                    'name' => $shipment->client->name ?? null,
                    'phone' => $shipment->client_phone ?? $shipment->client->phone,
                ] : null,
                'consignment_id' => $shipment->consignment_id,
                'created_at' => $shipment->created_at,
                'updated_at' => $shipment->updated_at,
            ];
        });

        return response()->json([
            'consignment' => [
                'id' => $consignment->id,
                'consignment_code' => $consignment->consignment_code,
                'name' => $consignment->name,
                'status' => $consignment->status,
                'current_status' => $consignment->current_status,
                'current_stage_name' => $consignment->getCurrentStageName(),
                'cargo_type' => $consignment->cargo_type,
                'created_at' => $consignment->created_at,
                'updated_at' => $consignment->updated_at,
            ],
            'parcels' => $shipments,
        ]);
    }

    /**
     * Get the latest consignment (by created_at)
     * GET /api/consignments/latest
     */
    public function getLatestConsignment()
    {
        $consignment = Consignment::orderBy('created_at', 'desc')->with('shipments')->first();
        if (!$consignment) {
            return response()->json(['error' => 'No consignments found'], 404);
        }
        $shipments = $consignment->shipments->map(function ($shipment) {
            return [
                'id' => $shipment->id,
                'tracking_number' => $shipment->code,
                'customer_id' => $shipment->client_id,
                'weight' => $shipment->total_weight,
                'declared_value' => $shipment->amount_to_be_collected,
                'status' => $shipment->status_id,
                'consignment_id' => $shipment->consignment_id,
                'created_at' => $shipment->created_at,
                'updated_at' => $shipment->updated_at,
            ];
        });
        return response()->json([
            'consignment' => [
                'id' => $consignment->id,
                'code' => $consignment->consignment_code,
                'name' => $consignment->name,
                'status' => $consignment->status,
                'current_status' => $consignment->current_status,
                'current_stage_name' => $consignment->getCurrentStageName(),
                'cargo_type' => $consignment->cargo_type,
                'created_at' => $consignment->created_at,
                'updated_at' => $consignment->updated_at,
            ],
            'parcels' => $shipments,
        ]);
    }
}