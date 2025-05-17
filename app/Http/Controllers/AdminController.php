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

    public function assign_thana()
    {

        return view('Admin.assignThana');
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
        $updated = DB::table('users')
                        ->where('id', $request->officer_name)
                        ->update([
                            'district_lead' => $request->district,  
                        ]);

        if ($updated) {
            return redirect()->back()->with('success', 'District assigned successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to assign district.');
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
    
            return redirect()->route('Admin.assignDistrictList')->with('success', 'District unassigned successfully!');
        } catch (\Exception $e) {
            return redirect()->route('Admin.assignDistrictList')->with('error', $e->getMessage());
        }
    }
    public function updateAssignDistrict(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'district_lead' => 'required|string|max:255',
            ]);
    
            $updated = DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => $validatedData['name'],
                    'district_lead' => $validatedData['district_lead'],
                ]);
    
            if ($updated) {
                return redirect()->route('Admin.assignDistrictList')
                                 ->with('success', 'District assignment updated successfully.');
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
    
        return view('Admin.updateAssignDistrict', compact('assign_district', 'districts'));
    }
    
    
    
    //assign thana 

    public function assignThana ()
    {
        $officers = DB::table('users')
            ->whereNull('district_lead')
            ->whereNull('thana_lead')
            ->where('role', 'officer')
            ->where('status', 1)
            ->get();
        $thana_list = DB::table('thana')->get();

        return view('Admin.assignThana', compact('officers','thana_list'));
    }

    public function CreateAssignThana(Request $request)
    {
        $updated = DB::table('users')
                        ->where('id', $request->officer_name)
                        ->update([
                            'thana_lead' => $request->thana_name,  
                        ]);

        if ($updated) {
            return redirect()->back()->with('success', 'thana assigned successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to assign thana.');
        }
    }
    public function showing_assign_thana()
    {
        $assign_thana = DB::table('users')->where('role','officer')
        ->whereNotNull('thana_lead')->get();
        return view('Admin.show-assign-thana', compact('assign_thana'));
    }
    
    public function assignThanadestroy($id)
    {
        try {
            DB::table('users')
                ->where('id', $id)
                ->update(['thana_lead' => null]);
    
            return redirect()->route('Admin.show-assign-thana')->with('success', 'thana unassigned successfully!');
        } catch (\Exception $e) {
            return redirect()->route('Admin.show-assign-thana')->with('error', $e->getMessage());
        }
    }

    public function updateAssignThana(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'officer_name' => 'required|string|max:255',
                'thana_name' => 'required|string|max:255',
            ]);
    
            $updated = DB::table('users')
                        ->where('id', $id)
                        ->update([
                            'name' => $validatedData['officer_name'],
                            'thana_lead' => $validatedData['thana_name'],
                        ]);
    
            if ($updated) {
                return redirect()->route('Admin.show-assign-thana', $id)
                                 ->with('success', 'Thana updated successfully.');
            } else {
                return redirect()->route('Admin.show-assign-thana', $id)
                                 ->with('error', 'Update failed. No changes made.');
            }
        }
    
        $thana = DB::table('users')->where('id', $id)->first();
        $thana_list = DB::table('thana')->get();
        return view('Admin.updateAssignThana', compact('thana', 'thana_list'));
    }
    
// asssign officer information  
  
    public function assignOfficer ()
    {
        $officers = DB::table('users')
            ->whereNull('district_lead')
            ->whereNull('thana_lead')
            ->where('role', 'officer')
            ->where('status', 1)
            ->get();
        $area_list= DB::table('area')->get();

        return view('Admin.assignOfficer', compact('officers','area_list'));
    }

    public function createOfficer(Request $req)
    {

        $req->validate([
            'officer_name' => 'required',
            'area_name'=> 'required|max:225',
        ],[
            'officer_name.required' => 'officer name field is requerd',
            'area_name.required' => 'area field is requerd',
        ]);

        $officer_create =DB::table('officer')->insert([

            'officer_name' => $req->officer_name,
            'area' => $req->area_name,
        ]);

        if($officer_create)
        {
            return redirect()->back()->with('success','officer added successfully');
        }else{
            return redirect()->back()->with('faild','Failed to add officer');
        }
    }

    
}
      
