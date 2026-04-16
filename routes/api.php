<?php
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BkashPaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OfficerControllerApi;
use App\Http\Controllers\Api\AdminControllerApi;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/my-offenses', [UserController::class, 'myOffenses']);
    Route::post('/offense/update-payment', [UserController::class, 'updatePayment']);
    Route::get('/myProfile', [UserController::class, 'myProfile']);
    Route::post('/update-profile/{id}', [UserController::class, 'updateProfile']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/officer/search-driver', [OfficerControllerApi::class, 'searchDriver']);
    Route::post('/officer/add-offense', [OfficerControllerApi::class, 'addOffense']);
});

Route::prefix('officer')->middleware('auth:sanctum')->group(function () {
    Route::get('/offense-list', [OfficerControllerApi::class, 'offenseList']);
    Route::delete('/delete-offense/{id}', [OfficerControllerApi::class, 'deleteOffense']);
    Route::put('/update-offense/{id}', [OfficerControllerApi::class, 'updateOffense']);
    Route::get('/edit-offense/{id}', [OfficerControllerApi::class, 'getOffenseById']);
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::get('/officers/pending', [AdminControllerApi::class, 'pendingOfficers']);
    Route::get('/officers/approved', [AdminControllerApi::class, 'approvedOfficers']);
    Route::post('/officers/{id}/approve', [AdminControllerApi::class, 'approveOfficer']);
    Route::put('/reject-officer/{id}', [AdminControllerApi::class, 'rejectOfficer']);

    Route::get('/thanas/list', [AdminControllerApi::class, 'getThanas']);
    Route::post('/thanas', [AdminControllerApi::class, 'addThana']);
    Route::put('/thanas/{id}', [AdminControllerApi::class, 'updateThana']);
    Route::delete('/thanas/{id}', [AdminControllerApi::class, 'deleteThana']);
    Route::get('/get/thana/{id}', [AdminControllerApi::class, 'getThanaById']);  
    Route::get('/offenses', [AdminControllerApi::class, 'offenseManagement']);  
    Route::get('/offenses/paid', [AdminControllerApi::class, 'offenseManagementPaid']);  
    Route::get('/offenses/unpaid', [AdminControllerApi::class, 'offenseManagementUnpaid']);  
});


Route::middleware('auth:sanctum')->group(function () {
    // Area routes
    Route::get('/areas', [AdminControllerApi::class, 'getAreas']);
    Route::post('/areas', [AdminControllerApi::class, 'addArea']);
    Route::put('/areas/{id}', [AdminControllerApi::class, 'updateArea']);
    Route::delete('/areas/{id}', [AdminControllerApi::class, 'deleteArea']);
    
    // Helper route for thanas by district
    Route::get('/thanas-by-district/{district}', [AdminControllerApi::class, 'getThanasByDistrict']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/assigned-officers', [AdminControllerApi::class, 'getAssignedOfficers']);
    Route::post('/assigned-officers', [AdminControllerApi::class, 'assignOfficer']);
    Route::put('/assigned-officers/{id}', [AdminControllerApi::class, 'updateAssignedOfficer']);
    Route::delete('/assigned-officers/{id}', [AdminControllerApi::class, 'deleteAssignedOfficer']);
    
    // Helper routes
    Route::get('/officers', [AdminControllerApi::class, 'getOfficers']);

    // dashboard stats
    Route::get('/admin/offenses/counts', [AdminControllerApi::class, 'dashboardStats']);
    Route::get('/user/offenses/counts', [UserController::class, 'dashboardStats']);
});



// API routes
Route::post('/bkash/create-payment/{amount}/{id}', [BkashPaymentController::class, 'createPayment']);
Route::get('/bkash/callback', [BkashPaymentController::class, 'callBack'])->name('bkash.callback');

// Test route
Route::get('/test', function() {
    return response()->json([
        'success' => true,
        'message' => 'API is working',
        'time' => now()->toDateTimeString()
    ]);
});