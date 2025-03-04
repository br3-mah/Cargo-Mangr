<?php

namespace Modules\Cargo\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Cargo\Entities\Shipment;
use Modules\Cargo\Mail\EmailManager;

class PaymentCallbackController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('cargo::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('cargo::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
{
    // Send an email notification about shipment paid status
    // Replace Order::get() with Shipment::get()
    // Replace plan_id with shipment_id
    
    // Log the request data properly by passing it as an array
    Log::info('Received payment callback request:', [$request->all()]);
    $array['view'] = 'emails.view';
    $array['subject'] = "Payment Status | ".$request->app_name;
    if (!filter_var(env('MAIL_USERNAME'), FILTER_VALIDATE_EMAIL)) {
        $array['from'] = env('MAIL_FROM_ADDRESS');
    }else{
        $array['from'] = env('MAIL_USERNAME');
    }
    
    try {
        if ($request->status === 'COMPLETED') {
            // Parse the incoming request
            $data = $request->all();

            // Validate required metadata before accessing it
            if (!isset($data['metadata']['customerId']) || !isset($data['metadata']['shipmentId'])) {
                return response()->json(['error' => 'Invalid metadata provided'], 400);
            }

            // Find the payer user by customerId from metadata
            $payer = User::where('id', $data['metadata']['customerId'])->first();

            if (!$payer) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Find the shipment by shipmentId from metadata
            $shipment = Shipment::where('id', (int)$data['metadata']['orderId'])->first();

            if ($shipment) {
                // Log payment data or create the payment record
                $this->createPayment($data, $shipment);
                
                // Handle shipment-specific logic
                switch ($shipment->type) {
                    case 'cargo_shipment':
                        // Handle cargo shipment payment logic
                        $shipment->status = 'paid';
                        $shipment->paid_amount = $data['depositedAmount'];
                        $shipment->paid_at = now();
                        $shipment->save();

                        // Notify user about the payment success for cargo shipment
                        // $payer->notify(new PaymentMade(
                        //     'Your cargo shipment payment has been processed successfully.',
                        //     'Cargo Shipment Payment'
                        // ));
                        $array['content'] = [
                            'Header' => 'Cargo Shipment Payment',
                            'Message' => 'Your cargo shipment payment has been processed successfully.',
                        ];
                        Mail::to($payer)->queue(new EmailManager($array));
                        break;

                    case 'express_shipment':
                        // Handle express shipment payment logic
                        $shipment->status = 'paid';
                        $shipment->paid_amount = $data['depositedAmount'];
                        $shipment->paid_at = now();
                        $shipment->save();

                        // Notify user about the payment success for express shipment
                        // $payer->notify(new PaymentMade(
                        //     'Your express shipment payment has been processed successfully.',
                        //     'Express Shipment Payment'
                        // ));
                        $array['content'] = [
                            'Header' => 'Cargo Shipment Payment',
                            'Message' => 'Your cargo shipment payment has been processed successfully.',
                        ];
                        Mail::to($payer)->queue(new EmailManager($array));
                        break;

                    default:
                        // If shipment type is not recognized, do nothing or log for future investigation
                        Log::warning('Unknown shipment type: ' . $shipment->type);
                        break;
                }
                
                // Update shipment status to reflect payment was made
                $shipment->status = 'paid';
                $shipment->save();

                // Return success response
                return response()->json(['message' => 'Payment processed successfully'], 200);
            } else {
                return response()->json(['error' => 'Shipment not found'], 404);
            }
        }
    } catch (\Throwable $th) {
        // Log the exception properly with context as an array
        Log::error('Error processing payment callback:', ['exception' => $th]);

        return response()->json(['error' => 'An error occurred while processing the payment'], 500);
    }
}


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('cargo::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('cargo::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}