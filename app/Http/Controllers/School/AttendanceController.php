<?php

namespace App\Http\Controllers\School;

use App\Models\Classes;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\StudentAttendance;
use App\Models\StudentClassAssign;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where(['school_id' => $school->id, 'is_deleted' => '0'])->OrderBy('name','ASC')->get();
        $sections = Section::where(['school_id' => $school->id, 'is_deleted' => '0'])->OrderBy('name','ASC')->get();

        $class_id = request()->class_id;
        $section_id = request()->section_id;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $students = [];
        $student_attendances = [];
        $dateList = [];
        if(!empty($class_id) AND !empty($section_id) AND !empty($from_date) AND !empty($to_date))
        {
            $dateList = calculateDatesBetween($from_date,$to_date);
            // return $dateList;
            $subjects = getSubjectsByClass($class_id);
            $query = StudentAttendance::where('school_id', $school->id)->where('class_id', $class_id)->where('section_id', $section_id);
            if(!empty(request()->student_id))
            {
                $query->where('student_id',request()->student_id);
                $students = StudentClassAssign::where('school_id', $school->id)->where('class_id', $class_id)->where('section_id', $section_id)->where('student_id',request()->student_id)->get();
            }
            else
            {
                $students = StudentClassAssign::where('school_id', $school->id)->where('class_id', $class_id)->where('section_id', $section_id)->get();
            }
            $student_attendances = $query->get();
        }
        return view("school.attendance.index")->with(compact('classes','sections','students','student_attendances','dateList'));
    }
}
