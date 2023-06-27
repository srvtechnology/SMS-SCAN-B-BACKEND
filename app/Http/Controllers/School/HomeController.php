<?php

namespace App\Http\Controllers\School;

use App\Models\User;
use App\Models\Staff;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public $school;
    public function __construct(){
        // $this->school = getSchoolInfoByUsername(Auth::user()->username);
    }

    public function dashboard()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $students = Student::where('school_id', $school->id)->where('is_deleted','0')->count();
        $staffs = Staff::where('school_id', $school->id)->where('is_deleted','0')->count();
        $parents = User::where('type','parent')->where('is_deleted','0')->count();
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->count();
        $sections = Section::where('school_id', $school->id)->where('is_deleted','0')->count();

        return view("school.dashboard")->with(compact('school','students','staffs','parents','classes','sections'));
    }
}
