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
Route::get('/Admin/add-thana', [AdminController::class, 'add_thana'])->name('Admin.add-thana');
Route::get('/Admin/divission', [AdminController::class, 'divission'])->name('Admin.divission');
Route::get('/Admin/add-area', [AdminController::class, 'addarea'])->name('Admin.add-area');
Route::get('/Admin/area-list', [AdminController::class, 'area_list'])->name('Admin.area-list');
Route::get('/Admin/assign-officer', [AdminController::class, 'assign_officer'])->name('Admin.assign-officer');
Route::get('/Admin/assign-officer-list', [AdminController::class, 'assign_officer_list'])->name('Admin.assign-officer-list');
Route::get('/Admin/verify-officer-account', [AdminController::class, 'verifyOfficerAccount'])->name('Admin.verify-officer-account');
Route::get('/Admin/manage-driver', [AdminController::class, 'ManageDriver'])->name('Admin.manage-driver');
Route::get('/Admin/thana_list', [AdminController::class, 'thanaList'])->name('Admin.thana_list');
Route::get('/Admin/assign-thana', [AdminController::class, 'assign_thana'])->name('Admin.assign-thana');
Route::get('/Admin/show-assign-thana', [AdminController::class, 'showing_assign_thana'])->name('Admin.show-assign-thana');
Route::get('/Admin/area-list', [AdminController::class, 'areaList'])->name('Admin.area-list');
Route::get('/Admin/assign-district', [AdminController::class, 'AssignDistrict'])->name('Admin.assign-district');
Route::get('/Admin/assign-district-list', [AdminController::class, 'AssignDistrictList'])->name('Admin.assign-district-list');
Route::get('/Admin/update-thana/{id}', [AdminController::class, 'UpdateThana'])->name('Admin.update-thana');
Route::get('/Admin/update-area/{id}', [AdminController::class, 'UpdateArea'])->name('Admin.update-area');

//post route
Route::post('/Admin/add-area', [AdminController::class, 'area'])->name('Admin.add-area');
Route::post('/Admin/add-thana', [AdminController::class, 'Createthana'])->name('Admin.add-thana');
Route::delete('/thana/{id}', [AdminController::class, 'thanadestroy'])->name('Admin.thana.delete');
Route::delete('/area/{id}', [AdminController::class, 'areadestroy'])->name('Admin.area.delete');
Route::post('/Admin/update-thana/{id}', [AdminController::class, 'updateThana'])->name('Admin.update-thana');
Route::post('/Admin/update-area/{id}', [AdminController::class, 'updateArea'])->name('Admin.update-area');

//End Admin controller