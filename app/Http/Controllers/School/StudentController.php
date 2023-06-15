<?php

namespace App\Http\Controllers\School;

use App\Models\Role;
use App\Models\User;
use App\Models\Staff;
use App\Models\Classes;
use App\Models\Parents;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ClassAssignSection;
use App\Models\ClassAssignSubject;
use App\Models\StudentClassAssign;
use App\Models\StudentFeeStructure;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $students = Student::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("id", 'desc')->paginate(10);
        return view("school.students.index")->with(compact('school','students'));
    }

    public function create()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $staffs = Staff::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("first_name", 'asc')->get();
        $students = Student::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("first_name", 'asc')->get();

        return view("school.students.create")->with(compact('school', 'classes','staffs','students'));
    }

    public function getSectionByClass($id)
    {
        $subjects = [];
        $sections = [];
        $class = Classes::find($id);
        $sectionAssign = ClassAssignSection::where('school_id',$class->school_id)
        ->where('class_id',$class->id)->get();
        foreach($sectionAssign as $section)
        {
            $sections[] = $section->section;
        }

        $subjectAssign = ClassAssignSubject::where('school_id',$class->school_id)
        ->where('class_id',$class->id)->get();
        foreach($subjectAssign as $subject)
        {
            $subjects[] = $subject->subject;
        }
        return [
            'sections'=>$sections,
            'subjects'=>$subjects
        ];
    }

    public function getParentByStudent($id)
    {
        $student = Student::find($id);
        $parent = Parents::find($student->parent_id);
        return $parent;
    }

    public function getStaffInfo($id)
    {
        $staff = Staff::find($id);
        return [
            'name'=>$staff->first_name.' '.$staff->last_name,
            'email'=>$staff->email,
            'phone' => $staff->phone,
            'emergency_phone' => $staff->phone
        ];
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $username = $this->generateUserName();
        $random_password = Str::random(8);

        $existUser = User::where('username',$username)->first();
        if(!$existUser)
        {
            $role = Role::where('name','SchoolAdmin')->first();
            $existUser = User::create([
                'name'  => $request->first_name.' '.$request->last_name,
                'username' => $username,
                'email' => $request->email,
                'password' => Hash::make($random_password),
                'type'  => 'student',
                'role_id'   =>  $role->id
            ]);
        }

        $student = new Student;
        $student->school_id = $school->id;
        $student->user_id = $existUser->id;
        $student->username = $username;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->gender = $request->gender;
        $student->dob = $request->dob;
        $student->admission_date = $request->admission_date;
        $student->address = $request->address;
        $student->permanent_address = $request->permanent_address;
        $student->created_by = Auth::user()->id;
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = Auth::user()->id.time() . '.' . $image->extension();
            $image->move(public_path('uploads/schools/student'), $imageName);
            $student->image = $imageName;
        }
        $student->save();

        //StudentClassAssign
        $studentClassAssign = new StudentClassAssign;
        $studentClassAssign->school_id = $school->id;
        $studentClassAssign->class_id = $request->class_id;
        $studentClassAssign->section_id  = $request->section_id;
        $studentClassAssign->student_id = $student->id;
        $studentClassAssign->save();

        //StudemtBackground
        $student->bg_school_name = $request->bg_school_name;
        $student->bg_class_name = $request->bg_class_name;
        if($request->hasFile('school_leave_certificate'))
        {
            $image = $request->file('school_leave_certificate');
            $imageName = Auth::user()->id.time().rand(000,999) . '.' . $image->extension();
            $image->move(public_path('uploads/schools/student'), $imageName);
            $student->school_leave_certificate = $imageName;
        }
        if($request->hasFile('mark_sheet'))
        {
            $image = $request->file('mark_sheet');
            $imageName = Auth::user()->id.time().rand(000,999) . '.' . $image->extension();
            $image->move(public_path('uploads/schools/student'), $imageName);
            $student->mark_sheet = $imageName;
        }
        $student->save();


        //FeeStructure
        $studentFee = new StudentFeeStructure;
        $studentFee->school_id  = $school->id;
        $studentFee->student_id  = $student->id;
        $studentFee->fee = $request->fee;
        $studentFee->amount = $request->fee_amount;
        $studentFee->save();

        //Parent
        $studentParentUsername = null;
        if($request->parent_type == "sibling")
        {
            $parent_student_id = $request->parent_student_id;
            $studentParentData = Student::find($parent_student_id);
            $studentParentUsername = $studentParentData->username;
        }
        if(!empty($studentParentUsername))
        {
            $parent = Parents::find($studentParentData->parent_id);
        }
        else
        {
            $parent_username = $this->generateUserName();
            $parent = new Parents;
            $parent->username = $parent_username;
        }

        $parent->name = $request->parent_name;
        $parent->email = $request->parent_email;
        $parent->phone = $request->parent_phone;
        $parent->emergency_phone = $request->emergency_phone;
        $parent->save();

        $student->parent_id = $parent->id;
        $student->parent_type = $request->parent_type;
        if(!empty($request->parent_student_id))
        {
            $sibling_id = $request->parent_student_id;
        }
        elseif(!empty($request->parent_staff_id))
        {
            $sibling_id = $request->parent_staff_id;
        }
        else
        {
            $sibling_id = 0;
        }
        $student->sibling_id = $sibling_id;
        $student->save();

        $existUser = User::where('username',$parent->username)->first();
        if(!$existUser)
        {
            $role = Role::where('name','SchoolAdmin')->first();
            $existUser = User::create([
                'name'  => $request->parent_name,
                'username' => $parent_username,
                'email' => $request->parent_email,
                'password' => Hash::make($random_password),
                'type'  => 'parent',
                'role_id'   =>  $role->id
            ]);
        }
        else
        {
            $existUser->name = $request->parent_name;
            $existUser->email = $request->parent_email;
            $existUser->save();
        }
        $parent->user_id = $existUser->id;
        $parent->save();

    }

    public function generateUserName()
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
        $student = Student::find($id);
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classNames = StudentClassAssign::where('school_id',$school->id)
            ->where('student_id',$student->id)
            ->groupBy('class_id')
            ->get(['class_id']);

        $response = [];
        foreach ($classNames as $key => $className) {
            $response[$key]['class_id'] = $className->class->id;
            $response[$key]['class_name'] = $className->class->name;
            $sections = StudentClassAssign::where('class_id', $className->class_id)
                ->where('school_id',$school->id)
                ->where('student_id',$student->id)
                ->get();

                foreach($sections as $index => $section) {
                    $response[$key]['sections'][$index]['section_id'] = $section->section->id;
                    $response[$key]['sections'][$index]['section_name'] = $section->section->name;
                }
        }
        return view("school.students.detail")->with(compact('student','response'));
    }

    public function edit($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $sections = Section::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $staffs = Staff::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("first_name", 'asc')->get();
        $students = Student::where('school_id', $school->id)->where('is_deleted','0')->where('id','!=',$id)->OrderBy("first_name", 'asc')->get();
        $studentData = Student::find($id);

        return view("school.students.edit")->with(compact('school', 'classes','staffs','students','studentData','sections'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $username = $this->generateUserName();
        $random_password = Str::random(8);

        $student = Student::find($request->id);
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->gender = $request->gender;
        $student->dob = $request->dob;
        $student->admission_date = $request->admission_date;
        $student->address = $request->address;
        $student->permanent_address = $request->permanent_address;
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = Auth::user()->id.time() . '.' . $image->extension();
            $image->move(public_path('uploads/schools/student'), $imageName);
            $student->image = $imageName;
        }
        $student->save();
        $existUser = User::where('username',$student->username)->first();
        if(!$existUser)
        {
            $role = Role::where('name','SchoolAdmin')->first();
            $user = User::create([
                'name'  => $request->first_name.' '.$request->last_name,
                'email' => $request->email
            ]);
        }

        //StudentClassAssign
        StudentClassAssign::where('school_id',$student->school_id)->where('student_id',$student->id)->delete();
        $studentClassAssign = new StudentClassAssign;
        $studentClassAssign->school_id = $school->id;
        $studentClassAssign->class_id = $request->class_id;
        $studentClassAssign->section_id  = $request->section_id;
        $studentClassAssign->student_id = $student->id;
        $studentClassAssign->save();

        //StudemtBackground
        $student->bg_school_name = $request->bg_school_name;
        $student->bg_class_name = $request->bg_class_name;
        if($request->hasFile('school_leave_certificate'))
        {
            $image = $request->file('school_leave_certificate');
            $imageName = Auth::user()->id.time().rand(000,999) . '.' . $image->extension();
            $image->move(public_path('uploads/schools/student'), $imageName);
            $student->school_leave_certificate = $imageName;
        }
        if($request->hasFile('mark_sheet'))
        {
            $image = $request->file('mark_sheet');
            $imageName = Auth::user()->id.time().rand(000,999) . '.' . $image->extension();
            $image->move(public_path('uploads/schools/student'), $imageName);
            $student->mark_sheet = $imageName;
        }
        $student->save();


        //FeeStructure
        StudentFeeStructure::where('school_id',$student->school_id)->where('student_id',$student->id)->delete();
        $studentFee = new StudentFeeStructure;
        $studentFee->school_id  = $school->id;
        $studentFee->student_id  = $student->id;
        $studentFee->fee = $request->fee;
        $studentFee->amount = $request->fee_amount;
        $studentFee->save();

        //Parent
        $studentParentUsername = null;
        if($request->parent_type == "sibling")
        {
            $parent_student_id = $request->parent_student_id;
            $studentParentData = Student::find($parent_student_id);
            $studentParentUsername = $studentParentData->username;
        }
        if(!empty($studentParentUsername))
        {
            $parent = Parents::find($studentParentData->parent_id);
        }
        else
        {
            $parent_username = $this->generateUserName();
            $parent = new Parents;
            $parent->username = $parent_username;
        }

        $parent->name = $request->parent_name;
        $parent->email = $request->parent_email;
        $parent->phone = $request->parent_phone;
        $parent->emergency_phone = $request->emergency_phone;
        $parent->save();

        $student->parent_id = $parent->id;
        $student->parent_type = $request->parent_type;
        if(!empty($request->parent_student_id) AND $request->parent_type == "sibling")
        {
            $sibling_id = $request->parent_student_id;
        }
        elseif(!empty($request->parent_staff_id) AND $request->parent_type == "staff")
        {
            $sibling_id = $request->parent_staff_id;
        }
        else
        {
            $sibling_id = 0;
        }
        $student->sibling_id = $sibling_id;
        $student->save();

        $existUser = User::where('username',$parent->username)->first();
        if(!$existUser)
        {
            $role = Role::where('name','SchoolAdmin')->first();
            $user = User::create([
                'name'  => $request->parent_name,
                'username' => $parent_username,
                'email' => $request->parent_email,
                'password' => Hash::make($random_password),
                'type'  => 'parent',
                'role_id'   =>  $role->id
            ]);
        }
        else
        {
            $existUser->name = $request->parent_name;
            $existUser->email = $request->parent_email;
            $existUser->save();
        }

    }

    public function delete(Request $request)
    {
        $student = Student::find($request->id);
        $student->is_deleted = "1";
        $student->save();

        return back()->with('success','Student Deleted Successfully');
    }
}
