<?php

namespace App\Http\Controllers\School;

use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function index()
    {
        return view("school.teachers.index");
    }

    public function create()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->OrderBy("name", 'asc')->get();
        $subjects = Subject::where('school_id',$school->id)->OrderBy('name', 'asc')->get();
        return view("school.teachers.create")->with(compact('school', 'classes','subjects'));
    }
}
