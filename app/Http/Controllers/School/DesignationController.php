<?php

namespace App\Http\Controllers\School;

use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DesignationController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $designations = Designation::where(['school_id' => $school->id,'is_deleted'=>'0'])->OrderBy("id","desc")->paginate(10);
        return view('school.designation.index')->with(compact('designations'));
    }

    public function create()
    {
        return view('school.designation.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);

        $designations = $request->designation;

        foreach ($designations as $designation) {
            $count = Designation::where(['school_id' => $school->id,'is_deleted'=>'0','name'=> $designation])->count();
            if($count <= 0)
            {
                Designation::create([
                    'school_id'    => $school->id,
                    'name' => $designation,
                    'created_by' => Auth::user()->id
                ]);
            }
        }
        return to_route('school.designations')->with('success', "Designation created successfully");
    }

    public function edit($id)
    {
        $designation = Designation::find($id);
        return view('school.designation.edit')->with(compact('designation'));
    }

    public function update(Request $request)
    {
        $designation = Designation::find($request->id);
        $validator = Validator::make($request->all(), [
           'name' =>'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $count = Designation::where('id','!=',$designation->id)->where('school_id',$designation->school_id)
        ->where('is_deleted','0')
        ->where('name',$request->name)->count();
        if($count > 0)
        {
            return back()->with('error',"Designation name already exists");
        }

        $designation->name = $request->name;
        $designation->save();
        return to_route('school.designations')->with('success', "Designation updated successfully");
    }

    public function delete(Request $request)
    {
        $designation = Designation::find($request->id);
        $designation->is_deleted = "1";
        $designation->save();
        return back()->with('success','Designation Deleted Successfully');
    }
}
