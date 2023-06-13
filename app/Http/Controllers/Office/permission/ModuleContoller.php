<?php

namespace App\Http\Controllers\Office\permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Office\Permission\ModelPermission;
use App\Models\Office\Permission\Module;

class ModuleContoller extends Controller
{
    
    public function index()
    {
        $data = Module::all();
        return view('office.permission.module.index',compact('data'));
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required']);
        Module::create($data);
        $data = Module::all();
        return view('office.permission.module.table',compact('data'));
    }

  
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $data = Module::find($id);
        return $data;
    }

   
    public function update(Request $request, $id)
    {
        
        $data = $request->validate(['name'=>'required']);
        Module::find($id)->update($data);
        $data = Module::all();
        return view('office.permission.module.table',compact('data'));
    }

    
    public function destroy($id)
    {
        //
    }
}
