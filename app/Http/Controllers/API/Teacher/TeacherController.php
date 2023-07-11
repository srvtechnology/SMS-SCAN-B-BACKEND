<?php

namespace App\Http\Controllers\API\Teacher;

use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Models\StaffAssignClass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function detail()
    {
        $classList = null;
        $subjectList = null;
        $user = User::where('id',Auth::user()->id)->first();
        $staff = Staff::with('designation','qualifications','experiences')->where('username',Auth::user()->username)->first();
        if(!empty($staff->image) AND file_exists(public_path('uploads/schools/logo').'/'.$staff->image))
        {
            $staff['image'] = asset('uploads/schools/logo/'.$staff->image);
        }
        $classNames = StaffAssignClass::with('sections')
            ->where('school_id',$user->school_id)
            ->where('staff_id',$staff->id)
            ->groupBy('class_id')
            ->get(['class_id']);

        $response = null;
        foreach ($classNames as $key => $className) {
            $response[$key]['class_id'] = $className->class->id;
            $response[$key]['class_name'] = $className->class->name;
            $sections = StaffAssignClass::where('class_id', $className->class_id)
                ->where('school_id',$user->school_id)
                ->where('staff_id',$staff->id)
                ->get();

                foreach($sections as $index => $section) {
                    $response[$key]['sections'][$index]['section_id'] = $section->section->id;
                    $response[$key]['sections'][$index]['section_name'] = $section->section->name;
                }
        }
        $subjects = null;
        $subjects = $staff->subjects;

        $data = [
            'user' => $staff,
            'classes' => $response
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'User Detail',
            'data' => $data
        ],200);
    }
}
