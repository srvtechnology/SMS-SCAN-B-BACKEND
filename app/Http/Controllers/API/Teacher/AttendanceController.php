<?php

namespace App\Http\Controllers\API\Teacher;

use App\Models\User;
use App\Models\Staff;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use App\Models\StudentAttendance;
use App\Models\StudentClassAssign;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function studentList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'section_id' => 'required',
            'date' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }

        $classCount = Classes::find($request->class_id);
        if(!$classCount)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Class Found.'
            ],401);
        }

        $sectionCount = Section::find($request->class_id);
        if(!$sectionCount)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Section Found.'
            ],401);
        }

        $user = User::where('id',Auth::user()->id)->first();
        $school = $user->school;
        $staff = Staff::where('username',Auth::user()->username)->first();
        if(empty($staff->assign_class_to_class_teacher) AND empty($staff->assign_section_to_class_teacher))
        {
            return response()->json([
                'status' => 'success',
                'message' => 'This Teacher is not a Class Teacher of any class yet.'
            ],401);
        }

        $response = null;
        $student_assign_classes = StudentClassAssign::where('school_id', $school->id)
        ->where('class_id', $request->class_id)
        ->where('section_id', $request->section_id)
        ->get();
        $date = date("Y-m-d",strtotime($request->date));
        if(count($student_assign_classes))
        {
            foreach($student_assign_classes as $class)
            {
                $student = Student::find($class->student_id);
                $attendance_bit = getStudentAttendance($request->class_id,$request->section_id,$student->id,$date);
                if($attendance_bit == "-")
                {
                    $attendance_bit = null;
                }
                $response[] = [
                    'id' => $student->id,
                    'name' => $student->first_name.' '.$student->last_name,
                    'gender' => $student->gender,
                    'attendance' => $attendance_bit,
                    'date' =>$date
                ];
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Students Attendance',
                'data' => $response
            ],200);
        }
        else
        {
            return response()->json([
                'status' => 'success',
                'message' => 'No Data Found'
            ],404);
        }
    }

    public function addStudentAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'section_id' => 'required',
            'date' => 'required',
            'student_id' => 'required',
            'attendance' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }

        $classCount = Classes::find($request->class_id);
        if(!$classCount)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Class Found.'
            ],401);
        }

        $sectionCount = Section::find($request->class_id);
        if(!$sectionCount)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Section Found.'
            ],401);
        }

        $student = Student::find($request->student_id);
        if(!$student)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Student Found.'
            ],401);
        }

        $user = User::where('id',Auth::user()->id)->first();
        $school = $user->school;
        $staff = Staff::where('username',Auth::user()->username)->first();
        if(!empty($staff->assign_class_to_class_teacher) AND !empty($staff->assign_section_to_class_teacher))
        {
            if($staff->assign_class_to_class_teacher == $request->class_id AND $staff->assign_section_to_class_teacher == $request->section_id)
            {
                if($request->attendance == 0)
                {
                    $attendance_bit = 0;
                }
                else if($request->attendance == 1)
                {
                    $attendance_bit = 1;
                }
                else
                {
                    $attendance_bit = 2;
                }
                $student_attendance = StudentAttendance::where('school_id',$school->id)
                ->where('class_id',$request->class_id)
                ->where('section_id',$request->section_id)
                ->where('staff_id',$staff->id)
                ->where('student_id',$student->id)
                ->first();
                if(!$student_attendance)
                {
                    $student_attendance = new StudentAttendance;
                }

                $student_attendance->school_id = $school->id;
                $student_attendance->class_id = $request->class_id;
                $student_attendance->section_id = $request->section_id;
                $student_attendance->staff_id = $staff->id;
                $student_attendance->student_id = $student->id;
                $student_attendance->date = date("Y-m-d H:i:s",strtotime($request->date));
                $student_attendance->attendance = $attendance_bit;
                $student_attendance->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Attendance added Successfully'
                ],200);
            }
            else
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You have no right to take attendance of this class'
                ],401);
            }
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'This Teacher is not a Class Teacher of any class yet.'
            ],401);
        }
    }

    public function viewStudents(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'section_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }

        $classCount = Classes::find($request->class_id);
        if(!$classCount)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Class Found.'
            ],401);
        }

        $sectionCount = Section::find($request->class_id);
        if(!$sectionCount)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Section Found.'
            ],401);
        }

        $user = User::where('id',Auth::user()->id)->first();
        $school = $user->school;
        $staff = Staff::where('username',Auth::user()->username)->first();
        $response = null;
        $student_assign_classes = StudentClassAssign::where('school_id', $school->id)
        ->where('class_id', $request->class_id)
        ->where('section_id', $request->section_id)
        ->get();
        if(count($student_assign_classes))
        {
            foreach($student_assign_classes as $class)
            {
                $student = Student::find($class->student_id);
                $response[] = [
                    'id' => $student->id,
                    'name' => $student->first_name.' '.$student->last_name,
                    'gender' => $student->gender,
                ];
            }

            return response()->json([
                'status' => 'success',
                'message' => 'View All Students',
                'data' => $response
            ],200);
        }
        else
        {
            return response()->json([
                'status' => 'success',
                'message' => 'No Data Found'
            ],404);
        }
    }

    public function applyLeave(Request $request)
    {
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

        $user = User::where('id',Auth::user()->id)->first();
        $school = $user->school;
        $staff = Staff::where('username',Auth::user()->username)->first();

        $leave_application = new LeaveApplication;
        $leave_application->school_id = $school->id;
        $leave_application->staff_id = $staff->id;
        $leave_application->user_id = $school->user_id;
        $leave_application->subject = "Leave Application";
        $leave_application->message = !empty($request->message) ? $request->message : "";
        $leave_application->date = date("Y-m-d");
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
}
