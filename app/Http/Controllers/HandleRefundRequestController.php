<?php

namespace App\Http\Controllers;

use App\Models\refund_request;
use Illuminate\Http\Request;

class HandleRefundRequestController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'image' => 'required|string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'message' => 'string',
            'ad_id' => 'required|integer',
        ]);

        // Check if a similar request already exists
        $existingRequest = refund_request::where([
            'image' => $validatedData['image'],
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'message' => 'Requested a refund',
            'ad_id' => $validatedData['ad_id'],
        ])->first();

        if ($existingRequest) {
            return response()->json(['message' => 'You have already requested a refund']);
        }

        // Create a new refund request record
        $refundRequest = new refund_request();
        $refundRequest->image = $validatedData['image'];
        $refundRequest->firstname = $validatedData['firstname'];
        $refundRequest->lastname = $validatedData['lastname'];
        $refundRequest->message = 'Requested a refund';
        $refundRequest->ad_id = $validatedData['ad_id'];
        $refundRequest->save();

        return response()->json(['message' => 'Refund request created successfully']);
    }

    public function index()
    {
        // Retrieve all refund request records
        $refundRequests = refund_request::all();

        return response()->json($refundRequests);
    }
}
