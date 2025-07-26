<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\http\helper;
use App\Http\Requests\Student\LoginRequest;
use App\Http\Requests\Student\registerRequest;
use App\Models\Student;
use App\Services\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function register(registerRequest $request)
    {
       $stu= $request->validated();
       
       $stu['password']= Hash::make($stu['password']);
       if($request->hasFile('image'))
       {
        $stu['image']=(new UploadImage())->upload($request->file('image'),"students");

       }

       $student=Student::create($stu);
      $token= $student->createToken('student')->plainTextToken;
      return successResponse("resgister suc student",["token"=>$token]);

  
    }


    public function login( LoginRequest $request)
    {
          $data=$request->validated();
          $student=Student::where("email",'=',$data['email'])->first();
          if(!$student)
          {
          
              return failResponse("not found email");
          }
          if(!Hash::check($data['password'],$student->password))
          {
                return failResponse("not found password");
          }

          if($student->tokens()->count()>0)
          {
            $student->tokens()->delete();
          }
          $token =$student->createToken('student')->plainTextToken;
          return successResponse("suc login student",['token'=>$token]);


    }


    public function logout(Request $request)
    {
      $student=$request->user('student_api')->currentAccessToken()->delete();
      return successResponse("suc logout");
    }

    public function profile(Request $request)
    {
      $profile=$request->user('student_api');
        return successResponse("suc profile",$profile);

    }


}
