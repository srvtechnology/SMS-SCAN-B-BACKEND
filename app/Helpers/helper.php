<?php

use App\Models\School;

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

function getSchoolLogo($school_id)
{
    $school = School::find($school_id);
    if(!empty($school->image) AND file_exists(public_path('uploads/schools/'.$school->image)))
    {
        $image = asset('uploads/schools/'.$school->image);
    }
    else
    {
        $image = asset('assets/default/placeholder.png');
    }
    return $image;
}

?>
