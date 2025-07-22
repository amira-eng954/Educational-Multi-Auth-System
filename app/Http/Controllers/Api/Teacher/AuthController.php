<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\LoginRequest;
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

       return response()->json([
        "suc"=>"register teacher",
        'token '=>$token
       ]);
    }



    public function login (LoginRequest $request){
      
        $new=$request->validated();
        $teacher=Teacher::where("email",'=',$new['email'])->first();
        if(!$teacher)
        {
            return response()->json([
        "suc"=>"register teacher not found",
        
       ]);
        }

        if(!Hash::check($new['password'],$teacher->password))
        {

             return response()->json([
        "suc"=>"register teacher pass  not found",
        
       ]);

        }

        if($teacher->tokens()->count()>0)
        {
            $teacher->tokens()->delete();
        }
       $token= $teacher->createToken('teacher')->plainTextToken;

          return response()->json([
        "suc"=>"login teacher",
        'token '=>$token
       ]);

        
    }


    public function logout(Request $request)
    {

        $request->user('teacher_api')->currentAccessToken()->delete();
          
          return response()->json([
        "suc"=>"logout teacher",
       
       ]);


    }
}
