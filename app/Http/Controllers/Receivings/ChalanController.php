<?php

namespace App\Http\Controllers\Receivings;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Models\Office\Shop\Shop;
use App\Http\Controllers\Controller;
use App\Models\Receivings\Receiving;
use Illuminate\Support\Facades\Session;
use App\Models\Receivings\ReceivingItem;
use App\Models\Repair\RepairComplete;
use App\Models\Repair\Repair;
use App\Models\Item\item_quantities;
use App\Models\Manager\ControlPanel\CashierShop;
use App\Models\Stock\StockMovent;

class ChalanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {

    }
    public function show($id)
    {

    	//dd("teest");
        session()->forget('data');

        $login_id       = get_shop_id_name()->id;
        $shop_address   = Shop::where('id',$login_id)->first();
        $date           = date('d-M-Y');
        $data           = Receiving::find($id);

        // if($data){ 
             $chalan_no = $data->id;
        // }else
        //     { $chalan_no = 0; }

        $item_location  = $data->employee_id;
        
        $receiving_item = ReceivingItem::where('receiving_id', $id)
                            ->where('item_location', $item_location)
                            //->with('item.subcategoryName', 'item.categoryName')
                            ->get();   



        //dd(json_decode($receiving_item[0]->racks)[0]->rack_name);

        return view('receivings.chalan',compact('date','chalan_no','receiving_item','data','shop_address'));
    }

    public function chalanExcelTable($id){
        
        $user = User::find(Auth::id());

        $receiving = Receiving::where('id', $id)->first();

        if($user->isAbleTo('stock-maintainance')){
            $receiving_items = ReceivingItem::with(['item.categoryName', 'item.subcategoryName'])
                            ->where('receiving_id', $id)
                            ->where('item_location', $receiving->destination)
                            ->get();   
        }else{
            $receiving_items = ReceivingItem::with(['item.categoryName', 'item.subcategoryName'])
                            ->where('receiving_id', $id)
                            ->where('item_location', get_shop_id_name()->id)
                            ->get();
        }
        //dd($receiving_items);

        return view('receivings.manage-transfer.challan-table', compact('receiving_items'));
    }

    public function UpdateRepairItem($id){

        $receivingDetails = Receiving::find($id);
        $receiving_items = ReceivingItem::with(['item.categoryName', 'item.subcategoryName'])
                            ->where('receiving_id', $id)
                            ->where('item_location', get_shop_id_name()->id)
                            ->get();

        return view('receivings.manage-transfer.update_item', compact('receiving_items','id','receivingDetails'));
    }

     public function ReturnRepairItem(Request $request){
        $rec_id = $request->rec_id;
        $item_id = $request->item_id;
        $receivingDetails = Receiving::find($rec_id);
        Receiving::find($rec_id)->update(['repair'=>2]);
        // dd($receivingDetails);

        $dispatch_id = CashierShop::where('shop_id',get_shop_id_name()->id)->first();

        $rece['receiving_time'] = date('Y-m-d H:i:s');
        $rece['employee_id'] = $receivingDetails->destination;
        $rece['destination'] = $receivingDetails->employee_id;
        $rece['dispatcher_id'] = $dispatch_id->cashier_id;
        $rece['completed'] = 1;
        $rece['repair'] = 3;

        $repair_item_dc_id = Receiving::create($rece)->id;
        ReceivingItem::where('receiving_id',$rec_id)->update(['repair_status' =>  1]);

        if(count($item_id) !=0){
            foreach ($item_id as $key => $Items){
                // dd($item_id[$key]);
                $repair = Repair::find($request->repair_id[$key]);
                $data['item_id'] = $item_id[$key];
                $data['rec_id']  = $rec_id;
                $data['repair_cat_id']  = $request->repair_id[$key];
                $data['amount']  = $repair->cost;
                $data['complete']  = $request->repair[$key];
                $data['uncomplete']  = $request->damage[$key];
                $data['repair_item_dc_id']  = $repair_item_dc_id;

                RepairComplete::create($data);

                ReceivingItem::create([
                    'receiving_id'      =>  $repair_item_dc_id,
                    'item_id'           =>  $item_id[$key],
                    'line'              =>  1,
                    'quantity_purchased'=>  $request->repair[$key],
                    'item_location'     =>  $receivingDetails->employee_id,
                    'receiving_quantity'=>  $request->repair[$key],
                    'repair_status'     =>  1
                ]);

                ReceivingItem::create([
                    'receiving_id'      =>  $repair_item_dc_id,
                    'item_id'           =>  $item_id[$key],
                    'line'              =>  2,
                    'quantity_purchased'=>  '-'.$request->repair[$key],
                    'item_location'     =>  $receivingDetails->destination,
                    'receiving_quantity'=>  $request->repair[$key],
                    'repair_status'     =>  1
                ]);

                StockMovent::create([
                    'receiving_id'  => $repair_item_dc_id,
                    'item_id'       => $item_id[$key],
                    'quantity'      => $request->repair[$key]
                ]);


                item_quantities::where('item_id',$item_id[$key])
                ->where('location_id',$receivingDetails->destination)
                ->decrement('quantity',$request->repair[$key]);

                item_quantities::where('item_id',$item_id[$key])
                ->where('location_id',$receivingDetails->employee_id)
                ->increment('quantity',$request->repair[$key]);
            }
        }   
    }
}
