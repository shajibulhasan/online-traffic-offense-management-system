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
                'transaction_id',
                'created_at',
                'updated_at'
            )
            ->get();

        return view('User.index', ['offenseList' => $offenseList]);
    }
     public function show()
    {
        $user = Auth::user();
        return view('User.profileShow', compact('user'));
    }
    public function edit()
    {
        $user = Auth::user();
        return view('User.profileEdit', compact('user'));
    }

    // Update Profile
   public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|unique:users,email,' . $user->id,
        'phone'   => 'nullable|string|max:20',
        'nid'     => 'nullable|string|max:50',
        'license' => 'nullable|string|max:50',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png',
    ]);



   
    if ($request->hasFile('profile_image')) {
        if ($user->profile_image && file_exists(public_path('images/' . $user->profile_image))) {
            unlink(public_path('images/' . $user->profile_image));
        }

        $fileName = $request->file('profile_image')->getClientOriginalName();

        $request->file('profile_image')->move(public_path('images'), $fileName);

        $user->profile_image = $fileName;
    }

    // Update user info
    $user->name    = $request->name;
    $user->email   = $request->email;
    $user->phone   = $request->phone;
    $user->nid     = $request->nid;
    $user->license = $request->license;
    $user->save();

    return redirect()->route('User.profileShow')->with('success', 'Profile updated successfully!');
}

}
