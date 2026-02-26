<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{


    public function myOffenses(Request $request)
    {
        $userId = $request->user()->id;

        $offenses = DB::table('offense_list')
            ->where('driver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $offenses
        ]);
    }
    public function myProfile(Request $request)
    {
        $userId = $request->user()->id;
        $user = DB::table('users')->where('id', $userId)->first();

        return response()->json([
            'status' => 200,
            'data' => $user
        ]);
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'offense_id' => 'required|exists:offense_list,id',
            'payment_status' => 'required|in:paid,unpaid',
        ]);

        $offenseId = $request->input('offense_id');
        $paymentStatus = $request->input('payment_status');

        $update = DB::table('offense_list')
            ->where('id', $offenseId)
            ->update(['payment_status' => $paymentStatus]);

        if ($update) {
            return response()->json([
                'status' => 200,
                'message' => 'Payment status updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update payment status'
            ]);
        }
    }

}