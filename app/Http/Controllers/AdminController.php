<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('Admin.index');
    }
    // public function AssignDistrict()
    // {
    //     return view('Admin.assignDistrict');
    // }
    // public function AssignDistrictList()
    // {
    //     return view('Admin.assignDistrictList');
    // }
    public function divission()
    {
        return view('Admin.divission');
    }
    public function addThana()
    {
        return view('Admin.addThana');
    }
    public function addArea()
    {
        return view('Admin.addArea');
    }
    public function area_list()
    {
        return view('Admin.areaList');
    }
    public function assignOfficer()
    {
        return view('Admin.assignOfficer');
    }
    public function assignOfficerList()
    {
        return view('Admin.assignOfficerList');
    }
    public function verifyOfficerAccount()
    {
        return view('Admin.verify-officer-account');
    }

    public function assign_thana()
    {

        return view('Admin.assign-thana');
    }
    public function showing_assign_thana()
    {

        return view('Admin.show-assign-thana');
    }

    //start the area part

    public function area(Request $request)
    {
        $request->validate(
            [
                'area_name' => 'required',
                'details_area' => 'required',
            ],
            [
                'area_name.required' => 'are field is required',
                'details_area.required' => 'details field is required'
            ]
        );
    
        $area_create = DB::table('area')->insert([
            'area_name' => $request->area_name,
            'details_area' => $request->details_area,
        ]);
    
        if ($area_create) {
            return redirect()->back()->with('success', 'Area added successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to add area');
        }
    }
        
    public function areaList()
    {
        $areas = DB::table('area')->get();
        return view('Admin.areaList', compact('areas'));
    }
    
    public function updateArea(Request $request, $id)
    {
        
        if ($request->isMethod('POST')) {
            $validatedData = $request->validate([
                'area_name' => 'required|string|max:255',
                'details_area' => 'required|string|max:255',
            ]);
            $updated = DB::table('area') 
                        ->where('id', $id) 
                        ->update([
                            'area_name' => $validatedData['area_name'],
                            'details_area' => $validatedData['details_area'],
                        ]);
  
            if ($updated) {
                return redirect()->route('Admin.updateArea', $id)
                                 ->with('success', 'Area updated successfully');
            } else {
                return redirect()->route('Admin.updateArea', $id)
                                 ->with('error', 'Area update failed. No changes made.');
            }
        }
    
        $area = DB::table('area')->where('id', $id)->first(); 
        return view('Admin.updateArea', compact('area'));
    }
    
    
    public function areadestroy($id)
    {
        try {
            // Using the DB facade to delete the record
            DB::table('area')->where('id', $id)->delete();
            return redirect()->route('Admin.areaList')->with('success', 'area deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('Admin.areaList')->with('error', $e->getMessage());
        }
    }
// strat thana part 
    public function Createthana(Request $req)
    {
        $req->validate(
        [
            'district_name' => 'required',
            'thana_name' => 'required|string|max:255',
            'contact' => 'required|numeric',
            'address' => 'required|string|max:500',
        ], [
            'district_name.required' => 'District field is required',
            'thana_name.required' => 'Thana name field is required',
            'contact.required' => 'Number field is required',
            'address.required' => 'Address field is required',
        ]);
    
        // Insert thana into the 'thana' table
        $thana_create = DB::table('thana')->insert([
            'district_name' => $req->district_name,
            'thana_name' => $req->thana_name,
            'contact' => $req->contact,
            'address' => $req->address,
        ]);

        if ($thana_create) {
            return redirect()->back()->with('success', 'thana added successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to add thana');
        }
    }
        
    public function thanaList()
    {
        $thanas = DB::table('thana')->get();
        return view('Admin.thanaList', compact('thanas'));
    }
    public function thanadestroy($id)
    {
        try {
            
            DB::table('thana')->where('id', $id)->delete();
            return redirect()->route('Admin.thanaList')->with('success', 'Thana deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('Admin.thanaList')->with('error', $e->getMessage());
        }
    }

    public function updateThana(Request $request, $id)
    {
        if ($request->isMethod('POST')) {  // Using POST instead of PUT
            $request->validate([
                'district_name' => 'required|string|max:255',
                'thana_name' => 'required|string|max:255',  
                'contact' => 'required|string|max:20',
                'address' => 'required|string',
            ]);
    
            $updated = DB::table('thana')
                        ->where('id', $id)
                        ->update([
                            'district_name' => $request->district_name,
                            'thana_name' => $request->thana_name,  
                            'contact' => $request->contact,
                            'address' => $request->address,
                        ]);
    
            if ($updated) {
                return redirect()->route('Admin.updateThana', $id)
                                 ->with('success', 'Thana updated successfully');
            } else {
                return redirect()->route('Admin.updateThana', $id)
                                 ->with('error', 'Thana update failed');
            }
        }
    
        $thana = DB::table('thana')->where('id', $id)->first();
    
        return view('Admin.updateThana', compact('thana'));
    }
  // Assign district information

    public function assignDistrict()
    {
        $officers = DB::table('users')
            ->whereNull('thana_lead')
            ->whereNull('district_lead')
            ->where('role', 'officer')
            ->where('status', 1)
            ->get();

        return view('Admin.assignDistrict', compact('officers'));
    }

    public function CreateAssign(Request $request)
    {
        $request->validate([
            'officer_name' => 'required',
            'district' => 'required',
        ], [
            'officer_name.required' => 'Officer name field is required',
            'district.required' => 'District field is required',
        ]);
    
        $officer = DB::table('users')->where('id', $request->officer_name)->first();
    
        if (!$officer) {
            return redirect()->back()->with('error', 'Selected officer does not exist.');
        }
    

        $assign_district = DB::table('assign_district')->insert([
            'officer_name' => $officer->name, 
            'district' => $request->district,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        if ($assign_district) {
            return redirect()->back()->with('success', 'District assigned successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to assign district.');
        }
    }
    

    public function assignDistrictList()
    {
        $assign_districts = DB::table('assign_district')->get();
        return view('Admin.assignDistrictList', compact('assign_districts'));
    }
    public function assignDistrcitdestroy($id)
    {
        try {
            
            DB::table('assign_district')->where('id', $id)->delete();
            return redirect()->route('Admin.assignDistrictList')->with('success', 'Thana deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('Admin.assignDistrictList')->with('error', $e->getMessage());
        }
    }
    
    public function updateAssignDistrict(Request $request, $id)
    {
        if ($request->isMethod('POST')) { 
            $request->validate([
                'officer_name' => 'required|string|max:255',
                'district' => 'required|string|max:255',  
               
            ]);
    
            $updated = DB::table('assign_district')
                        ->where('id', $id)
                        ->update([
                            'officer_name' => $request->officer_name,
                            'district' => $request->district,  
                        ]);
    
            if ($updated) {
                return redirect()->route('Admin.updateAssignDistrict', $id)
                                 ->with('success', 'Thana updated successfully');
            } else {
                return redirect()->route('Admin.updateAssignDistrict', $id)
                                 ->with('error', 'Thana update failed');
            }
        }
    
        $assign_district = DB::table('assign_district')->where('id', $id)->first();
    
        return view('Admin.updateAssignDistrict', compact('assign_district'));
    }
   
}
      
