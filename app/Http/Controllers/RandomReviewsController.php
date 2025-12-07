<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class RandomReviewsController extends Controller
{
    public function showRandomReviews()
    {
        $reviews = Review::with('user')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $data = [];

        foreach ($reviews as $review) {
            $reviewUser = User::find($review->reviewer_id);
            $data[] = [
                'user_name' => ucfirst($review->user->firstname) . ' ' . ucfirst($review->user->lastname),
                'user_image' => $review->user->image? $review->user->image : 'storage/avatar/default.png',
                'ratings' => $review->rating,
                'comment' => $review->comment,
            ];
        }

        return response()->json($data);
    }
}
