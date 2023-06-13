<?php

namespace App\Http\Controllers\Office\Offer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Office\Offer\DiscountPurchase;
use App\Models\Manager\MciCategory;

class DiscountOnPurchase extends Controller
{
    
    public function index()
    {
        $data = DiscountPurchase::with(['category'])->get();
        return view('office.offers.discount_on_purch.index',compact('data'));
    }

   
    public function create()
    {
    	$category = MciCategory::all();
    	$id = '';
    	$data=[];
        return view('office.offers.discount_on_purch.create_update',compact('category','id','data'));
    }

  
    public function store(Request $request)
    {	
    	$date = explode('-',$request->daterangepicker);
        $start_date = $date[0];
        $end_date = $date[1];
        $update_id = $request->update_id;

    	$Data = $request->validate(['category_id' => 'required',
    								'amount'	  => 'required',
    								'item_barcode'=> 'required',    								
    								]);
        $Data1['category_id'] = trim($Data['category_id']);
        $Data1['amount'] = trim($Data['amount']);
        $Data1['item_barcode'] = trim($Data['item_barcode']);

    	$Data1['from_date'] = date('Y-m-d',strtotime($start_date));
    	$Data1['to_date'] = date('Y-m-d',strtotime($end_date));
    	
    	if($update_id !=''){
    	    DiscountPurchase::find($update_id)->update($Data1);
    	}
    	else{
    		DiscountPurchase::create($Data1);
    	}

        $data = DiscountPurchase::with(['category'])->get();

        return view('office.offers.discount_on_purch.table',compact('data'));


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = MciCategory::all();
        $data = DiscountPurchase::find($id);
        return view('office.offers.discount_on_purch.create_update',compact('category','id','data'));
    }

 
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        DiscountPurchase::destroy($id);
        $data = DiscountPurchase::with(['category'])->get();

        return view('office.offers.discount_on_purch.table',compact('data'));
    }
}
