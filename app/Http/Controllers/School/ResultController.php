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
                $studentsQuery->where('student_id',request()->student_id);
            }
            else
            {
                $subjects = getSubjectsByClass($class_id);
            }
            $students = $studentsQuery->get();
        }
        return view("school.result.index")->with(compact('exams','classes','sections','subjects','students','student_results'));
    }
}
