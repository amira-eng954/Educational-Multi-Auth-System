<?php

namespace App\Http\Controllers\Api\Family;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main\RateRequest;
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
}
