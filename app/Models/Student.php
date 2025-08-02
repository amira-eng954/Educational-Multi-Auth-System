<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
     protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'phone',
        'age'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function courses()
    {
       return  $this->belongsToMany(Course::class);
    }

      public function familyStudent()
    {
       return  $this->belongsToMany(Student::class);
    }

    public function teacherRating()
    {
        return $this->morphToMany(Teacher::class,'rateable','teacher_rating')->withPivot("comment",'rate')->withTimestamps();
    }

    public function teacherRatingMe()
    {
         return $this->morphedByMany(Teacher::class,"rateable",'student_rate')->withPivot("comment",'rate')->withTimestamps();
    }

     public function verifications()
    {
        return $this->morphMany(Verification::class,'verificable');
    }
}
