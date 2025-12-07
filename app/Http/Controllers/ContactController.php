<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact(Request $request)
    {
        try {

            $contact = new Contact();
            $contact->name = $request->name;
            $contact->phonenumber = $request->phonenumber;
            $contact->email = $request->email;
            $contact->message = $request->message;
            $contact->save();

            return response()->json(['message' => 'Someone will contact you soon!'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
