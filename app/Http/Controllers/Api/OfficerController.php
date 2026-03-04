<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OfficerController extends Controller
{
    /**
     * Search Driver by phone, email, license or NID
     */
   public function searchDriver(Request $request)
{
    try {
        $type = $request->query('type');
        $value = $request->query('value');

        if (!$type || !$value) {
            return response()->json([
                'success' => false,
                'message' => 'Search type and value are required'
            ], 400);
        }

        $query = DB::table('users')->where('role', 'user');

        switch ($type) {
            case 'phone':
                $query = $query->where('phone', $value);
                break;
            case 'email':
                $query = $query->where('email', $value);
                break;
            case 'license':
                $query = $query->where('license', $value);
                break;
            case 'nid':
                $query = $query->where('nid', $value);
                break;
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid search type'
                ], 400);
        }

        $driver = $query->first();

        if ($driver) {
            // Make sure email is always returned even if null
            return response()->json([
                'success' => true,
                'message' => 'Driver found successfully',
                'driver' => [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'email' => $driver->email, // Ensure email is always a string
                    'phone' => $driver->phone,
                    'nid' => $driver->nid,
                    'license' => $driver->license ?? '',
                    'role' => $driver->role,
                    'total_points' => $driver->total_points ?? 0,
                    'profile_image' => $driver->profile_image ?? null,
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No driver found with this ' . $type
            ], 404);
        }

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Add new offense
     */
    public function addOffense(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'offense_type' => 'required|string|max:255',
                'details_offense' => 'required|string',
                'fine' => 'required|numeric|min:0',
                'point' => 'required|integer|min:0',
                'driver_id' => 'required|integer|exists:users,id',
                'thana' => 'required|string|max:255',
                'officer_name' => 'required|string|max:255',
            ]);

            // Check if driver exists and is actually a driver
            $driver = DB::table('users')->where('id', $request->driver_id)->first();
            if (!$driver || $driver->role !== 'user') {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid driver ID'
                ], 400);
            }

            // Insert offense into database
            $offenseId = DB::table('offenses')->insertGetId([
                'offense_type' => $request->offense_type,
                'details_offense' => $request->details_offense,
                'fine' => $request->fine,
                'point' => $request->point,
                'driver_id' => $request->driver_id,
                'thana' => $request->thana,
                'officer_name' => $request->officer_name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Get the inserted offense
            $offense = DB::table('offenses')->where('id', $offenseId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Offense added successfully',
                'offense' => [
                    'id' => $offense->id,
                    'offense_type' => $offense->offense_type,
                    'details_offense' => $offense->details_offense,
                    'fine' => $offense->fine,
                    'point' => $offense->point,
                    'driver_id' => $offense->driver_id,
                    'thana' => $offense->thana,
                    'officer_name' => $offense->officer_name,
                    'created_at' => $offense->created_at,
                ]
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all offenses for a specific driver
     */
    public function getDriverOffenses($driverId)
    {
        try {
            $offenses = DB::table('offenses')
                ->where('driver_id', $driverId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'offenses' => $offenses
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get offense statistics
     */
    public function getOffenseStatistics()
    {
        try {
            $statistics = [
                'total_offenses' => DB::table('offenses')->count(),
                'total_fine_collected' => DB::table('offenses')->sum('fine'),
                'total_points_given' => DB::table('offenses')->sum('point'),
                'offenses_by_type' => DB::table('offenses')
                    ->select('offense_type', DB::raw('count(*) as count'))
                    ->groupBy('offense_type')
                    ->get(),
                'recent_offenses' => DB::table('offenses')
                    ->join('users', 'offenses.driver_id', '=', 'users.id')
                    ->select('offenses.*', 'users.name as driver_name')
                    ->orderBy('offenses.created_at', 'desc')
                    ->limit(10)
                    ->get()
            ];

            return response()->json([
                'success' => true,
                'statistics' => $statistics
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}