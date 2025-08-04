<?php
namespace App\Services;

use App\Mail\sendEmailVerificationCode;
use App\Mail\sendPasswordVerificationCode;
use Illuminate\Support\Facades\Mail;

class  sendVerificationCode
{

    public function Gcode()
    {
        $code=rand(11111,99999);
        return $code;
    }

    public function sendEmailVerificationCode($user)
    {
         $code=$this->Gcode();
         if($user->verifications()->count()>0)
         {
            $user->verifications()->where('uses','=',0)->get()->map(function($vert){
                $vert->update(['uses'=>1]);
            });

         }

         $user->verifications()->create([
            'code'=>$code,
            'expired_at'=>now()->addHour(),
            'uses'=>0,
            'type'=>"email"
         ]);
         Mail::to($user)->send(new sendEmailVerificationCode($code));
    }

    public function  sendPasswordVerificationCode($user)
    {
        $code=$this->Gcode();
        if($user->verifications()->count()>0)
        {
            $user->verifications()->where('uses','=',0)->get()->map(function($item){
                $item->update(['uses'=>1]);
            });
        }

        $user->verifications()->create([
            'code'=>$code,
            'expired_at'=>now()->addHour(),
            'uses'=>0,
            'type'=>"phone"
        ]);
        Mail::to($user)->send(new sendPasswordVerificationCode($code));
    }

}