<?php

namespace App\Http\Controllers\School;

use App\Models\Exam;
use App\Models\Classes;
use App\Models\Section;
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
            $subjects = getSubjectsByClass($class_id);
            $students = StudentClassAssign::where('school_id', $school->id)->where('class_id', $class_id)->where('section_id', $section_id)->get();
            // return $students;
            $student_results = StudentResult::where('school_id',$school->id)->where('class_id', $class_id)->where('section_id', $section_id)->get();
            // return $student_results;
        }
        // foreach($examTimeSheet as $examTimeSheetData)
        // {
        //     if(!in_array(date('d/m/Y',strtotime($examTimeSheetData->date)),$dateList))
        //     {
        //         $dateList[] = date('d/m/Y',strtotime($examTimeSheetData->date));
        //         $timeSheetsData = ExamTimeSheet::where('school_id',$school->id)->where('exam_id',$exam_id)->where('class_id',$class_id)
        //         ->where('date',$examTimeSheetData->date)->where('is_deleted','0')->get();
        //         foreach($timeSheetsData as $timeSheet)
        //         {
        //             $timesheets[] = [
        //                 'subject'   => $timeSheet->subject->name,
        //                 'date'   =>  date("d/m/Y",strtotime($timeSheet->date)),
        //                 'start_time'    => $timeSheet->start_time,
        //                 'end_time' => $timeSheet->end_time,
        //             ];
        //         }

        //     }
        // }
        return view("school.result.index")->with(compact('exams','classes','sections','subjects','students','student_results'));
    }
}
