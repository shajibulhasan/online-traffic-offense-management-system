<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfficerController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// start Admin controller  
Route::get('/Admin/index', [AdminController::class, 'index'])->name('Admin.index');
Route::get('/Admin/addThana', [AdminController::class, 'addThana'])->name('Admin.addThana');
Route::get('/Admin/divission', [AdminController::class, 'divission'])->name('Admin.divission');
Route::get('/Admin/addArea', [AdminController::class, 'addArea'])->name('Admin.addArea');
Route::get('/Admin/areaList', [AdminController::class, 'areaList'])->name('Admin.areaList');
Route::get('/Admin/assignOfficer', [AdminController::class, 'assignOfficer'])->name('Admin.assignOfficer');
Route::get('/Admin/assignOfficerList', [AdminController::class, 'assignOfficerList'])->name('Admin.assignOfficerList');
Route::get('/Admin/verifyOfficerAccount', [AdminController::class, 'verifyOfficerAccount'])->name('Admin.verifyOfficerAccount');
Route::get('/Admin/thanaList', [AdminController::class, 'thanaList'])->name('Admin.thanaList');
Route::get('/Admin/assignThana', [AdminController::class, 'assign_thana'])->name('Admin.assignThana');
Route::get('/Admin/show-assign-thana', [AdminController::class, 'showing_assign_thana'])->name('Admin.show-assign-thana');
Route::get('/Admin/areaList', [AdminController::class, 'areaList'])->name('Admin.areaList');
Route::get('/Admin/assignDistrictList', [AdminController::class, 'AssignDistrictList'])->name('Admin.assignDistrictList');
Route::get('/Admin/updateThana/{id}', [AdminController::class, 'UpdateThana'])->name('Admin.updateThana');
Route::get('/Admin/updateArea/{id}', [AdminController::class, 'UpdateArea'])->name('Admin.updateArea');
Route::get('/Admin/assignDistrict', [AdminController::class, 'assignDistrict'])->name('Admin.assignDistrict');
Route::get('/Admin/updateAssignDistrict/{id}', [AdminController::class, 'updateAssignDistrict'])->name('Admin.updateAssignDistrict');
Route::get('/Admin/assignThana',[AdminController::class, 'assignThana'])->name('Admin.assignThana');
Route::get('/Admin/assignOfficerList', [AdminController::class, 'areaOficerList'])->name('Admin.assignOfficerList');
Route::get('/Admin/updateAssignOfficer', [AdminController::class, 'updateAssignOfficer'])->name('Admin.updateAssignOfficer');
// Show edit page
Route::get('/Admin/updateAssignThana/{id}', [AdminController::class, 'updateAssignThana'])->name('Admin.updateAssignThana');
Route::get('/Admin/updateAssignOfficer/{id}', [AdminController::class, 'updateAssignOfficer'])->name('Admin.updateAssignOfficer');
//post route
Route::post('/Admin/updateAssignOfficer/{id}', [AdminController::class, 'updateAssignOfficer'])->name('Admin.updateAssignOfficer');
Route::post('/Admin/assignOfficer', [AdminController::class, 'createAssignOfficer'])->name('Admin.assignOfficer');
Route::post('/Admin/updateAssignThana/{id}', [AdminController::class, 'updateAssignThana'])->name('Admin.updateAssignThana');
Route::post('/Admin/assignThana', [AdminController::class, 'CreateAssignThana'])->name('Admin.assignThana');
Route::post('/Admin/assignDistrict', [AdminController::class, 'CreateAssign'])->name('Admin.assignDistrict');
Route::post('/officers/{id}/approve', [AdminController::class, 'approveOfficer'])->name('officers.approve');
Route::post('/Admin/updateAssignDistrict/{id}', [AdminController::class, 'updateAssignDistrict'])->name('Admin.updateAssignDistrict');
Route::post('/Admin/assignDistrict', [AdminController::class, 'CreateAssign'])->name('Admin.createAssign');
Route::post('/Admin/addArea', [AdminController::class, 'area'])->name('Admin.addArea');
Route::post('/Admin/addThana', [AdminController::class, 'Createthana'])->name('Admin.addThana');
Route::delete('/thana/{id}', [AdminController::class, 'thanadestroy'])->name('Admin.thana.delete');
Route::delete('/area/{id}', [AdminController::class, 'areadestroy'])->name('Admin.area.delete');
Route::delete('/assignOfficer/{id}', [AdminController::class, 'assignOfficerdestroy'])->name('Admin.assignOfficer.delete');
Route::delete('/Admin/assignDistrict/{id}', [AdminController::class, 'assignDistrcitdestroy'])->name('Admin.assignDistrict.delete');
Route::delete('/Admin/show-assign-thana/{id}', [AdminController::class, 'assignThanadestroy'])->name('Admin.show-assign-thana.delete');
Route::post('/Admin/updateThana/{id}', [AdminController::class, 'updateThana'])->name('Admin.updateThana');
Route::post('/Admin/updateArea/{id}', [AdminController::class, 'updateArea'])->name('Admin.updateArea');

//End Admin controller

//start Officer controller 
Route::get('/Officer/addOffense', [OfficerController::class, 'addOffense'])->name('Officer.addOffense');
Route::get('/Officer/offenseList', [OfficerController::class, 'offenseList'])->name('Officer.offenseList');
Route::get('/Officer/updateOffense', [OfficerController::class, 'updateOffense'])->name('Officer.updateOffense');
Route::get('/officer/search-driver', [OfficerController::class, 'searchDriver'])->name('officer.searchDriver');
// post method
Route::post('/Officer/addOffense', [OfficerController::class, 'createAddOffense'])->name('Officer.addOffense');
Route::delete('/offense/{id}', [OfficerController::class, 'offensedestroy'])->name('Officer.offense.delete');
Route::get('/officer/driver', [OfficerController::class, 'Driver'])->name('officer.Driver');
//End officer controller

//strat Driver controller