<?php

namespace App\Http\Controllers\School;

use App\Models\Staff;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\TimeTablePeriod;
use App\Models\StaffAssignClass;
use App\Models\TimeTableSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TimeTableAssignPeriod;
use Illuminate\Support\Facades\Validator;

class AssignPeriodController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $assign_periods = TimeTableAssignPeriod::where('school_id', $school->id)->where('is_deleted','0')->paginate(10);

        return view("school.assign-periods.index")->with(compact('assign_periods','classes'));
    }

    public function create()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $class_ranges = TimeTableSetting::where('school_id', $school->id)->where('is_deleted','0')
        ->distinct()->get(['from_class','to_class']);
        $staffs = Staff::where('school_id',$school->id)->where('is_deleted','0')->get();

        return view("school.assign-periods.create")->with(compact('school', 'classes','class_ranges','staffs'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'class_id1' =>'required',
            'day_range1'    =>  'required',
            'period_id1' =>'required',
            'teacher_id1' =>'required',
            'section_id1' =>'required',
            'subject_id1'    =>  'required',
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
                    'day_range' => $request->input('day_range' . $index),
                    'period_id' => $request->input('period_id' . $index),
                    'teacher_id' => $request->input('teacher_id' . $index),
                    'section_id' => $request->input('section_id' . $index),
                    'subject_id' => $request->input('subject_id' . $index),
                ];
            }
        }
        $result = false;
        foreach($fields as $field) {
            $count = TimeTableAssignPeriod::where('school_id', $school->id)->where('is_deleted','0')
            ->where('class_id', $field['class_id'])
            ->where('time_table_setting_id',$field['day_range'])
            ->where('time_table_period_id',$field['period_id'])
            ->where('section_id',$field['section_id'])
            ->where('subject_id',$field['subject_id'])
            ->count();
            if($count == 0)
            {
                $assign_period = new TimeTableAssignPeriod;
                $assign_period->school_id = $school->id;
                $assign_period->class_id  = $field['class_id'];
                $assign_period->section_id  = $field['section_id'];
                $assign_period->staff_id  = $field['teacher_id'];
                $assign_period->subject_id = $field['subject_id'];
                $assign_period->time_table_setting_id = $field['day_range'];
                $assign_period->time_table_period_id  = $field['period_id'];
                $assign_period->created_by   = Auth::user()->id;
                $assign_period->save();
                $result = true;
            }
        }

        if($result)
        {
            return to_route("school.timetable.assign_periods")->with('success','Periods Assigned successfully');
        }
        else
        {
            return to_route("school.timetable.assign_periods")->with('error','Already Period Assigned');
        }
    }

    public function edit($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $class_ranges = TimeTableSetting::where('school_id', $school->id)->where('is_deleted','0')
        ->distinct()->get(['from_class','to_class']);
        $staffs = Staff::where('school_id',$school->id)->where('is_deleted','0')->get();
        $assignPeriod = TimeTableAssignPeriod::find($id);
        $periods = $this->getPeriodsByClass($assignPeriod->time_table_setting_id);
        $classAllData = $this->getAllDataByClass($assignPeriod->class_id);
        $subjects = $classAllData['subjects'];
        $sections = $classAllData['sections'];
        $day_ranges = $classAllData['day_range'];

        return view("school.assign-periods.edit")->with(compact('school', 'classes','class_ranges','staffs','assignPeriod','day_ranges','periods','sections','subjects'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'class_id1' =>'required',
            'day_range1'    =>  'required',
            'period_id1' =>'required',
            'teacher_id1' =>'required',
            'section_id1' =>'required',
            'subject_id1'    =>  'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $count = TimeTableAssignPeriod::where('school_id', $school->id)->where('is_deleted','0')
            ->where('class_id', $request->class_id1)
            ->where('time_table_setting_id',$request->day_range1)
            ->where('time_table_period_id',$request->period_id1)
            ->where('section_id',$request->section_id1)
            ->where('subject_id',$request->subject_id1)
            ->where('id','!=',$request->id)
            ->count();
        if($count > 0)
        {
            return back()->with('error','Already Period Assigned');
        }

        $assign_period = TimeTableAssignPeriod::find($request->id);
        $assign_period->school_id = $school->id;
        $assign_period->class_id  = $request->class_id1;
        $assign_period->section_id  = $request->section_id1;
        $assign_period->staff_id  = $request->teacher_id1;
        $assign_period->subject_id = $request->subject_id1;
        $assign_period->time_table_setting_id = $request->day_range1;
        $assign_period->time_table_period_id  = $request->period_id1;
        $assign_period->created_by   = Auth::user()->id;
        $assign_period->save();

        return to_route("school.timetable.assign_periods")->with('success','Periods Assigned Updated successfully');
    }

    public function delete(Request $request)
    {
        $period = TimeTableAssignPeriod::find($request->id);
        $period->is_deleted = "1";
        $period->save();
        return back()->with('success','Assign Period Deleted Successfully');
    }

    public function getPeriodsByClass($id)
    {
        $periods = TimeTablePeriod::where('time_table_setting_id',$id)->get();
        return $periods;
    }

    public function getAllDataByClass($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $class = Classes::find($id);
        if(count($class->assignedSections) > 0)
        {
            foreach($class->assignedSections as $sec_index => $section)
            {
                $sections[$sec_index] = [
                    'id' => $section->section->id,
                    'name' => $section->section->name,
                ];
            }
        }
        else
        {
            $sections = null;
        }
        if(count($class->assignedSubjects) > 0)
        {
            foreach($class->assignedSubjects as $sub_index => $subject)
            {
                $subjects[$sub_index] = [
                    'id' => $subject->subject->id,
                    'name' => $subject->subject->name,
                ];
            }
        }
        else
        {
            $subjects = null;
        }

        $day_range = [];
        $time_table_settings = TimeTableSetting::where('from_class','<=',$class->id)->where('to_class','>=',$class->id)->get();
        foreach($time_table_settings as $time_index => $time_setting)
        {
            $day_range[$time_index] = [
                'id' => $time_setting->id,
                'name' => implode(",",json_decode($time_setting->weekdays)),
            ];
        }
        return [
            'subjects' => $subjects,
            'sections' => $sections,
            'day_range' => $day_range,
        ];
    }

    public function viewTimeTable()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $class_id = request()->class_id;
        $section_id = request()->section_id;
        $assign_periods = TimeTableAssignPeriod::where('school_id',$school->id)->where('section_id',$section_id)->get();
        $timetablesetting = TimeTableSetting::find($assign_periods[0]->time_table_setting_id);
        $weekdays = json_decode($timetablesetting->weekdays);
        $start_time = $timetablesetting->start_time;
        $end_time = $timetablesetting->end_time;

        $start_time = [];
        foreach($assign_periods as $assign_period)
        {
            $start_time[] = $assign_period->period->start_time;
            $periods[] = [
                'subject'   => $assign_period->subject->name,
                'teacher'   =>  $assign_period->staff->first_name . ' ' . $assign_period->staff->last_name,
                'start_time'    => $assign_period->period->start_time,
                'end_time' => $assign_period->period->end_time,
            ];
        }
        return view("school.assign-periods.view-timetable")->with(compact('start_time','weekdays','periods'));
    }
}
