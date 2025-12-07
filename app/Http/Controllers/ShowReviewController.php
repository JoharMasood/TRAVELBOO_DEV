<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShowReviewController extends Controller
{
    public function getRatingsAndComments($user_id)
    {
        try {
            $reviews = Review::where('user_id', $user_id)->get();

            $result = [];
            foreach ($reviews as $review) {
                $reviewer = User::find($review->reviewer_id);
                $reviewerName = $reviewer ? ucfirst($reviewer->firstname) . ' ' . ucfirst($reviewer->lastname) : 'Unknown Reviewer';
                $reviewerAvatar = $reviewer->image ? $reviewer->image : 'storage/avatar/default.png';

                $result[] = [
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'reviewer_name' => $reviewerName,
                    'reviewer_avatar' => $reviewerAvatar
                ];
            }

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Error retrieving ratings and comments: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while retrieving ratings and comments.'], 500);
        }
    }
}
