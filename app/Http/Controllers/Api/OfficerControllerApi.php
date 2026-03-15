<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OfficerControllerApi extends Controller
{
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
                'thana_name' => 'required|string|max:255',
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
            $offenseId = DB::table('offense_list')->insertGetId([
                'offense_type' => $request->offense_type,
                'details_offense' => $request->details_offense,
                'fine' => $request->fine,
                'point' => $request->point,
                'driver_id' => $request->driver_id,
                'thana_name' => $request->thana,
                'officer_id' => $request->officer_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Get the inserted offense
            $offense = DB::table('offense_list')->where('id', $offenseId)->first();

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
                    'thana_name' => $offense->thana_name,
                    'officer_id' => $offense->officer_id,
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

     public function offenseList(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'type' => 'required|in:phone,email,license,nid',
                'value' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $type = $request->query('type', $request->input('type'));
            $value = $request->query('value', $request->input('value'));
            
            Log::info('Offense List Request', [
                'type' => $type, 
                'value' => $value,
                'all_params' => $request->all()
            ]);

            // First find the driver
            $query = DB::table('users')->where('role', 'user');

            switch ($type) {
                case 'phone':
                    $query->where('phone', $value);
                    break;
                case 'email':
                    $query->where('email', $value);
                    break;
                case 'license':
                    $query->where('license', $value);
                    break;
                case 'nid':
                    $query->where('nid', $value);
                    break;
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid search type'
                    ], 400);
            }

            $driver = $query->first();

            if (!$driver) {
                return response()->json([
                    'success' => false,
                    'message' => 'No driver found with this ' . $type,
                    'data' => []
                ], 404);
            }

            // Get offenses for this driver


            $offenses = DB::table('offense_list as o')
                ->leftJoin('users as driver', 'o.driver_id', '=', 'driver.id')
                ->leftJoin('users as officer', 'o.officer_id', '=', 'officer.id')
                ->where('o.driver_id', $driver->id)
                ->orderBy('o.created_at', 'desc')
                ->select(
                    'o.id',
                    'o.driver_id',
                    'o.officer_id',
                    'o.thana_name',
                    'o.details_offense',
                    'o.fine',
                    'o.point',
                    'o.status',
                    'o.transaction_id',
                    'o.created_at',
                    'driver.name as driver_name',
                    'officer.name as officer_name'
                )
                ->get()
                ->map(function($offense) {
                    return [
                        'id' => $offense->id,
                        'driver_name' => $offense->driver_name ?? 'Unknown',
                        'officer_name' => $offense->officer_name ?? 'Unknown',
                        'thana_name' => $offense->thana_name,
                        'details_offense' => $offense->details_offense,
                        'fine' => (int)$offense->fine,
                        'point' => (int)$offense->point,
                        'status' => $offense->status ?? 'unpaid',
                        'transaction_id' => $offense->transaction_id,
                        'created_at' => $offense->created_at,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Offenses found successfully',
                'driver' => [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'email' => $driver->email,
                    'phone' => $driver->phone,
                ],
                'data' => $offenses->values()->toArray(),
                'total_fine' => $offenses->sum('fine'),
                'total_points' => $offenses->sum('point'),
            ], 200);

        } catch (\Exception $e) {
            Log::error('Offense list error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Server error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an offense
     */
    public function deleteOffense(Request $request, $id)
    {
        try {
            Log::info('Delete offense request', ['id' => $id]);

            // Check if offense exists
            $offense = DB::table('offense_list')->where('id', $id)->first();

            if (!$offense) {
                return response()->json([
                    'success' => false,
                    'message' => 'Offense not found'
                ], 404);
            }

            // Optional: Check if user has permission to delete
            // You can add authorization logic here

            // Delete the offense
            DB::table('offense_list')->where('id', $id)->delete();

            Log::info('Offense deleted successfully', ['id' => $id]);

            return response()->json([
                'success' => true,
                'message' => 'Offense deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Delete offense error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete offense',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     public function getOffenseById(Request $request, $id)
    {
        try {

            // Get offense details with joins
            $offense = DB::table('offense_list as o')
                ->leftJoin('users as driver', 'o.driver_id', '=', 'driver.id')
                ->leftJoin('users as officer', 'o.officer_id', '=', 'officer.id')
                ->where('o.id', $id)
                ->select(
                    'o.id',
                    'o.driver_id',
                    'o.officer_id',
                    'o.thana_name',
                    'o.details_offense',
                    'o.offense_type',
                    'o.fine',
                    'o.point',
                    'o.status',
                    'o.transaction_id',
                    'o.created_at',
                    'o.updated_at',
                    'driver.name as driver_name',
                    'driver.email as driver_email',
                    'driver.phone as driver_phone',
                    'officer.name as officer_name'
                )
                ->first();

            if (!$offense) {
                return response()->json([
                    'success' => false,
                    'message' => 'Offense not found'
                ], 404);
            }

            // Check if offense is paid - cannot edit paid offenses
            if ($offense->status === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot edit paid offense'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $offense->id,
                    'driver_id' => $offense->driver_id,
                    'officer_id' => $offense->officer_id,
                    'thana_name' => $offense->thana_name,
                    'details_offense' => $offense->details_offense,
                    'offense_type' => $offense->offense_type,
                    'fine' => (int)$offense->fine,
                    'point' => (int)$offense->point,
                    'status' => $offense->status,
                    'transaction_id' => $offense->transaction_id,
                    'driver_name' => $offense->driver_name,
                    'driver_email' => $offense->driver_email,
                    'driver_phone' => $offense->driver_phone,
                    'officer_name' => $offense->officer_name,
                    'created_at' => $offense->created_at,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Get offense error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update offense (API)
     */
    public function updateOffense(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'offense_type' => 'required|string|max:255',
                'details_offense' => 'required|string',
                'fine' => 'required|numeric|min:0',
                'point' => 'required|integer|min:0',
            ]);

            $updated = DB::table('offense_list')
                ->where('id', $id)
                ->update([
                    'offense_type' => $request->offense_type,
                    'details_offense' => $request->details_offense,
                    'fine' => $request->fine,
                    'point' => $request->point,
                    'updated_at' => now(),
                ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Offense updated successfully'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Offense not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
