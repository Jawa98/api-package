<?php

use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;

if(!function_exists('to_user')){
    function to_user($user): ?User{
        return $user;
    }
}

if(!function_exists('to_token'))
{
    function to_token($token): ?PersonalAccessToken
    {
        return $token;
    }
}

if(!function_exists('upload_file'))
{
    function upload_file($request_file, $prefix, $folder_name)
    {
        $extension = $request_file->getClientOriginalExtension();
        $file_to_store = $prefix . '_' . time(). rand(1000, 9999) . '.' . $extension;
        $path = storage_path('app/public/'. $folder_name);
        if(!File::isDirectory($path))
            File::makeDirectory($path, 0755, true, true);

        $request_file->storeAs('public/' . $folder_name, $file_to_store);
        return $folder_name.'/'.$file_to_store;
    }
}

if(!function_exists('delete_file_if_exist'))
{
    function delete_file_if_exist($file)
    {
        if(Storage::exists('public/'.$file))
            Storage::delete('public/'.$file);
    }
}
