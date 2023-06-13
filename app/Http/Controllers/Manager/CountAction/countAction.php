<?php

namespace App\Http\Controllers\Manager\CountAction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Office\Shop\Shop;
use App\Models\Item\item_quantities;
use App\Models\Item\Item;
use App\Models\Manager\MciBrand;
use App\Models\Manager\MciCategory;
use App\Models\Manager\MciColor;
use App\Models\Manager\MciSize;
use App\Models\Manager\MciSubCategory;


class countAction extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Shop::get();
        $get_cat = MciCategory::get();
        $get_brand = MciBrand::get();


        return view("manager.count_action.index", compact("shop", "get_cat", "get_brand"));
    }



    public function getAllItems($id)
    {

        $test = $id ;
        if($test == "0")
        {
            $item = item_quantities::all()->sum('quantity');
        }else{          
            
            $item = item_quantities::where('location_id', (int)$test)->sum('quantity');
          
        }
        /*else{
            $item = item_quantities::where('location_id', $request->location_id)->count();
        }*/

        //$test = count($item);
        return $item;
    }


    public function getItemSubCategories(Request $request)
    {
        $sub_category = MciSubCategory::where('parent_id', $request->cat_id)->pluck('id', 'sub_categories_name');
        return response()->json($sub_category);
    }

    public function getItemColor()
    {
        $get_color = MciColor::get()->pluck('id', 'color_name');
        return response()->json($get_color);
    }

    public function getItemSize()
    {
        $get_size = MciSize::get()->pluck('id', 'sizes_name');
        return response()->json($get_size);
    }

    public function getAllItemsCount(Request $request)
    {

        $c1 = $request->category ;
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
