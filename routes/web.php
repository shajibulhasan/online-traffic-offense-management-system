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
Route::get('/Admin/assign-officer', [AdminController::class, 'assign_officer'])->name('Admin.assign-officer');
Route::get('/Admin/assign-officer-list', [AdminController::class, 'assign_officer_list'])->name('Admin.assign-officer-list');
Route::get('/Admin/verify-officer-account', [AdminController::class, 'verifyOfficerAccount'])->name('Admin.verify-officer-account');
Route::get('/Admin/thanaList', [AdminController::class, 'thanaList'])->name('Admin.thanaList');
Route::get('/Admin/assign-thana', [AdminController::class, 'assign_thana'])->name('Admin.assign-thana');
Route::get('/Admin/show-assign-thana', [AdminController::class, 'showing_assign_thana'])->name('Admin.show-assign-thana');
Route::get('/Admin/area-list', [AdminController::class, 'areaList'])->name('Admin.area-list');
Route::get('/Admin/assign-district', [AdminController::class, 'AssignDistrict'])->name('Admin.assign-district');
Route::get('/Admin/assign-district-list', [AdminController::class, 'AssignDistrictList'])->name('Admin.assign-district-list');
Route::get('/Admin/updateThana/{id}', [AdminController::class, 'UpdateThana'])->name('Admin.updateThana');
Route::get('/Admin/updateArea/{id}', [AdminController::class, 'UpdateArea'])->name('Admin.updateArea');

//post route
Route::post('/Admin/addArea', [AdminController::class, 'area'])->name('Admin.addArea');
Route::post('/Admin/addThana', [AdminController::class, 'Createthana'])->name('Admin.addThana');
Route::delete('/thana/{id}', [AdminController::class, 'thanadestroy'])->name('Admin.thana.delete');
Route::delete('/area/{id}', [AdminController::class, 'areadestroy'])->name('Admin.area.delete');
Route::post('/Admin/updateThana/{id}', [AdminController::class, 'updateThana'])->name('Admin.updateThana');
Route::post('/Admin/updateArea/{id}', [AdminController::class, 'updateArea'])->name('Admin.updateArea');

//End Admin controller