<?php

use App\Http\Controllers\User\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/auth')->group(function(){
    Route::post('/register',[UserController::class,'register'])->name('auth.register');
    Route::post('/login',[UserController::class,'login'])->name('auth.login');
    Route::post('/forgot-password',[UserController::class,'forgotPassword'])->name('auth.forgot_password');
    Route::any('/reset-password/{token}', [UserController::class,'resetPassword'])->middleware('api')->name('password.reset');
});