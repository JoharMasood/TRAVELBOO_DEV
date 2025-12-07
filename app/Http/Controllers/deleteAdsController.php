<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class deleteAdsController extends Controller
{
    public function destroy($id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $ad = Ad::findOrFail($id);

        if ($ad->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $ad->delete();

        return response()->json(['message' => 'Ad deleted successfully']);
    }
}
