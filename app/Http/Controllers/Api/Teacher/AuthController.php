<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\LoginRequest;
use App\Http\Requests\Teacher\ProfileRequest;
use App\Http\Requests\Teacher\registerRequest;
use App\Models\Teacher;
use App\Services\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(registerRequest $request)
    {
       $teacher= $request->validated();
       $teacher['password']=Hash::make($teacher['password']);
       if($request->hasFile('image'))
       {
         
             $teacher['image']=(new UploadImage())->upload($request->file('image'),"teachers");
       }
       $teacher=Teacher::create($teacher);
       $token=$teacher->createToken("teacher")->plainTextToken;
        return successResponse("resgister suc teacher",["token"=>$token]);


       
    }



    public function login (LoginRequest $request){
      
        $new=$request->validated();
        $teacher=Teacher::where("email",'=',$new['email'])->first();
        if(!$teacher)
        {
           
            return failResponse("not found email");
        }

        if(!Hash::check($new['password'],$teacher->password))
        {

            return failResponse("not found password");
  
        }

        if($teacher->tokens()->count()>0)
        {
            $teacher->tokens()->delete();
        }
       $token= $teacher->createToken('teacher')->plainTextToken;
       return successResponse("suc login teacher",['token'=>$token]);

        
    }


    public function logout(Request $request)
    {

        $request->user('teacher_api')->currentAccessToken()->delete();
          
         return successResponse("suc logout teacher");

    }

     public function profile(Request $request)
    {
      $profile=$request->user('teacher_api');
        return successResponse("suc profile",$profile);

    }

      public function update_profile(ProfileRequest $request)
    {
        $data=$request->validated();
        if($request->hasFile('image'))
        {

        }
        $teacher=$request->user("teacher_api");
        $teacher->update($data);
        return successResponse("update profile suc",$teacher);

    }

}
