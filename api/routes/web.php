<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'authenticate']);

Route::get('/', function () {
    return view('welcome');
});
