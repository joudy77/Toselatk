<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post ('sendVerificationCode',[UserController:: class,'sendVerificationCode']);
Route::post ('login',[UserController:: class,'login']);
Route::post ('logout',[UserController:: class,'logout'])->middleware('auth:sanctum');
Route::post ('verifyCode',[UserController:: class,'verifyCode']);
Route::post ('dataentry',[UserController:: class,'dataentry']);
?>