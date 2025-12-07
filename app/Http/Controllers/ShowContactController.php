<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShowContactController extends Controller
{
    public function showContact(Request $request)
    {
        try {
            $dateRange = $request->input('date_range', null);
            $contacts = null;

            if ($dateRange) {
                $startDate = null;
                $endDate = null;

                switch ($dateRange) {
                    case 'last_7_days':
                        $startDate = Carbon::now()->subDays(7)->toDateTimeString();
                        $endDate = Carbon::now()->toDateTimeString();
                        break;
                    case 'last_30_days':
                        $startDate = Carbon::now()->subDays(30)->toDateTimeString();
                        $endDate = Carbon::now()->toDateTimeString();
                        break;
                    case 'last_1_year':
                        $startDate = Carbon::now()->subYear()->toDateTimeString();
                        $endDate = Carbon::now()->toDateTimeString();
                        break;
                }

                // Retrieve contacts within the specified date range
                $contacts = Contact::whereBetween('created_at', [$startDate, $endDate])
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                // Retrieve all contacts
                $contacts = Contact::orderBy('created_at', 'desc')
                    ->get();
            }

            return response()->json($contacts);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving the contacts.'], 500);
        }
    }
}
