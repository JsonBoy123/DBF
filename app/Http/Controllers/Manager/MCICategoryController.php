<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager\MciCategory;
use App\Imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;

class MCICategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mciCategory = MciCategory::get();
        $mciSize = MciCategory::get();
        $mciBrand = MciCategory::get();
        $mciColor = MciCategory::get();
        $mciSubCategory = MciCategory::get();
       // dd($request);
        return view("manager.mci.index",compact('mciCategory','mciSize','mciBrand','mciColor','mciSubCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data = $request->validate(['category_name'=>'required|unique:mci_categories,category_name']);
        MciCategory::create($data);
        return back()->with('success','added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate(['category_name'=>'required|unique:mci_categories,category_name']);
        MciCategory::find($id)->update($data);
        return back()->with('success','updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentDate = date('Y-m-d H:i:s');
        MciCategory::where('id', $id)->update(['status' => 1,'deleted_at'=>$currentDate]);
      return back()->with("success","Category Soft Delete Successfully");
    }

    public function categoryImport(Request $request){
       //return $request->file('size_file');
        Excel::import(new CategoryImport, request()->file('category_file'));
        return back();
    }
}
