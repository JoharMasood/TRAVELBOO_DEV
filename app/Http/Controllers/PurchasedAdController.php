<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Transaction;
use Illuminate\Http\Response;

class PurchasedAdController extends Controller
{
    public function index(Request $request)
    {
        try {
            $record = [];
            $adId = $request->input('ad_id');
            $userId = $request->input('user_id');

            // Check if user is authenticated
            if (!auth()->check()) {
                return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
            }

            $purchasedUsers = Transaction::where('ad_id', $adId)
                ->where('status', 'paid')
                ->with('purchaser', 'ownerAd', 'seller')
                ->get();

            foreach ($purchasedUsers as $purchasedUser) {
                $record[] = [
                    'buyer_name' => ucfirst($purchasedUser->purchaser->firstname) . ' ' . ucfirst($purchasedUser->purchaser->lastname),
                    'ad_seller_name' => ucfirst($purchasedUser->seller->firstname) . ' ' . ucfirst($purchasedUser->seller->lastname),
                    'ad_name' => $purchasedUser->ownerAd->place,
                    'buyer_profile' => $purchasedUser->purchaser->image
                ];
            }

            return response()->json($record);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
