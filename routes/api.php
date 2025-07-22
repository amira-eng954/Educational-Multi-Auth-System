<?php

use App\Http\Controllers\Api\Family\AuthController as FamliyAuthController;
use App\Http\Controllers\Api\Student\AuthController as StudentAuthController;
use App\Http\Controllers\Api\Teacher\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/////////////////////////////////////////////////
Route::group(['prefix'=>"techer"],function(){

    Route::post("register",[AuthController::class,"register"]);
     Route::post("login",[AuthController::class,"login"]);

});

/////////////////////////////////////////////////student/////////////
Route::group(['prefix'=>"student"],function(){
     
    Route::post("register",[StudentAuthController::class,"register"]);
});

//////////////////////////////////////////////Family//////////

Route::group(['prefix'=>"family"],function(){
      Route::post("register",[FamliyAuthController::class,"register"]);
       Route::post("login",[FamliyAuthController::class,"login"]);

});



