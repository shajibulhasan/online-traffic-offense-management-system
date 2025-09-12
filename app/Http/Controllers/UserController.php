<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    { 
        $user = Auth::user();

        $offenseList = DB::table('offense_list')
            ->where('driver_id', $user->id)
            ->select(
                'id',
                'thana_name as thana', 
                'details_offense as details',
                'fine',
                'point',
                'status',
                'created_at',
                'updated_at'
            )
            ->get();

        return view('User.index', ['offenseList' => $offenseList]);
    }
}
