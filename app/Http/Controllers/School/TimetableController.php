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
        $periodsQuery = TimeTablePeriod::where('school_id', $school->id)->where('is_deleted','0')->OrderBy('id','DESC')->paginate(10);
        $periods = [];
        $daySettingList = [];
        foreach($periodsQuery as $index => $period)
        {
            if(!in_array($period->time_table_setting_id,$daySettingList))
            {
                $timetablesetting = TimeTableSetting::find($period->time_table_setting_id);
                $daySettingList[] = $period->time_table_setting_id;
                $periods[$index]['id'] = $period->id;
                $periods[$index]['class_id'] = $period->class->id;
                $periods[$index]['class'] = $period->class->name;
                $periods[$index]['days_id'] = $timetablesetting->id;
                $periods[$index]['days'] = implode(",",json_decode($timetablesetting->weekdays));
            }
        }

        return view("school.periods.index")->with(compact('periods','periodsQuery'));
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
            'date_range'    =>  'required',
            'subject_id1' =>'required',
            'staff_id1' =>'required',
            'start_time1' =>'required',
            'end_time1' =>'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $fields = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'subject_id') !== false) {
                $index = substr($key, -1);
                $fields[] = [
                    'subject_id' => $value,
                    'staff_id' => $request->input('staff_id' . $index),
                    'start_time' => $request->input('start_time' . $index),
                    'end_time' => $request->input('end_time' . $index),
                ];
            }
        }

        foreach($fields as $field) {
            $count = TimeTablePeriod::where('school_id', $school->id)->where('subject_id',$field['subject_id'])->where('class_id',$request->class_id)
            ->where('time_table_setting_id',$request->date_range)
            ->where('is_deleted','0')->count();
            if($count == 0)
            {
                $period = new TimeTablePeriod;
                $period->school_id = $school->id;
                $period->class_id  = $request->class_id;
                $period->time_table_setting_id  = $request->date_range;
                $period->subject_id = $field['subject_id'];
                $period->staff_id = $field['staff_id'];
                $period->start_time = $field['start_time'];
                $period->end_time = $field['end_time'];
                $period->created_by = Auth::user()->id;
                $period->save();
            }
        }

        return to_route("school.timetable.periods")->with('success','Periods created successfully');
    }

    public function editPeriods($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $teachers = Staff::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("first_name", 'asc')->get();
        $curPeriod = TimeTablePeriod::where('time_table_setting_id',$id)->first();
        $classData = Classes::find($curPeriod->class_id);
        $periods = TimeTablePeriod::where('time_table_setting_id',$id)->where('school_id',$school->id)->get();
        $subjects = $this->getSectionsByClass($classData->id);
        $day_ranges = $this->getDateRange($classData->id);

        return view("school.periods.edit")->with(compact('periods','classes','teachers','classData','subjects','day_ranges','curPeriod'));
    }

    public function updatePeriods(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'class_id' =>'required',
            'date_range'    =>'required',
            'subject_id1' =>'required',
            'staff_id1' =>'required',
            'start_time1' =>'required',
            'end_time1' =>'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $fields = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'subject_id') !== false) {
                $index = substr($key, -1);
                $fields[] = [
                    'subject_id' => $value,
                    'staff_id' => $request->input('staff_id' . $index),
                    'start_time' => $request->input('start_time' . $index),
                    'end_time' => $request->input('end_time' . $index),
                ];
            }
        }
        TimeTablePeriod::where('school_id', $school->id)->where('class_id',$request->class_id)
        ->where('time_table_setting_id',$request->id)->where('is_deleted', '0')->delete();
        foreach($fields as $field) {
            $count = TimeTablePeriod::where('school_id', $school->id)->where('subject_id',$field['subject_id'])->where('class_id',$request->class_id)
            ->where('time_table_setting_id',$request->id)
            ->where('is_deleted','0')->count();
            if($count == 0)
            {
                $period = new TimeTablePeriod;
                $period->school_id = $school->id;
                $period->class_id  = $request->class_id;
                $period->time_table_setting_id  = $request->date_range;
                $period->subject_id = $field['subject_id'];
                $period->staff_id = $field['staff_id'];
                $period->start_time = $field['start_time'];
                $period->end_time = $field['end_time'];
                $period->created_by = Auth::user()->id;
                $period->save();
            }
        }

        return to_route("school.timetable.periods")->with('success','Periods updated successfully');
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
        // foreach ($weekdays as $day) {
        //     if($day == 'Monday')
        //     {
        //         $day_index = 0;
        //     }
        //     elseif($day == 'Tuesday')
        //     {
        //         $day_index = 1;
        //     }
        //     elseif($day == 'Wednesday')
        //     {
        //         $day_index = 2;
        //     }
        //     elseif($day == 'Thursday')
        //     {
        //         $day_index = 3;
        //     }
        //     elseif($day == 'Friday')
        //     {
        //         $day_index = 4;
        //     }
        //     elseif($day == 'Saturday')
        //     {
        //         $day_index = 5;
        //     }
        //     elseif($day == 'Sunday')
        //     {
        //         $day_index = 6;
        //     }
        //     foreach ($periods as $key => $period) {
        //         $eventData[] = [
        //             'day_index' => $day_index,
        //             'day' => $day,
        //             'id' => $period->id,
        //             // 'time' => date("h:i a", strtotime($period->start_time)),
        //             // 'end_time' => date("h:i a", strtotime($period->end_time)),
        //             'time' => $period->start_time,
        //             'end_time' => $period->end_time,
        //             'subject' => $period->subject->name
        //         ];
        //     }
        // }
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
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $class = Classes::find($id);
        $timetablesettings = TimeTableSetting::where('school_id',$school->id)
        ->orWhere('from_class' ,$class->id)
        ->orWhere('to_class' ,$class->id)
        ->get();
        $day_range = [];
        foreach($timetablesettings as $key => $timetable_setting)
        {
            $day_range[$key]['id'] = $timetable_setting->id;
            $day_range[$key]['days'] = implode(",",json_decode($timetable_setting->weekdays));
        }
        return $day_range;
    }
}
