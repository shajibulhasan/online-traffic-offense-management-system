<?php
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BkashTokenizePaymentController as BkashController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->get(
    '/my-offenses',
    [UserController::class, 'myOffenses']
);
Route::middleware('auth:sanctum')->get(
    '/myProfile',
    [UserController::class, 'myProfile']
);

Route::post('/bkash-create-payment/{fine}/{offenseId}', [App\Http\Controllers\BkashTokenizePaymentController::class, 'createPayment']);

