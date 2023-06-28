<?php

namespace App\Http\Controllers\School;

use App\Models\Staff;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\TimeTablePeriod;
use Illuminate\Validation\Rule;
use App\Models\TimeTableSetting;
use App\Models\ClassAssignSubject;
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

        $countRange = TimeTableSetting::where('school_id', $school->id)
        ->where('to_class',$request->from_class)
        ->count();
        if($countRange > 0)
        {
            return back()->with('error','You have already added same time.You cant add between already slots');
        }

        $count = TimeTableSetting::where('school_id', $school->id)
        ->where('from_class','<=',$request->from_class)
        ->where('to_class','>=',$request->to_class)
        ->count();

        if($count > 0)
        {
            return back()->with('error','You have already added same time.You cant add between already slots');
        }

        $array = [
            $request->from_class,
            $request->to_class
        ];
        $class_range = json_encode($array);
        $timetable_setting = new TimeTableSetting;
        $timetable_setting->school_id = $school->id;
        $timetable_setting->from_class = $request->from_class;
        $timetable_setting->to_class = $request->to_class;
        $timetable_setting->class_range = $class_range;
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
        $timetable_setting->class_range = [$request->from_class,$request->to_class];
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
        $timetable_setting->delete();

        return back()->with('success','Timetable settings Deleted Successfully');
    }

    public function periods()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $periodsQuery = TimeTablePeriod::where('school_id', $school->id)->where('is_deleted','0')->OrderBy('id','DESC')->paginate(10);
        $periods = [];
        $daySettingList = [];
        foreach($periodsQuery as $index => $period)
        {
            if(!in_array($period->time_table_setting_id,$daySettingList))
            {
                $timetablesetting = TimeTableSetting::find($period->time_table_setting_id);
                $daySettingList[] = $period->time_table_setting_id;
                $periods[$index]['id'] = $period->time_table_setting_id;
                $periods[$index]['title'] = $period->title;
                $periods[$index]['class'] = $timetablesetting->fromClass->name.'-'.$timetablesetting->toClass->name;
                $periods[$index]['days'] = implode(",",json_decode($timetablesetting->weekdays));
            }
        }
        return view("school.periods.index")->with(compact('periods','periodsQuery'));
    }

    public function createPeriods()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $class_ranges = TimeTableSetting::where('school_id', $school->id)->where('is_deleted','0')
        ->distinct()->get(['from_class','to_class']);

        return view("school.periods.create")->with(compact('school', 'classes','class_ranges'));
    }

    public function storePeriods(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'class_id' =>'required',
            'date_range'    =>  'required',
            'start_time1' =>'required',
            'end_time1' =>'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $fields = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'title') !== false) {
                $index = substr($key, -1);
                $fields[] = [
                    'title' => $value,
                    'start_time' => $request->input('start_time' . $index),
                    'end_time' => $request->input('end_time' . $index),
                ];
            }
        }
        $result = false;
        foreach($fields as $field) {
            $count = TimeTablePeriod::where(['school_id'=> $school->id,'time_table_setting_id' => $request->date_range,'is_deleted' => '0'])
            ->where('start_time','<=',$field['start_time'])
            ->where('end_time','>=',$field['end_time'])
            ->count();
            $countPeriodTime = TimeTablePeriod::where(['school_id'=> $school->id,'time_table_setting_id' => $request->date_range,'title' => $field['title'],'is_deleted' => '0'])->count();
            if($count == 0 AND $countPeriodTime == 0)
            {
                $period = new TimeTablePeriod;
                $period->school_id = $school->id;
                $period->time_table_setting_id  = $request->date_range;
                $period->title = $field['title'];
                $period->start_time = $field['start_time'];
                $period->end_time = $field['end_time'];
                $period->created_by = Auth::user()->id;
                $period->save();
                $result = true;
            }
        }
        if($result)
        {
            return to_route("school.timetable.periods")->with('success','Periods created successfully');
        }
        else
        {
            return to_route("school.timetable.periods")->with('error','Periods could not be added. Already exists.');
        }
    }

    public function editPeriods($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);

        $class_ranges = TimeTableSetting::where('school_id', $school->id)->where('is_deleted','0')
        ->distinct()->get(['from_class','to_class']);
        $timetable_setting = TimeTableSetting::where('id',$id)->first();
        $curPeriod = TimeTablePeriod::where('time_table_setting_id',$id)->first();
        $class_id = $timetable_setting->from_class.'-'.$timetable_setting->to_class;
        $day_range_id = $id;
        $curClass_range = $timetable_setting->fromClass->id.'-'.$timetable_setting->toClass->id;
        $periods = TimeTablePeriod::where('time_table_setting_id',$id)->where('school_id',$school->id)->get();

        return view("school.periods.edit")->with(compact('periods','curPeriod','class_ranges','curClass_range','class_id','day_range_id'));
    }

    public function updatePeriods(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'class_id' =>'required',
            'date_range'    =>'required',
            'start_time1' =>'required',
            'end_time1' =>'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $fields = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'title') !== false) {
                $index = substr($key, -1);
                $fields[] = [
                    'title' => $value,
                    'start_time' => $request->input('start_time' . $index),
                    'end_time' => $request->input('end_time' . $index),
                ];
            }
        }
        $result = false;
        foreach($fields as $key => $field) {
            $count = TimeTablePeriod::where(['school_id'=> $school->id,'time_table_setting_id' => $request->date_range,'is_deleted' => '0'])
            ->where('start_time','<=',$field['start_time'])
            ->where('end_time','>=',$field['end_time'])
            ->count();
            $countPeriodTime = TimeTablePeriod::where(['school_id'=> $school->id,'time_table_setting_id' => $request->date_range,'title' => $field['title'],'is_deleted' => '0'])->count();

            if($count == 0 AND $countPeriodTime == 0)
            {
                if($key == 0)
                {
                    TimeTablePeriod::where('school_id', $school->id)->where('time_table_setting_id',$request->id)->where('is_deleted', '0')->delete();
                }

                $period = new TimeTablePeriod;
                $period->school_id = $school->id;
                $period->time_table_setting_id  = $request->date_range;
                $period->title = $field['title'];
                $period->start_time = $field['start_time'];
                $period->end_time = $field['end_time'];
                $period->created_by = Auth::user()->id;
                $period->save();
                $result = true;
            }

        }
        if($result)
        {
            return to_route("school.timetable.periods")->with('success','Periods updated successfully');
        }
        else
        {
            return to_route("school.timetable.periods")->with('error','Periods could not be added. Already exists.');
        }
    }

    public function getSectionsByClass($id)
    {
        $subjects = ClassAssignSubject::with(['subject', 'schoolClass'])
            ->whereHas('schoolClass', function ($query) use($id) {
                $query->where('id', $id);
            })
            ->get();

            $newArr = [];
        foreach ($subjects as $index =>$subject) {
            $newArr[$index]['id'] = $subject->subject_id;
            $newArr[$index]['name'] = $subject->subject->name;
        }
        return $newArr;
    }

    public function deletePeriods(Request $request)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $periods = TimeTablePeriod::where('time_table_setting_id',$request->id)->where('school_id',$school->id)->get();
        foreach($periods as $period)
        {
            $periodData = TimeTablePeriod::find($period->id);
            $periodData->is_deleted = "1";
            $periodData->save();
        }


        return back()->with('success','Period Deleted Successfully');
    }

    public function detailPeriods($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $periods = TimeTablePeriod::where('time_table_setting_id',$id)->where('school_id',$school->id)->get();
        $idsList = [];
        $weekdays = [];
        $eventData = [];
        foreach($periods as $key => $period)
        {
            if(!in_array($period->time_table_setting_id,$idsList))
            {
                $idsList[] = $period->time_table_setting_id;
                $timetable_setting = TimeTableSetting::find($period->time_table_setting_id);
                $weekdays = json_decode($timetable_setting->weekdays);
            }
        }
        $data = [];
        foreach ($weekdays as $day) {
            if ($day == 'Monday') {
                $day_index = 0;
            } elseif ($day == 'Tuesday') {
                $day_index = 1;
            } elseif ($day == 'Wednesday') {
                $day_index = 2;
            } elseif ($day == 'Thursday') {
                $day_index = 3;
            } elseif ($day == 'Friday') {
                $day_index = 4;
            } elseif ($day == 'Saturday') {
                $day_index = 5;
            } elseif ($day == 'Sunday') {
                $day_index = 6;
            }
            $periodsData = [];
            foreach ($periods as $key => $period) {
                    $periodsData[] = [
                        'start' => $period->start_time,
                        'end' => $period->end_time,
                        'title' => $period->subject->name,
                    ];
            }

            if (!empty($periodsData)) {
                $data[] = [
                    'day' => $day_index,
                    'periods' => $periodsData
                ];
            }
        }

        $response = json_encode($data);
        return view("school.periods.detail")->with(compact('periods','school','weekdays','eventData','response'));
    }

    public function getDateRange($id)
    {
        $explode = explode('-', $id);
        $from_class = $explode[0];
        $to_class = $explode[1];
        $school = getSchoolInfoByUsername(Auth::user()->username);

        $timetablesettings = TimeTableSetting::where('school_id',$school->id)
        ->where('from_class' ,$from_class)
        ->where('to_class' ,$to_class)
        ->get();

        $day_range = [];
        foreach($timetablesettings as $key => $timetable_setting)
        {
            // $count = TimeTablePeriod
            $day_range[$key]['id'] = $timetable_setting->id;
            $day_range[$key]['days'] = implode(",",json_decode($timetable_setting->weekdays));
        }
        return $day_range;
    }

    public function getTimeRange($class_id,$day_range)
    {
        $explode = explode('-', $class_id);
        $from_class = $explode[0];
        $to_class = $explode[1];
        $school = getSchoolInfoByUsername(Auth::user()->username);

        $timetablesettings = TimeTableSetting::where('school_id',$school->id)
        ->where('from_class' ,$from_class)
        ->where('to_class' ,$to_class)
        ->where('id',$day_range)
        ->first();
        $timetablesettings['end_time'] = date('H:i', strtotime($timetablesettings->end_time) + 60);
        return $timetablesettings;
    }
}
