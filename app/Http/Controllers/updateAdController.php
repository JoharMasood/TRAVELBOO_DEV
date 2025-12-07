<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

use App\Models\Ad;

class updateAdController extends Controller
{
    public function update(Request $request, $id)
    {
        try {
            if (!$request->user()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $ad = Auth::user()->ads()->findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ad not found.'], 404);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $cardImage = Image::make($image->getRealPath());
            $cardImage->fit(400, 400, function ($constraint) {
                $constraint->upsize();
            });
            $cardImage->save(storage_path("app/public/images/$filename"));
            $ad->image = 'storage/images/'.$filename;
        }

        $ad->place = $request['place'];
        $ad->days = $request['days'];
        $ad->night = $request['night'];
        $ad->person = $request['person'];
        $ad->price = $request['price'];
        $ad->meal = $request['meal'];
        $ad->bonfire = $request['bonfire'];
        $ad->tourguide = $request['tourguide'];
        $ad->description = $request['description'];

        if ($ad->save()) {
            return response()->json(['message' => 'Ad updated successfully.','ad'=> $ad]);
        } else {
            return response()->json(['message' => 'Failed to update ad.'], 500);
        }
    }
}
