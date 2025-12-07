<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ShowAllUserController extends Controller
{
    public function showuser(Request $request)
    {
        try {
            // Check if the user is authenticated
            if (!$request->user()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Retrieve all users
            $users = User::all();

            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch users'], 500);
        }
    }
}
