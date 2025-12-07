<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPurchasedAds extends Controller
{
    public function purchasedAds()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $userId = Auth::id();

        // Retrieve the purchased ads for the current logged-in user with a status of "paid"
        $purchasedAds = User::find($userId)
            ->purchasedAds()
            ->wherePivot('status', 'paid')
            ->get();

        $result = [];
        foreach ($purchasedAds as $ad) {
            $adOwner = ucfirst($ad->user->firstname) . ' ' . ucfirst($ad->user->lastname);
            $adOwnerId = $ad->user->id;

            if (!isset($result[$adOwner])) {
                $result[$adOwner] = [
                    'ad_owner' => $adOwner,
                    'ad_owner_id' => $adOwnerId,
                    'reviewer_id' => $userId,
                    'ads' => [],
                ];
            }

            $result[$adOwner]['ads'][] = $ad;
        }

        return response()->json(array_values($result));
    }
}
