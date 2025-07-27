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
Route::group(['prefix'=>"teacher"],function(){

    Route::post("register",[AuthController::class,"register"]);
     Route::post("login",[AuthController::class,"login"]);

     Route::middleware('auth:teacher_api')->group(function(){
      Route::post("logout",[AuthController::class,'logout']);
      Route::get('profile',[AuthController::class,'profile']);
      Route::post("update-profile",[AuthController::class,'update_profile']);
     });

});

/////////////////////////////////////////////////student/////////////
Route::group(['prefix'=>"student"],function(){
     
    Route::post("register",[StudentAuthController::class,"register"]);
    Route::post("login",[StudentAuthController::class,"login"]);

    Route::middleware('auth:student_api')->group(function(){
      Route::post("logout",[StudentAuthController::class,"logout"]);
      Route::get('profile',[StudentAuthController::class,'profile']);
      Route::post("update-profile",[StudentAuthController::class,'update_profile']);
    });
});

//////////////////////////////////////////////Family//////////

Route::group(['prefix'=>"family"],function(){
       Route::post("register",[FamliyAuthController::class,"register"]);
       Route::post("login",[FamliyAuthController::class,"login"]);

       Route::middleware('auth:family_api')->group(function(){
         Route::post("logout",[FamliyAuthController::class,"logout"]);
         Route::get('profile',[FamliyAuthController::class,'profile']);
         Route::post("update-profile",[FamliyAuthController::class,'update_profile']);
       });

});



