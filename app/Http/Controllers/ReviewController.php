<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function handlereview(Request $request)
    {
        try {
            // Check if the user is authenticated
            if (!$request->user()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $review = new Review();
            $review->user_id = $request->ad_owner_id;
            $review->reviewer_id = $request->reviewer_id;
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->save();

            return response()->json(['message' => 'Review saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save review'], 500);
        }
    }
}
