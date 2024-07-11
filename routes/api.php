<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/registration', RegistrationController::class);
Route::post('/login', LoginController::class)->middleware('throttle:login');
Route::post('/logout', LogoutController::class);
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request){
        return new UserResource($request->user());
    });
    Route::get('/balance', \App\Http\Controllers\UserBalance\IndexController::class);
    Route::get('/balance-transactions', \App\Http\Controllers\BalanceTransaction\IndexController::class);
});

