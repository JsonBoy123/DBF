<?php

namespace App\Http\Controllers\Receivings;

use DB;
use Auth;
use Helper;
use Response;
use App\User;
use Notification;
use App\Models\Item\Item;
use Illuminate\Http\Request;
use App\Models\AccoRepairItem;
use App\Models\Office\Shop\Shop;
use App\Models\Stock\StockMovent;
use App\Models\TempStockReceiving;
use App\Models\Stock\StockTransfer;
use App\Http\Controllers\Controller;
use App\Models\Receivings\Receiving;
use App\Notifications\Notifications;
use App\Models\Item\item_quantities;
use App\Models\Manager\ManageItemRack;
use Illuminate\Support\Facades\Session;
use App\Models\Receivings\ReceivingItem;
use App\Models\Office\Employees\Employees;
use App\Models\Receivings\ReceivingRequest;
use App\Models\Manager\ControlPanel\Cashier;
use App\Models\Receivings\ReceivingRequestItems;
use App\Models\Manager\ControlPanel\CashierShop;
use App\Models\Repair\Repair;

class ReceivingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        // dd(session()->forget('show_list'));
        $login_id = get_shop_id_name()->id;

        $Shop     = Shop::where('id','!=',$login_id)->get();

        $cashier  = CashierShop::with(['cashier'])->where('shop_id',get_shop_id_name()->id)->get();
        // dd($cashier);

        return view('receivings.index',compact('Shop','cashier','login_id'));
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        session()->put('mode',$request->mode);  
         if($request->flag == 'item_list_update')
          {
            $itemData = Item::with(['item_discount'])->where("item_number",$request->barcode)->first();
            // return $itemData;
            $login_id   = get_shop_id_name()->id;

            $actual_qty = item_quantities::where('item_id',$itemData->id)->where('location_id',$login_id)->first();

            if(session('receiving_data') !=null){
            $sessionDatas = session('receiving_data');
            $sessionData = '';

            foreach ($sessionDatas as $key => $value) {
                if($key == $itemData->id){
                    $sessionData = session('receiving_data')[$itemData->id];
                    // $sessionData[]
                   $value['qty'] = $value['qty'] + 1;
                   $sessionDatas[$key] = $value;
                }
            }           
                if($sessionData ==null){               
                    $sessionDatas[$itemData->id] = $this->create_receiving_items($actual_qty,$itemData);
                }

                session()->put('receiving_data',$sessionDatas);

            }else{
                // return "hello";
                $insertData[$itemData->id] = $this->create_receiving_items($actual_qty,$itemData);
                session()->put('receiving_data',$insertData);

            }

          }elseif($request->flag == 'item_quntity_update'){
            $sessionDatas = session('receiving_data');
            $sessionData = '';
            foreach ($sessionDatas as $key => $value) {
                if($key == $request->item_id){
                    $sessionData = session('receiving_data')[$request->item_id];
                    // $sessionData[]
                   $value['qty'] = $request->qty;
                   $sessionDatas[$key] = $value;
                }
            }     
             session()->put('receiving_data',$sessionDatas);

          }
       return view('receivings.itmes-display');
        // $res        = $request->barcode;
        // $status        = $request->status;
        // // dd($res);
        // $data       = Item::with(['item_discount'])->where("item_number",$res)->first();
        // $login_id   = get_shop_id_name()->id;
        // $actual_qty = item_quantities::where('item_id',$data->id)->where('location_id',$login_id)->first();

        // $data1['actual_qty']        = $actual_qty->quantity;
        // $data1['item_id']           = $data->id;
        // $data1['name']              = $data->name;
        // $data1['item_number']       = $data->item_number;
        // $data1['unit_price']        = $data->unit_price == 0 ? $data->item_discount->retail:$data->unit_price;
        // $data1['qty']               = 1;
        // $data1['receiving_quantity']= $data->receiving_quantity;
       

        // if(session('data') != ''){
        //     session()->put('data.'.$data->id, $data1);            
        // }
        // else{
        //     session()->put('data.'.$data->id, $data1);          

        // }

        // if($status == '1'){
        //     return redirect('receivings');
        // }

        //  return view('receivings.itmes-display');
    }


    public function repair_items(Request $request){
        
        $itemData = Item::with(['item_discount'])->where("item_number",$request->barcode)->first();
            // return $itemData;
        $login_id   = get_shop_id_name()->id;

        $actual_qty = item_quantities::where('item_id',$itemData->id)->where('location_id',$login_id)->first();
        $items = session('receiving_data') == null ? session('receiving_data',array()):session('receiving_data');

        if(isset($items[$itemData->id])){
                $items[$itemData->id]['qty'] = (int)$items[$itemData->id]['qty']+1;
                session()->put('receiving_data',$items);             
        }
        else{
            $items[$itemData->id] = [
                                  'actual_qty'    => $actual_qty->quantity,
                                  'item_id'       => $itemData->id,
                                  'name'          => $itemData->name,
                                  'item_number'   => $itemData->item_number,
                                  'unit_price'    => 0,
                                  'qty'           => '1',
                                  'receiving_quantity' =>  0,
                                  'repair_cat_id'    => 'null',
                                  'repair_cat'     => Repair::all(),
                                ];
            session()->put('receiving_data',$items);        
            session()->put('mode',$request->mode);  
            return session('mode');
           
        }
    }

    public function save_category_on_item(Request $request){
        $item_id = $request->item_id;
        $cat_id = $request->cat_id;
        $items = session('receiving_data');
        $items[$item_id]['repair_cat_id'] = $cat_id;
        session()->put('receiving_data',$items);
    }

    public function delete_all(){
        session()->forget('receiving_data');
        Session::remove('receiving_session');
        Session::remove('receiving_request');
        Session::remove('receiving_data');

        return redirect()->back();
    }

    public function create_receiving_items($actual_qty,$itemData){ //sesssion create itmes
        $data = [
            'actual_qty'    => $actual_qty->quantity,
            'item_id'       => $itemData->id,
            'name'          => $itemData->name,
            'item_number'   => $itemData->item_number,
            'unit_price'    => $itemData->unit_price == 0 ? $itemData->fixed_sp : $itemData->unit_price,
            'qty'           => '1',
            'repair_cat'    => 'null',
            'repair_cat_id'    => 'null',
            'receiving_quantity' =>  $itemData->receiving_quantity,
            //'test'          =>  $itemData->fixed_sp
        ];
        return $data;
    }


      public function save_receiving_items(Request $request)
    {
        // return $request->all();
    /* Start Receiving Table Part */ 
    
        if(Session::has('receiving_data') != null){

            $data['employee_id']   = $request->login_shop_id;
            $data['dispatcher_id'] = $request->dispatcher_id;
            $data['destination']   = $request->destination_id;
            $data['comment']       = $request->comment;
            $data['receiving_time']= date('Y-m-d H:i:s');
            $data['completed'] = '1'; //Reciving status pending 
            $data['repair'] = $request->mode =='repair' ? 1 :0;
            $data['laxyo_house']   = 1;
            $data['receiving_request'] = Session::has('receiving_session') == 1 ? session()->get('receiving_request')['request_id'] : null;


            $receiving_id = Receiving::create($data)->id;
        }


    /* End Receiving Table Part */

    /* Start Receiving_item Table Part */ 


        $count =1;

        foreach (session('receiving_data') as $key => $value) {
            // dd($value['repair_cat_id']);

            $receiving = [
                'receiving_id'  => $receiving_id,
                'item_id'       => $key,

           ];     

    /* Start Item Quantities Table Part */ 

           $item_actual_qty = $value['actual_qty'];
         
            item_quantities::where('item_id',$key)
                ->where('location_id',$request->login_shop_id)
                ->decrement('quantity',$value['qty']);


    /* End Item Quantities Table Part */ 

           $receiving['quantity_purchased'] = -$value['qty'];
           $receiving['item_location']      = $request->login_shop_id;
           $receiving['line']               = $count;
           $receiving['repair_status']      = 0;
           $receiving['repair_price']       = $value['repair_cat_id'] == 'null' ? 0: $value['repair_cat_id']; 

           $count = $count + 1;

           ReceivingItem::create($receiving);

           $receiving['quantity_purchased'] = $value['qty'];
           $receiving['item_location']      = $request->destination_id;
           $receiving['line']               = $count;
           $receiving['repair_status']      = 0;     
           $receiving['repair_price']       = $value['repair_cat_id'] == 'null' ? 0: $value['repair_cat_id'];   

           $count = $count + 1;

           ReceivingItem::create($receiving);




    /* End Receiving_item Table Part */

    /* Start Stock Movement Table Part */ 

            $stock = [
                'receiving_id'  => $receiving_id,
                'item_id'       => $key,
                'quantity'      => $value['qty'],
                'processed'     => '1',
            ];          

           StockMovent::create($stock);
          if(get_shop_id_name()->id == 1){

            $qty = $value['qty'];
            $racks  = ManageItemRack::with(['rack_name','rack_item'])->where('item_id',$key)->orderBy('quantity','asc')->get();  
            $totalqty = 0;
            $store[$key]=''; 
            $rak = []; 
            // dd($racks);  
            if(count($racks) !=0){ 
            $rack_name_arr = []   ;

                foreach ($racks as $rack) {
                    $rack_qty = $rack->quantity;

                    if($qty !=0){
                        if($rack_qty > 0){
                            if($qty > $rack_qty){
                                $qty = (int)$qty - (int)$rack_qty;
                                ManageItemRack::find($rack->id)->update(['quantity'=>0]); 
                                $rak[trim($rack->rack_name->rack_number)] =  $rack->quantity; 
                                // $totalqty = $rack->quantity; 
                                $rack_name_arr[] = [
                                    'rack_name'  =>  $rack->rack_name->rack_number,
                                    'quantity'   =>  $rack_qty
                                ];
                            }else{
                                $qty1   = (int)$rack->quantity - (int)$qty;
                                                 
                                ManageItemRack::find($rack->id)->update(['quantity'=>$qty1]);
                                $rak[trim($rack->rack_name->rack_number)] = $qty ;
                                // $totalqty +=$qty; 

                                $rack_name_arr[] = [
                                    'rack_name'  =>  $rack->rack_name->rack_number,
                                    'quantity'   =>  $qty
                                ];

                                $qty   = 0;   
                            }  
                        }
                    }

                    /*$rack_name_arr[] = [
                        'rack_name'  =>  $rack->rack_name->rack_number,
                        'quantity'   =>  $totalqty
                    ];*/
                }
                $store[$key] = $rak;
                //return $rack_name_arr;
                if(count($rack_name_arr) !=0){
                   $rack_name_d =  json_encode($rack_name_arr);
                }else{
                    $rack_name_d = null;
                }

                //dd($rack_name_d);
                ReceivingItem::where('receiving_id', $receiving_id)
                    ->where('item_id', $key)
                    ->update(['racks' => $rack_name_d]);
            } 
        	Session::put('show_list', $store);
          }
        }

        // dd($store[0]);
        #____________Update account repair items_______________

        if(Auth::user()->hasPermission('repair_panel')){

            $items = ReceivingItem::where('receiving_id', $receiving_id)
                        ->where('item_location', '<>', 31)->get();

            foreach($items as $item) {

                AccoRepairItem::create([
                    'receiving_id'  =>  $receiving_id,
                    'item_id'       =>  $item->item_id,
                    'qty'           =>  $item->quantity_purchased,
                    'date'          =>  date('Y-m-d H:i:s')
                ]);
            }
        }



        /*** Update receiving request status to 1 ***/

        if(Session::has('receiving_session')){

            if(in_array(get_shop_id_name()->id, [1, 16, 17, 19])){

                ReceivingRequest::where('id', session()->get('receiving_request')['request_id'])
                        ->update([
                            'laxyo_admin'           => 3,
                            'reference_receiving_id'=> $receiving_id]);

                /*** Notification for new Return Receivings ***/

                $shop = Employees::where('shop_id', session()->get('receiving_request')['requested_by']->id)->first();

                $user = User::find($shop->user_id);
                $user_type = 'requested_by';

            }else{
                ReceivingRequest::where('id', session()->get('receiving_request')['request_id'])
                        ->update([
                            'status'             => 1,
                            'return_receiving_id'=> $receiving_id]);

                $user = User::whereIn('id', [4, 18])->orderBy('id')->get();
                $user_type = 'laxyo_admin';
            }

            /*** Notification for new Return Receivings ***/

            //$user = User::find($shop->user_id)->get();

            $data['id']     = $receiving_id;
            $data['user']   = $user_type;
            $data['url']    = 'manage_transfer';
            $data['message']= 'You have new DC( Receiving ).';

            Notification::send($user, new Notifications($data));

        }else{

            /*** Notification for direct new Receivings ***/

            $shop = Employees::where('shop_id', $request->destination_id)->first();

            $user = User::find($shop->user_id);

            $data['id']     = $receiving_id;
            $data['user']   = 'requested_by';
            $data['url']    = 'manage_transfer';
            $data['message']= 'You have new DC( Receiving ).';

            Notification::send($user, new Notifications($data));

        }

        session::forget('receiving_data');
        Session::remove('receiving_session');
        Session::remove('receiving_request');
        Session::remove('receiving_data');

        return $receiving_id;
    }

    public function remove_entry_session(Request $request, $id)
    {
        $id = $request->id;

        session::forget('receiving_data.'.$id);  

        $data = session('receiving_data');

        session()->flash('success', 'Product removed successfully');

          return redirect()->route('receivings.index')->with('success','Item deleted successfully');
    }
    public function destroy($id)
    { 
    } 

    // public function allChalances(){

    //     return view('receivings.manage-transfer.all-chalances');
    // }
     public function getSaleItem(Request $request)
    {
        //dd($request->all());
        $query  = $request->get('query');
        $data   =  Item::where('name', 'ILIKE', "%{$query}%")->orwhere('item_number', 'ILIKE', "%{$query}%")->get();
        $output = '<ul class="dropdown-menu" style="display:block; position:relative">';

        if(count($data) != null)
        {
              foreach($data as $row)
              {
                $output .= '<li id="selectLI"><a id="getItemID" href="?itemId='.$row->id.'" style="pointer-events: none;" value="'.$row->id.'">'.$row->name .' | '.$row->item_number.'  </a></li>';
              }
        }
        else
        {
            $output .= '<li><a href="JavaScript:void(0);">No Items available</a></li>';
        }
        $output .= '</ul>';
        echo $output;
    }

    /*
    *Request for Items
    */

    public function requestForItems(){

        $shops = Shop::all();

        //$shops = Shop::whereNotIn('shop_owner_id', [12, 13, 14, 16])->get();
        //$items = item_quantities::with('item')->selectRaw('distinct item_id')->paginate(10);

        $items = Item::select('id', 'item_number', 'name', 'unit_price', 'fixed_sp', 'category', 'subcategory')
                    ->whereHas('item_quantities',function($query){
                        $query->whereIN('location_id',[1, 2, 5, 6, 7, 12])
                        ->where('quantity','>','0');
                    })->with(['item_quantities' => function($q){
                        $q->select('item_id','location_id','quantity')
                        ->whereIn('location_id',[1, 2, 5, 6, 7, 12])
                        ->orderBy('location_id');
                    }, 'categoryName', 'subcategoryName'])->paginate(20);

        $users = User::wherePermissionIs('hide_shops')->get()->pluck('id');

        $employee = Employees::where('user_id', Auth::id())
                    ->whereNotIn('user_id', $users)
                    ->first();

        $user = User::where('id', Auth::id())->first();

        return view('request_for_items',compact('shops','items', 'employee'));
    }

    /*
    *Modal view
    */

    public function stockRequest(Request $request){

        $currentshop    = $request->item['currentshop'];
        $shops          = $request->item['shops'];
        $item_id        = $request->item['id'];
        $item_qty       = $request->item['qty'];

        $entry = TempStockReceiving::where('shop_id', $shops)
                    ->where('item_id', $item_id)
                    ->where('destination_shop', $currentshop)
                    ->first();

        if($entry == null){

            if($item_qty != 0){

                TempStockReceiving::insert([
                    'shop_id'           => $shops,
                    'item_id'           => $item_id,
                    'quantity'          => $item_qty,
                    'destination_shop'  => $currentshop
                ]);
            }

        }elseif($item_qty == 0){

        	TempStockReceiving::where('shop_id', $shops)
                ->where('item_id', $item_id)
                ->where('destination_shop', $currentshop)
                ->delete();

        }else{
            TempStockReceiving::where('shop_id', $shops)
                ->where('item_id', $item_id)
                ->where('destination_shop', $currentshop)
                ->update(['quantity' => $item_qty]);
        }

    }

    public function stockRequestShow(Request $request){

    	$stockTemp = TempStockReceiving::with(['itemShop', 'item'])
    					->where('destination_shop', $request->shop)
    					->get();
        $users = User::wherePermissionIs('stock-maintainance')->get();


    	return view('RequestItems.show', compact('stockTemp'));
    }

    public function stockRequestStore(Request $request){

    	$shops = array_unique($request->shops);

        //dd(get_shop_id_name()->id);

    	$stock_shops = [];

    	foreach($shops as $index){


	    	$stock_shops = TempStockReceiving::where('shop_id', $index)
                                ->where('destination_shop', get_shop_id_name()->id)
                                ->first();

            if(in_array($stock_shops->shop_id, [1, 16, 17, 19])){

                $status      = 1;
                $laxyo_admin = 2;
            }else{
                $status = $laxyo_admin = 0;
            }

            $rec_request     = ReceivingRequest::create([
                                'time'          =>  date('Y-m-d H:i:s'),
                                'requested_by'  =>  $stock_shops->destination_shop,
                                'requested_to'  =>  $stock_shops->shop_id,
                                'status'        =>  $status,
                                'laxyo_admin'   =>  $laxyo_admin,
                                'comment'       =>  $request->comment,
                            ]);

            $request_id = $rec_request->id;

            $requestedItem = TempStockReceiving::with('item')
                                ->where('destination_shop', get_shop_id_name()->id)
                                ->where('shop_id', $stock_shops->shop_id)
                                ->get();

            foreach($requestedItem as $items){

                ReceivingRequestItems::create([
                    'receiving_request_id'=>  $request_id,
                    'item_id'             =>  $items->item_id,
                    'quantity'            =>  $items->quantity,

                ]);
            }

            TempStockReceiving::with('item')
                                ->where('shop_id', $stock_shops->shop_id)
                                ->where('destination_shop', get_shop_id_name()->id)
                                ->delete();

            /*** Notification for new requests ***/

            $users = User::whereIn('id', [4, 18])->orderBy('id')->get();

            $data['id']     = $request_id;
            $data['user']   = 'laxyo_admin';
            $data['url']    = 'manage_transfer';
            $data['message']= 'You have new request from shop.';

            Notification::send($users, new Notifications($data));
		}

		return back()->with('success', 'Request has been sent');
    }

    public function generate_list(){
        $show_list = session('show_list');

        // dd($show_list);
        return view('manager.manage_item_by_rack.item_sheet',compact('show_list'));
    }

    public function delete_list(){

        session()->forget('show_list');
    }

    public function saveItemInSession(Request $request){
        $item_id = $request->item_id;
        $shop_id = $request->shops_id;
        $status = $request->status;
        dd(session('shop_item_list'),'top');
        $data = session('shop_item_list');
        
        if(session('shop_item_list') == null){
            $data = array();
        }
        
        if($status == 1){  
            if(!empty($data)){
            dd(count($data));
            dd($data,'status 1');
                array_push($data[$shop_id],[$item_id=>0]);
                session()->put('shop_item_list',$data);
            }
            else{
                $data[$shop_id] = [$item_id=>0];
                session()->put('shop_item_list',$data);
            }            
        }
        else{
                dd(session('shop_item_list'),'status 0');
            unset($data[$shop_id][$item_id]);
            session()->put('shop_item_list',$data);
        }

    }

}
