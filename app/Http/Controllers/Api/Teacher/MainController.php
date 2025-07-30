<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main\RateRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //

    public $teacher;
    public function __construct()
    {
        $this->teacher=auth('teacher_api')->user();
    }

    public function studentRating(RateRequest $request,$id)
    {
        $student=Student::find($id);
        $data=$this->teacher->studentRating()->attach($id,[
            'rate'=>$request->rate,
            'comment'=>$request->comment
        ]);
        return successResponse(data:$data);
    }

     public function AllGivnRating()
     {
        $AllGivnRating=collect([$this->teacher->familyRatingMe(),$this->teacher->studentRatingMe()])->flatten();
         return successResponse(data:$AllGivnRating);
     }
}
