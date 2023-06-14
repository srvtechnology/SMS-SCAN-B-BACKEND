<?php

use App\Models\User;
use App\Models\Staff;
use App\Models\School;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StaffAssignClass;

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

function getStaffImage($staff_id)
{
    $staff = Staff::find($staff_id);
    if(!empty($staff->image) AND file_exists(public_path('uploads/schools/logo/'.$staff->image)))
    {
        $image = asset('uploads/schools/logo/'.$staff->image);
    }
    else
    {
        $image = asset('assets/default/placeholder.png');
    }
    return $image;
}

function getStudentImage($student_id)
{
    $student = Student::find($student_id);
    if(!empty($student->image) AND file_exists(public_path('uploads/schools/student/'.$student->image)))
    {
        $image = asset('uploads/schools/student/'.$student->image);
    }
    else
    {
        $image = asset('assets/default/placeholder.png');
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

function getSchoolStatus($school_id)
{
    $school = School::find($school_id);
    $user = User::where('email',$school->email)->first();
    return $user->status;
}

function getSectionStatus($school_id)
{
    $section = Section::find($school_id);
    return $section->status;
}

function getClassStatus($class_id)
{
    $class = Classes::find($class_id);
    return $class->status;
}

function getSubjectStatus($school_id)
{
    $subject = Subject::find($school_id);
    return $subject->status;
}

function getSchoolInfoByUsername($username)
{
    $school = School::where('username',$username)->first();
    // if(!$school)
    // {
    //     dd("back to login");
    // }
    return $school;
}

function selectedSectionArray($school_id,$staff_id,$class_id)
{
    $sections = StaffAssignClass::where('class_id', $class_id)
    ->where('school_id',$school_id)
    ->where('staff_id',$staff_id)
    ->get();
    $response = [];
    foreach($sections as $section)
    {
        $response[] = $section->section_id;
    }
    return $response;
}

?>
