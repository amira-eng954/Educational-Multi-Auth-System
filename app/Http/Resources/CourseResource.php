<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {//parent::toArray($request)
        return[
            'title'=>$this->title,
            'description'=>$request->desc,
            'image'=>"assets('storage/images'.$this->image",
            'teacher'=>new TeacherResource($this->teacher),
        ] ;
    }
}
