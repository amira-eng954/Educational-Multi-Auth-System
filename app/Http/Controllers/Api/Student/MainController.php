<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main\RateRequest;
use App\Http\Resources\CourseResource;
use App\Models\Teacher;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //

    public $student;
     public function __construct()
    {
       $this->student=auth('student_api')->user();
    }

    // الاشتراك فى الكورس 

    public function enroll($id)
     {
        if($this->student->courses()->where('course_id',$id)->exists())
        {
           return successResponse("you enroll before");
        }
        $this->student->courses()->attach($id);
        return successResponse("You enroll now suc");

    }

    // عرض كورساتى

    public function my_courses()
    {
        $courses=$this->student->courses()->get();
         return successResponse("You enroll courses " ,CourseResource::collection($courses) );


    }
    //تفاصيل كورس معين

    public function detail_course($id)
    {

        $course=$this->student->courses()->where('course_id',$id)->first();
        
        if(!$course)
        {
            return failResponse("not found course");

        }
        return successResponse(data: new CourseResource($course));
    }

    public function teacherRating(RateRequest $request ,$id)
    {
        $teacher=Teacher::find($id);
       $data= $this->student->teacherRating()->attach($id,[
            'rate'=>$request->rate,
            'comment'=>$request->comment
        ]);
        return successResponse(data:$data);

    }





}
