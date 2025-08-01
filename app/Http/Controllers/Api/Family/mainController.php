<?php

namespace App\Http\Controllers\Api\Family;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main\RateRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class mainController extends Controller
{
    //

    public $family;
    public function __construct()
    {
        $this->family=auth("family_api")->user();
        
    }

    public function familyRating(RateRequest $request,$id)
    {
        $teacher_id=Teacher::find($id);
        $data=$request->validated();
        $this->family->teacherRating()->attach($id,[
            'rate'=>$request->rate,
            'comment'=>$request->comment
        ]);
        return successResponse(data:$data);

    }

    public function AllStudentRating()
    {
        $students=$this->family->studentsFamily()->pluck('id')->toArray();
        $teacher=Teacher::all()->map(function($item) use ($students){
            return $item->studentRating()->where("students.id",$students)->get();
        });
    }

    public function AllFamilyRating()
    {
        $rating=Teacher::all()->map(function($item){
            return $item->familyRatingMe()->where("families.id",$this->family->id)->get();
        });
    }




    public function searchTeacher($search)
    {
        $teacher=Teacher::where("name","LIKE","%$search%")->get();
        if($teacher->isEmpty())
        {
            return failResponse("not found teacher to this name");
        }
        return successResponse("teacher", TeacherResource::collection($teacher));
    }


     public function searchStudent($search)
    {
       $student=Student::where("name","LIKE","%$search%")->get();
        if($student->isEmpty())
        {
            return failResponse("not found student to this name");
        }

        return successResponse("student", TeacherResource::collection($student));

    }


}
