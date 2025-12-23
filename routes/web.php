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

// Route::get('/', function () {
//     return view('welcome')->name('dashboard');
// });

Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// start Admin controller  
Route::get('/Admin/verifyOfficerAccount', [AdminController::class, 'verifyOfficerAccount'])->name('Admin.verifyOfficerAccount')->middleware(DivisionLead::class);
Route::get('/Admin/assignDistrictList', [AdminController::class, 'AssignDistrictList'])->name('Admin.assignDistrictList')->middleware(DivisionLead::class);
Route::get('/Admin/assignDistrict', [AdminController::class, 'assignDistrict'])->name('Admin.assignDistrict')->middleware(DivisionLead::class);

Route::get('/Admin/assignThana',[AdminController::class, 'assignThana'])->name('Admin.assignThana')->middleware(DistrictLead::class);
// Route::get('/Admin/assignThana', [AdminController::class, 'assign_thana'])->name('Admin.assignThana')->middleware(DistrictLead::class);
Route::get('/Admin/show-assign-thana', [AdminController::class, 'showing_assign_thana'])->name('Admin.show-assign-thana')->middleware(DistrictLead::class);
Route::get('/Admin/addThana', [AdminController::class, 'addThana'])->name('Admin.addThana')->middleware(DistrictLead::class);
Route::get('/Admin/thanaList', [AdminController::class, 'thanaList'])->name('Admin.thanaList')->middleware(DistrictLead::class);

Route::get('/Admin/assignOfficer', [AdminController::class, 'assignOfficer'])->name('Admin.assignOfficer')->middleware(ThanaLead::class);
Route::get('/Admin/assignOfficerList', [AdminController::class, 'areaOficerList'])->name('Admin.assignOfficerList')->middleware(ThanaLead::class);
Route::get('/Admin/addArea', [AdminController::class, 'addArea'])->name('Admin.addArea')->middleware(ThanaLead::class);
Route::get('/Admin/areaList', [AdminController::class, 'areaList'])->name('Admin.areaList')->middleware(ThanaLead::class);

Route::get('/Admin/index', [AdminController::class, 'index'])->name('Admin.index')->middleware(ValidateOfficer::class);
Route::get('/Admin/divission', [AdminController::class, 'divission'])->name('Admin.divission')->middleware(ValidateOfficer::class);
// Route::get('/Admin/assignOfficerList', [AdminController::class, 'assignOfficerList'])->name('Admin.assignOfficerList')->middleware(ValidateOfficer::class);
// Route::get('/Admin/areaList', [AdminController::class, 'areaList'])->name('Admin.areaList')->middleware(ValidateOfficer::class);
Route::get('/Admin/updateThana/{id}', [AdminController::class, 'UpdateThana'])->name('Admin.updateThana')->middleware(ValidateOfficer::class);
Route::get('/Admin/updateArea/{id}', [AdminController::class, 'UpdateArea'])->name('Admin.updateArea')->middleware(ValidateOfficer::class);
Route::get('/Admin/updateAssignDistrict/{id}', [AdminController::class, 'updateAssignDistrict'])->name('Admin.updateAssignDistrict')->middleware(ValidateOfficer::class);
Route::get('/Admin/updateAssignOfficer', [AdminController::class, 'updateAssignOfficer'])->name('Admin.updateAssignOfficer')->middleware(ValidateOfficer::class);
// Show edit page
Route::get('/Admin/updateAssignThana/{id}', [AdminController::class, 'updateAssignThana'])->name('Admin.updateAssignThana')->middleware(ValidateOfficer::class);
Route::get('/Admin/updateAssignOfficer/{id}', [AdminController::class, 'updateAssignOfficer'])->name('Admin.updateAssignOfficer')->middleware(ValidateOfficer::class);
//post route
Route::post('/Admin/updateAssignOfficer/{id}', [AdminController::class, 'updateAssignOfficer'])->name('Admin.updateAssignOfficer')->middleware(ValidateOfficer::class);
Route::post('/Admin/assignOfficer', [AdminController::class, 'createAssignOfficer'])->name('Admin.assignOfficer')->middleware(ValidateOfficer::class);
Route::post('/Admin/updateAssignThana/{id}', [AdminController::class, 'updateAssignThana'])->name('Admin.updateAssignThana')->middleware(ValidateOfficer::class);
Route::post('/Admin/assignThana', [AdminController::class, 'CreateAssignThana'])->name('Admin.assignThana')->middleware(ValidateOfficer::class);
Route::post('/Admin/assignDistrict', [AdminController::class, 'CreateAssign'])->name('Admin.assignDistrict')->middleware(ValidateOfficer::class);
Route::post('/officers/{id}/approve', [AdminController::class, 'approveOfficer'])->name('officers.approve')->middleware(ValidateOfficer::class);
Route::post('/Admin/updateAssignDistrict/{id}', [AdminController::class, 'updateAssignDistrict'])->name('Admin.updateAssignDistrict')->middleware(ValidateOfficer::class);
Route::post('/Admin/assignDistrict', [AdminController::class, 'CreateAssign'])->name('Admin.createAssign')->middleware(ValidateOfficer::class);
Route::post('/Admin/addArea', [AdminController::class, 'area'])->name('Admin.addArea')->middleware(ValidateOfficer::class);
Route::post('/Admin/addThana', [AdminController::class, 'Createthana'])->name('Admin.addThana')->middleware(ValidateOfficer::class);
Route::delete('/thana/{id}', [AdminController::class, 'thanadestroy'])->name('Admin.thana.delete')->middleware(ValidateOfficer::class);
Route::delete('/area/{id}', [AdminController::class, 'areadestroy'])->name('Admin.area.delete')->middleware(ValidateOfficer::class);
Route::delete('/assignOfficer/{id}', [AdminController::class, 'assignOfficerdestroy'])->name('Admin.assignOfficer.delete')->middleware(ValidateOfficer::class);
Route::delete('/Admin/assignDistrict/{id}', [AdminController::class, 'assignDistrcitdestroy'])->name('Admin.assignDistrict.delete')->middleware(ValidateOfficer::class);
Route::delete('/Admin/show-assign-thana/{id}', [AdminController::class, 'assignThanadestroy'])->name('Admin.show-assign-thana.delete')->middleware(ValidateOfficer::class);
Route::post('/Admin/updateThana/{id}', [AdminController::class, 'updateThana'])->name('Admin.updateThana')->middleware(ValidateOfficer::class)->middleware(ValidateOfficer::class);
Route::post('/Admin/updateArea/{id}', [AdminController::class, 'updateArea'])->name('Admin.updateArea')->middleware(ValidateOfficer::class)->middleware(ValidateOfficer::class);

//End Admin controller

//start Officer controller 
Route::get('/Officer/addOffense', [OfficerController::class, 'addOffense'])->name('Officer.addOffense')->middleware(AreaLead::class);
Route::get('/Officer/offenseList', [OfficerController::class, 'offenseList'])->name('Officer.offenseList')->middleware(AreaLead::class);
Route::get('/Officer/updateOffense/{id}', [OfficerController::class, 'editOffense'])->name('Officer.updateOffense')->middleware(AreaLead::class);
Route::get('/officer/search-driver', [OfficerController::class, 'searchDriver'])->name('officer.searchDriver')->middleware(AreaLead::class);
// post method
Route::post('/Officer/addOffense', [OfficerController::class, 'createAddOffense'])->name('Officer.addOffense')->middleware(ValidateOfficer::class);
Route::delete('/offense/{id}', [OfficerController::class, 'offensedestroy'])->name('Officer.offense.delete')->middleware(ValidateOfficer::class);
Route::get('/officer/driver', [OfficerController::class, 'Driver'])->name('officer.Driver')->middleware(ValidateOfficer::class);
Route::post('/Officer/updateOffense/{id}', [OfficerController::class, 'updateOffense'])->name('Officer.updateOffense.update')->middleware(AreaLead::class);
//End officer controller

//strat Driver controller


Route::get('/User/index', [UserController::class, 'index'])->name('User.index')->middleware(ValidateUser::class);
Route::get('/User/profileShow', [UserController::class, 'show'])->name('User.profileShow')->middleware(ValidateUser::class);
Route::get('/User/ProfileEdit', [UserController::class, 'edit'])->name('profile.edit')->middleware(ValidateUser::class);
Route::post('/User/ProfileEdit', [UserController::class, 'update'])->name('profile.update')->middleware(ValidateUser::class);


//end Driver controller


// bkash payment gateway

Route::middleware(['auth'])->group(function () {
    Route::get('/bkash/payment', [App\Http\Controllers\BkashTokenizePaymentController::class,'index'])->name('bkash-payment');
    Route::post('/bkash/create-payment/{ammout}/{id}', [App\Http\Controllers\BkashTokenizePaymentController::class,'createPayment'])->name('bkash-create-payment');
    Route::get('/bkash/callback', [App\Http\Controllers\BkashTokenizePaymentController::class,'callBack'])->name('bkash-callBack');

});

// end payment gateway
