<?php

use App\Http\Controllers\Api\Family\AuthController as FamliyAuthController;
use App\Http\Controllers\Api\Family\mainController as FamilyMainController;
use App\Http\Controllers\Api\Student\AuthController as StudentAuthController;
use App\Http\Controllers\Api\Student\MainController;
use App\Http\Controllers\Api\Teacher\AuthController;
use App\Http\Controllers\Api\Teacher\CourseController;
use App\Http\Controllers\Api\Teacher\MainController as TeacherMainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//////////////////////////////public/////////////////////////////

Route::group(['prefix'=>"public"],function(){
    
   Route::get("all-courses",[CourseController::class,"all_courses"]);//كل الكورسات المتاحه فى الداتا بيز
   Route::get("details/{id}",[CourseController::class,"details"]); // دى عرض تفاصيل الكورس 
   Route::group(['prefix'=>"search"],function(){
   Route::get("Teacher/{search}",[FamilyMainController::class,"searchTeacher"]);// بحث عن مدرس
   Route::get("Student/{search}",[FamilyMainController::class,"searchStudent"]);//بحث عن طالب
   Route::get("Course",[CourseController::class,'searchCourse']);// بحث عن كورس معين
   });
});



/////////////////////////////////////////////////teacher//////////
Route::group(['prefix'=>"teacher"],function(){

    Route::post("register",[AuthController::class,"register"]);
     Route::post("login",[AuthController::class,"login"]);

     Route::middleware('auth:teacher_api')->group(function(){
      Route::post("logout",[AuthController::class,'logout']);
      Route::get('profile',[AuthController::class,'profile']);
      Route::post("update-profile",[AuthController::class,'update_profile']);
       Route::post("verify",[AuthController::class,'verify']);
      Route::apiResource("courses",CourseController::class); //curd cousers to one teacher
      Route::group(['prefix'=>"rating"],function(){
         Route::post("studentRating/{id}",[TeacherMainController::class,'studentRating']);// المدرس بيقيم الطالب
         Route::get("AllGivnRating",[TeacherMainController::class,"AllGivnRating"]);// كل التقيمات الل العائله والطلاب قيموها للمدرس
      
     });
    });

});

/////////////////////////////////////////////////student//////////
Route::group(['prefix'=>"student"],function(){
     
    Route::post("register",[StudentAuthController::class,"register"]);
    Route::post("login",[StudentAuthController::class,"login"]);

    Route::middleware('auth:student_api')->group(function(){
      Route::post("logout",[StudentAuthController::class,"logout"]);
      Route::get('profile',[StudentAuthController::class,'profile']);
      Route::post("update-profile",[StudentAuthController::class,'update_profile']);
      Route::post("verify",[StudentAuthController::class,'verify']);

      Route::post("enroll/{id}",[MainController::class,"enroll"]);// الاشتراك فى الكورس
      Route::get("my-courses",[MainController::class,'my_courses']);//  كل كورساتى الل انا مسجل فيها
      Route::get("details_course/{id}",[MainController::class,'detail_course']);//   تفاصيل كورس معين الطالب مسجل فيه
      Route::group(['prefix'=>'rating'],function(){
         Route::post("teacherRating/{id}",[MainController::class,"teacherRating"]);// تقييم الطالب للمدرس

      });
    });
});

//////////////////////////////////////////////Family/////////////////

Route::group(['prefix'=>"family"],function(){
       Route::post("register",[FamliyAuthController::class,"register"]);
       Route::post("login",[FamliyAuthController::class,"login"]);

      Route::middleware('auth:family_api')->group(function(){
        Route::post("logout",[FamliyAuthController::class,"logout"]);
        Route::get('profile',[FamliyAuthController::class,'profile']);
        Route::post("update-profile",[FamliyAuthController::class,'update_profile']);
        Route::post("verify",[FamliyAuthController::class,'verify']);
        Route::group(['prefix'=>"rating"],function(){
            Route::post("teacherRating/{id}",[FamilyMainController::class,"familyRating"]);//تقيميم العائله للمدرس
            Route::get("AllStudentRating",[FamilyMainController::class,'AllStudentRating']);//كل تقيمات الطلاب الخاصه ب العائله 
            Route::get("AllFamilyRating",[FamilyMainController::class,'AllFamilyRating']);//كل تقيمات العائله الخاصه ب الممدرسين
         });
       });

});



