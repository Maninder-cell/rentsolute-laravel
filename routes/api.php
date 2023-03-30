<?php

use App\Http\Controllers\Amenity\AmenityController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Property\PropertyController;
use App\Http\Controllers\Question\QuestionController;
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
Route::prefix('/auth')->group(function(){
    Route::post('/register',[UserController::class,'register'])->name('auth.register');
    Route::post('/login',[UserController::class,'login'])->name('auth.login');
    Route::post('/forgot-password',[UserController::class,'forgotPassword'])->name('auth.forgot_password');
    Route::any('/reset-password/{token}', [UserController::class,'resetPassword'])->name('password.reset');
});

Route::prefix('/amenity')->middleware('auth:api')->group(function(){
    Route::post('/new_amenity',[AmenityController::class,'saveAmenity'])->name('amenity.create');
    Route::get('/get_amenities',[AmenityController::class,'getAmenities'])->name('amenity.gets');
});

Route::prefix('/question')->middleware('auth:api')->group(function(){
    Route::post('/new_question',[QuestionController::class,'saveQuestion'])->name('question.create');
    Route::get('/get_questions',[QuestionController::class,'getQuestions'])->name('question.gets');
});

Route::prefix('/property')->middleware('auth:api')->group(function(){
    Route::post('/new_property',[PropertyController::class,'saveProperty'])->name('property.create');
    Route::put('/update_property/{id}',[PropertyController::class,'updateProperty'])->name('property.update');
    Route::delete('/delete_property/{id}',[PropertyController::class,'deleteProperty'])->name('property.delete');
});

Route::post('/save_image',[ImageController::class,'saveImage'])->middleware('auth:api')->name('save_image');
