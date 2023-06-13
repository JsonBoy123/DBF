<?php

namespace App\Http\Controllers\Manager\ListAction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager\ListAction;
use App\Models\Manager\MciCategory;
use App\Models\Manager\MciSubCategory;
use App\Models\Manager\MciBrand;
use App\Models\Manager\MciSize;
use App\Models\Manager\MciColor;
use App\Models\Office\Shop\Shop;
use App\Models\Item\Item;
use App\Models\Item\items_taxes;
use App\Exports\AllItemsExport;
use Maatwebsite\Excel\Facades\Excel;


class ListActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $shop =  Shop::get();
         $MciCategory = MciCategory::get();
         $Brand = MciBrand::get();
         $Size = MciSize::get();
         $Color = MciColor::get();
         // dd($data);
         $mciCategory = MciCategory::where('status',0)->get();
        return view('manager.list-action.index',compact('shop','MciCategory','Brand','Color','Brand','Size'));
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
        return 'success';
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getSubCategory()
    {
         $categoryId = $_POST['category'];
         $mciSubCategory = MciSubCategory::with('categoryDetail')->where('status',0)->where('parent_id',$categoryId)->get();
         
        //dd($mciSubCategory);
        echo "<select>";
        echo "<option><--Select Sub-category--></option>";
            foreach($mciSubCategory as $value){

            echo "<option>". $data = $value->sub_categories_name . "</option>";

            }

        echo "</select>";
        return $data;
    }

    public function getAllData()
    {
         $subcategory = $_POST['subcategory'];
         $category = $_POST['category'];
         $brandId = $_POST['brand'];
         $mciSubCategory = MciSubCategory::where('sub_categories_name',$subcategory)->first(); 
         $brandDetails  = MciBrand::where('id',$brandId)->first();
         $SubCategoryId = $mciSubCategory->id;
   
        $data = Item::with(["ItemTax", "brandName", "categoryName", "subcategoryName", "sizeName", "colorName"])
                      ->where('subcategory',$SubCategoryId)
                      ->where('category',$category)
                      // ->where('brand',$brandId)
                      ->get();

                      // dd($data);
            return view('manager.list-action.show-data',compact('data'));
         
    }
    public function exportItems()
    {
        return Excel::download(new AllItemsExport, 'all-items.xlsx');
    }
}
