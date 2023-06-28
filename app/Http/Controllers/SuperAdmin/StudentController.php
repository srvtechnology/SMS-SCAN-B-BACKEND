<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentClassAssign;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index()
    {
        $schools = School::OrderBy('name','asc')->where('is_deleted','0')->get();
        $query = new Student;
        if(!empty(request()->input('school_id')))
        {
            $query = $query->where('school_id',request()->input('school_id'));
        }
        $students = $query->where('is_deleted','0')->OrderBy("id", 'desc')->paginate(10);
        return view("superadmin.student.index")->with(compact('schools','students'));
    }

    public function detail($id)
    {
        $student = Student::find($id);
        $classNames = StudentClassAssign::where('school_id',$student->school_id)
            ->where('student_id',$student->id)
            ->groupBy('class_id')
            ->get(['class_id']);

        $response = [];
        foreach ($classNames as $key => $className) {
            $response[$key]['class_id'] = $className->class->id;
            $response[$key]['class_name'] = $className->class->name;
            $sections = StudentClassAssign::where('class_id', $className->class_id)
                ->where('school_id',$student->school_id)
                ->where('student_id',$student->id)
                ->get();

                foreach($sections as $index => $section) {
                    $response[$key]['sections'][$index]['section_id'] = $section->section->id;
                    $response[$key]['sections'][$index]['section_name'] = $section->section->name;
                }
        }
        return view("superadmin.student.detail")->with(compact('student','response'));
    }
}
