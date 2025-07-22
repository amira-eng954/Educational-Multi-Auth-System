<?php

namespace App\Http\Controllers\Api\Family;

use App\Http\Controllers\Controller;
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

        return response()->json([
            'token'=>$token
        ]);

    }
}
