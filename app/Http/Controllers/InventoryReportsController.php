<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager\MciBrand;
use App\Models\Manager\MciCategory;
use App\Models\Manager\MciSubCategory;
use App\Models\Item\item_quantities;
use App\Models\Item\Item_Discount;
use App\Models\Office\Shop\Shop;
use App\Models\Item\Item;

use App\Models\Sales\SalesItem;
use App\Models\Sales\Sale;
use App\Models\Sales\SaleItemTaxe;
use App\Models\Sales\SaleTaxe;
use App\Models\Sales\SalesPayment;

class InventoryReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexLowInventory()
    {
        //dd("test");
         return view("Inventory_Reports.low_inventory_index");
    }

    public function showLowInventory(Request $request)
    {
         return view("Inventory_Reports.inventory_low_show");
        
    }

    public function indexInventorySummery()
    {
        $shops = Shop::get();
        return view("Inventory_Reports.inventory_summery_index",compact('shops'));
        
    }

    public function showInventorySummery(Request $request)
    {
        $location = $request->stock_location;
        $item_count = $request->item_count;
        // dd($age);
        if($item_count == "0")
        {
            $items = item_quantities::with(['item','item_discount','shop'])->where('location_id',$location)->get();
        }
        elseif($item_count == "zeroAndLess")
        {
            $items = item_quantities::with(['item','item_discount','shop'])->where('quantity',0)
            ->where('location_id',$location)
            ->get();
        }
        elseif($item_count == "moreThanZero")
        {
            $items = item_quantities::with(['item','item_discount','shop'])->where('quantity','!=',0)
            ->where('location_id',$location)
            ->get();
        }
        return view("Inventory_Reports.inventory_summery_table",compact('items'));
    }
       
    public function indexInventoryAge()
    {
        $shops = Shop::get();
        return view("Inventory_Reports.inventory_age_index",compact('shops'));
        //dd("shops");
    }

    public function showInventoryAge(Request $request)
    {
        $location = $request->stock_location;
        $age = $request->age;
        // dd($age);
        if($age == "0")
        {
            $items = item_quantities::with(['item'])->where('quantity','!=',0)->where('location_id',$location)->get();
        }
        else
        {
            if($age = "30")
            {
                $start_date = date("Y-m-d", strtotime("-1 months"));
            }elseif($age = "90")
            {
                $start_date = date("Y-m-d", strtotime("-3 months"));
            }elseif($age = "180")
            {
                $start_date = date("Y-m-d", strtotime("-6 months"));
            }elseif($age = "365")
            {
                $start_date = date("Y-m-d", strtotime("-12 months"));
            }
            
            $end_date = date('Y-m-d');
                $items = item_quantities::with(['item'])->where('quantity','!=',0)
                ->whereBetween('updated_at', [$start_date, $end_date])
                ->where('location_id',$location)
                ->get();
        }
        return view("Inventory_Reports.inventory_age_table",compact('items'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
}
