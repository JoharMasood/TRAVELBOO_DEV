<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPanelReviewController extends Controller
{

    public function showreviews(Request $request)
    {
        $query = $request->input('query');

        $reviews = Review::with(['user'])
            ->whereHas('user', function ($userQuery) use ($query) {
                $userQuery->where('firstname', 'like', '%' . $query . '%')
                    ->orWhere('lastname', 'like', '%' . $query . '%');
            })
            ->get();
        $data = [];
        // Retrieve the user details associated with reviewer_id
        foreach ($reviews as $review) {
            $reviewUser = User::find($review->reviewer_id);
            $data[] = [
                'review_id' => $review->id,
                'reviewer_id' => $review->reviewer_id,
                'user_id' => $review->user_id,
                'ratings' => $review->rating,
                'comment' => $review->comment,
                'reviewer_name' => ucfirst($reviewUser->firstname) . ' ' . ucfirst($reviewUser->lastname),
                'reviewer_image' => $reviewUser->image,
                'user_name' => ucfirst($review->user->firstname) . ' ' . ucfirst($review->user->lastname),
                'user_image' => $review->user->image,
            ];
        }
        return response()->json($data);
    }
}
