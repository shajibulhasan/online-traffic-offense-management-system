<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfficerController;
use App\Http\Middleware\ValidateUser;
use App\Http\Middleware\ValidateOfficer;
use App\Http\Middleware\DivisionLead;
use App\Http\Middleware\DistrictLead;
use App\Http\Middleware\ThanaLead;
use App\Http\Middleware\AreaLead;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

Auth::routes();



Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// start Admin controller  
// Thana routes
Route::get('/Admin/addThana', [AdminController::class, 'addThana'])->name('Admin.addThana');
Route::get('/Admin/thanaList', [AdminController::class, 'thanaList'])->name('Admin.thanaList');
Route::post('/Admin/addThana', [AdminController::class, 'Createthana'])->name('Admin.addThana');
Route::get('/Admin/updateThana/{id}', [AdminController::class, 'UpdateThana'])->name('Admin.updateThana');
Route::post('/Admin/updateThana/{id}', [AdminController::class, 'updateThana'])->name('Admin.updateThana');
Route::delete('/area/{id}', [AdminController::class, 'areadestroy'])->name('Admin.area.delete');


// Verify Officer Account
Route::get('/Admin/verifyOfficerAccount', [AdminController::class, 'verifyOfficerAccount'])->name('Admin.verifyOfficerAccount');


// Area routes
Route::get('/get-thanas-by-district/{district}', [AdminController::class, 'getThanasByDistrict']);
Route::get('/Admin/addArea', [AdminController::class, 'addArea'])->name('Admin.addArea');
Route::get('/Admin/areaList', [AdminController::class, 'areaList'])->name('Admin.areaList');
Route::post('/Admin/addArea', [AdminController::class, 'area'])->name('Admin.addArea');
Route::get('/Admin/updateArea/{id}', [AdminController::class, 'UpdateArea'])->name('Admin.updateArea');
Route::delete('/thana/{id}', [AdminController::class, 'thanadestroy'])->name('Admin.thana.delete');
Route::post('/Admin/updateArea/{id}', [AdminController::class, 'updateArea'])->name('Admin.updateArea');


// Assign Officer
Route::get('/Admin/assignOfficer', [AdminController::class, 'assignOfficer'])->name('Admin.assignOfficer');
Route::post('/Admin/updateAssignOfficer/{id}', [AdminController::class, 'updateAssignOfficer'])->name('Admin.updateAssignOfficer');
Route::post('/Admin/assignOfficer', [AdminController::class, 'createAssignOfficer'])->name('Admin.assignOfficer');

// Offense
Route::get('/Officer/addOffense', [OfficerController::class, 'addOffense'])->name('Officer.addOffense');
Route::get('/Officer/offenseList', [OfficerController::class, 'offenseList'])->name('Officer.offenseList');
Route::get('/Officer/updateOffense/{id}', [OfficerController::class, 'editOffense'])->name('Officer.updateOffense');
Route::get('/officer/search-driver', [OfficerController::class, 'searchDriver'])->name('officer.searchDriver');
Route::post('/Officer/addOffense', [OfficerController::class, 'createAddOffense'])->name('Officer.addOffense');
Route::delete('/offense/{id}', [OfficerController::class, 'offensedestroy'])->name('Officer.offense.delete');
Route::get('/officer/driver', [OfficerController::class, 'Driver'])->name('officer.Driver');
Route::post('/Officer/updateOffense/{id}', [OfficerController::class, 'updateOffense'])->name('Officer.updateOffense.update');


// PDF generation route
Route::get('/Officer/offense-list-pdf/{driver_id}', 
    [HomeController::class, 'offenseListPdf']
)->name('Officer.offenseListPdf');
Route::get('/verify-report/{id}', function($id){
    return "Verified report for driver ID: ".$id;
});



Route::get('/Admin/assignDistrictList', [AdminController::class, 'AssignDistrictList'])->name('Admin.assignDistrictList');
Route::get('/Admin/assignDistrict', [AdminController::class, 'assignDistrict'])->name('Admin.assignDistrict');

Route::get('/Admin/assignThana',[AdminController::class, 'assignThana'])->name('Admin.assignThana');
Route::get('/Admin/show-assign-thana', [AdminController::class, 'showing_assign_thana'])->name('Admin.show-assign-thana');

Route::get('/Admin/assignOfficerList', [AdminController::class, 'areaOficerList'])->name('Admin.assignOfficerList');

Route::get('/Admin/index', [AdminController::class, 'index'])->name('Admin.index');
Route::get('/Admin/divission', [AdminController::class, 'divission'])->name('Admin.divission');
Route::get('/Admin/updateAssignDistrict/{id}', [AdminController::class, 'updateAssignDistrict'])->name('Admin.updateAssignDistrict');
Route::get('/Admin/updateAssignOfficer', [AdminController::class, 'updateAssignOfficer'])->name('Admin.updateAssignOfficer');
// Show edit page
Route::get('/Admin/updateAssignThana/{id}', [AdminController::class, 'updateAssignThana'])->name('Admin.updateAssignThana');
Route::get('/Admin/updateAssignOfficer/{id}', [AdminController::class, 'updateAssignOfficer'])->name('Admin.updateAssignOfficer');
//post route
Route::post('/Admin/updateAssignThana/{id}', [AdminController::class, 'updateAssignThana'])->name('Admin.updateAssignThana');
Route::post('/Admin/assignThana', [AdminController::class, 'CreateAssignThana'])->name('Admin.assignThana');
Route::post('/Admin/assignDistrict', [AdminController::class, 'CreateAssign'])->name('Admin.assignDistrict');
Route::post('/officers/{id}/approve', [AdminController::class, 'approveOfficer'])->name('officers.approve');
Route::post('/Admin/updateAssignDistrict/{id}', [AdminController::class, 'updateAssignDistrict'])->name('Admin.updateAssignDistrict');
Route::post('/Admin/assignDistrict', [AdminController::class, 'CreateAssign'])->name('Admin.createAssign');
Route::delete('/assignOfficer/{id}', [AdminController::class, 'assignOfficerdestroy'])->name('Admin.assignOfficer.delete');
Route::delete('/Admin/assignDistrict/{id}', [AdminController::class, 'assignDistrcitdestroy'])->name('Admin.assignDistrict.delete');
Route::delete('/Admin/show-assign-thana/{id}', [AdminController::class, 'assignThanadestroy'])->name('Admin.show-assign-thana.delete');

//End Admin controller

//start Officer controller 
//End officer controller

//strat Driver controller


Route::get('/User/index', [UserController::class, 'index'])->name('User.index')->middleware(ValidateUser::class);
Route::get('/User/profileShow', [UserController::class, 'show'])->name('User.profileShow');
Route::get('/User/ProfileEdit', [UserController::class, 'edit'])->name('profile.edit');
Route::post('/User/ProfileEdit', [UserController::class, 'update'])->name('profile.update');


//end Driver controller


// bkash payment gateway

Route::middleware(['auth'])->group(function () {
    Route::get('/bkash/payment', [App\Http\Controllers\BkashTokenizePaymentController::class,'index'])->name('bkash-payment');
    Route::post('/bkash/create-payment/{ammout}/{id}', [App\Http\Controllers\BkashTokenizePaymentController::class,'createPayment'])->name('bkash-create-payment');
    Route::get('/bkash/callback', [App\Http\Controllers\BkashTokenizePaymentController::class,'callBack'])->name('bkash-callBack');

});

// end payment gateway
