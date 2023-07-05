<?php

namespace App\Http\Controllers\School;

use App\Models\Exam;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\StudentResult;
use App\Models\StudentClassAssign;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PDF;

class ResultController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $exams = Exam::where(['school_id' => $school->id, 'is_deleted' => '0'])->OrderBy('id','DESC')->get();
        $classes = Classes::where(['school_id' => $school->id, 'is_deleted' => '0'])->OrderBy('name','ASC')->get();
        $sections = Section::where(['school_id' => $school->id, 'is_deleted' => '0'])->OrderBy('name','ASC')->get();

        $class_id = request()->class_id;
        $section_id = request()->section_id;
        $exam_id = request()->exam_id;
        $subjects = [];
        $students = [];
        $student_results = [];
        $allStudents = [];
        if(!empty($class_id) AND !empty($section_id) AND !empty($exam_id))
        {

            $studentsQuery = StudentClassAssign::where('school_id', $school->id)->where('class_id', $class_id)->where('section_id', $section_id);
            $student_results = StudentResult::where('school_id',$school->id)->where('class_id', $class_id)->where('section_id', $section_id)->get();
            if(!empty(request()->student_id))
            {
                $studentsQuery->where('student_id',request()->student_id);
            }

            if(!empty(request()->subject_id))
            {
                $subject = Subject::find(request()->subject_id);
                $subjects[] = [
                    'id' => $subject->id,
                    'name' => $subject->name
                ];
            }
            else
            {
                $subjects = getSubjectsByClass($class_id);
            }
            $allStudents = StudentClassAssign::where('school_id', $school->id)->where('class_id', $class_id)->where('section_id', $section_id)->get();
            $students = $studentsQuery->get();
        }
        return view("school.result.index")->with(compact('exams','classes','sections','subjects','students','student_results','allStudents'));
    }

    public function downloadPDF()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $class_id = request()->class_id;
        $section_id = request()->section_id;
        $exam_id = request()->exam_id;
        $subject_id = request()->subject_id;
        $student_id = request()->student_id;
        $subject = null;

        if(!empty($class_id) AND !empty($section_id) AND !empty($exam_id))
        {

            $studentsQuery = StudentClassAssign::where('school_id', $school->id)->where('class_id', $class_id)->where('section_id', $section_id);
            $student_results = StudentResult::where('school_id',$school->id)->where('class_id', $class_id)->where('section_id', $section_id)->get();
            if(!empty(request()->student_id))
            {
                $studentsQuery->where('student_id',request()->student_id);
            }

            if(!empty(request()->subject_id))
            {
                $subject = Subject::find(request()->subject_id);
                $subjects[] = [
                    'id' => $subject->id,
                    'name' => $subject->name
                ];
            }
            else
            {
                $subjects = getSubjectsByClass($class_id);
            }
            $subjects = array_chunk($subjects, 5);
            $allStudents = StudentClassAssign::where('school_id', $school->id)->where('class_id', $class_id)->where('section_id', $section_id)->get();
            $students = $studentsQuery->get();

            $count = count($subjects)+1;
            $pdf = PDF::loadView('school.result.pdf', compact('count','subject','subjects','students','student_results'))->setPaper('a4', 'portrait');
            // return $pdf->stream("sadasd.pdf");
            return $pdf->download('Attendance Sheet/Class-'.getAttendanceData(request()->class_id,request()->section_id,request()->from_date,request()->to_date).'.pdf');
        }
    }
}
