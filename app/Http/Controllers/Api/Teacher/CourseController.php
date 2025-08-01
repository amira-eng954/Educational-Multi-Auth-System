<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Services\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    //

    public $teacher;
    public function __construct()
    {
        $this->teacher=auth('teacher_api')->user();
    }

    public function index()
    {
        // $teacher = Auth::guard('teacher_api')->user();
       
        $courses=$this->teacher->courses()->get();

        return successResponse("all course",CourseResource::collection($courses));

    }

    public function show($id)
    {
       
        //$course=Course::where('id',$id)->where('teacher_id',$this->teacher->id)->first();
        $course=$this->teacher->courses()->where('id',$id)->first();
        if(!$course)
        {
            return failResponse("not found course");
        }
        return successResponse("course",new CourseResource($course));

    }
     public function store(CourseRequest $request)
    {
        $teacher=$this->teacher;
        $course=$request->validated();
        if($request->image)
        {
          $course['image']=(new UploadImage())->upload($request->file('image'),"images");
        }
        $newcourse= $teacher->courses()->create($course);
        return successResponse("create course",new CourseResource($newcourse));
        
        
    }

     public function update(CourseRequest $request,$id)
    { 


         $teacher=$request->user("teacher_api");
        $course=$request->validated();
        $oldcourse=Course::where('id',$id)->where("teacher_id",'=',$teacher->id)->first();
        if(!$oldcourse)
        {
            return failResponse("not found course");
        }
        if($request->hasFile('image'))
        {
            if($oldcourse->image)
            {
               (new UploadImage())->deleteImage("images",$oldcourse->image);
            }
           $course['image']=(new UploadImage())->upload($request->file('image'),"images");
        }
       $oldcourse->update($course);
        return successResponse(" update course",new CourseResource($oldcourse));
        
    }


     public function destroy(Request $request,$id)
    {
        $teacher=$this->teacher->id;
        $course=Course::where('id',$id)->where('teacher_id',$teacher)->first();
        if(!$course)
        {
            return failResponse("not found course");
        }
        if($course->image)
        {
            (new UploadImage())->deleteImage("images",$course['image']);
        }
        $course->delete();
        return successResponse("couse Deleted suc");
        
    }


    public function all_courses()
    {
        return successResponse("all courses",CourseResource::collection(Course::all()));
    }

    public function details($id)
    {
        $course=Course::find($id);
        if(!$course)
        {
            return failResponse("not found course");
        }

          return successResponse(data: new CourseResource($course));

    }


    public function searchCourse($search)
    {
          $course=Course::where("name","LIKE","%$search%")->get();
        if($course->isEmpty())
        {
            return failResponse("not found student to this name");
        }

        return successResponse("student", CourseResource::collection($course));

    }
}
