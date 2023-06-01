<?php

function getUserImage()
{
    if(!empty(Auth::user()->image) AND file_exists(public_path('uploads/profile/'.Auth::user()->image)))
    {
        $image = asset('uploads/profile/'.Auth::user()->image);
    }
    else
    {
        $image = asset('assets/default/avatar.jpg');
    }
    return $image;
}

?>
