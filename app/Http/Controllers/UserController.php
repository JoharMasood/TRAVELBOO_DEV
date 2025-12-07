<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function userdetail()
    {
        $x = Auth::user();
        $roles = auth()->user()->getRoleNames();

        if (count($roles) > 0) {
            $x->role = $roles[0];
        } else {
            $x->role = null;
        }

        return $x;
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'old_password' => 'required',
                'new_password' => 'nullable|min:8',
            ]);

            $user = Auth::user();

            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(['message' => 'Invalid old password'], 422);
            }
            $user->firstname = $request->first_name;
            $user->lastname = $request->last_name;
            if ($request->new_password) {
                $user->password = Hash::make($request->new_password);
            }

            $user->save();

            return response()->json(['message' => 'User updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'User update failed'], 500);
        }
    }
}
