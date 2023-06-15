<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Staff;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\StaffAssignClass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    function index()
    {
        $schools = School::OrderBy('name','asc')->where('is_deleted','0')->get();
        $query = new Staff;
        if(!empty(request()->input('school_id')))
        {
            $query = $query->where('school_id',request()->input('school_id'));
        }
        $staffs = $query->where('is_deleted','0')->OrderBy('id','DESC')->paginate(10);
        return view("superadmin.teacher.index")->with(compact('schools','staffs'));
    }

    public function detail($id)
    {
        $staff = Staff::find($id);
        $additional_documents = $staff->additional_documents;
        $additional_documents = explode(',', $additional_documents);
        $classNames = StaffAssignClass::with('sections')
            ->where('school_id',$staff->school_id)
            ->where('staff_id',$staff->id)
            ->groupBy('class_id')
            ->get(['class_id']);

        $response = [];
        foreach ($classNames as $key => $className) {
            $response[$key]['class_id'] = $className->class->id;
            $response[$key]['class_name'] = $className->class->name;
            $sections = StaffAssignClass::where('class_id', $className->class_id)
                ->where('school_id',$staff->school_id)
                ->where('staff_id',$staff->id)
                ->get();

                foreach($sections as $index => $section) {
                    $response[$key]['sections'][$index]['section_id'] = $section->section->id;
                    $response[$key]['sections'][$index]['section_name'] = $section->section->name;
                }
        }
        return view("superadmin.teacher.detail")->with(compact('staff','additional_documents','response'));
    }
}
