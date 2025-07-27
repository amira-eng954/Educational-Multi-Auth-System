<?php

namespace App\Http\Controllers\Api\Family;

use App\Http\Controllers\Controller;
use App\Http\Requests\Family\LoginRequest;
use App\Http\Requests\Family\ProfileRequest;
use App\Http\Requests\Family\RegisterRequest;
use App\Models\Family;
use App\Services\UploadImage ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function register(RegisterRequest $request)
    {
        $data=$request->validated();
        $data['password']=Hash::make($data['password']);
        if($request->hasFile('image')){
        $data['image']=(new UploadImage())->upload($request->file('image'),"family");
        }

       $family=Family::create($data);
       $token= $family->createToken("family")->plainTextToken;

       return successResponse("suc register family",['token'=>$token]);

    }

    public function login(LoginRequest $request)

    {
         $data=$request->validated();
         $family=Family::where("email","=",$data['email'])->first();
         if(!$family)
         {
             return failResponse("not found email");
         }

            if(!Hash::check($data['password'],$family->password))
            {
                     return failResponse("not found password");
            }

            if($family->tokens()->count()>0)
            {
                $family->tokens()->delete();
            }
            $token=$family->createToken('family')->plainTextToken;
          return successResponse("suc login family",['token'=>$token]);

      

    }

    public function logout(Request $request)
    { 
        $family=$request->user('family_api')->currentAccessToken()->delete();
         return successResponse("suc logout");


    }

    public function profile(Request $request)
    {
        $family=$request->user('family_api');
        return successResponse("profile family",$family);
    }

    public function update_profile(ProfileRequest $request)
    {
        $data=$request->validated();
      
        if($request->hasFile("image"))
        {

             
        }
        $family=$request->user("family_api");
       $family->update($data);
      
        return successResponse("update suc profile",$family);
        

    }
}
