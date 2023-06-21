<?php

namespace App\Http\Controllers\School;

use App\Models\Staff;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\TimeTablePeriod;
use Illuminate\Validation\Rule;
use App\Models\TimeTableSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TimetableController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $timetable_settings = TimetableSetting::where('school_id', $school->id)->where('is_deleted','0')->OrderBy('id','DESC')->paginate(10);
        return view("school.timetable.index")->with(compact('timetable_settings'));
    }

    public function create()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $weekdays = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];

        return view("school.timetable.create")->with(compact('school', 'classes','weekdays'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'from_class' =>'required',
            'to_class' =>'required',
            'start_time' =>'required',
            'end_time' =>'required',
            'weekdays' => 'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $weekdays = json_encode($request->weekdays);
        $previousAllData = TimeTableSetting::where('school_id', $school->id)
            ->where('is_deleted','0')
            ->where('from_class',$request->from_class)
            ->where('to_class',$request->to_class)
            ->where('weekdays', $weekdays)
            ->count();

        if($previousAllData > 0)
        {
            return back()->with('error','You have already added same time.')->withInput();
        }

        $timetable_setting = new TimeTableSetting;
        $timetable_setting->school_id = $school->id;
        $timetable_setting->from_class = $request->from_class;
        $timetable_setting->to_class = $request->to_class;
        $timetable_setting->start_time = $request->start_time;
        $timetable_setting->end_time = $request->end_time;
        $timetable_setting->weekdays = $weekdays;
        $timetable_setting->created_by  = Auth::user()->id;
        $timetable_setting->save();

        return to_route("school.timetable.setting")->with('success','Timetable settings created successfully');
    }

    public function edit($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $weekdays = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
        $timetable_setting = TimeTableSetting::find($id);

        return view("school.timetable.edit")->with(compact('school', 'classes','weekdays','timetable_setting'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'from_class' =>'required',
            'to_class' =>'required',
            'start_time' =>'required',
            'end_time' =>'required',
            'weekdays' => 'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $weekdays = json_encode($request->weekdays);
        $previousAllData = TimeTableSetting::where('school_id', $school->id)
            ->where('is_deleted','0')
            ->where('from_class',$request->from_class)
            ->where('to_class',$request->to_class)
            ->where('weekdays', $weekdays)
            ->where('id','!=',$request->id)
            ->count();

        if($previousAllData > 0)
        {
            return back()->with('error','You have already added same time.')->withInput();
        }

        $timetable_setting = TimeTableSetting::find($request->id);
        $timetable_setting->school_id = $school->id;
        $timetable_setting->from_class = $request->from_class;
        $timetable_setting->to_class = $request->to_class;
        $timetable_setting->start_time = $request->start_time;
        $timetable_setting->end_time = $request->end_time;
        $timetable_setting->weekdays = $weekdays;
        $timetable_setting->created_by  = Auth::user()->id;
        $timetable_setting->save();

        return to_route("school.timetable.setting")->with('success','Timetable settings created successfully');
    }

    public function delete(Request $request)
    {
        $timetable_setting = TimeTableSetting::find($request->id);
        $timetable_setting->is_deleted = "1";
        $timetable_setting->save();

        return back()->with('success','Timetable settings Deleted Successfully');
    }

    public function periods()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $periods = TimeTablePeriod::where('school_id', $school->id)->where('is_deleted','0')->OrderBy('id','DESC')->paginate(10);

        return view("school.periods.index")->with(compact('periods'));
    }

    public function createPeriods()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $teachers = Staff::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("first_name", 'asc')->get();

        return view("school.periods.create")->with(compact('school', 'classes','teachers'));
    }

    public function storePeriods(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'class_id' =>'required',
            'subject_id' =>'required',
            'no_of_periods' =>'required',
            'duration' =>'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $count = TimeTablePeriod::where('school_id',$school->id)->where('class_id',$request->class_id)
        ->where('subject_id',$request->subject_id)->where('is_deleted','0')->count();
        if($count > 0) {
            return back()->with('error','Period already exists');
        }
        $periods = new TimeTablePeriod;
        $periods->school_id = $school->id;
        $periods->class_id = $request->class_id;
        $periods->subject_id  = $request->subject_id;
        $periods->no_of_periods = $request->no_of_periods;
        $periods->duration = $request->duration;
        $periods->created_by = Auth::user()->id;
        $periods->save();

        return to_route("school.timetable.periods")->with('success','Periods created successfully');
    }

    public function editPeriods($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $period = TimeTablePeriod::find($id);

        return view("school.periods.edit")->with(compact('period','classes'));
    }

    public function updatePeriods(Request $request)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'class_id' =>'required',
            'subject_id' =>'required',
            'no_of_periods' =>'required',
            'duration' =>'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $count = TimeTablePeriod::where('school_id',$school->id)->where('class_id',$request->class_id)
        ->where('subject_id',$request->subject_id)->where('is_deleted','0')
        ->where('id','!=',$request->id)->count();
        if($count > 0) {
            return back()->with('error','Period already exists');
        }
        $periods = TimeTablePeriod::find($request->id);
        $periods->school_id = $school->id;
        $periods->class_id = $request->class_id;
        $periods->subject_id  = $request->subject_id;
        $periods->no_of_periods = $request->no_of_periods;
        $periods->duration = $request->duration;
        $periods->created_by = Auth::user()->id;
        $periods->save();

        return to_route("school.timetable.periods")->with('success','Periods created successfully');
    }

    public function deletePeriods(Request $request)
    {
        $period = TimeTablePeriod::find($request->id);
        $period->is_deleted = "1";
        $period->save();

        return back()->with('success','Period Deleted Successfully');
    }
}
