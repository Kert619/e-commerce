<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::post('logout', [AuthController::class, 'logout']);
//     Route::get('user', [AuthController::class, 'user']);
// });

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('/user', function (Request $request) {
//     return $request->header();
// });
