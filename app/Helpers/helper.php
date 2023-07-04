<?php

use App\Models\Exam;
use App\Models\User;
use App\Models\Staff;
use App\Models\School;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StudentResult;
use App\Models\StaffAssignClass;
use App\Models\StudentAttendance;
use App\Models\ClassAssignSubject;

function getUserImage()
{
    if(!empty(Auth::user()->image) AND file_exists(public_path('uploads/profile/'.Auth::user()->image)))
    {
        $image = asset('uploads/profile/'.Auth::user()->image);
    }
    else
    {
        $image = asset('assets/default/avatar.jpg');
    }
    return $image;
}

function getStaffImage($staff_id)
{
    $staff = Staff::find($staff_id);
    if(!empty($staff->image) AND file_exists(public_path('uploads/schools/logo/'.$staff->image)))
    {
        $image = asset('uploads/schools/logo/'.$staff->image);
    }
    else
    {
        $image = asset('assets/default/placeholder.png');
    }
    return $image;
}

function getStudentImage($student_id)
{
    $student = Student::find($student_id);
    if(!empty($student->image) AND file_exists(public_path('uploads/schools/student/'.$student->image)))
    {
        $image = asset('uploads/schools/student/'.$student->image);
    }
    else
    {
        $image = asset('assets/default/placeholder.png');
    }
    return $image;
}

function getSchoolLogo($school_id)
{
    $school = School::find($school_id);
    if(!empty($school->image) AND file_exists(public_path('uploads/schools/'.$school->image)))
    {
        $image = asset('uploads/schools/'.$school->image);
    }
    else
    {
        $image = asset('assets/default/placeholder.png');
    }
    return $image;
}

function getSchoolStatus($school_id)
{
    $school = School::find($school_id);
    $user = User::where('email',$school->email)->first();
    return $user->status;
}

function getSectionStatus($school_id)
{
    $section = Section::find($school_id);
    return $section->status;
}

function getClassStatus($class_id)
{
    $class = Classes::find($class_id);
    return $class->status;
}

function getSubjectStatus($school_id)
{
    $subject = Subject::find($school_id);
    return $subject->status;
}

function getSchoolInfoByUsername($username)
{
    $school = School::where('username',$username)->first();
    // if(!$school)
    // {
    //     dd("back to login");
    // }
    return $school;
}

function selectedSectionArray($school_id,$staff_id,$class_id)
{
    $sections = StaffAssignClass::where('class_id', $class_id)
    ->where('school_id',$school_id)
    ->where('staff_id',$staff_id)
    ->get();
    $response = [];
    foreach($sections as $section)
    {
        $response[] = $section->section_id;
    }
    return $response;
}

function getSubjectsByClass($id)
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

function getSubjectTotalMarks($exam_id,$class_id,$section_id,$subject_id)
{
    $school = getSchoolInfoByUsername(Auth::user()->username);
    $student_result = StudentResult::where('school_id',$school->id)->where('exam_id',$exam_id)
    ->where('class_id',$class_id)->where('subject_id',$subject_id)
    ->where('section_id',$section_id)->first();
    if(!empty($student_result->total_marks))
    {
        $total_marks = $student_result->total_marks;
    }
    else
    {
        $total_marks = 0;
    }
    return  $total_marks;
}

function getSubjectObtainedMarks($exam_id,$class_id,$section_id,$subject_id,$student_id)
{
    $school = getSchoolInfoByUsername(Auth::user()->username);
    $student_result = StudentResult::where('school_id',$school->id)->where('exam_id',$exam_id)
    ->where('class_id',$class_id)->where('subject_id',$subject_id)
    ->where('section_id',$section_id)->where('student_id',$student_id)->first();
    if(!empty($student_result->total_marks))
    {
        $obtained_marks = $student_result->obtained_marks;
    }
    else
    {
        $obtained_marks = 0;
    }
    return  $obtained_marks;
}

function getResultData($exam_id,$class_id,$section_id)
{
    $school = getSchoolInfoByUsername(Auth::user()->username);
    $exam = Exam::find($exam_id);
    $class = Classes::find($class_id);
    $section = Section::find($section_id);

    if(!empty($exam) AND !empty($class) AND !empty($section))
    {
        $name = $class->name.'('.$section->name.')'.'/'.$exam->title;
    }
    else
    {
        $name = '';
    }

    return $name;

}

function calculateDatesBetween($start_date, $end_date) {
    $start_date = new DateTime($start_date);
    $end_date = new DateTime($end_date);

    $dates_between = array();

    while ($start_date <= $end_date) {
        $date = $start_date->format('Y-m-d');
        $day = $start_date->format('l');
        $dates_between[] = array('date' => $date, 'day' => $day);
        $start_date->modify('+1 day'); // Increment the date by one day
    }

    return $dates_between;
}

function getStudentAttendance($class_id,$section_id,$student_id,$date)
{
    $school = getSchoolInfoByUsername(Auth::user()->username);
    $newdate = date("Y-m-d",strtotime($date));
    $student_attendance = StudentAttendance::where('school_id', $school->id)
    ->where('class_id', $class_id)
    ->where('section_id', $section_id)
    ->where('student_id', $student_id)
    ->whereDate('date', '=', $newdate)
    ->first();

    if(!empty($student_attendance))
    {
        $attendance = $student_attendance->attendance == 1 ? 'P' :'A';
    }
    else
    {
        $attendance = '-';
    }
    return $attendance;
}

function getAttendanceData($class_id,$section_id,$from_date,$to_date)
{
    $school = getSchoolInfoByUsername(Auth::user()->username);
    $class = Classes::find($class_id);
    $section = Section::find($section_id);

    if(!empty($class) AND !empty($section))
    {
        $fromMonth = date("M",strtotime($from_date)).' '.date("Y",strtotime($from_date));
        $toMonth = date("M",strtotime($to_date)).' '.date("Y",strtotime($to_date));;

        $name = $class->name.'('.$section->name.')'.'/Month-'.$fromMonth.' to '.$toMonth;
    }
    else
    {
        $name = '';
    }

    return $name;
}
?>
