<?php

namespace App\Http\Controllers\School;

use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\StudyMaterial;
use App\Models\ClassAssignSubject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudyMaterialController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $study_materials = StudyMaterial::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("id", 'desc')->paginate(10);
        return view("school.study-material.index")->with(compact('school','study_materials'));
    }

    public function create()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $subjects = Subject::where('school_id',$school->id)->where('is_deleted','0')->OrderBy('name', 'asc')->get();

        return view("school.study-material.create")->with(compact('school','classes','subjects'));
    }

    public function getSectionsByClass($id)
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

    public function store(Request $request)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'title' =>'required',
            'type' =>'required',
            'class_id' =>'required',
            'subject_id' =>'required',
            'media' =>'required',
            'description' =>'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $study_material = new StudyMaterial;
        $study_material->school_id =$school->id;
        $study_material->title = $request->title;
        $study_material->type = $request->type;
        $study_material->class_id  = $request->class_id;
        $study_material->subject_id  = $request->subject_id;
        $study_material->date = $request->date;
        $study_material->description = $request->description;
        $study_material->created_by  = Auth::user()->id;
        if($request->hasFile('media'))
        {
            $image = $request->file('media');
            $imageName = Auth::user()->id.time() . '.' . $image->extension();
            $image->move(public_path('uploads/schools/study-material'), $imageName);
            $study_material->media = $imageName;
        }
        $study_material->save();

        return to_route("school.studyMaterial.view-content")->with("success","Study Material uploaded successfully");

    }

    public function edit($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $subjects = Subject::where('school_id',$school->id)->where('is_deleted','0')->OrderBy('name', 'asc')->get();
        $study_material = StudyMaterial::find($id);
        if(!$study_material)
        {
            return back();
        }
        return view("school.study-material.edit")->with(compact('school','classes','subjects','study_material'));
    }

    public function update(Request $request)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'title' =>'required',
            'type' =>'required',
            'class_id' =>'required',
            'subject_id' =>'required',
            'description' =>'required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $study_material = StudyMaterial::find($request->id);
        $study_material->school_id =$school->id;
        $study_material->title = $request->title;
        $study_material->type = $request->type;
        $study_material->class_id  = $request->class_id;
        $study_material->subject_id  = $request->subject_id;
        $study_material->date = $request->date;
        $study_material->description = $request->description;
        $study_material->created_by  = Auth::user()->id;
        if($request->hasFile('media'))
        {
            $previous_media = $study_material->media;
            if(!empty($previous_media) AND file_exists(public_path('uploads/schools/study-material/'.$previous_media)))
            {
                unlink(public_path('uploads/schools/study-material/'.$previous_media));
            }

            $image = $request->file('media');
            $imageName = Auth::user()->id.time() . '.' . $image->extension();
            $image->move(public_path('uploads/schools/study-material'), $imageName);
            $study_material->media = $imageName;
        }

        $study_material->save();

        return to_route("school.studyMaterial.view-content")->with("success","Study Material uploaded successfully");

    }

    public function detail($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $subjects = Subject::where('school_id',$school->id)->where('is_deleted','0')->OrderBy('name', 'asc')->get();
        $study_material = StudyMaterial::find($id);
        if(!$study_material)
        {
            return back();
        }
        return view("school.study-material.detail")->with(compact('school','classes','subjects','study_material'));
    }

    public function delete(Request $request)
    {
        $study_material = StudyMaterial::find($request->id);
        $study_material->is_deleted = "1";
        $study_material->save();

        return back()->with('success','Study Material Deleted Successfully');
    }
}
