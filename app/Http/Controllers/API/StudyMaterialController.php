<?php

namespace App\Http\Controllers\API;

use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\StudyMaterial;
use App\Models\ClassAssignSubject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudyMaterialController extends Controller
{
    public function getClasses()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted', '0')->get();
        if(count($classes) > 0)
        {
            return response()->json([
                'status' =>200,
                'message' => 'Classes Available',
                'data' => $classes,
            ],200);
        }
        return response()->json([
            'status' =>200,
            'message' => 'No Class Found',
            'data'  => null,
        ],200);
    }

    public function getSubjectsByClass(Request $request)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $class = Classes::where('school_id', $school->id)->where('is_deleted', '0')->where('id',$request->class)->first();
        if(!$class)
        {
            return response()->json([
                'status' =>200,
                'message' => 'No Class Found',
                'data'  => null,
            ],200);
        }
        $subjects = ClassAssignSubject::with(['subject', 'schoolClass'])
            ->whereHas('schoolClass', function ($query) use($request) {
                $query->where('id', $request->class);
            })
            ->where('school_id',$school->id)
            ->get();

        $newArr = [];
        foreach ($subjects as $index =>$subject) {
            $newArr[$index]['id'] = $subject->subject_id;
            $newArr[$index]['name'] = $subject->subject->name;
        }
        return response()->json([
            'status' =>200,
            'message' => 'Subjects Found',
            'data'  => $newArr,
        ],200);
    }

    public function store(Request $request)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'title' =>'required',
            'type' =>'required',
            'class' =>'required',
            'subject' =>'required',
            'media' =>'required',
            'description' =>'required',
            'date'  =>'required',
         ]);

        if ($validator->fails()) {
            return response()->json([
                'status' =>401,
                'error' => $validator->errors()
            ],401);
        }

        $study_material = new StudyMaterial;
        $study_material->school_id =$school->id;
        $study_material->title = $request->title;
        $study_material->type = $request->type;
        $study_material->class_id  = $request->class;
        $study_material->subject_id  = $request->subject;
        $study_material->date = date("Y-m-d",strtotime($request->date));
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
        return response()->json([
            'status' =>200,
            'message' => 'Study material uploaded successfully',
        ],200);
    }

    public function viewAllContent()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $study_materials = StudyMaterial::where('school_id', $school->id)->where('is_deleted', '0')->OrderBy('id','DESC')->get();
        if(count($study_materials) > 0)
        {
            $modifiedData = $study_materials->map(function ($study_material) {
                $study_materialData = $study_material->toArray();

                $study_materialData['media'] = asset('uploads/schools/study-material/'.$study_material->media);
                $study_materialData['class'] = $study_material->class->name;
                $study_materialData['subject'] = $study_material->subject->name;

                unset($study_materialData['class_id'],$study_materialData['subject_id'],$study_materialData['school_id'],$study_materialData['is_deleted']);
                return $study_materialData;
            });
            return response()->json([
                'status' =>200,
                'message' => 'Study Material Available',
                'data' => $modifiedData,
            ],200);
        }
        return response()->json([
            'status' =>200,
            'message' => 'No Study Material Found',
            'data'  => null,
        ],200);
    }
}
