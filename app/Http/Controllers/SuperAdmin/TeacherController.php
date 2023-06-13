<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherController extends Controller
{
    function index()
    {
        $schools = School::OrderBy('name','asc')->where('is_deleted','0')->get();
        if(!empty(request()->input('school_id')))
        {

        }
        return view("superadmin.teacher.index")->with(compact('schools'));
    }
}
