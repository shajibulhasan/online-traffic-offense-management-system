<?php
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BkashPaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/my-offenses', [UserController::class, 'myOffenses']);
    Route::post('/offense/update-payment', [UserController::class, 'updatePayment']);
    Route::get('/myProfile', [UserController::class, 'myProfile']);
    Route::post('/update-profile', [UserController::class, 'updateProfile']);
});

// Clear any existing routes and add these
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