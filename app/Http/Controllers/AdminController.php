<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('Admin.index');
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

    public function assignOfficerList()
    {
        return view('Admin.assignOfficerList');
    }

    public function assign_thana()
    {

        return view('Admin.assignThana');
    }

// strat Verify Officer Account 

    public function verifyOfficerAccount()
    {
        $officers = DB::table('users')
        ->whereNull('thana_lead')
        ->where('role', 'officer')
        ->where('status', 0)
        ->get();
        return view('Admin.verifyOfficerAccount', compact('officers'));
    }
    public function approveOfficer($id)
    {
       
        $updated = DB::table('users')
            ->where('id', $id)
            ->update(['status' => 1]);

        if ($updated) {
            return redirect()->back()->with('success', 'Officer approved successfully.');
        } else {
            return redirect()->back()->with('error', 'Officer approval failed.');
        }
    }

    
    //start the area part

    public function area(Request $request)
    {
        $request->validate(
            [
                'area_name' => ['required', 'string', 'max:100'],
                'details_area' =>[ 'required','string', 'max:500']
            ]);
    
        $area_create = DB::table('area')->insert([
            'area_name' => $request->area_name,
            'details_area' => $request->details_area,
        ]);
    
        if ($area_create) {
            return redirect()->route('Admin.areaList')->with('success', 'Area added successfully');
        } else {
            return redirect()->route('Admin.area')->with('error', 'Failed to add area');
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
                return redirect()->route('Admin.areaList', $id)
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
            'district_name' => ['required','string', 'max:100'],
            'thana_name' => ['required','string', 'max:255'],
            'contact' => ['required','unique:thana'],
            'address' => ['required', 'string', 'max:500'],
        ]);
        
        $thana_create = DB::table('thana')->insert([
            'district_name' => $req->district_name,
            'thana_name' => $req->thana_name,
            'contact' => $req->contact,
            'address' => $req->address,
        ]);

        if ($thana_create) {
            return redirect()->route('Admin.thanaList')->with('success', 'thana added successfully');
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
        if ($request->isMethod('POST')) {  
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
                return redirect()->route('Admin.thanaList', $id)
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
            ->whereNull('area_lead')
            ->where('role', 'officer')
            ->where('status', 1)
            ->get();

        return view('Admin.assignDistrict', compact('officers'));
    }

    public function CreateAssign(Request $request)
    {
        $request->validate([
              
                'officer_name' => ['required', 'string', 'max:255'],
                 'district' => ['required', 'string', 'max:255'],

            ]);
    
       $create = DB::table('users')
                        ->where('id', $request->officer_name)
                        ->update([
                            'district_lead' => $request->district,  
                        ]);

        if ($create) {
            return redirect()->route('Admin.assignDistrictList')->with('success', 'District Lead officer assigned successfully.');
        } else {
            return redirect()->route('Admin.assignDistrict')->with('error', 'Failed to assign district Lead.');
        }
    }
    
    public function assignDistrictList()
    {

        $assign_districts = DB::table('users')->where('role','officer')
        ->whereNotNull('district_lead')->get();
        return view('Admin.assignDistrictList', compact('assign_districts'));
    }
    public function assignDistrcitdestroy($id)
    {
        try {
            DB::table('users')
                ->where('id', $id)
                ->update(['district_lead' => null]);
    
            return redirect()->route('Admin.assignDistrictList')->with('success', 'District lead officer unassigned successfully!');
        } catch (\Exception $e) {
            return redirect()->route('Admin.assignDistrictList')->with('error', $e->getMessage());
        }
    }
    public function updateAssignDistrict(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
              
                'district_lead' => 'required|string|max:255',
            ]);
    
            $updated = DB::table('users')
                ->where('id', $id)
                ->update([
                    
                    'district_lead' => $validatedData['district_lead'],
                ]);
    
            if ($updated) {
                return redirect()->route('Admin.assignDistrictList')
                                 ->with('success', 'District lead assigned officer updated successfully.');
            } else {
                return redirect()->route('Admin.assignDistrictList')
                                 ->with('error', 'No changes made or update failed.');
            }
        }
    
        $assign_district = DB::table('users')
            ->select('id', 'name', 'district_lead')
            ->where('id', $id)
            ->first();
    
        $districts = [ // move to a constant or config if reused
            'Dhaka', 'Gazipur', 'Munshiganj', 'Kishoreganj', 'Shariatpur', 'Gopalganj', 'Narayanganj', 'Manikganj',
            'Faridpur', 'Norsingdi', 'Rajbari', 'Tangail', 'Madaripur', 'Mymensingh', 'Sherpur', 'Jamalpur',
            'Netrokona', 'Chittagong', 'Cox\'s Bazar', 'Bandarban', 'Comilla', 'Brahmanbaria', 'Chandpur', 'Feni',
            'Lakshmipur', 'Noakhali', 'Rangamati', 'Khagrachari', 'Khulna', 'Jessore', 'Satkhira', 'Kushtia',
            'Chuadanga', 'Bagerhat', 'Jhenaidah', 'Magura', 'Meherpur', 'Narail', 'Rajshahi', 'Naogaon',
            'Sirajganj', 'Joypurhat', 'Bogura', 'Chapainawabganj', 'Natore', 'Pabna', 'Nilphamari', 'Dinajpur',
            'Panchagarh', 'Gaibandha', 'Kurigram', 'Lalmonirhat', 'Rangpur', 'Thakurgaon', 'Bhola', 'Barisal',
            'Pirojpur', 'Barguna', 'Jhalokathi', 'Patuakhali', 'Moulvibazar', 'Sylhet', 'Habiganj', 'Sunamganj'
        ];
    
        return view('Admin.updateAssignDistrict', compact('assign_district'));
    }
    
    
    
//assign thana lead information  

    public function assignThana ()
    {
        $officers = DB::table('users')
            ->whereNull('district_lead')
            ->whereNull('area_lead')
            ->whereNull('thana_lead')
            ->where('role', 'officer')
            ->where('status', 1)
            ->get();
        $thana_list = DB::table('thana')->get();

        return view('Admin.assignThana', compact('officers','thana_list'));
    }

    public function CreateAssignThana(Request $request)
    {
        $request->validate([
                          'officer_name' => ['required', 'string', 'max:255'],
                           'thana_name' => ['required', 'string', 'max:255'],

            ]);

        $create = DB::table('users')
                        ->where('id', $request->officer_name)
                        ->update([
                            'thana_lead' => $request->thana_name,  
                        ]);

        if ($create) {
            return redirect()->route('Admin.show-assign-thana')->with('success', 'Assign thana lead officer successfully.');
        } else {
            return redirect()->route('Admin.assignThana')->with('error', 'Failed to assign thana lead officer.');
        }
    }

    public function showing_assign_thana()
    {
        $assign_thana = DB::table('users')
            ->select('users.*', 'thana.thana_name', 'thana.district_name')
            ->join('thana', 'users.thana_lead', '=', 'thana.thana_name')
            ->where('users.role', 'officer')
            ->where('thana.district_name', Auth::user()->district_lead)
            ->whereNotNull('thana_lead')->get();
        return view('Admin.show-assign-thana', compact('assign_thana'));
    }
    
    public function assignThanadestroy($id)
    {
        try {
            DB::table('users')
                ->where('id', $id)
                ->update(['thana_lead' => null]);
    
            return redirect()->route('Admin.show-assign-thana')->with('success', 'Assign thana officer unassigned successfully!');
        } catch (\Exception $e) {
            return redirect()->route('Admin.show-assign-thana')->with('error', $e->getMessage());
        }
    }

    public function updateAssignThana(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
               
                'thana_name' => 'required|string|max:255',
            ]);
    
            $updated = DB::table('users')
                        ->where('id', $id)
                        ->update([
                            'thana_lead' => $validatedData['thana_name'],
                        ]);
    
            if ($updated) {
                return redirect()->route('Admin.show-assign-thana', $id)
                                 ->with('success', 'Assign Thana lead officer updated successfully.');
            } else {
                return redirect()->route('Admin.show-assign-thana', $id)
                                 ->with('error', 'Update failed. No changes made.');
            }
        }
    
        $thana = DB::table('users')->where('id', $id)->first();
        $thana_list = DB::table('thana')
                        ->where('district_name', Auth::user()->district_lead)->get();
        return view('Admin.updateAssignThana', compact('thana', 'thana_list'));
    }
    

// asssign officer information  
  
    public function assignOfficer ()
    {
        $officers = DB::table('users')
            ->whereNull('district_lead')
            ->whereNull('thana_lead')
            ->whereNull('area_lead')
            ->where('role', 'officer')
            ->where('status', 1)
            ->get();
        $area_list= DB::table('area')->get();

        return view('Admin.assignOfficer', compact('officers','area_list'));
    }

    public function createAssignOfficer(Request $request)
    {
         $request->validate([
                          'officer_name' => ['required', 'string', 'max:255'],
                           'area_name' => ['required', 'string', 'max:255'],

            ]);

        $create = DB::table('users')
                ->where('id', $request->officer_name)
                ->update([
                    'area_lead'=>$request->area_name,
                ]);

        if ($create) {
            return redirect()->route('Admin.assignOfficerList')->with('success', 'Assign area lead officer successfully.');
        } else {
            return redirect()->route('Admin.assignOfficer')->with('error', 'Failed to assign area lead officer.');
        }
    }
    
    public function areaOficerList()
    {
        $assign_areaOfficer = DB::table('users')->where('role','officer')
        ->whereNotNull('area_lead')->get();
        return view('Admin.assignOfficerList', compact('assign_areaOfficer'));
    }

    public function updateAssignOfficer(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
               
                'area_name' => 'required|string|max:255',
            ]);
    
            $updated = DB::table('users')
                        ->where('id', $id)
                        ->update([
                            'area_lead' => $validatedData['area_name'],
                        ]);
    
            if ($updated) {
                return redirect()->route('Admin.assignOfficerList', $id)
                                 ->with('success', 'Assign area lead officer updated successfully.');
            } else {
                return redirect()->route('Admin.assignOfficerList', $id)
                                 ->with('error', 'Update failed. No changes made.');
            }
        }
    
       $assign_officer = DB::table('users')->where('id', $id)->first();
        $area_list = DB::table('area')->get();
        return view('Admin.updateAssignOfficer', compact('assign_officer', 'area_list'));
    }

    public function assignOfficerdestroy($id)
    {
        try {
            DB::table('users')
                ->where('id', $id)
                ->update(['area_lead' => null]);
    
            return redirect()->route('Admin.assignOfficerList')->with('success', 'Area officer lead unassigned successfully!');
        } catch (\Exception $e) {
            return redirect()->route('Admin.assignOfficerList')->with('error', $e->getMessage());
        }
    }
   
    
}
      
