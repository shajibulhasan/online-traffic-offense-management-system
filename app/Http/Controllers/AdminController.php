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
    public function AssignDistrict()
    {
        return view('Admin.assign-district');
    }
    public function AssignDistrictList()
    {
        return view('Admin.assign-district-list');
    }
    public function divission()
    {
        return view('Admin.divission');
    }
    public function add_thana()
    {
        return view('Admin.add-thana');
    }
    public function addarea()
    {
        return view('Admin.add-area');
    }
    public function area_list()
    {
        return view('Admin.area-list');
    }
    public function assign_officer()
    {
        return view('Admin.assign-officer');
    }
    public function assign_officer_list()
    {
        return view('Admin.assign-officer-list');
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
                'AreaName' => 'required',
                'DetailsArea' => 'required',
            ],
            [
                'AreaName.required' => 'AreaName field is required',
                'DetailsArea.required' => 'DetailsArea field is required'
            ]
        );
    
        $area_create = DB::table('area')->insert([
            'AreaName' => $request->AreaName,
            'DetailsArea' => $request->DetailsArea,
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
        return view('Admin.area-list', compact('areas'));
    }
    
    public function updateArea(Request $request, $id)
    {
        // Handle the POST request to update the area data
        if ($request->isMethod('POST')) {
            // Validate the form data
            $validatedData = $request->validate([
                'AreaName' => 'required|string|max:255',
                'DetailsArea' => 'required|string|max:255',
            ]);
    
            // Attempt to update the area in the database
            $updated = DB::table('area') 
                        ->where('id', $id) 
                        ->update([
                            'AreaName' => $validatedData['AreaName'],
                            'DetailsArea' => $validatedData['DetailsArea'],
                        ]);
    
            // Check if any row was updated
            if ($updated) {
                return redirect()->route('Admin.update-area', $id)
                                 ->with('success', 'Area updated successfully');
            } else {
                return redirect()->route('Admin.update-area', $id)
                                 ->with('error', 'Area update failed. No changes made.');
            }
        }
    
        // Fetch the area data for the form
        $area = DB::table('area')->where('id', $id)->first(); 
    
        // Return the view with the area data
        return view('Admin.update-area', compact('area'));
    }
    
    
    public function areadestroy($id)
    {
        try {
            // Using the DB facade to delete the record
            DB::table('area')->where('id', $id)->delete();
            return redirect()->route('Admin.area-list')->with('success', 'area deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('Admin.area-list')->with('error', $e->getMessage());
        }
    }
// strat thana part 
    public function Createthana(Request $req)
    {
        $req->validate(
        [
            'districtName' => 'required',
            'thanaName' => 'required|string|max:255',
            'contact' => 'required|numeric',
            'address' => 'required|string|max:500',
        ], [
            'districtName.required' => 'District field is required',
            'thanaName.required' => 'Thana name field is required',
            'contact.required' => 'Number field is required',
            'address.required' => 'Address field is required',
        ]);
    
        // Insert thana into the 'thana' table
        $thana_create = DB::table('thana')->insert([
            'districtName' => $req->districtName,
            'thanaName' => $req->thanaName,
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
        return view('Admin.thana_list', compact('thanas'));
    }
    //thana deleted
    public function thanadestroy($id)
    {
        try {
            
            DB::table('thana')->where('id', $id)->delete();
            return redirect()->route('Admin.thana_list')->with('success', 'Thana deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('Admin.thana_list')->with('error', $e->getMessage());
        }
    }

    public function updateThana(Request $request, $id)
    {
       
        if ($request->isMethod('POST') && $request->has('thanaName')) {
            $request->validate([
                'districtName' => 'required|string|max:255',
                'thanaName' => 'required|string|max:255',
                'contact' => 'required|string|max:20',
                'address' => 'required|string',
            ]);
    
            $updated = DB::table('thana') 
                        ->where('id', $id) 
                        ->update([
                            'districtName' => $request->districtName,
                            'thanaName' => $request->thanaName,
                            'contact' => $request->contact,
                            'address' => $request->address,
                        ]);
    
            if ($updated) {
                return redirect()->route('Admin.update-thana', $id)
                                 ->with('success', 'Thana updated successfully');
            } else {
                return redirect()->route('Admin.update-thana', $id)
                                 ->with('error', 'Thana update failed');
            }
        }
    
        $thana = DB::table('thana')->where('id', $id)->first(); 
    
        return view('Admin.update-thana', compact('thana'));
    }
    
}
      
