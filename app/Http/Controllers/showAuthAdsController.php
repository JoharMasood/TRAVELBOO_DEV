<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class showAuthAdsController extends Controller
{
    public function authads(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $userId = auth()->user()->id;

        $query = Ad::where('user_id', $userId);

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('place', 'like', '%' . $searchTerm . '%');
        }

        $ads = $query->get();
        return $ads;
    }
}
