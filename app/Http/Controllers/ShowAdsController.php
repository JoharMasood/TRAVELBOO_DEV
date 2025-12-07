<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ShowAdsController extends Controller
{
    public function showads()
    {
        $loggedInUserId = Auth::id();
        $currentDate = Carbon::now()->format('Y-m-d');

        $ads = User::where('id', '!=', $loggedInUserId)
            ->with(['ads' => function ($query) use ($currentDate) {
                $query->where('validationdate', '>=', $currentDate);
            }])
            ->get();

        $adsByUserName = [];
        foreach ($ads as $ad) {
            $filteredAds = $ad->ads->filter(function ($ad) use ($currentDate) {
                return $ad->validationdate >= $currentDate;
            });

            if ($filteredAds->isNotEmpty()) {
                $adsByUserName[] = [
                    'user_name' => ucfirst($ad['firstname']) . ' ' . ucfirst($ad['lastname']),
                    'user_id' => $ad['id'],
                    'ads' => $filteredAds
                ];
            }
        }

        return response()->json($adsByUserName);
    }
}
