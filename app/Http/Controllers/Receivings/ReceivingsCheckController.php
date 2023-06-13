<?php

namespace App\Http\Controllers\Receivings;

use App\Models\Sales\Sale;
use Illuminate\Http\Request;
use App\Models\Sales\SalesItem;
use App\Http\Controllers\Controller;
use App\Models\Receivings\Receiving;
use App\Models\Receivings\ReceivingItem;

class ReceivingsCheckController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

    public function index() 
    {
        
        $receivings = Receiving::where('completed', '!=', 0)
                            ->where('repair', 0)
                            ->whereIn('employee_id', [1, 19, 16])
                            ->orWhereIn('destination', [1])
                            ->orderBy('id', 'DESC')
                            ->get();

        
        return view('receivings.items-check.index', compact('receivings'));
    }

    public function show($id)
    {
        $receiving = Receiving::where('id', $id)->first();

        $items = ReceivingItem::where('receiving_id', $id)->get();

        $recv_qty = ReceivingItem::where('receiving_id', $id)
                        ->where('item_location', $receiving->destination)
                        ->sum('quantity_purchased');

        return view('receivings.items-check.show', compact('items', 'recv_qty', 'receiving'));
    }

    public function update(Request $request, $receiving_id)
    {
        $request->validate([
            'item_check' => 'required'
        ]);

        $items = $request->item_check;

        //dd([$request->item_check, $receiving_id]);

        foreach($items as $key => $value){

            ReceivingItem::where('id', $key)->where('receiving_id', $receiving_id)
                ->update(['security_check' => $value]);
        }

        Receiving::where('id', $receiving_id)->update(['security_check' => 1]);

        return redirect('receivings-check')->with('success', 'Request has been approved.');
    }

    public function destroy($id){}

    public function receivingCheckHistory(){

        $today = date('Y-m-d');
        $receivings = Receiving::where('security_check', 1)
                            ->where('completed', '<>', 0)
                            ->where('repair', 0)
                            //->where('receiving_request', null)
                            ->whereDate('receiving_time', '<=', $today)
                            ->whereDate('receiving_time', '>=', date('Y-m-d', strtotime($today.' - 5 days')))
                            ->orderBy('id', 'DESC')
                            ->get();

        return view('receivings.items-check.history', compact('receivings'));
    }

    public function receivingShowHistory( $id){

        $receiving = Receiving::where('id', $id)->first();

        $items = ReceivingItem::where('receiving_id', $id)->get();

        $recv_qty = ReceivingItem::where('receiving_id', $id)
                        ->where('item_location', $receiving->destination)
                        ->sum('quantity_purchased');

        return view('receivings.items-check.history-show', compact('items', 'recv_qty', 'receiving'));
    }

    ##### Sales Check #######

    public function salesIndex(){

        $sales = Sale::with('customer')
                    ->where('security_check', 0)
                    ->where('sale_status', '<>', 2)
                    ->where('cancelled', '<>', 1)
                    // ->where('comment', '<>', '%test%')
                    ->whereIn('sale_type', ['wholesale', 'retail', '1rupee', 'franchise'])
                    ->whereIn('employee_id', [1, 19])
                    ->orderBy('id', 'desc')
                    ->get();

        return view('receivings.items-check.sales.index', compact('sales'));
    }

    public function salesShow( $id){

        $sale = Sale::with(['sale_items.item'])->where('id', $id)->first();

        $sale_qty = SalesItem::where('sale_id', $id)->sum('quantity_purchased');

        return view('receivings.items-check.sales.show', compact('sale', 'sale_qty'));
    }

    public function salesUpdate(Request $request ,$sale_id){

        $request->validate([
            'item_check' => 'required'
        ]);

        $items = $request->item_check;

        foreach($items as $key => $value){

            SalesItem::where('item_id', $key)->where('sale_id', $sale_id)->update(['security_check' => 1]);
        }

        Sale::where('id', $sale_id)->update(['security_check' => 1]);


        return redirect()->route('sales-check.index')->with('success', 'Request has been updated.');
    }

    public function salesCheckHistory(){

        $today = date('Y-m-d');
    
        $sales_history = Sale::with('customer')
                            ->where('security_check', 1)
                            ->whereIn('sale_type', ['retail', 'repair', 'wholesale', '1rupee'])
                            ->whereDate('sale_time', '<=', $today)
                            ->whereDate('sale_time', '>=', date('Y-m-d', strtotime($today.' - 1 days')))
                            ->orderBy('id', 'desc')
                            ->get();

        return view('receivings.items-check.sales.history', compact('sales_history'));
    }

    public function salesShowHistory( $id){

        $sale = Sale::with(['sale_items.item'])->where('id', $id)->first();

        $sale_qty = SalesItem::where('sale_id', $id)->sum('quantity_purchased');

        return view('receivings.items-check.sales.show-history', compact('sale', 'sale_qty'));
    }
}
