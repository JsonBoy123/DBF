<?php

namespace App\Http\Controllers\Repair;

use Illuminate\Http\Request;
use App\Models\Repair\Repair;
use App\Http\Controllers\Controller;
use App\Models\Receivings\Receiving;
use App\Models\Repair\RepairComplete;
use App\Models\AccoRepairItem;
use App\Models\AccoRepairBill;
use Carbon\Carbon;

class RepairController extends Controller
{

    public function index()
    {
       $data = Repair::all();
       // dd($data);
       return view('office.Repair.index',compact('data'));
    }
   
    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required',
        							'cost' =>'required|numeric'
    								]);
        Repair::create($data);
        return redirect()->back();

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }
   
    public function update(Request $request, $id)
    {
        $data = $request->validate(['name'=>'required',
        							'cost' =>'required|numeric'
    								]);
        Repair::find($id)->update($data);
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        //
    }

    public function CompleteWork(){
        $complete = Receiving::with(['repair_amount' => function($q){
            $q->select('rec_id','amount');
        },'repair_quantity'=>function($query){
            $query->select('rec_id','complete');
        }])
                            ->where(['destination'=>get_shop_id_name()->id,'repair'=>2])
                            ->get();
        return view('office.Repair.complete_work',compact('complete'));
    }

    public function WorkItemDetail($id){
        $data = RepairComplete::with(['repair_category','item'])->where('rec_id',$id)->get();   
        // dd($data);
        return view('office.Repair.complete_work_item',compact('data'));
    }

    public function accountsRepairItem(){
        $first = Carbon::now()->firstOfMonth();
        $last  = Carbon::now()->lastOfMonth();
        
        $startdate = date('Y-m-d',strtotime($first));
        $enddate   = date('Y-m-d',strtotime($last));

        $items = AccoRepairItem::with('item')->whereBetween('date', [$startdate, $enddate])->get();

        return view('accounts.index', compact('items'));

    }

    public function accountsRepairStore(Request $request){

    	$bill = AccoRepairBill::create(['bill_date' => date('Y-m-d')]);

    	$total_item = 0;
    	$total_amt	= 0;

    	foreach ($request->checkBtn as $key) {
    		$repairItem = AccoRepairItem::where('id', $key)->with(['item'])->first();

    		AccoRepairItem::where('id', $key)
    			->update([
    				'status'	    => '1',
    				'bill_id'	    => $bill->id,
                    'repair_cost'   => $repairItem['item']->repair_cost
    			]);

    		$total_item = $total_item + $repairItem->qty;
    		$total_amt 	= $total_amt  + ($repairItem['item']->repair_cost*$repairItem->qty);
    	}

	    AccoRepairBill::where('id', $bill->id)->update([
	    		'quantity'		=> $total_item,
	    		'bill_amount'	=>	$total_amt
	    	]);


    	$challan = AccoRepairBill::where('id', $bill->id)->with(['repairItems.item'])->first();
        
        return $lastId = $bill->id;
        //return view('accounts.challan', compact('challan'));
    }

    public function accountsRepairChallan($id){
        $challan = AccoRepairBill::where('id', $id)->with(['repairItems.item'])->first();
    	return view('accounts.challan', compact('challan'));
    }

    public function accountsRepairHistory(){

    	$bills = AccoRepairBill::all();

    	return view('accounts.history_index', compact('bills'));
    }

    public function getRepairedItem(Request $request){
        $startdate  = date('Y-m-d',strtotime($request->fromDate));
        $enddate    = date('Y-m-d',strtotime($request->toDate));

        $items = AccoRepairItem::with('item')->whereBetween('date', [$startdate, $enddate])->get();

        return view('accounts.search-table', compact('items'));
    }

}
