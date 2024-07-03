<?php

use App\Http\Controllers\Api\Auth\LoginController;

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;


Route::post('login', LoginController::class);
Route::post('logout', LogoutController::class);
Route::post('register', RegisterController::class);

