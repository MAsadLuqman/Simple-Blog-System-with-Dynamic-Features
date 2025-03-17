<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('register', [UserController::class, 'register']);
Route::get('sendmail/{id}', [UserController::class, 'sendmail']);
Route::get('verifyUser/{id}', [UserController::class, 'verifyUser']);
Route::post('password/email', [UserController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{id}/{time}', [UserController::class, 'verifyResetLink'])->name('update.password');
Route::post('password/reset/{id}', [UserController::class, 'updatePassword'])->name('update_password');
Route::post('login',[UserController::class,'login']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('users',[UserController::class,'index']);
    Route::get('dashboard',[UserController::class,'dashboard']);
    Route::get('adduser',[UserController::class,'adduser']);
    Route::get('show',[UserController::class,'show']);
    Route::delete('delete/{id}',[UserController::class,'delete']);
    Route::get('search',[UserController::class,'search']);
    Route::get('update/{id}',[UserController::class,'update']);
    Route::post('count',[UserController::class,'count']);
    Route::get('profile',[UserController::class,'profile']);
    Route::post('logout',[UserController::class,'logout']);
});

