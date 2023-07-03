<?php

namespace App\Http\Controllers\School;

use App\Models\Exam;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\ExamTimeSheet;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExamTimeSheetController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $exams = Exam::where(['school_id' => $school->id, 'is_deleted' => '0'])->OrderBy('id','DESC')->get();

        $examsTimeSheet = ExamTimeSheet::where('school_id', $school->id)->where('is_deleted','0')->OrderBy('id','DESC')->paginate(10);
        $timeSheetList = [];
        $examIDLists = [];
        // return $examsTimeSheet;
        foreach($examsTimeSheet as $index => $exam_time_sheet)
        {
            if(!in_array($exam_time_sheet->exam_id,$examIDLists))
            {
                $examData = Exam::find($exam_time_sheet->exam_id);
                $examIDLists[] = $examData->id;
                $timeSheetList[$index]['exam_id'] = $examData->id;
                $timeSheetList[$index]['name'] = $examData->title;
            }
        }
        return view("school.exam-timesheet.index")->with(compact('timeSheetList','examsTimeSheet','exams'));
    }

    public function create()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $exams = Exam::where(['school_id' => $school->id, 'is_deleted' => '0'])->OrderBy('id','DESC')->get();
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();

        return view("school.exam-timesheet.create")->with(compact('exams','classes'));
    }

    public function store(Request $request)
    {
        // return $request;
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'exam_id' =>'required',
            'class_id1'    =>  'required',
            'subject_id1' =>'required',
            'date1' =>'required',
            'start_time1' =>'required',
            'end_time1'    =>  'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $fields = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'class_id') !== false) {
                $index = substr($key, -1);
                $fields[] = [
                    'class_id' => $value,
                    'subject_id' => $request->input('subject_id' . $index),
                    'date' => $request->input('date' . $index),
                    'start_time' => $request->input('start_time' . $index),
                    'end_time' => $request->input('end_time' . $index),
                ];
            }
        }
        $result = false;
        // return $fields;
        foreach($fields as $field) {
            $count = ExamTimeSheet::where('school_id', $school->id)->where('is_deleted','0')
            ->where('exam_id', $request->exam_id)
            ->where('class_id', $field['class_id'])
            ->where('subject_id',$field['subject_id'])
            ->where('date',$field['date'])
            ->count();
            if($count == 0)
            {
                $exam_timesheet = new ExamTimeSheet;
                $exam_timesheet->school_id = $school->id;
                $exam_timesheet->exam_id = $request->exam_id;
                $exam_timesheet->class_id  = $field['class_id'];
                $exam_timesheet->subject_id = $field['subject_id'];
                $exam_timesheet->date = $field['date'];
                $exam_timesheet->start_time  = $field['start_time'];
                $exam_timesheet->end_time  = $field['end_time'];
                $exam_timesheet->created_by   = Auth::user()->id;
                $exam_timesheet->save();
                $result = true;
            }
        }
        if($result)
        {
            return to_route("school.exam-timetable")->with('success','ExamSheet added successfully');
        }
        else
        {
            return to_route("school.exam-timetable")->with('error','Already Exam Sheet Exists');
        }
    }

    public function edit($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $exams = Exam::where(['school_id' => $school->id, 'is_deleted' => '0'])->OrderBy('id','DESC')->get();
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $exam_time_sheet = ExamTimeSheet::where('exam_id',$id)->first();
        if(!$exam_time_sheet)
        {
            return back();
        }
        $exam_time_sheets = ExamTimeSheet::where('exam_id',$id)->where('school_id',$school->id)->where('is_deleted','0')->get();

        return view("school.exam-timesheet.edit")->with(compact('exams','classes','exam_time_sheet','exam_time_sheets'));
    }

    public function update(Request $request)
    {
        // return $request;
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'exam_id' =>'required',
            'class_id1'    =>  'required',
            'subject_id1' =>'required',
            'date1' =>'required',
            'start_time1' =>'required',
            'end_time1'    =>  'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $fields = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'class_id') !== false) {
                $index = substr($key, -1);
                $fields[] = [
                    'class_id' => $value,
                    'subject_id' => $request->input('subject_id' . $index),
                    'date' => $request->input('date' . $index),
                    'start_time' => $request->input('start_time' . $index),
                    'end_time' => $request->input('end_time' . $index),
                ];
            }
        }
        $result = false;
        // return $fields;
        ExamTimeSheet::where('school_id', $school->id)->where('exam_id', $request->exam_id)->delete();
        foreach($fields as $field) {
            $count = ExamTimeSheet::where('school_id', $school->id)->where('is_deleted','0')
            ->where('exam_id', $request->exam_id)
            ->where('class_id', $field['class_id'])
            ->where('subject_id',$field['subject_id'])
            ->where('date',$field['date'])
            ->count();
            if($count == 0)
            {
                $exam_timesheet = new ExamTimeSheet;
                $exam_timesheet->school_id = $school->id;
                $exam_timesheet->exam_id = $request->exam_id;
                $exam_timesheet->class_id  = $field['class_id'];
                $exam_timesheet->subject_id = $field['subject_id'];
                $exam_timesheet->date = $field['date'];
                $exam_timesheet->start_time  = $field['start_time'];
                $exam_timesheet->end_time  = $field['end_time'];
                $exam_timesheet->created_by   = Auth::user()->id;
                $exam_timesheet->save();
                $result = true;
            }
        }
        if($result)
        {
            return to_route("school.exam-timetable")->with('success','ExamSheet updated successfully');
        }
        else
        {
            return to_route("school.exam-timetable")->with('error','Already Exam Sheet Exists');
        }
    }

    public function detail($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $exams = Exam::where(['school_id' => $school->id, 'is_deleted' => '0'])->OrderBy('id','DESC')->get();
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $exam_time_sheet = ExamTimeSheet::where('exam_id',$id)->first();
        if(!$exam_time_sheet)
        {
            return back();
        }
        $exam_time_sheets = ExamTimeSheet::where('exam_id',$id)->where('school_id',$school->id)->where('is_deleted','0')->get();

        return view("school.exam-timesheet.detail")->with(compact('exams','classes','exam_time_sheet','exam_time_sheets'));
    }

    public function delete(Request $request)
    {
        $exam_time_sheets = ExamTimeSheet::where('exam_id', $request->id)->get();
        $exam_time_sheets->each(function($exam_time_sheet) {
            $exam_time_sheet->update([
                'is_deleted' => '1'
            ]);
        });

        return back()->with('success','Exam Time Sheet Deleted Successfully');
    }

    public function getClassByExam($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $exam_time_sheets = ExamTimeSheet::where('exam_id',$id)->where('school_id',$school->id)->where('is_deleted','0')->get();
        $classList = [];
        $classIDList = [];
        foreach($exam_time_sheets as $index => $exam_time_sheet)
        {
            if(!in_array($exam_time_sheet->class_id,$classIDList))
            {
                $classIDList[] = $exam_time_sheet->class_id;
                $classList[] = [
                    'id'    =>$exam_time_sheet->class->id,
                    'name' => $exam_time_sheet->class->name
                ];
            }
        }

        return $classList;
    }

    public function viewTimesheet()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $exams = Exam::where(['school_id' => $school->id, 'is_deleted' => '0'])->OrderBy('id','DESC')->get();
        $class_id = request()->class_id;
        $exam_id = request()->exam_id;
        $examTimeSheet = ExamTimeSheet::where('school_id',$school->id)->where('exam_id',$exam_id)->where('class_id',$class_id)
        ->where('is_deleted','0')->get();
        if(count($examTimeSheet) == 0)
        {
            return back()->with('error','No Record Found');
        }
        $dateList = [];
        $subjects = getSubjectsByClass($class_id);
        foreach($examTimeSheet as $examTimeSheetData)
        {
            if(!in_array(date('d/m/Y',strtotime($examTimeSheetData->date)),$dateList))
            {
                $dateList[] = date('d/m/Y',strtotime($examTimeSheetData->date));
                $timeSheetsData = ExamTimeSheet::where('school_id',$school->id)->where('exam_id',$exam_id)->where('class_id',$class_id)
                ->where('date',$examTimeSheetData->date)->where('is_deleted','0')->get();
                foreach($timeSheetsData as $timeSheet)
                {
                    $timesheets[] = [
                        'subject'   => $timeSheet->subject->name,
                        'date'   =>  date("d/m/Y",strtotime($timeSheet->date)),
                        'start_time'    => $timeSheet->start_time,
                        'end_time' => $timeSheet->end_time,
                    ];
                }

            }
        }
        // return $dateList;
        // return $timesheets;
        return view("school.exam-timesheet.view-timesheet")->with(compact('timesheets','dateList','exams','subjects'));
    }
}
