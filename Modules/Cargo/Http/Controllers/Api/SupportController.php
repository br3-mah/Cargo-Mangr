<?php

namespace Modules\Cargo\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Resources\UserCollection;
use app\Http\Helpers\ApiHelper;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Modules\Cargo\Emails\TicketSupportMail;
use Modules\Cargo\Entities\Mission;
use Modules\Cargo\Entities\BusinessSetting;
use Modules\Cargo\Entities\ShipmentSetting;
use Modules\Cargo\Entities\Shipment;
use Modules\Cargo\Entities\ShipmentMission;
use Modules\Cargo\Entities\PackageShipment;
use Modules\Cargo\Entities\Package;
use Modules\Cargo\Entities\DeliveryTime;
use Modules\Currency\Entities\Currency;
use Modules\Cargo\Entities\Client;
use Modules\Cargo\Entities\Country;
use Modules\Cargo\Entities\State;
use Modules\Cargo\Entities\Area;
use Modules\Cargo\Entities\Branch;
use Modules\Cargo\Entities\Support;

class SupportController
{
    public function ajaxSubmitTicket(Request $request){

        try {

            // Validate the request data
            $validated = $request->validate([
                'subject' => 'required|string|max:255',
                'category' => 'required|string',
                'priority' => 'required|string|in:low,medium,high,urgent',
                'shipment_number' => 'nullable|string|max:50',
                'message' => 'required|string',
                'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB each
            ]);

            // Handle file uploads
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('support_tickets', 'public');
                    $attachments[] = $path;
                }
            }
            // Create the support ticket
            $ticket = Support::create([
                'subject' => $validated['subject'],
                'category' => $validated['category'],
                'priority' => $validated['priority'],
                'shipment_number' => $validated['shipment_number'] ?? null,
                'message' => $validated['message'],
                'attachments' => json_encode($attachments), // Store as JSON array
                'user_id'=>auth()->user()->id
            ]);

            // Handle attachments
            $attachments = $request->file('attachments') ?? [];

            // Send Email
            Mail::send(new TicketSupportMail($ticket));

            return response()->json([
                'message' => 'Support ticket submitted successfully!',
                'ticket_id' => $ticket->id,
                'attachments' => $attachments
            ], 200);
        } catch (\Throwable $th) {
            dd($th);
        }

    }
}