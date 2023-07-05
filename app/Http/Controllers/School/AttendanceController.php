<?php

namespace App\Http\Controllers\School;

use App\Models\Classes;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\StudentAttendance;
use App\Models\StudentClassAssign;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PDF;

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
        $allStudents = [];
        if(!empty($class_id) AND !empty($section_id) AND !empty($from_date) AND !empty($to_date))
        {
            if($from_date > $to_date)
            {
                return back()->with('error','Kindly select right date');
            }
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
            $allStudents = StudentClassAssign::where('school_id', $school->id)->where('class_id', $class_id)->where('section_id', $section_id)->get();
            $student_attendances = $query->get();
        }
        return view("school.attendance.index")->with(compact('classes','sections','students','student_attendances','dateList','allStudents'));
    }

    public function downloadPDF()
    {
        $class_id = request()->class_id;
        $section_id = request()->section_id;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $student_id = request()->student_id;
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where(['school_id' => $school->id, 'is_deleted' => '0'])->OrderBy('name','ASC')->get();
        $sections = Section::where(['school_id' => $school->id, 'is_deleted' => '0'])->OrderBy('name','ASC')->get();

        if(!empty($class_id) AND !empty($section_id) AND !empty($from_date) AND !empty($to_date))
        {
            if($from_date > $to_date)
            {
                return back()->with('error','Kindly select the right date');
            }
            $dateList = calculateDatesBetween($from_date,$to_date);
            $dateList = array_chunk($dateList, 5); // Split dateList into chunks of 5 entries per row
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
            // return $dateList[0];
        }
        $count = count($dateList)+1;
        $pdf = PDF::loadView('school.attendance.pdf', compact('count','classes','sections','students','student_attendances','dateList'))->setPaper('a4', 'portrait');
        // return $pdf->stream("sadas.pdf");
        return $pdf->download('Attendance Sheet/Class-'.getAttendanceData(request()->class_id,request()->section_id,request()->from_date,request()->to_date).'.pdf');
    }

}
