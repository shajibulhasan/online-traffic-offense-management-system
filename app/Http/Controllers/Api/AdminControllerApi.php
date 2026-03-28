<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminControllerApi extends Controller
{
    public function pendingOfficers()
    {
        $pendingOfficers = DB::table('users')->where('role', 'officer')->where('status', 0)->get();

        return response()->json([
            'success' => true,
            'message' => 'Pending officers fetched successfully',
            'data' => $pendingOfficers
            ],200);
    
    }

    public function approvedOfficers()
    {
        $approvedOfficers = DB::table('users')->where('role', 'officer')->where('status', 1)->get();

        return response()->json([
            'success' => true,
            'message' => 'Approved officers fetched successfully',
            'data' => $approvedOfficers
            ],200);
    
    }

    public function approveOfficer($id)
    {
        $updated = DB::table('users')->where('id', $id)->update(['status' => 1, 'updated_at' => now()]);

        if($updated)
        {
            return response()->json([
                'success' => true,
                'message' => 'Officer approved successfully',
                ],200);
        }
    }


}
