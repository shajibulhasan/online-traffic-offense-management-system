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

}