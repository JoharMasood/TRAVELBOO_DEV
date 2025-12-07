<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class filterAndSortAdsController extends Controller
{
    public function filterAndSortAds(Request $request)
    {
        $searchQuery = $request->get('query');
        $sortOrder = $request->get('sort_order');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');

        $loggedInUserId = Auth::id();
        $currentDate = Carbon::now()->format('Y-m-d');
        $paidAds = Transaction::where('status' , 'paid')->pluck('ad_id');
        $ads = User::where('id', '!=', $loggedInUserId)
//            ->where('transactions', function ($queryBuilder) {
//                $queryBuilder->where('status', '!=','paid');
//            })
            ->whereHas('ads', function ($queryBuilder) use ($paidAds, $currentDate, $searchQuery) {
                $queryBuilder->where('validationdate', '>=', $currentDate)->whereNotIn('id' , $paidAds);
                if ($searchQuery) {
                    $queryBuilder->where('place', 'like', "%{$searchQuery}%")->whereNotIn('id' , $paidAds);
                }
            })
            ->with(['ads' => function ($queryBuilder) use ($paidAds, $currentDate, $searchQuery) {
                $queryBuilder->where('validationdate', '>=', $currentDate)->whereNotIn('id' , $paidAds);
                if ($searchQuery) {
                    $queryBuilder->where('place', 'like', "%{$searchQuery}%")->whereNotIn('id' , $paidAds);
                }
            }])->get();

        $adsByUserName = [];
        foreach ($ads as $ad) {
            $filteredAds = $ad->ads->filter(function ($ad) use ($currentDate, $searchQuery, $minPrice, $maxPrice) {
                return $ad->validationdate >= $currentDate && (!$searchQuery || stripos($ad->place, $searchQuery) !== false) && (!$minPrice || $ad->price >= $minPrice) && (!$maxPrice || $ad->price <= $maxPrice);
            });

            if ($filteredAds->isNotEmpty()) {
                $adsByUserName[] = [
                    'user_name' => ucfirst($ad->firstname) . ' ' . ucfirst($ad->lastname),
                    'user_id' => $ad->id,
                    'ads' => $filteredAds->values()->all()
                ];
            }
        }

        switch ($sortOrder) {
            case 'price_high_to_low':
                $adsByUserName = $this->sortByPriceHighToLow($adsByUserName);
                break;
            case 'price_low_to_high':
                $adsByUserName = $this->sortByPriceLowToHigh($adsByUserName);
                break;
            case 'recently_added':
                $adsByUserName = $this->sortByRecentlyAdded($adsByUserName);
                break;
        }

        return response()->json($adsByUserName);
    }

    private function sortByPriceHighToLow($adsByUserName)
    {
        return collect($adsByUserName)->map(function ($item) {
            $item['ads'] = collect($item['ads'])->sortByDesc('price')->values()->all();
            return $item;
        })->toArray();
    }

    private function sortByPriceLowToHigh($adsByUserName)
    {
        return collect($adsByUserName)->map(function ($item) {
            $item['ads'] = collect($item['ads'])->sortBy('price')->values()->all();
            return $item;
        })->toArray();
    }

    private function sortByRecentlyAdded($adsByUserName)
    {
        return collect($adsByUserName)->map(function ($item) {
            $item['ads'] = collect($item['ads'])->sortByDesc(function ($ad) {
                return $ad->created_at;
            })->values()->all();
            return $item;
        })->sortByDesc(function ($item) {
            return optional($item['ads'][0])->created_at;
        })->values()->all();
    }
}
