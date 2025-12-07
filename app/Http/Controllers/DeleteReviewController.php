<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteReviewController extends Controller
{
    public function deleteReview(Request $request): \Illuminate\Http\JsonResponse
    {
        $userId = $request->input('user_id');
        $reviewerId = $request->input('reviewer_id');
        $id = $request->input('id');

        // Check if the user is authenticated
//        if (!auth()->check()) {
//            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
//        }

        // Find the review matching the provided IDs
        $review = Review::where('user_id', $userId)
            ->where('reviewer_id', $reviewerId)
            ->where('id', $id)
            ->first();

        // Check if the review exists
        if (!$review) {
            return response()->json(['message' => 'Review not found'], Response::HTTP_NOT_FOUND);
        }

        // Check if the authenticated user is the owner of the review
//        if ($review->user_id !== auth()->id()) {
//            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
//        }

        // Delete the review
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
