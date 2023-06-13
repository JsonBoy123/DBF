<?php

namespace App\Http\Controllers\Manager\Enventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item\Item;
use App\Models\Item\temp_item;
use App\Models\Manager\MciSize;
use App\Models\Manager\MciColor;
use App\Models\Office\Shop\Shop;
use App\Models\Manager\MciBrand;
use App\Models\Item\items_taxes;
use App\Models\Item\Item_Discount;
use App\Models\Manager\MciCategory;
use App\Models\Item\item_quantities;
use App\Models\Item\temp_item_sheets;
use App\Models\Manager\MciSubCategory;
use App\Models\Manager\ControlPanel\CustomTab;


class EnventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $sheet = temp_item_sheets::with('uploader_name')->orderBy('id', 'desc')->get();
        $app_sheet = temp_item_sheets::with('uploader_name')->where('sheet_status','1')->orderBy('id', 'desc')->get();

        //dd($sheet);
        return view("manager.enventory.index",compact('sheet','app_sheet'));
    }

    public function show($id)
    {
      
        $sheet_id = $id;
        //dd($sheet_id);
        $sheet = temp_item_sheets::where('id',$sheet_id)->select('sheet_status')->first();
        //dd($sheet);
        $data = temp_item::where('parent_id', $sheet_id)->get();
        return view("manager.enventory.uploading_sheet", compact('data', 'sheet', 'sheet_id'));
    }

    public function getBarcode($id)
    {
        $parent_id = $id;
        $items = Item::with(["ItemTax", "brandName", "item_discount", "categoryName", "subcategoryName", "sizeName", "colorName",'item_quantity' => function ($query) {
                    $query->where('location_id',get_shop_id_name()->id);
            }])->where('parent_id', $parent_id)->get();
        //dd($items);
        return view("manager.enventory.uploaded_sheet", compact('items'));
    }

    public function getAllItemsCount(Request $request)
    {

        $c1 = $request->category;
        $c2 = $request->sub_category1 ;
        $c3 = $request->brand ;
        $c4 = $request->size ;
        $c5 = $request->color ;
        
   //dd($c1, $c2, $c3, $c4, $c5);
        $countAll = Item::where('category', $c1)
                ->where('subcategory', $c2)
                ->where('brand', $c3)
                ->orWhere('size', $c4)
                ->orWhere('color', $c5)
                ->count();
     //dd($countAll);
        return $countAll;
        // $sub_category = MciSubCategory::all();
        // return $sub_category;
    }


}
