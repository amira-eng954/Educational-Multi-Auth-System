<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //

     protected $fillable = [
        'title',
        'desc',
        'image',
        'teacher_id',
        'price',
        
    ];
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }


}
