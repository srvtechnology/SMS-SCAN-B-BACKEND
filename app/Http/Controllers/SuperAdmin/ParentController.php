<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Parents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParentController extends Controller
{
    public function index()
    {
        $parents = Parents::OrderBy("id", 'desc')->paginate(10);
        return view("superadmin.parent.index")->with(compact('parents'));
    }

    public function detail($id)
    {
        $parent = Parents::find($id);
        return view("superadmin.parent.detail")->with(compact('parent'));
    }
}
