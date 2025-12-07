<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DeleteUserController extends Controller
{
    public function destroy(Request $request, $id)
    {
        // Check if the user is authenticated
//        if (!auth()->check()) {
//            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
//        }

        // Find the user to be deleted
        $user = User::findOrFail($id);

        // Check if the authenticated user is the owner of the user account
//        if ($user->id !== auth()->id()) {
//            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
//        }

        try {
            DB::beginTransaction();

            // Delete associated ads
            $user->ads()->delete();

            // Delete associated transactions
            $user->transactions()->delete();

            // Delete associated reviews
            $user->reviews()->delete();

            // Delete the user
            $user->delete();

            DB::commit();

            return response()->json(['message' => 'User and associated data deleted successfully']);
        } catch (QueryException $exception) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while deleting the user'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
