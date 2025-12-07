<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class CheckTransaction extends Controller
{
    public function checkTransaction($userId, $adId)
    {
        try {
            $transaction = Transaction::where([['user_id', $userId] , ['ad_id', $adId] , ['status', 'paid']])
                ->exists();

            return response()->json(['exists' => $transaction]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
