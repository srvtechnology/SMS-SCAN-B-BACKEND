<?php

namespace App\Http\Controllers\API\Teacher;

use App\Models\User;
use App\Models\Staff;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
use App\Models\HomeWork;
use Illuminate\Http\Request;
use App\Models\StudyMaterial;
use App\Models\LeaveApplication;
use App\Models\StaffAssignClass;
use App\Models\TimeTableSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TimeTableAssignPeriod;
use Illuminate\Support\Facades\Validator;

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
                    $response[$key]['sections'][$index]['class_teacher'] = 0;
                    if(!empty($staff->assign_class_to_class_teacher) AND !empty($staff->assign_section_to_class_teacher) AND ($className->class->id == $staff->assign_class_to_class_teacher) AND ($section->section->id == $staff->assign_section_to_class_teacher))
                    {
                        $response[$key]['sections'][$index]['class_teacher'] = 1;
                    }
                }
        }
        $subjects = null;
        if(count($staff->subjects) > 0)
        {
            foreach($staff->subjects as $sub_index => $subjects)
            {
                $staff["subjects"][$sub_index] = [
                    'id' => $subjects->subject->id,
                    'name' => $subjects->subject->name,
                ];
            }
        }

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

    public function viewLeaveApplication()
    {
        $user = User::where('id',Auth::user()->id)->first();
        $school = $user->school;
        $staff = Staff::where('username',Auth::user()->username)->first();

        $leave_applications = LeaveApplication::where('staff_id',$staff->id)->OrderBy('id','DESC')->get();
        if(count($leave_applications) > 0)
        {
            foreach($leave_applications as $key => $leave_application)
            {
                if(!empty($leave_application->file) AND file_exists(public_path('uploads/schools/leave').'/'.$leave_application->file))
                {
                    $leave_applications[$key]['file'] = asset("uploads/schools/leave/".$leave_application->file);
                }
                $leave_applications[$key]['user'] = $leave_application->user;
                unset($leave_applications[$key]['user_id']);
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

    public function createHomeWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'section_id' => 'required',
            'title' => 'required',
            'due_date' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }
        if(empty($request->description) AND count($request->files) == 0)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Input any one description or file'
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

        $homework = new HomeWork;
        $homework->school_id = $school->id;
        $homework->created_by_staff = $staff->id;
        $homework->class_id = $request->class_id;
        $homework->section_id = $request->section_id;
        $homework->type = "homework";
        $homework->title = $request->title;
        $homework->description = $request->description;
        if ($request->hasFile('files')) {
            $fileNames = [];
            foreach ($request->file('files') as $file) {
                $image = $file;
                $imageName = Auth::user()->id . time() . rand(0, 99) . '.' . $image->extension();
                $image->move(public_path('uploads/schools/homework'), $imageName);
                $fileNames[] = $imageName;
            }
            $homework->files = implode(',', $fileNames);
        }
        $homework->due_date = $request->due_date;
        $homework->date = now();
        $result = $homework->save();
        if($result)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'HomeWork has been uploaded successfully'
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

    public function viewHomeWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'section_id' => 'required'
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

        $homeworks = HomeWork::where('created_by_staff',$staff->id)->where('type','homework')->where('is_deleted','0')->OrderBy('id','DESC')->get();
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

        if(count($homeworks) > 0)
        {
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

    public function deleteHomeWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'section_id' => 'required',
            'id' => 'required'
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

        $homeworkID = HomeWork::where('id',$request->id)->where('type','homework')->first();
        if(!$homeworkID)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Home Work Found.'
            ],401);
        }

        $homeworkID->is_deleted = '1';
        $result = $homeworkID
        ->save();
        if($result)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'HomeWork has been deleted successfully'
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

    public function editHomeWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'section_id' => 'required',
            'title' => 'required',
            'due_date' => 'required',
            'home_work_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }
        if(empty($request->description) AND count($request->files) == 0)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Input any one description or file'
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

        $homework = HomeWork::where('id',$request->home_work_id)->where('type','homework')->first();
        if(!$homework)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Home Work Found.'
            ],401);
        }

        $user = User::where('id',Auth::user()->id)->first();
        $school = $user->school;
        $staff = Staff::where('username',Auth::user()->username)->first();

        $homework->school_id = $school->id;
        $homework->created_by_staff = $staff->id;
        $homework->class_id = $request->class_id;
        $homework->section_id = $request->section_id;
        $homework->type = "homework";
        $homework->title = $request->title;
        $homework->description = $request->description;
        if ($request->hasFile('files')) {
            $fileNames = [];
            foreach ($request->file('files') as $file) {
                $image = $file;
                $imageName = Auth::user()->id . time() . rand(0, 99) . '.' . $image->extension();
                $image->move(public_path('uploads/schools/homework'), $imageName);
                $fileNames[] = $imageName;
            }
            $homework->files = implode(',', $fileNames);
        }
        else
        {
            $homework->files = null;
        }
        $homework->due_date = $request->due_date;
        $result = $homework->save();
        if($result)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'HomeWork has been updated successfully'
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

    public function changeStatusHomeWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'section_id' => 'required',
            'home_work_id' => 'required',
            'status'    =>  'required'
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

        $homework = HomeWork::find($request->home_work_id);
        if(!$homework)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Home Work Found.'
            ],401);
        }

        $homework->status = $request->status;
        $result = $homework->save();
        if($result)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'Status has been updated successfully'
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


    public function createSyllabus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'section_id' => 'required',
            'title' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }
        if(empty($request->description) AND count($request->files) == 0)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Input any one description or file'
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

        $homework = new HomeWork;
        $homework->school_id = $school->id;
        $homework->created_by_staff = $staff->id;
        $homework->class_id = $request->class_id;
        $homework->section_id = $request->section_id;
        $homework->type = "syllabus";
        $homework->title = $request->title;
        $homework->description = $request->description;
        if ($request->hasFile('files')) {
            $fileNames = [];
            foreach ($request->file('files') as $file) {
                $image = $file;
                $imageName = Auth::user()->id . time() . rand(0, 99) . '.' . $image->extension();
                $image->move(public_path('uploads/schools/syllabus'), $imageName);
                $fileNames[] = $imageName;
            }
            $homework->files = implode(',', $fileNames);
        }
        $homework->date = now();
        $result = $homework->save();
        if($result)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'Syllabus has been uploaded successfully'
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

    public function viewSyllabus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'section_id' => 'required'
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

        $homeworks = HomeWork::where('created_by_staff',$staff->id)->where('type','syllabus')->where('is_deleted','0')->OrderBy('id','DESC')->get();
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

            unset($homeworks[$key]['due_date'],$homeworks[$key]['status'],$homeworks[$key]['type'],$homeworks[$key]['created_by_staff']);
        }

        if(count($homeworks) > 0)
        {
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

    public function deleteSyllabus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'section_id' => 'required',
            'id' => 'required'
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

        $homeworkID = HomeWork::where('id',$request->id)->where('type','syllabus')->first();
        if(!$homeworkID)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Home Work Found.'
            ],401);
        }

        $homeworkID->is_deleted = '1';
        $result = $homeworkID
        ->save();
        if($result)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'Syllabus has been deleted successfully'
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

    public function editSyllabus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'section_id' => 'required',
            'title' => 'required',
            'syllabus_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }
        if(empty($request->description) AND count($request->files) == 0)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Input any one description or file'
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

        $homework = HomeWork::where('id',$request->syllabus_id)->where('type','syllabus')->first();
        if(!$homework)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Home Work Found.'
            ],401);
        }

        $user = User::where('id',Auth::user()->id)->first();
        $school = $user->school;
        $staff = Staff::where('username',Auth::user()->username)->first();

        $homework->school_id = $school->id;
        $homework->created_by_staff = $staff->id;
        $homework->class_id = $request->class_id;
        $homework->section_id = $request->section_id;
        $homework->type = "syllabus";
        $homework->title = $request->title;
        $homework->description = $request->description;
        if ($request->hasFile('files')) {
            $fileNames = [];
            foreach ($request->file('files') as $file) {
                $image = $file;
                $imageName = Auth::user()->id . time() . rand(0, 99) . '.' . $image->extension();
                $image->move(public_path('uploads/schools/syllabus'), $imageName);
                $fileNames[] = $imageName;
            }
            $homework->files = implode(',', $fileNames);
        }
        else
        {
            $homework->files = null;
        }
        $result = $homework->save();
        if($result)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'Syllabus has been updated successfully'
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

    public function viewResources(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'subject_id' => 'required',
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

        $subjectCount = Subject::find($request->class_id);
        if(!$subjectCount)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No Subject Found.'
            ],401);
        }
        $user = User::where('id',Auth::user()->id)->first();
        $school = $user->school;
        $staff = Staff::where('username',Auth::user()->username)->first();

        $resources = StudyMaterial::select('id','title','type')->where('school_id',$school->id)->where('is_deleted','0')
        ->where('class_id',$request->class_id)->where('subject_id',$request->subject_id)->get();

        if(count($resources) > 0)
        {
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

    public function detailResources(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'resource_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }

        $user = User::where('id',Auth::user()->id)->first();
        $school = $user->school;
        $staff = Staff::where('username',Auth::user()->username)->first();

        $resource = StudyMaterial::where('school_id',$school->id)->where('is_deleted','0')
        ->where('id',$request->resource_id)->first();

        if(!empty($resource))
        {
            if(!empty($resource->media) AND file_exists(public_path('uploads/schools/study-material').'/'.$resource->media))
            {
                $resource['media'] = asset("uploads/schools/study-material/".$resource->media);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Resources',
                'data' => $resource
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

    public function viewTimeTable(Request $request)
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

        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $assign_periods = TimeTableAssignPeriod::where('school_id',$school->id)->where('class_id',$class_id)
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
