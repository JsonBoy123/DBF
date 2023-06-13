<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager\MciBrand;
use App\Imports\BrandImport;
use Maatwebsite\Excel\Facades\Excel;

class MCIBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       dd('index');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       ///dd('create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request);

        $data = $request->validate(['brand_name'=>'required|unique:mci_brands,brand_name']);
        MciBrand::create($data);
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
        $data = $request->validate(['brand_name'=>'required|unique:mci_brands,brand_name']);
        MciBrand::find($id)->update($data);
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
        MciBrand::where('id', $id)->update(['status' => 1,'deleted_at'=>$currentDate]);
      return back()->with("success","Brand Soft Delete Successfully");
    }


    public function brandImport(Request $request){
       
        Excel::import(new BrandImport, request()->file('brand_file'));
        return back();
    }
}
