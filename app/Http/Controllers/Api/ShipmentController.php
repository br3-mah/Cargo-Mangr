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