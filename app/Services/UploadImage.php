<?php
namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class UploadImage{

    public function upload($file,$folder)
    {
       $image=uniqid() .'.' . $file->getClientOriginalExtension();
       $file->storeAs($folder,$image,"public");
       return $image;


    }

    public function deleteImage($folder,$file)
    {
        Storage::disk("public")->delete($folder.'/'.$file);
    }
}