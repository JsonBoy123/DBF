<?php

namespace App\Http\Controllers;

use App\Models\Office\Employees\Employees;
use Illuminate\Support\Facades\Hash;
use App\Models\Item\item_quantities;
use App\Models\Item\Item;
use App\Models\Sales\OtherDiscount;
use App\Models\Sales\SalesPayment;
use App\Models\OpenCloseTimeings;
use App\Models\Office\Shop\Shop;
use App\Models\Sales\SalesItem;
use Illuminate\Http\Request;
use App\Models\Sales\Sale;
use DateTimeZone;
use DateTime;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $date = date('Y-m-d');        
        
        $tabs = Shop::where('deleted_at' ,NULL)->get();        
        
        $userId = Auth::id();
        $owner = Employees::where('user_id', $userId)->first();
        $shop_owner_id = $owner->id;
        //dd($shop_owner_id);
        $open_close = OpenCloseTimeings::where('location_owner', $shop_owner_id)->orderBy('id','Desc')->paginate(10);

        $timing = OpenCloseTimeings::where(['date'=> $date, 'location_owner'=> $shop_owner_id])->first();
        //dd($timing);
        if($timing == null)
        {
            $timing = "";
        }
        
        if(Auth::user()->isAbleTo('receiving-items-check')){
            return redirect('receivings-check');
        }else{
            return view('home',compact('tabs','timing','open_close', 'userId'));
        }
    }

    public function storeLoginTime(Request $request)
    {
        //dd($request->time);
        $data = new OpenCloseTimeings;

        $data->logintime    = $request->time;
        $data->reason    = $request->reason;
        //dd($data);

            $userId = Auth::id();
            
            $owner = Employees::where('user_id', $userId)->first();
            $shop_owner_id = $owner->id;
        $data->location_owner = $shop_owner_id;
            
            $location_id = Shop::where('shop_owner_id', $shop_owner_id)->first();
        $data->location_id = $location_id->id;
            //dd($shop_owner_id , $shop_location_id);

        $data->date = date('Y-m-d');

        $data->save();
    } 

    public function getAllLoginTime()  
    {
        $userId = Auth::id();
        $owner = Employees::where('user_id', $userId)->first();
        $shop_owner_id = $owner->id;
        //dd($shop_owner_id);
        $open_close = OpenCloseTimeings::where('location_owner', $shop_owner_id)->get();
        //dd($open_close);
        return view('open_close_details',compact('open_close'));
    }


    public function getAllShopsDetails()
    {
        $quantity = item_quantities::sum('quantity');
        $date = date('Y-m-d');
        $todays_sale_id = Sale::where(['sale_time'=> $date])->get();
        if(!empty($todays_sale_id))
        {
            $earning = 0;
            $p_q = 0;
            foreach($todays_sale_id as $data){
                $purchase_quantity = SalesItem::where('sale_id', $data->id)->sum('quantity_purchased');
                $payment_amt = SalesPayment::where('sale_id', $data->id)->sum('payment_amount');
                $other_dis = OtherDiscount::where('sale_id', $data->id)->first();
                if(!empty($other_dis)){
                    $o_d = $other_dis->damage + $other_dis->special + $other_dis->refrence + $other_dis->other;
                    $gross_value = $payment_amt-$o_d;
                }else{
                    $gross_value = $payment_amt;
                }
                $earning += $gross_value;
                $p_q     += $purchase_quantity;
            }
            
            return [
                'quantity' => $quantity,
                'purchase_quantity' => $p_q,
                'earning' => number_format($earning, 2)
            ];
        }
        else
        {
            return [
            'quantity' => $quantity,
            'purchase_quantity' => "0",
            'earning' => "0"
            ];
        }
    }

    public function getSingleShopsDetails(Request $request)
    {
        $shop_id = $request->shop_id;
        /*if($location_id == 19)
        {
        	$shop_id = 1; 
        }else{
        	$shop_id = $location_id;
        }*/
        $quantity = item_quantities::where('location_id', $shop_id)->sum('quantity');

        //dd($quantity);
        $date = date('Y-m-d');
        
        $todays_sale_id = Sale::where(['sale_time'=> $date, 'employee_id'=> $shop_id])->get();
        if(!empty($todays_sale_id))
        {
            $earning = 0;
            $p_q = 0;
            foreach($todays_sale_id as $data){
                $purchase_quantity = SalesItem::where('sale_id', $data->id)->sum('quantity_purchased');
                $payment_amt = SalesPayment::where('sale_id', $data->id)->sum('payment_amount');
                $other_dis = OtherDiscount::where('sale_id', $data->id)->first();
                if(!empty($other_dis)){
                    $o_d = $other_dis->damage + $other_dis->special + $other_dis->refrence + $other_dis->other;
                    $gross_value = $payment_amt-$o_d;
                }else{
                    $gross_value = $payment_amt;
                }
                $p_q     += $purchase_quantity;
                $earning += $gross_value;
            }
            
            return [
                'quantity' => $quantity,
                'purchase_quantity' => $p_q,
                'earning' => number_format($earning, 2)
            ];
        }
        else
        {
            return [
            'quantity' => $quantity,
            'purchase_quantity' => "0",
            'earning' => "0"
            ];
        }
        
    }

    public function requestForItems(){
        $shops = Shop::all();
        return view('request_for_items',compact('shops'));
    }

    public function showDiscountAlert(){
        $other = OtherDiscount::with(['location_name'])->where('status',false)->get();
        
        if(count($other) !=0){
            return view('item_discount_request',compact('other'));
        }
        else{
            return response(null,401);
        }
    }

    public function changeStatus(Request $request, $id,$status){

        $discount = OtherDiscount::where('id', $id)->first();

        if($discount->special != null){
            $type = 'special';
        }elseif($discount->damage != null){
            $type = 'damage';
        }elseif($discount->refrence != null){
            $type = 'refrence';
        }else{
            $type  = 'other';
        }

        OtherDiscount::find($id)
            ->update([
                'status' => $status,
                "$type"=> $request->discount_value]);

        return $this->showDiscountAlert();

    }

    public function update_item_quantity(){


          $items = SalesItem::paginate(10);
           // $users = DB::table('items')->get();
          return $items;
        // $items =  item_quantities::where('location_id','19')->update(item_quantities::select('item_id','quantity')->where('location_id','1')->get());

        // foreach ($items as $item) {
        //     // return $item;
        //     $item_fetch = item_quantities::where('item_id',$item->item_id)->where('location_id','19')->update(['quantity' => $item->quantity]);
        //     // return $item->quantity. ' ' .$item->item_id;
        // }
    }
}
