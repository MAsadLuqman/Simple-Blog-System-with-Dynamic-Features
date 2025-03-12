<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(){
        $permission = Permission::get();
        if(request()->ajax()){
            return response()->json($permission);
        }
        return view('permissions.index',compact('permission'));
    }
}
