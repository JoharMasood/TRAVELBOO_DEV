<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateImageController extends Controller
{
    public function updateImage(Request $request)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $user = auth()->user();
            $user->image = $request->image;
            $user->save();
            return response()->json(['message' => 'Image updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the image'], 500);
        }
    }
}
