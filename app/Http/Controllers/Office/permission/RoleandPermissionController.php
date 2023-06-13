<?php

namespace App\Http\Controllers\Office\permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Office\Permission\Permission;
use App\Models\Office\Permission\Module;

class RoleandPermissionController extends Controller
{
    
    public function index()
    {
        $data = Module::all();        
        return view('office.permission.index',compact('data'));
    }

   
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required',
                                    'display_name'=>'required',
                                    'moule_id'=>'required'
                                    ]);
        Permission::create($data);
        $data = Permission::with(['module'])->where('moule_id',$data['moule_id'])->get();

        return view('office.permission.table',compact('data'));

    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        Models::destroy($id);
    }

    public function get($id){
        $data = Permission::with(['module'])->where('moule_id',$id)->get();
        return view('office.permission.table',compact('data'));
    }
}
