<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Cargo\Entities\Shipment;
use Illuminate\Http\Request;
use App\Models\Consignment;
use App\Models\Transxn;
use DB;

class ShipmentController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $shipments = Shipment::where('code', 'LIKE', "%{$query}%")->limit(10)->get();
        return response()->json($shipments);
    }

    public function paid(Request $request)
    {
        $request->validate([
            'shipment_id'    => 'required|exists:shipments,id',
            'discount_type'  => 'nullable|in:percentage,fixed',
            'discount_value' => 'nullable|numeric|min:0',
            'final_total'    => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();
            $shipment = Shipment::findOrFail($request->shipment_id);
            $baseAmount = $request->final_total;

            $discountAmount = 0;
            $calculatedFinalTotal = $baseAmount;

            // Only apply discount if both discount_type and discount_value are provided
            if (!empty($request->discount_type) && $request->discount_value !== null) {
                $discountType = $request->discount_type;
                $discountValue = floatval($request->discount_value);

                if ($discountType === 'percentage') {
                    $discountAmount = ($baseAmount * $discountValue) / 100;
                } elseif ($discountType === 'fixed') {
                    $discountAmount = $discountValue;
                }

                $calculatedFinalTotal = $baseAmount - $discountAmount;

                // Prevent negative totals
                if ($calculatedFinalTotal < 0) {
                    $calculatedFinalTotal = 0;
                }
            }

            // dd($calculatedFinalTotal);
            // Optional consistency check
            if (abs($calculatedFinalTotal - $request->final_total) > 0.01) {
                throw new \Exception("Final total mismatch with discount calculation.");
            }

            // Update shipment
            $shipment->paid = 1;
            $shipment->save();

            // Generate receipt number
            $lastTransaction = Transxn::orderBy('id', 'desc')->first();
            $nextReceiptNumber = 'REC-' . str_pad(optional($lastTransaction)->id + 1, 6, '0', STR_PAD_LEFT);

            // Store transaction
            $transaction = Transxn::create([
                'shipment_id'     => $shipment->id,
                'receipt_number'  => $nextReceiptNumber,
                'discount_type'   => $request->discount_type,
                'discount_value'  => $request->discount_value ?? 0,
                'total'           => $calculatedFinalTotal,
            ]);

            DB::commit();
            return response()->json([
                'message'     => 'Payment recorded successfully.',
                'transaction' => $transaction,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error'   => 'Payment failed.',
                'message' => $th->getMessage(),
            ], 500);
        }
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

    /**
     * Get a single parcel/shipment by tracking number
     * GET /api/parcels/{tracking_number}
     */
    public function getParcelByTrackingNumber($tracking_number)
    {
        $shipment = Shipment::with(['client', 'consignment'])
            ->where('code', $tracking_number)
            ->firstOrFail();

        return response()->json([
            'id' => $shipment->id,
            'tracking_number' => $shipment->code,
            'product_name' => $shipment->description ?? null,
            'weight' => $shipment->total_weight,
            'declared_value' => $shipment->amount_to_be_collected,
            'customer' => $shipment->client ? [
                'id' => $shipment->client->id,
                'name' => $shipment->client->name ?? null,
                'email' => $shipment->client->email ?? null,
            ] : null,
            'consignment_id' => $shipment->consignment_id,
            'status' => $shipment->status_id,
            'created_at' => $shipment->created_at,
            'updated_at' => $shipment->updated_at,
        ]);
    }

    /**
     * Get parcels/shipments by status
     * GET /api/parcels/status/{status}
     */
    public function getParcelsByStatus($status)
    {
        $shipments = Shipment::where('status_id', $status)
            ->with(['client', 'consignment'])
            ->get();

        $result = $shipments->map(function ($shipment) {
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

        return response()->json($result);
    }

    /**
     * Get parcels/shipments updated since a timestamp
     * GET /api/parcels/updated-since?timestamp=YYYY-MM-DDTHH:mm:ssZ
     */
    public function getParcelsUpdatedSince(Request $request)
    {
        $timestamp = $request->query('timestamp');
        if (!$timestamp) {
            return response()->json(['error' => 'timestamp query param required'], 400);
        }
        $shipments = Shipment::where('updated_at', '>=', $timestamp)
            ->with(['client', 'consignment'])
            ->get();

        $result = $shipments->map(function ($shipment) {
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

        return response()->json($result);
    }
}