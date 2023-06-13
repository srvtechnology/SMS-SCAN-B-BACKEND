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
        $staffs = Staff::where('school_id', $school->id)->where('is_deleted','0')->OrderBy('id','DESC')->paginate(10);
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
        if(!empty($request->from_date[0]) AND !empty($request->to_date[0]) AND !empty($request->exp_instituation[0]))
        {
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
        $classNames = StaffAssignClass::with('sections')
            ->where('school_id',$school->id)
            ->where('staff_id',$staff->id)
            ->groupBy('class_id')
            ->get(['class_id']);

        $response = [];
        foreach ($classNames as $key => $className) {
            $response[$key]['class_id'] = $className->class->id;
            $response[$key]['class_name'] = $className->class->name;
            $sections = StaffAssignClass::where('class_id', $className->class_id)
                ->where('school_id',$school->id)
                ->where('staff_id',$staff->id)
                ->get();

                foreach($sections as $index => $section) {
                    $response[$key]['sections'][$index]['section_id'] = $section->section->id;
                    $response[$key]['sections'][$index]['section_name'] = $section->section->name;
                }
        }
        return view("school.teachers.detail")->with(compact('school', 'staff','additional_documents','response'));
    }

    public function edit($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $subjects = Subject::where('school_id',$school->id)->where('is_deleted','0')->OrderBy('name', 'asc')->get();
        $designations = Designation::where('school_id',$school->id)->where('is_deleted','0')->OrderBy('name', 'asc')->get();
        $staff = Staff::find($id);

        $classNames = StaffAssignClass::with('sections')
            ->where('school_id',$school->id)
            ->where('staff_id',$staff->id)
            ->groupBy('class_id')
            ->get(['class_id']);

        $response = [];
        foreach ($classNames as $key => $className) {
            $response[$key]['class_id'] = $className->class->id;
            $response[$key]['class_name'] = $className->class->name;
            $sections = StaffAssignClass::where('class_id', $className->class_id)
                ->where('school_id',$school->id)
                ->where('staff_id',$staff->id)
                ->get();

                foreach($sections as $index => $section) {
                    $response[$key]['sections'][$index]['section_id'] = $section->section->id;
                    $response[$key]['sections'][$index]['section_name'] = $section->section->name;
                }
        }
        $subjectResponse = [];
        if(count($staff->subjects)>0)
        {
            foreach($staff->subjects as $subject)
            {
                $subjectResponse[] = $subject->subject->id;
            }
        }
        return view("school.teachers.edit")->with(compact('school', 'classes', 'subjects','designations','staff','response','subjectResponse'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');
        $staff = Staff::find($request->staff_id);
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = Auth::user()->id.time() . '.' . $image->extension();
            $image->move(public_path('uploads/schools/logo'), $imageName);
            $staff->image = $imageName;
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
            $staff->additional_documents = $additional_documents_implode;
        }

        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;
        $staff->email = $request->email;
        $staff->phone = $request->phone;
        $staff->gender = $request->gender;
        $staff->designation_id  = $request->designation_id;
        $staff->address = $request->address;
        $staff->salary = $request->salary;
        $staff->joining_date = $request->joining_date;
        $staff->fb_profile = $request->fb_profile;
        $staff->insta_profile = $request->insta_profile;
        $staff->linkedIn_profile = $request->linkedIn_profile;
        $staff->twitter_profile = $request->twitter_profile;
        $staff->save();
        // $staff = Staff::where('id',$request->staff_id)->update($data);
        if($staff)
        {
            $existUser = User::where('email',$request->email)->first();
            if(!$existUser)
            {
                $existUser->name = $request->first_name.' '.$request->last_name;
                $existUser->email = $request->email;
                $existUser->save();
            }
        }

        //StaffQualifiucation
        if(count($request->year)> 0 AND count($request->education) > 0 AND count($request->instituation) > 0)
        {
            StaffQualification::where(['school_id'=>$staff->school_id,'staff_id' => $staff->id])->delete();
            foreach($request->year as $qual_index => $year)
            {
                $staffQualification = new StaffQualification();
                $staffQualification->school_id = $staff->school_id;
                $staffQualification->staff_id = $staff->id;
                $staffQualification->year = $year;
                $staffQualification->education = $data['education'][$qual_index];
                $staffQualification->instituation = $data['instituation'][$qual_index];
                $staffQualification->save();
            }
        }

        //StaffExperience
        if(!empty($request->from_date[0]) AND !empty($request->to_date[0]) AND !empty($request->exp_instituation[0]))
        {
            if(count($request->from_date)> 0 AND count($request->to_date) > 0 AND count($request->exp_instituation) > 0)
            {
                StaffExperience::where(['school_id'=>$staff->school_id,'staff_id' => $staff->id])->delete();
                foreach($request->from_date as $exp_index => $from_date)
                {
                    $staffExperience = new StaffExperience();
                    $staffExperience->school_id = $staff->school_id;
                    $staffExperience->staff_id = $staff->id;
                    $staffExperience->from_date = $from_date;
                    $staffExperience->to_date = $data['to_date'][$exp_index];
                    $staffExperience->instituation = $data['exp_instituation'][$exp_index];
                    $staffExperience->save();
                }
            }
        }

        //StaffAssignClass
        if(!empty($request->section_id))
        {
            if(count($request->section_id) > 0)
            {
                StaffAssignClass::where(['school_id'=>$staff->school_id,'staff_id' => $staff->id])->delete();
                foreach($request->section_id as $section_index => $section)
                {
                    $section_ids = explode(',', $section);
                    $class_id = $section_ids[0];
                    $section_id = $section_ids[1];
                    $staffAssignClass = new StaffAssignClass();
                    $staffAssignClass->school_id = $staff->school_id;
                    $staffAssignClass->staff_id = $staff->id;
                    $staffAssignClass->class_id = $class_id;
                    $staffAssignClass->section_id = $section_id;
                    $staffAssignClass->save();
                }
            }
        }

        //StaffAssignSubject
        if(!empty($request->subject_id))
        {
            if(count($request->subject_id) > 0)
            {
                StaffAssignSubject::where(['school_id'=>$staff->school_id,'staff_id' => $staff->id])->delete();
                foreach($request->subject_id as $subject_index => $subject)
                {
                    $staffAssignSubject = new StaffAssignSubject();
                    $staffAssignSubject->school_id = $staff->school_id;
                    $staffAssignSubject->staff_id = $staff->id;
                    $staffAssignSubject->subject_id = $subject;
                    $staffAssignSubject->save();
                }
            }
        }

        return to_route("school.teachers")->with('success','Staff Updated Successfully');
    }

    public function delete(Request $request)
    {
        $staff = Staff::find($request->id);
        $staff->is_deleted = "1";
        $staff->save();

        return back()->with('success','Teacher Deleted Successfully');
    }
}