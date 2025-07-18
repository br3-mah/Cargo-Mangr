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
        // dd($tracking_number);
        $shipment = Shipment::with(['client', 'consignment'])
            ->where('code', $tracking_number)
            ->firstOrFail();

            // dd($shipment);
        return response()->json([
            'id' => $shipment->id,
            'tracking_number' => $shipment->code,
            'product_name' => $shipment->description ?? null,
            'weight' => $shipment->total_weight,
            'declared_value' => $shipment->amount_to_be_collected,
            'customer' => $shipment->client ? [
                'id' => $shipment->client->id,
                'name' => $shipment->client->name ?? null,
                'phone' => $shipment->client_phone ?? $shipment->client->phone,
            ] : null,
            'consignment_id' => $shipment->consignment_id,
            'status' => $shipment->status_id,
            'consignment_current_status' => $shipment->consignment ? $shipment->consignment->current_status : null,
            'consignment_current_stage_name' => $shipment->consignment ? $shipment->consignment->getCurrentStageName() : null,
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
        // Normalize the requested status for comparison
        $normalizedStatus = strtolower($status);

        // Get all shipments with their consignments
        $shipments = Shipment::with(['client', 'consignment'])->get();

        // Filter shipments by consignment status
        $filtered = $shipments->filter(function ($shipment) use ($normalizedStatus) {
            return $shipment->consignment && strtolower($shipment->consignment->status) === $normalizedStatus;
        });

        $result = $filtered->map(function ($shipment) {
            // Determine tracker status using consignment's status (pending, in_transit, delivered)
            $tracker_status = null;
            if ($shipment->consignment && $shipment->consignment->status) {
                $status = strtolower($shipment->consignment->status);
                if ($status === 'pending') {
                    $tracker_status = 'Pending';
                } elseif ($status === 'in_transit') {
                    $tracker_status = 'In Transit';
                } elseif ($status === 'delivered') {
                    $tracker_status = 'Delivered';
                } else {
                    $tracker_status = ucfirst($status);
                }
            }
            return [
                'id' => $shipment->id,
                'tracking_number' => $shipment->code,
                'customer_id' => $shipment->client_id,
                'customer_name' => $shipment->client->name,
                'customer_phone' => $shipment->client_phone ?? $shipment->client->phone,
                'weight' => $shipment->total_weight,
                'cost' => $shipment->shipping_cost,
                'status' => $shipment->status_id,
                'consignment' => $shipment->consignment,
                'tracker_status' => $tracker_status,
                'created_at' => $shipment->created_at,
                'updated_at' => $shipment->updated_at,
            ];
        });

        return response()->json($result->values());
    }

    /**
     * Get parcels/shipments updated since a timestamp
     * GET /api/parcels/updated-since?timestamp=YYYY-MM-DDTHH:mm:ssZ
     */
    public function getParcelsUpdatedSince(Request $request)
    {
        try {
            $timestamp = $request->input('timestamp');
            if (!$timestamp) {
                return response()->json(['error' => 'timestamp field required'], 400);
            }
            $shipments = Shipment::where('updated_at', '>=', $timestamp)
                ->with(['client', 'consignment'])
                ->get();

            if ($shipments->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'error' => 'No updated shipments found.'
                ], 404);
            }

            $result = $shipments->map(function ($shipment) {
                return [
                    'id' => $shipment->id,
                    'tracking_number' => $shipment->code,
                    'customer_id' => $shipment->client_id,
                    'customer_name' => $shipment->client->name,
                    'customer_phone' => $shipment->client_phone ?? $shipment->client->phone,
                    'weight' => $shipment->total_weight,
                    'cost' => $shipment->shipping_cost,
                    'status' => $shipment->status_id,
                    'consignment' => $shipment->consignment,
                    'created_at' => $shipment->created_at,
                    'updated_at' => $shipment->updated_at,
                ];
            });

            return response()->json($result);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Receive confirmation when a parcel is physically scanned into warehouse
     * POST /api/parcels/received-confirmation
     */
    public function receivedConfirmation(Request $request)
    {
        try {
            $data = $request->validate([
                'consignment_id' => 'required|integer|exists:consignments,id',
                'tracking_numbers' => 'required|array',
                'tracking_numbers.*' => 'required|string',
                'received_at' => 'nullable|date',
                'condition' => 'nullable|string',
            ]);

            $receivedAt = $data['received_at'] ?? now();
            $trackingNumbers = $data['tracking_numbers'];

            // If the first element is a stringified JSON array, decode it
            if (count($trackingNumbers) === 1 && is_string($trackingNumbers[0]) && str_starts_with(trim($trackingNumbers[0]), '[')) {
                $decoded = json_decode($trackingNumbers[0], true);
                if (is_array($decoded)) {
                    $trackingNumbers = $decoded;
                }
            }

            $updated = [];
            foreach ($trackingNumbers as $tracking_number) {
                $shipment = Shipment::where('code', $tracking_number)
                    ->where('consignment_id', $data['consignment_id'])
                    ->first();
                if ($shipment) {
                    $shipment->status_id = Shipment::RECIVED_STATUS;
                    $shipment->received_at = $receivedAt;
                    $shipment->condition = $data['condition'] ?? null;
                    $shipment->save();
                    $updated[] = $shipment->id;
                }
            }
            return response()->json(['success' => true, 'updated_shipments' => $updated]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Receive confirmation when parcel leaves the warehouse
     * POST /api/parcels/dispatch-confirmation
     */
    public function dispatchConfirmation(Request $request)
    {
        try {
            $data = $request->validate([
                'tracking_numbers' => 'required|array',
                'tracking_numbers.*' => 'required|string',
                'dispatch_time' => 'required|date',
                'next_destination' => 'nullable|string',
                'dispatched_by' => 'nullable|string',
            ]);

            $dispatchTime = $data['dispatch_time'];
            $trackingNumbers = $data['tracking_numbers'];

            // If the first element is a stringified JSON array, decode it
            if (count($trackingNumbers) === 1 && is_string($trackingNumbers[0]) && str_starts_with(trim($trackingNumbers[0]), '[')) {
                $decoded = json_decode($trackingNumbers[0], true);
                if (is_array($decoded)) {
                    $trackingNumbers = $decoded;
                }
            }

            $updated = [];
            foreach ($trackingNumbers as $tracking_number) {
                $shipment = Shipment::where('code', $tracking_number)->first();
                if ($shipment) {
                    $shipment->status_id = Shipment::IN_STOCK_STATUS;
                    $shipment->dispatch_time = $dispatchTime;
                    $shipment->next_destination = $data['next_destination'] ?? null;
                    $shipment->dispatched_by = $data['dispatched_by'] ?? null;
                    $shipment->save();
                    $updated[] = $shipment->id;
                }
            }
            return response()->json(['success' => true, 'updated_shipments' => $updated]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get invoice for a parcel by tracking number
     * GET /api/invoices/{tracking_number}
     */
    public function getInvoiceByTrackingNumber($tracking_number)
    {
        $shipment = Shipment::with(['client', 'consignment'])->where('code', $tracking_number)->firstOrFail();

        // Use only shipment fields for the invoice breakdown
        $amount = $shipment->amount_to_be_collected;
        $paid = $shipment->paid ?? false;
        $currency = 'USD'; // Adjust as needed or fetch from shipment if available

        $breakdown = [
            'shipping_cost' => $shipment->shipping_cost,
            'return_cost' => $shipment->return_cost,
            'amount_to_be_collected' => $shipment->amount_to_be_collected,
            'total_weight' => $shipment->total_weight,
            'volume' => $shipment->volume,
            'receipt_number' => null,
            'status' => $shipment->status_id,
            'paid' => $paid,
            'client' => $shipment->client ? [
                'id' => $shipment->client->id,
                'name' => $shipment->client->name ?? null,
                'phone' => $shipment->client_phone ?? null,
            ] : null,
            'consignment' => $shipment->consignment ? [
                'id' => $shipment->consignment->id,
                'code' => $shipment->consignment->consignment_code,
                'name' => $shipment->consignment->name,
            ] : null,
            'created_at' => $shipment->created_at,
            'updated_at' => $shipment->updated_at,
        ];

        return response()->json([
            'tracking_number' => $shipment->code,
            'amount' => $amount,
            'paid' => $paid,
            'currency' => $currency,
            'breakdown' => $breakdown,
        ]);
    }

    /**
     * Get customer details by customer_id
     * GET /api/customers/{customer_id}
     */
    public function getCustomerById($customer_id)
    {
        try {
            $client = \Modules\Cargo\Entities\Client::findOrFail($customer_id);
            // Try to get the latest shipment for this client to fetch client_phone
            $shipment = Shipment::where('client_id', $client->id)->whereNotNull('client_phone')->orderByDesc('created_at')->first();
            $shipmentPhone = $shipment ? $shipment->client_phone : null;
            return response()->json([
                'id' => $client->id,
                'name' => $client->name ?? null,
                'phone' => $client->phone ?? $shipmentPhone,
                'address' => $client->addressess,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Customer not found',
            ], 404);
        }
    }

    /**
     * Receive alerts from WMS when parcel is damaged, missing, or incorrect
     * POST /api/parcels/flag
     */
    public function flagParcel(Request $request)
    {
        $data = $request->validate([
            'tracking_number' => 'required|string',
            'reason' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        $shipment = Shipment::where('code', $data['tracking_number'])->first();
        if (!$shipment) {
            return response()->json(['error' => 'Parcel not found'], 404);
        }
        // You may want to log this in a separate table; for now, add to logs or update a field
        $shipment->flag_reason = $data['reason'];
        $shipment->flag_notes = $data['notes'] ?? null;
        $shipment->save();
        return response()->json(['success' => true, 'flagged_shipment_id' => $shipment->id]);
    }

    /**
     * Reconciliation endpoint: WMS sends scanned tracking numbers, LMS returns matched, missing, extras
     * POST /api/reconcile
     */
    public function reconcile(Request $request)
    {
        try {
            $data = $request->validate([
                'consignment_id' => 'required|integer|exists:consignments,id',
                'scanned_tracking_numbers' => 'required|array',
                'scanned_tracking_numbers.*' => 'required|string',
            ]);
            $consignment = Consignment::with('shipments')->findOrFail($data['consignment_id']);
            $expected = $consignment->shipments->pluck('code')->toArray();
            $scanned = $data['scanned_tracking_numbers'];
            $matched = array_values(array_intersect($expected, $scanned));
            $missing = array_values(array_diff($expected, $scanned));
            $extras = array_values(array_diff($scanned, $expected));
            return response()->json([
                'matched' => $matched,
                'missing' => $missing,
                'extras' => $extras,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get parcels/shipments that haven't been acknowledged by warehouse (unsynced)
     * GET /api/parcels/unsynced
     */
    public function getUnsyncedParcels(Request $request)
    {
        // Example: filter by status_id or a custom 'synced' flag if available
        $shipments = Shipment::whereNull('received_at')->with('consignment')->get();
        $result = $shipments->map(function ($shipment) {
            return [
                'tracking_number' => $shipment->code,
                'consignment_id' => $shipment->consignment_id,
                'consignment_code' => $shipment->consignment ? $shipment->consignment->consignment_code : null,
                'status' => $shipment->status_id,
            ];
        });
        return response()->json($result);
    }
}