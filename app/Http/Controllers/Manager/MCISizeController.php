<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager\MciSize;
use App\Imports\SizeImport;
use Maatwebsite\Excel\Facades\Excel;

class MCISizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
       $data = $request->validate(['sizes_name'=>'required|unique:mci_sizes,sizes_name']);
        MciSize::create($data);
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
        $data = $request->validate(['sizes_name'=>'required|unique:mci_sizes,sizes_name']);
        MciSize::find($id)->update($data);
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
        MciSize::where('id', $id)->update(['status' => 1,'deleted_at'=>$currentDate]);
      return back()->with("success","Size Soft Delete Successfully");
    }

    public function sizeImport(Request $request){
       //return $request->file('size_file');
        Excel::import(new SizeImport, request()->file('size_file'));
        return back();
    }
}
