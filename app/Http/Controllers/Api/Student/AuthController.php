<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
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

      return response()->json([
        'token'=>$token
      ]);

  
    }


    public function login()
    {

    }


}
