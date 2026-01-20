<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficerController extends Controller
{
    public function addOffense()
    {
        $thana_list = DB::table('thana')->get();
        return view('Officer.addOffense', compact( 'thana_list'));
    }
public function createAddOffense(Request $request)
{
    $request->validate([
        'driver_id'       => ['required', 'exists:users,id'],
        'thana_name'      => ['required', 'string', 'max:250'],
        'details_offense' => ['required', 'string', 'max:500'],
        'fine'            => ['required'],
        'point'           => ['required'],
    ]);

    $create = DB::table('offense_list')->insert([
        'driver_id'       => $request->driver_id,
        'officer_id'      => auth()->user()->id,
        'thana_name'      => $request->thana_name,
        'details_offense' => $request->details_offense,
        'fine'            => $request->fine,
        'point'           => $request->point,
        'created_at'      => now(),
        'updated_at'      => now(),
    ]);

  

    if ($create) {
        return redirect()->route('Officer.addOffense')->with('success', 'Offense created successfully');
    } else {
        return redirect()->route('Officer.addOffense')->with('error', 'Failed to create offense');
    }
}


    public function searchDriver(Request $request)
    {
        $request->validate([
            'type'  => 'required|in:phone,email,license,nid',
            'value' => 'required|string|max:255',
        ]);
        if ($request->type === 'license') {
            $column = 'license';
        } elseif ($request->type === 'nid') {
            $column = 'nid';
        } else {
            $column = $request->type; // phone বা email
        }
        $driver = DB::table('users')
            ->where($column, $request->value)
            ->where('role', 'user')
            ->first();
        if ($driver) {
            return response()->json([
                'success' => true,
                'driver'  => [
                    'id'   => $driver->id,
                    'name' => $driver->name
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Driver not found'
            ]);
        }
    }


    public function offenseList(Request $request)
    {
        $Offense_list = [];

        if ($request->has(['type', 'value'])) {
            $type = $request->query('type');
            $value = $request->query('value');
            $column = $type === 'license' ? 'license' : $type;

            $driver = DB::table('users')
                ->where($column, $value)
                ->where('role', 'user')
                ->first();

            if ($driver) {
                $Offense_list = DB::table('offense_list')
                    ->join('users as officers', 'offense_list.officer_id', '=', 'officers.id')
                    ->join('users as drivers', 'offense_list.driver_id', '=', 'drivers.id')
                    ->where('offense_list.driver_id', $driver->id)
                    ->select(
                        'offense_list.*',
                        'officers.name as officer_name',
                        'drivers.name as driver_name'
                    )
                    ->get();
            }
        }

        if ($request->ajax() || $request->has('ajax')) {
            return response()->json([
                'success' => true,
                'data' => $Offense_list
            ]);
        }

        return view('Officer.offenseList', compact('Offense_list'));
    }

public function editOffense($id)
{
  
    $offense = DB::table('offense_list')
        ->join('users', 'offense_list.driver_id', '=', 'users.id')
        ->where('offense_list.id', $id)
        ->select('offense_list.*', 'users.name as driver_name')
        ->first();

    return view('Officer.updateOffense', compact('offense'));
}

public function updateOffense(Request $request, $id)
{
   
    $driver = DB::table('users')
        ->where('id', $request->driver_id) 
        ->first();

    $update = DB::table('offense_list')
        ->where('id', $id)
        ->update([
            'driver_id'       => $driver->id,
            'officer_id'      => auth()->id(),
            'thana_name'      => $request->thana_name,
            'details_offense' => $request->details_offense,
            'fine'            => $request->fine,
            'point'           => $request->point,
            'updated_at'      => now(),
        ]);

    return $update
        ? redirect()->route('Officer.offenseList')->with('success', 'Offense updated successfully')
        : redirect()->route('Officer.offenseList')->with('error', 'Failed to update offense');
}

}
