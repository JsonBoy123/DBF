<?php

namespace App\Http\Controllers\Manager;

use Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager\MciSubCategory;
use App\Imports\SubCategoryImport;

class MCISubCategoryController extends Controller
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
       // dd($request);
        /*$data = $request->validate(['sub_categories_name'=>'required|unique:mci_sub_categories,sub_categories_name']);
        $data['parent_id'] = $request->category_name;*/
        $data = array(
            'sub_categories_name' =>  $request->sub_categories_name,
            'parent_id'           =>  $request->category_name
        );
        MciSubCategory::create($data);
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
        
        $data = $request->validate(['sub_categories_name'=>'required|unique:mci_sub_categories,sub_categories_name']);
        $data['parent_id'] = $request->category_name;;
        MciSubCategory::find($id)->update($data);
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
        MciSubCategory::where('id', $id)->update(['status' => 1,'deleted_at'=>$currentDate]);
      return back()->with("success","SubCategory Soft Delete Successfully");
    }


    public function subCategoryImport(Request $request){
       //return $request->file('size_file');
        $cat_id = $request->category_name;
        $rows = Excel::toCollection(new SubCategoryImport, request()->file('sub_category_file'));


        foreach ($rows as $items) {
        // dd($items);
            foreach ($items as $sub_cat) {
            // dd($sub_cat);
                if($sub_cat['sub_categories_name'] !=''){
                    $subCategory = MciSubCategory::orWhere('sub_categories_name',$sub_cat['sub_categories_name'])
                    ->orWhere('sub_categories_name','LIKE','%'. $sub_cat['sub_categories_name'].'%')
                    ->where('parent_id', $cat_id)
                    ->first();
                    // dd($subCategory);
                    if($subCategory == null){                    
                        MciSubCategory::create([
                            'sub_categories_name' => $sub_cat['sub_categories_name'],
                            'parent_id' => $cat_id
                        ]);
                    }
                }
                //dd($subCategory);
            }

        }

        return back();
    }
}
