<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveAdsRequest;
use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Exception;

class PostAdController extends Controller
{
    public function ads(SaveAdsRequest $request)
    {
        try {

            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images', $filename);
                $cardImage = Image::make(storage_path("app/public/images/$filename"));
                $cardImage->fit(400, 400, function ($constraint) {
                    $constraint->upsize();
                });
                $cardImage->save();

                $imagePath = 'storage/images/' . $filename;
            } else {
                $imagePath = 'storage/avatar/d1.png';
            }
            $ad = new Ad();
            $ad->user_id = Auth::id();
            $ad->place = $request->place;
            $ad->days = $request->days;
            $ad->night = $request->night;
            $ad->person = $request->person;
            $ad->price = $request->price;
            $ad->meal = $request->meal;
            $ad->bonfire = $request->bonfire;
            $ad->tourguide = $request->tourguide;
            $ad->description = $request->description;
            $ad->validationdate = Carbon::createFromFormat('d-m-Y', $request->validationdate);
            $ad->image = $imagePath;
            $ad->save();
            return response()->json(['message' => 'Ad Created Successfully!']);
        } catch (Exception $ex) {
            if (isset($filename)) {
                Storage::delete('public/images/' . $filename);
            }
            return response()->json(['message' => $ex->getMessage()]);
        }
    }
}
