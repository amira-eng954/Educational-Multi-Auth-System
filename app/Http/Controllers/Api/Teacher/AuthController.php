<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\LoginRequest;
use App\Http\Requests\Teacher\ProfileRequest;
use App\Http\Requests\Teacher\registerRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Models\Verification;
use App\Services\sendVerificationCode;
use App\Services\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
       (new sendVerificationCode())->sendEmailVerificationCode($teacher);
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
        return successResponse("suc profile",new TeacherResource($profile));

    }

      public function update_profile(ProfileRequest $request)
    {
        $data=$request->validated();
        if($request->hasFile('image'))
        {

        }
        $teacher=$request->user("teacher_api");
        $teacher->update($data);
        return successResponse("update profile suc",new TeacherResource($teacher));

    }

    public function verify(Request $request)
    {
        $code=Validator::make($request->only(['code']),[
            'code'=>"required|string"
        ]);
        if($code->fails())
        {
            return failResponse(data:$code->errors());
        }
        $code1=$code->validated();
        $teacher=auth('teacher_api')->user();
        $old=$teacher->verifications()->where([
            ['uses','=',0],
            ['type','=','email'],
            ['expired_at','>',now()],
            ['code','=',$code1['code']]
        ])->first();
        if(!$old)
        {
            return failResponse("not exists code");
        }
        $old->update(['uses'=>1]);
         return failResponse(" exists code");

    }

    public function forgetPassword(Request $request)
    {
        $email=Validator::make($request->only(['email']),
        ['email'=>"required|email"]);

        if($email->fails())
        {
            return failResponse(data:$email->errors());

        }
        $email=$email->validated();
        $teacher=Teacher::where("email",'=',$email['email'])->first();
        if(!$teacher)
        {
            return failResponse("not found email");
        }
        (new sendVerificationCode())->sendPasswordVerificationCode($teacher);
        return successResponse("done send code for reset password");

    }

    public function resetPassword(Request $request)
    {
        $data=Validator::make($request->only(['code','password','password_confirmation']),[
            'code'=>"required",
            'password'=>"required|min:3|confirmed",
            
        ]);
        if($data->fails())
        {
            return failResponse(data:$data->errors());
        }
        $data=$data->validated();
        $code=Verification::where([
            ['code','=',$data['code']],
            ['uses','=',0],
            ['type','=','password'],
            ['expired_at','>',now()],
            ])->first();
        
        if(!$code)
        {
            return failResponse("not found code");
        }
        $teacher=Teacher::find($code->verificable_id);
        $teacher->update([
            'password'=>Hash::make($data['password'])
        ]);
        $code->update([
            'uses'=>1
        ]);
        return successResponse("updated password");

      
    }




}
