<?php

namespace App\Http\Controllers;

use App\Models\UsageData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UsageDataController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Check if the user is authenticated
            if (!$request->user()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $dateRange = $request->input('date_range', 'last_7_days');
            $startDate = null;
            $endDate = null;

            switch ($dateRange) {
                case 'last_7_days':
                    $startDate = Carbon::now()->subDays(7)->toDateString();
                    $endDate = Carbon::now()->toDateString();
                    break;
                case 'last_30_days':
                    $startDate = Carbon::now()->subDays(30)->toDateString();
                    $endDate = Carbon::now()->toDateString();
                    break;
                case 'last_1_year':
                    $startDate = Carbon::now()->subYear()->toDateString();
                    $endDate = Carbon::now()->toDateString();
                    break;
            }

            // Retrieve usage data within the specified date range
            $usageData = UsageData::whereBetween('date', [$startDate, $endDate])
                ->orderBy('date')
                ->get();

            return response()->json($usageData);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving the usage data.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Check if the user is authenticated
            $requestData = $request->validate([
                'date' => 'required|date_format:d-m-y',
                'usage' => 'required|numeric',
            ]);

            $date = Carbon::createFromFormat('d-m-y', $requestData['date'])->toDateString();
            $usage = $requestData['usage'] / 60;
            // Create a new usage data record
            $usageData = UsageData::create([
                'date' => $date,
                'usage' => $usage,
            ]);

            return response()->json($usageData, 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while storing the usage data.'], 500);
        }
    }
}
