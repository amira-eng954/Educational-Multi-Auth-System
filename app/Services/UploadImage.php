<?php
namespace App\Services;
use GuzzleHttp\Client;
class UploadImage{

    public function upload($file,$folder)
    {
       $image=uniqid() .'.' .$file->getClientOriginalExtension();
       $file->storeAs($folder,$image,"public");
       return $image;


    }
}