<?php

namespace App\Http\Controllers;

use App\Models\refund_request;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Stripe\Stripe;
use Stripe\Refund;
use Illuminate\Http\Response;

class RefundController extends Controller
{
    public function refundPayment(Request $request)
    {
        // Retrieve the Stripe API key from the .env file
        $stripeApiKey = env('STRIPE_SECRET');

        // Set the Stripe API key
        Stripe::setApiKey($stripeApiKey);

        // Retrieve the ad ID from the request
        $adId = $request->ad_id;

        // Validate the ad ID
        if (!$adId) {
            return response()->json(['message' => 'Invalid ad ID.']);
        }

        // Retrieve the transaction based on the ad ID from the database
        $transaction = Transaction::where('ad_id', $adId)->first();

        // Check if the transaction exists
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found.']);
        }

        // Check if the transaction has already been refunded
        if ($transaction->status === 'refunded') {
            return response()->json(['message' => 'Transaction has already been refunded.']);
        }

        // Retrieve the charge ID associated with the transaction
        $chargeId = $transaction->charge_id;

        try {
            // Create a refund using the Stripe API
            $refund = Refund::create([
                'charge' => $chargeId,
            ]);

            // Update the transaction status in the database
            $transaction->status = 'refunded';
            $transaction->save();
            refund_request::where('ad_id', $adId)->delete();
            return response()->json(['message' => 'Refund successful.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
