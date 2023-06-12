<?php

namespace App\Http\Controllers\School;

use App\Models\Role;
use App\Models\User;
use App\Models\Staff;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Designation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StaffExperience;
use App\Models\StaffAssignClass;
use App\Models\StaffAssignSubject;
use App\Models\StaffQualification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $staffs = Staff::where('school_id', $school->id)->where('is_deleted','0')->paginate(10);
        return view("school.teachers.index")->with(compact('school', 'staffs'));
    }

    public function create()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $subjects = Subject::where('school_id',$school->id)->where('is_deleted','0')->OrderBy('name', 'asc')->get();
        $designations = Designation::where('school_id',$school->id)->where('is_deleted','0')->OrderBy('name', 'asc')->get();
        return view("school.teachers.create")->with(compact('school', 'classes','subjects','designations'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->except('_token');
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $data['school_id'] = $school->id;
        $username = $this->generateUserName();
        $data['username'] = $username;
        $data['created_by'] = Auth::user()->id;
        $random_password = Str::random(8);
        $data['password']   = Hash::make($random_password);
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = Auth::user()->id.time() . '.' . $image->extension();
            $image->move(public_path('uploads/schools/logo'), $imageName);
            $data['image'] = $imageName;
        }
        if($request->hasFile('documents'))
        {
            $filenames = $request->file('documents');
            $additional_documents = [];
            foreach($request->file('documents') as $key => $filenameData)
            {
                $imageName = Auth::user()->id.time().rand(000,9999) . '.' . $filenameData->extension();
                $filenameData->move(public_path('uploads/schools/additional_documents'), $imageName);
                $additional_documents[] = $imageName;
            }
            $additional_documents_implode = implode(",",$additional_documents);
            $data['additional_documents'] = $additional_documents_implode;
        }
        $staff = Staff::create($data);
        if($staff)
        {
            $existUser = User::where('email',$request->email)->first();
            if(!$existUser)
            {
                $role = Role::where('name','SchoolAdmin')->first();
                $user = User::create([
                    'name'  => $request->first_name.' '.$request->last_name,
                    'username' => $username,
                    'email' => $request->email,
                    'password' => $data['password'],
                    // 'type'  => 'staff',
                    'role_id'   =>  $role->id
                ]);
            }
        }

        //StaffQualifiucation
        if(count($request->year)> 0 AND count($request->education) > 0 AND count($request->instituation) > 0)
        {
            foreach($request->year as $qual_index => $year)
            {
                $staffQualification = new StaffQualification();
                $staffQualification->school_id = $data['school_id'];
                $staffQualification->staff_id = $staff->id;
                $staffQualification->year = $year;
                $staffQualification->education = $data['education'][$qual_index];
                $staffQualification->instituation = $data['instituation'][$qual_index];
                $staffQualification->save();
            }
        }

        //StaffExperience
        if(count($request->from_date)> 0 AND count($request->to_date) > 0 AND count($request->exp_instituation) > 0)
        {
            foreach($request->from_date as $exp_index => $from_date)
            {
                $staffExperience = new StaffExperience();
                $staffExperience->school_id = $data['school_id'];
                $staffExperience->staff_id = $staff->id;
                $staffExperience->from_date = $from_date;
                $staffExperience->to_date = $data['to_date'][$exp_index];
                $staffExperience->instituation = $data['exp_instituation'][$exp_index];
                $staffExperience->save();
            }
        }

        //StaffAssignClass
        if(count($request->section_id) > 0)
        {
            foreach($request->section_id as $section_index => $section)
            {
                $section_ids = explode(',', $section);
                $class_id = $section_ids[0];
                $section_id = $section_ids[1];
                $staffAssignClass = new StaffAssignClass();
                $staffAssignClass->school_id = $data['school_id'];
                $staffAssignClass->staff_id = $staff->id;
                $staffAssignClass->class_id = $class_id;
                $staffAssignClass->section_id = $section_id;
                $staffAssignClass->save();
            }
        }

        //StaffAssignSubject
        if(count($request->subject_id) > 0)
        {
            foreach($request->subject_id as $subject_index => $subject)
            {
                $staffAssignSubject = new StaffAssignSubject();
                $staffAssignSubject->school_id = $data['school_id'];
                $staffAssignSubject->staff_id = $staff->id;
                $staffAssignSubject->subject_id = $subject;
                $staffAssignSubject->save();
            }
        }

        return to_route("school.teachers")->with('success','Staff Added Successfully');
    }

    private function generateUserName()
    {
        $str = Str::random(8);
        $count = User::where('username',$str)->count();
        if($count > 0)
        {
            $str = $str . $count;
        }
        return $str;
    }

    public function detail($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $staff = Staff::find($id);
        $additional_documents = $staff->additional_documents;
        $additional_documents = explode(',', $additional_documents);
        // $classNames = StaffAssignClass::with('section')
        //     ->where('school_id',$school->id)
        //     ->where('staff_id',$staff->id)
        //     ->groupBy('class_id')
        //     ->get(['class_id']);

        // $response = [];
        // foreach ($classNames as $key => $className) {
        //     $response[$key]['class_name'] = $className->class->name;
        //     $sections = StaffAssignClass::with('section')->where('class_id', $className->class_id)
        //         ->get();

            //     foreach($sections as $section) {
            //         $response[] = [
            //             // 'class_name' => $className->class->name,
            //             'section_names' => $section->section->name,
            //         ];
            //     }
                // return array_push($response,$response);
                // return $response;
        // }
        // dd($response);
        return view("school.teachers.detail")->with(compact('school', 'staff','additional_documents'));
    }
}
