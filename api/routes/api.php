<?php

use App\Http\Controllers\AttributeCategoryController;
use App\Http\Controllers\AttributeDefinitionController;
use App\Http\Controllers\AttributeGroupController;
use App\Http\Controllers\AttributeUnitController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Route::get('/home', function () {
//     return response()->json(['message' => 'Welcome to home']);
// })->name('home');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', [AuthController::class, 'user']);

    Route::get('categories/options', [CategoryController::class, 'options']);
    Route::apiResource('categories', CategoryController::class);
    Route::get('attribute-units/options', [AttributeUnitController::class, 'options']);
    Route::apiResource('attribute-units', AttributeUnitController::class);
    Route::apiResource('attribute-categories', AttributeCategoryController::class);
    Route::apiResource('attribute-groups', AttributeGroupController::class);
    Route::apiResource('attribute-definitions', AttributeDefinitionController::class);
});
