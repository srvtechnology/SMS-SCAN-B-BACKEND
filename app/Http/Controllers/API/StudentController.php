<?php

namespace App\Http\Controllers\API;

use DateTime;
use App\Models\User;
use App\Models\Staff;
use App\Models\Student;
use App\Models\HomeWork;
use Illuminate\Http\Request;
use App\Models\StudyMaterial;
use App\Models\TimeTableSetting;
use App\Models\StudentAttendance;
use App\Models\StudentClassAssign;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TimeTableAssignPeriod;
use App\Models\StudentLeaveApplication;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    protected $user;
    protected $school;
    protected $student;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->initializeVariables();

            return $next($request);
        });
    }

    protected function initializeVariables()
    {
        $this->user = User::where('id', Auth::user()->id)->first();
        $this->school = $this->user->school;
        $this->student = Student::where('username',Auth::user()->username)->first();
    }

    public function viewAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }
        $from_date = date("Y-m-d",strtotime($request->from_date));
        $to_date = date("Y-m-d",strtotime($request->to_date));

        if($from_date > $to_date)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Kindly select right date'
            ],401);
        }
        $dateList = calculateDatesBetween($from_date,$to_date);

        //Calculate days
        $startDate = new DateTime($from_date);
        $endDate = new DateTime($to_date);
        $interval = $startDate->diff($endDate);
        $daysCount = $interval->days;

        $prensentHistory = StudentAttendance::select('date','attendance')->where('school_id', $this->school->id)->where('student_id',$this->student->id)
            ->whereDate('date','>=',$from_date)->whereDate('date','<=',$to_date)
            ->where('attendance','1')->get();

        $absentHistory = StudentAttendance::select('date','attendance')->where('school_id', $this->school->id)->where('student_id',$this->student->id)
            ->whereDate('date','>=',$from_date)->whereDate('date','<=',$to_date)
            ->where('attendance','0')->get();

        $leaveHistory = StudentAttendance::select('date','attendance')->where('school_id', $this->school->id)->where('student_id',$this->student->id)
            ->whereDate('date','>=',$from_date)->whereDate('date','<=',$to_date)
            ->where('attendance','2')->get();

        $prensentHistoryPercentage = (count($prensentHistory) / $daysCount) * 100;
        $prensentHistoryPercentage = number_format($prensentHistoryPercentage, 2);

        $absentHistoryPercentage = (count($absentHistory) / $daysCount) * 100;
        $absentHistoryPercentage = number_format($absentHistoryPercentage, 2);

        $leaveHistoryPercentage = (count($leaveHistory) / $daysCount) * 100;
        $leaveHistoryPercentage = number_format($leaveHistoryPercentage, 2);

        $history = [
            'present_percentage' => (float)$prensentHistoryPercentage,
            'absent_percentage' => (float)$absentHistoryPercentage,
            'leave_percentage' => (float)$leaveHistoryPercentage,
            'attendance_not_added_percentage' => 100 - ($prensentHistoryPercentage + $absentHistoryPercentage + $leaveHistoryPercentage)
        ];

        $response = [
            'history' => $history,
            'present' => $prensentHistory,
            'absent' => $absentHistory,
            'leave' => $leaveHistory
        ];
        return $response;

        // $attendance_history = [
        //     'absent_history' =>
        // ];
        return $attendance_history;

        // foreach($dateList as $dateData)
        // {
        //     return getStudentAttendance($request->class_id,$request->section_id,$this->student->id,$dateData['date']);
        // }
        // return "end";

        // $attendance_bit = getStudentAttendance($request->class_id,$request->section_id,$this->student->id,$date);
        // if($attendance_bit == "-")
        // {
        //     $attendance_bit = null;
        // }
        // $response[] = [
        //     'id' => $student->id,
        //     'name' => $student->first_name.' '.$student->last_name,
        //     'gender' => $student->gender,
        //     'attendance' => $attendance_bit,
        //     'date' =>$date
        // ];
    }

    public function applyLeave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }
        if(empty($request->message) AND empty($request->file))
        {
            $validator = Validator::make($request->all(), [
                'message' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ],401);
            }
        }

        $student_assign_classess = StudentClassAssign::where('school_id',$this->school->id)->where('student_id',$this->student->id)->first();
        if(!$student_assign_classess)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Record Found.'
            ],401);
        }
        $staff = Staff::where('school_id',$this->school->id)->where('assign_class_to_class_teacher',$student_assign_classess->class_id)
        ->where('assign_section_to_class_teacher',$student_assign_classess->section_id)->where('is_deleted','0')->first();

        $leave_application = new StudentLeaveApplication;
        $leave_application->school_id = $this->school->id;
        $leave_application->staff_id = $staff->id;
        $leave_application->student_id = $this->student->id;
        $leave_application->subject = "Leave Application";
        $leave_application->message = !empty($request->message) ? $request->message : "";
        $leave_application->date = date("Y-m-d",strtotime($request->date));
        if($request->hasFile("file"))
        {
            $image = $request->file('file');
            $imageName = Auth::user()->id.time() . '.' . $image->extension();
            $image->move(public_path('uploads/schools/leave'), $imageName);
            $leave_application->file = $imageName;
        }
        $result = $leave_application->save();
        if($result)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'Leave Application has been submitted successfully',
            ],200);
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ],401);
        }
    }

    public function viewLeaveApplication()
    {

        $leave_applications = StudentLeaveApplication::where('school_id',$this->school->id)->where('student_id',$this->student->id)->OrderBy('id','DESC')->get();
        if(count($leave_applications) > 0)
        {
            foreach($leave_applications as $key => $leave_application)
            {
                if(!empty($leave_application->file) AND file_exists(public_path('uploads/schools/leave').'/'.$leave_application->file))
                {
                    $leave_applications[$key]['file'] = asset("uploads/schools/leave/".$leave_application->file);
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => 'All Leave Applications',
                'data' => $leave_applications
            ],200);
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'NO Record Found',
            ],404);
        }
    }

    public function viewHomeWork()
    {
        $student_assign_classess = StudentClassAssign::where('school_id',$this->school->id)->where('student_id',$this->student->id)->first();
        if($student_assign_classess)
        {
            $homeworks = HomeWork::select('id','title','description','files','due_date','date')->where('school_id',$this->school->id)->where('class_id',$student_assign_classess->class_id)->where('section_id',$student_assign_classess->section_id)
                ->where('type','homework')->where('is_deleted','0')->OrderBy('id','DESC')->get();
                if(count($homeworks) > 0)
                {
                    foreach ($homeworks as $key => $homework) {
                        $explode = explode(",", $homework->files);
                        $modifiedFiles = [];
                        if(!empty($homework->files))
                        {
                            foreach ($explode as $file_index => $fileName) {
                                $filePath = public_path('uploads/schools/homework') . '/' . $fileName;
                                if (file_exists($filePath)) {
                                    $modifiedFiles[$file_index] = asset("uploads/schools/homework/" . $fileName);
                                }
                            }
                            $homework->files = $modifiedFiles;
                        }
                    }
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Home Works.',
                        'data' => $homeworks
                    ],200);
                }
                else
                {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'No Record Found.'
                    ],404);
                }
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Record Found.'
            ],404);
        }
    }

    public function viewSyllabus()
    {
        $student_assign_classess = StudentClassAssign::where('school_id',$this->school->id)->where('student_id',$this->student->id)->first();
        if($student_assign_classess)
        {
            $homeworks = HomeWork::select('id','title','description','files','due_date','date')->where('school_id',$this->school->id)->where('class_id',$student_assign_classess->class_id)->where('section_id',$student_assign_classess->section_id)
                ->where('type','syllabus')->where('is_deleted','0')->OrderBy('id','DESC')->get();
                if(count($homeworks) > 0)
                {
                    foreach ($homeworks as $key => $homework) {
                        $explode = explode(",", $homework->files);
                        $modifiedFiles = [];
                        if(!empty($homework->files))
                        {
                            foreach ($explode as $file_index => $fileName) {
                                $filePath = public_path('uploads/schools/syllabus') . '/' . $fileName;
                                if (file_exists($filePath)) {
                                    $modifiedFiles[$file_index] = asset("uploads/schools/syllabus/" . $fileName);
                                }
                            }
                            $homework->files = $modifiedFiles;
                        }
                    }
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Home Works.',
                        'data' => $homeworks
                    ],200);
                }
                else
                {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'No Record Found.'
                    ],404);
                }
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Record Found.'
            ],404);
        }
    }

    public function viewResources()
    {
        $student_assign_classess = StudentClassAssign::where('school_id',$this->school->id)->where('student_id',$this->student->id)->first();
        if($student_assign_classess)
        {
            $resources = StudyMaterial::select('id','title','type','media')->where('school_id',$this->school->id)->where('is_deleted','0')
            ->where('class_id',$student_assign_classess->class_id)->get();
            if(count($resources) > 0)
            {
                foreach ($resources as $key => $resource) {
                    if(!empty($resource->media))
                    {
                        $filePath = public_path('uploads/schools/study-material') . '/' . $resource->media;
                        if (file_exists($filePath)) {
                            $resources[$key]["media"] = asset("uploads/schools/study-material/" . $resource->media);
                        }
                    }
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Resources',
                    'data' => $resources
                ],200);
            }
            else
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No Record Found'
                ],404);
            }
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Record Found'
            ],404);
        }


    }

    public function viewTimeTable()
    {
        $student_assign_classess = StudentClassAssign::where('school_id',$this->school->id)->where('student_id',$this->student->id)->first();
        if(!$student_assign_classess)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Record Found.'
            ],401);
        }
        $class_id = $student_assign_classess->class_id;
        $section_id = $student_assign_classess->section_id;
        $assign_periods = TimeTableAssignPeriod::where('school_id',$this->school->id)->where('class_id',$class_id)
        ->where('section_id',$section_id)->get();
        if(count($assign_periods) == 0)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Record Found.'
            ],401);
        }
        $timetablesetting = TimeTableSetting::find($assign_periods[0]->time_table_setting_id);
        $weekdays = json_decode($timetablesetting->weekdays);

        $finalResponse = null;
        foreach($weekdays as $key => $weekday)
        {
            $finalResponse[$key]['day'] = $weekday;
            foreach($assign_periods as $index => $assign_period)
            {
                $periods[$index]['subject'] = $assign_period->period->title;
                $periods[$index]['teacher'] = $assign_period->staff->first_name . ' ' . $assign_period->staff->last_name;
                $periods[$index]['start_time'] = $assign_period->period->start_time;
                $periods[$index]['end_time'] = $assign_period->period->end_time;
            }
            $finalResponse[$key]['periods'] = $periods;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'All Data',
            'data' => $finalResponse
        ],401);
    }
}
