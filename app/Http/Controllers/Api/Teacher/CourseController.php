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

    public function index()
    {
        $teacher = Auth::guard('teacher_api')->user();
        $courses=Course::where('teacher_id',$teacher->id)->get();
        return successResponse("all course",CourseResource::collection($courses));

    }

    public function show($id)
    {
        $teacher=auth('teacher_api')->user();
        $course=Course::where('id',$id)->where('teacher_id',$teacher->id)->first();
        if(!$course)
        {
            return failResponse("not found course");
        }
        return successResponse("course",new CourseResource($course));

    }
     public function store(CourseRequest $request)
    {
        $teacher=$request->user("teacher_api");
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
        $teacher=$request->user("teacher_api")->id;
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
}
