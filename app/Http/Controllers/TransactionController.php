<?php

namespace App\Http\Controllers;

use App\Events\AdPurchased;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Ad;
use App\Notifications\AdPurchasedByOwnerNotification;
use App\Notifications\AdPurchasedByBuyerNotification;
use App\Events\AdOwner;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function makePayment(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $stripeApiKey = env('STRIPE_SECRET');
        Stripe::setApiKey($stripeApiKey);

        $userId = $request->user_id;
        $adId = $request->ad_id;
        $adOwnerId = $request->ad_owner_id;

        if (!$userId || !$adId) {
            return response()->json(['message' => 'Invalid user ID or ad ID.']);
        }

        $adPrice = Ad::where('id', $adId)->value('price');
        $amountInPaisa = $adPrice * 100;

        try {
            $charge = Charge::create([
                'amount' => $amountInPaisa,
                'currency' => 'pkr',
                'source' => $request->stripeToken,
                'description' => 'Payment for Ad ID ' . $adId,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        $transaction = new Transaction();
        $transaction->user_id = $userId;
        $transaction->ad_id = $adId;
        $transaction->ad_owner_id = $adOwnerId;
        $transaction->status = 'paid';
        $transaction->amount = $adPrice;
        $transaction->payment_method = 'credit card';
        $transaction->charge_id = $charge->id;
        $transaction->save();

        $adOwner = User::find($adOwnerId);
        $buyer = User::find($userId);
        $ad = Ad::find($adId);

        event(new AdPurchased($adOwner, $buyer, $ad));

        $adOwnerName = $adOwner->firstname;

        $adOwner->notify(new AdPurchasedByOwnerNotification($adId, $buyer->firstname));
        $buyer->notify(new AdPurchasedByBuyerNotification($adId, $adOwnerName));
        return response()->json(['message' => 'Payment successful.']);
    }
}
