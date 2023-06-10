<?php

namespace App\Traits;
use Illuminate\Support\Facades\Storage;
trait UploadTrait
{

    public function uploadFile($file, $directory = 'unknown') : string
    {
        $path = base_path('images/' . $directory);
        $name = time() . rand(1000000, 9999999) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images/' . $directory, $name);
        return 'storage/images/' . $directory.'/'.$name;
    }
    public function deleteFile($file_name, $directory = 'unknown') : void
    {
        $image = null;
        if($file_name){
            $link_array = explode('/',$file_name);
            $image = end($link_array);
        }
        if ($image && Storage::exists('public/images/' . $directory . '/' . $image)) {
            Storage::delete('public/images/' . $directory . '/' . $image);
        }
    }
}
