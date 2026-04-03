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

    public function updateProfile(Request $request, $id)
    {
        $userId = $id;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $userId,
            'nid' => 'nullable|string|max:20|unique:users,nid,' . $userId,
        ]);

        $updateData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'nid' => $request->input('nid'),
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->input('password'));
        }

        $update = DB::table('users')
            ->where('id', $userId)
            ->update($updateData);

        if ($update) {
            return response()->json([
                'status' => 200,
                'message' => 'Profile updated successfully',
                'data' => DB::table('users')->where('id', $userId)->first()
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update profile'
            ]);
        }
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


    function dashboardStats(Request $request) {
        $userId = $request->user()->id;

        $totalOffenses = DB::table('offense_list')
            ->where('driver_id', $userId)
            ->count();

        $paidOffenses = DB::table('offense_list')
            ->where('driver_id', $userId)
            ->where('status', 'paid')
            ->count();

        $unpaidOffenses = DB::table('offense_list')
            ->where('driver_id', $userId)
            ->where('status', 'unpaid')
            ->count();

        return response()->json([
            'status' => 200,
            'message' => 'Dashboard stats fetched successfully',
            'data' => [
                'total_offenses' => $totalOffenses,
                'unpaid_offenses' => $unpaidOffenses
            ]
        ]);
    }

}