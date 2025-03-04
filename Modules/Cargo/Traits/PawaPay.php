<?php

namespace Modules\Cargo\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
use Ramsey\Uuid\Uuid;
use App\Models\Order;
use Modules\Cargo\Entities\Shipment;

trait PawaPay
{
    public function deposit($data, $shipment_id)
    {
        // dd($data);
        // $data= [
        //     'correspondent' => 'required',
        //     'phone' => 'required',
        //     'amount' => 'required',
        //     'user_id' => 'required',
        // ];

        $shipment = Shipment::where('id', $shipment_id)->first();
    
        try {
            $depositId = Uuid::uuid4()->toString();
            $payload = $this->preparePayload($data, $depositId, $shipment);

            Log::info('Payload:', $payload);

            $response = Http::withHeaders($this->getHeaders())
                ->post('https://api.sandbox.pawapay.io/deposits', $payload);
                // dd($payload);
            if ($response->successful()) {
                return true;
            }

            throw new Exception("API request failed with status {$response->status()} and message: " . $response->body());
        } catch (Exception $e) {
            dd($e);
            // Log::error('Payment submission failed', [
            //     'exception' => $e
            // ]);
            // return response()->json([
            //     'error' => 'Failed to submit payment',
            //     'details' => $e->getMessage()
            // ], 500);
        }
    }

    private function preparePayload($data, $uuid, $shipment): array
    {

        return [
            "depositId" => (string)$uuid,//generate random uuid
            "amount" => (string)$shipment->amount_to_be_collected,
            "currency" => "ZMW",
            "correspondent" => (string)$data['correspondant'],
            "payer" => [
                "address" => ["value" => (string)$data['phone']],
                "type" => "MSISDN"
            ],
            "customerTimestamp" => now()->toIso8601String(),
            "statementDescription" => "Payment of item on Cag",
            "country" => "ZMB",
            "preAuthorisationCode" => "PMxQYqfDx",
            "metadata" => [
                ["fieldName" => "orderId", "fieldValue" => (string)$shipment->id],
                ["fieldName" => "customerId", "fieldValue" => (string)$shipment->client_id, "isPII" => true]
            ]
        ];
    }

    private function getHeaders(): array
    {
        return [
            'Content-Digest' => 'New-World Cargo Shipment',
            'Authorization' => 'Bearer eyJraWQiOiIxIiwiYWxnIjoiRVMyNTYifQ.eyJ0dCI6IkFBVCIsInN1YiI6IjI3MzkiLCJtYXYiOiIxIiwiZXhwIjoyMDU2NjEzMTY3LCJpYXQiOjE3NDEwODAzNjcsInBtIjoiREFGLFBBRiIsImp0aSI6Ijc5MDE3OWRhLTRiZDUtNGU4NS04MDliLTk3M2YzYjU2MmY5YyJ9.OWpgrIFAG8JzD-DfoSq7qfJGKA1aPsUaQu37bEciYkU0ab2cAk9VRUczuUqZlKEXPPONC74HftU3ox9nc0YePQ',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }
}