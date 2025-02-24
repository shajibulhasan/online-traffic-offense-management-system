<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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
Route::get('/Admin/verify-officer-account', [AdminController::class, 'verifyOfficerAccount'])->name('Admin.verify-officer-account');
Route::get('/Admin/thanaList', [AdminController::class, 'thanaList'])->name('Admin.thanaList');
Route::get('/Admin/assign-thana', [AdminController::class, 'assign_thana'])->name('Admin.assign-thana');
Route::get('/Admin/show-assign-thana', [AdminController::class, 'showing_assign_thana'])->name('Admin.show-assign-thana');
Route::get('/Admin/areaList', [AdminController::class, 'areaList'])->name('Admin.areaList');
Route::get('/Admin/assignDistrictList', [AdminController::class, 'AssignDistrictList'])->name('Admin.assignDistrictList');
Route::get('/Admin/updateThana/{id}', [AdminController::class, 'UpdateThana'])->name('Admin.updateThana');
Route::get('/Admin/updateArea/{id}', [AdminController::class, 'UpdateArea'])->name('Admin.updateArea');
Route::get('/Admin/assignDistrict', [AdminController::class, 'assignDistrict'])->name('Admin.assignDistrict');
Route::get('/Admin/assignDistrict', [AdminController::class, 'assignDistrict'])->name('Admin.assignDistrict');
Route::get('/Admin/updateAssignDistrict/{id}', [AdminController::class, 'updateAssignDistrict'])->name('Admin.updateAssignDistrict');


//post route
Route::post('/Admin/updateAssignDistrict/{id}', [AdminController::class, 'updateAssignDistrict'])->name('Admin.updateAssignDistrict');
Route::post('/Admin/assignDistrict', [AdminController::class, 'CreateAssign'])->name('Admin.createAssign');
Route::post('/Admin/addArea', [AdminController::class, 'area'])->name('Admin.addArea');
Route::post('/Admin/addThana', [AdminController::class, 'Createthana'])->name('Admin.addThana');
Route::delete('/thana/{id}', [AdminController::class, 'thanadestroy'])->name('Admin.thana.delete');
Route::delete('/area/{id}', [AdminController::class, 'areadestroy'])->name('Admin.area.delete');
Route::delete('/assignDistrcit/{id}', [AdminController::class, 'assignDistrcitdestroy'])->name('Admin.assignDistrict.delete');
Route::post('/Admin/updateThana/{id}', [AdminController::class, 'updateThana'])->name('Admin.updateThana');
Route::post('/Admin/updateArea/{id}', [AdminController::class, 'updateArea'])->name('Admin.updateArea');

//End Admin controller