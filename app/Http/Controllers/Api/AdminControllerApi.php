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


    public function getThanas(){
        $thanas = DB::table('thana')->get();

        return response()->json([
            'success' => true,
            'message' => 'Thanas fetched successfully',
            'data' => $thanas
            ],200);
    }

      // Add Thana Function
    public function addThana(Request $request)
    {
        // Validate the request
        $request->validate([
            'division' => 'required|string',
            'district' => 'required|string',
            'thana_name' => 'required|string|unique:thana,thana_name',
            'contact' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        try {
            // Insert into database
             $id = DB::table('thana')->insertGetId([
                'division' => $request->division,
                'district' => $request->district,
                'thana_name' => $request->thana_name,
                'contact' => $request->contact,
                'address' => $request->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        // Get the inserted thana
        $thana = DB::table('thana')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Thana added successfully',
                'data' => $thana  
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add thana',
                'error' => $e->getMessage()
            ], 500);
        }
    }


     // Update thana
    public function updateThana(Request $request, $id)
    {
        $request->validate([
            'division' => 'required|string',
            'district' => 'required|string',
            'thana_name' => 'required|string|unique:thana,thana_name,' . $id,
            'contact' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        try {
            $updated = DB::table('thana')
                ->where('id', $id)
                ->update([
                    'division' => $request->division,
                    'district' => $request->district,
                    'thana_name' => $request->thana_name,
                    'contact' => $request->contact,
                    'address' => $request->address,
                    'updated_at' => now(),
                ]);

            $updatedThana = DB::table('thana')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Thana updated successfully',
                'data' => $updatedThana
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update thana',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get thana by id
    public function getThanaById($id)
    {
        $thana = DB::table('thana')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Thana fetched successfully',
            'data' => $thana
        ], 200);
    }


    // Delete thana
    public function deleteThana($id)
    {
        try {
            $thana = DB::table('thana')->where('id', $id)->first();
            
            if (!$thana) {
                return response()->json([
                    'success' => false,
                    'message' => 'Thana not found'
                ], 404);
            }

            DB::table('thana')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => $thana->thana_name . ' deleted successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete thana',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    // Add these functions to AdminController

    public function addArea(Request $request)
    {
        $request->validate([
            'area_name' => 'required|string|unique:area,area_name',
            'details_area' => 'required|string',
            'district' => 'required|string',
            'thana_name' => 'required|string',
        ]);

        try {
            $id = DB::table('area')->insertGetId([
                'district' => $request->district,
                'thana_name' => $request->thana_name,
                'area_name' => $request->area_name,
                'details_area' => $request->details_area,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $area = DB::table('area')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Area added successfully',
                'data' => $area
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add area'
            ], 500);
        }
    }


    public function getThanasByDistrict($district)
    {
        try {
            $thanas = DB::table('thana')->where('district', $district)->get();

            return response()->json([
                'success' => true,
                'message' => 'Thanas fetched successfully',
                'data' => $thanas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch thanas'
            ], 500);
        }
    }


    public function getAreas()
    {
        try {
            $areas = DB::table('area')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $areas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch areas'
            ], 500);
        }
    }

    public function updateArea(Request $request, $id)
    {
        $request->validate([
            'area_name' => 'required|string|unique:area,area_name,' . $id,
            'details_area' => 'required|string',
            'district' => 'required|string',
            'thana_name' => 'required|string',
        ]);

        try {
            DB::table('area')
                ->where('id', $id)
                ->update([
                    'district' => $request->district,
                    'thana_name' => $request->thana_name,
                    'area_name' => $request->area_name,
                    'details_area' => $request->details_area,
                    'updated_at' => now(),
                ]);

            $area = DB::table('area')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Area updated successfully',
                'data' => $area
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update area'
            ], 500);
        }
    }

    public function deleteArea($id)
    {
        try {
            $area = DB::table('area')->where('id', $id)->first();
            
            if (!$area) {
                return response()->json([
                    'success' => false,
                    'message' => 'Area not found'
                ], 404);
            }

            DB::table('area')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => $area->area_name . ' deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete area'
            ], 500);
        }
    }




    // Get all assigned officers
    public function getAssignedOfficers()
    {
        try {
            $assignments = DB::table('users')
                ->whereNotNull('district')
                ->whereNotNull('thana')
                ->whereNotNull('area_lead')
                ->where('role', 'officer')
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $assignments
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch assigned officers'
            ], 500);
        }
    }

    // Assign officer
    public function assignOfficer(Request $request)
    {
        $request->validate([
            'district' => 'required|string',
            'thana' => 'required|string',
            'area_lead' => 'required|string',
        ]);

        try {            
             DB::table('users')
                ->where('id', $request->officer_id)
                ->update([
                'district' => $request->district,
                'thana' => $request->thana,
                'area_lead' => $request->area_lead,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $assignment = DB::table('users')->where('id', $request->officer_id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Officer assigned successfully',
                'data' => $assignment
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign officer'
            ], 500);
        }
    }

    // Update assigned officer
    public function updateAssignedOfficer(Request $request, $id)
    {
        $request->validate([
            'district' => 'required|string',
            'thana' => 'required|string',
            'area_lead' => 'required|string',
        ]);

        try {            
            DB::table('assigned_officers')
                ->where('id', $id)
                ->update([
                    'district' => $request->district,
                    'thana' => $request->thana,
                    'area_lead' => $request->area_lead,
                    'updated_at' => now(),
                ]);

            $assignment = DB::table('users')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Assignment updated successfully',
                'data' => $assignment
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update assignment'
            ], 500);
        }
    }

    // Delete assigned officer
    public function deleteAssignedOfficer($id)
    {
        try {
            $assignment = DB::table('users')->where('id', $id)->first();
            
            if (!$assignment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Assignment not found'
                ], 404);
            }

            DB::table('users')->where('id', $id)
                ->update([
                    'district' => NULL,
                    'thana' => NULL,
                    'area_lead' => NULL,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => $assignment->name . ' unassigned successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to unassign officer'
            ], 500);
        }
    }


    public function getOfficers()
    {
        try {
            $officers = DB::table('users')->where('role', 'officer')->where('status', 1)->whereNull('district')->whereNull('thana')->whereNull('area_lead')->get();

            return response()->json([
                'success' => true,
                'message' => 'Officers fetched successfully',
                'data' => $officers
                ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch officers'
            ], 500);
        }
    }



    public function dashboardStats()
    {
        try {
            $totalOffenseCount = DB::table('offense_list')->count();
            $todayOffenseCount = DB::table('offense_list')->whereDate('created_at', now()->toDateString())->count();

            return response()->json([
                'success' => true,
                'message' => 'Dashboard stats fetched successfully',
                'data' => [
                    'total_offense' => $totalOffenseCount,
                    'today_offense' => $todayOffenseCount,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch dashboard stats'
            ], 500);
        }
    }

}
