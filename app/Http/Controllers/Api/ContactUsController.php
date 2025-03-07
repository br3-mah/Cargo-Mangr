<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactNotification;
use App\Models\ContactUs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
        public function sendContact(Request $request): JsonResponse
        {
            // Validate input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string|max:2000',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            // Save to database
            ContactUs::create($request->all());
    
            // Send email to admin
            $adminEmail = 'admin@example.com'; // Replace with actual admin email
            Mail::to($adminEmail)->send(new ContactNotification($request->all()));
    
            // Send confirmation email to the user
            Mail::to($request->email)->send(new ContactNotification([
                'name' => $request->name,
                'email' => $request->email,
                'message' => "Thank you for contacting us. We have received your message and will respond soon."
            ]));
    
            return response()->json(['success' => true, 'message' => 'Message sent successfully.'], 200);
        }
}