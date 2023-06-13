<?php

namespace App\Http\Controllers\Sales;

use Auth;
use Helper;
use Session;
use Response;
use App\Customer;
use App\Models\Item\Item;
use App\Models\Sales\Sale;
use Illuminate\Http\Request;
use App\Models\Office\Shop\Shop;
use App\Models\Office\Broker\Broker;
use App\Http\Controllers\Controller;
use App\Models\Sales\SalesReturnHistory;
use App\Manager\ControlPanel\ControlPanel;
use App\Models\Manager\ControlPanel\Cashier;
use App\Models\Office\Offer\DiscountPurchase;
use App\Models\Manager\ControlPanel\CashierShop;
use App\Models\Office\Permission\ModelPermission;
use App\Models\Manager\BulkAction\BulkAction_Discount;


class SalesController extends Controller 
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        
      $cashier = CashierShop::with(['cashier'])->where('shop_id',get_shop_id_name()->id)->get();
      $shop = ModelPermission::with(['shop'])->where(['module_id'=>4,'location_id'=>Auth::user()->id])->get();
      // dd($cashier);
      $data = Broker::all();
      return view('sales.index',compact('shop','cashier','data'));
    }   


    public function store(Request $request)
    {    
      if ($request->item_name) {
          
          $s_id = get_shop_id_name()->id;
          if(in_array($s_id, [16, 17, 18, 19]))
          {
              $loc_id = '1';
          }
          else{
              $loc_id = get_shop_id_name()->id;
          }

        $product  = Item::with(['ItemTax','item_quantity'=> function($query) use($loc_id){
          $query->where('location_id',$loc_id);
        },'item_discount'])->where("item_number",$request->item_name)->get();

        $id        = $product[0]->id;
        $billType  = $request->billType;


        session()->put('billType',$billType);
        $item      = session()->get('item');
        $cat_total = session('cat') == null ? array(): session('cat') ;
        $bulk      = BulkAction_Discount::where('subcategory',$product[0]->subcategory)->first();
        $buyGet    = [];
       

        if($bulk && $bulk->status !=0){
          // dd($bulk);
          if(session('buyGet') == null){
            if($bulk->status > 0){
              // $buyGet[$product[0]->category][$bulk->status][$id]  = [$product[0]->unit_price];
              $buyGet[$product[0]->subcategory][$bulk->status][$id] = (int)$product[0]->unit_price;              
            }
          }
          else{
            if($bulk->status > 0){
               $buyGet = session('buyGet');
               // $buyGet[$product[0]->category][$bulk->status][$id]  = [$product[0]->unit_price];
               if(isset($buyGet[$product[0]->subcategory][$bulk->status][$id])){
                  $buyGet[$product[0]->subcategory][$bulk->status][$id]  += (int)$product[0]->unit_price;
               }
               else{
                  $buyGet[$product[0]->subcategory][$bulk->status][$id]  = (int)$product[0]->unit_price;
               }
               // $buyGet[$product[0]->subcategory][$bulk->status][$id][0] += 1;
             }
          
          }

            session()->put('buyGet',$buyGet);
            $totalValue = session('buyGet');
            $totGet = $totalValue[$product[0]->subcategory][$bulk->status];
            asort($totGet);
          
              $totalValue[$product[0]->subcategory][$bulk->status] = $totGet;
              session()->put('buyGet',$totalValue);
            
        }

          if(!$item) {
            $cat_total = session('cat') == null ? array(): session('cat') ;
            // dd($cat_total);
              $data = DiscountPurchase::all();              
              // foreach($data as $Data ){                

                if(array_key_exists($product[0]->subcategory,$cat_total)){
                   $cat_total[$product[0]->subcategory] += $product[0]->unit_price != '0.00' ? $product[0]->item_discount->$billType  !='0.00' ? ($product[0]->unit_price -  ($product[0]->unit_price * $product[0]->item_discount->$billType)/100):$product[0]->unit_price : $product[0]->item_discount->$billType ;
                }
                else{                	
                   $cat_total[$product[0]->subcategory] = $product[0]->unit_price != '0.00' ? $product[0]->item_discount->$billType  !='0.00' ? ($product[0]->unit_price -  ($product[0]->unit_price * $product[0]->item_discount->$billType )/100):$product[0]->unit_price : $product[0]->item_discount->$billType;
                }


                 
              // }
              if(!empty($cat_total)){
                  session()->put('cat',$cat_total);
                }
                // dd(session('cat'));

                   
            $item[$id] = [
                    "item_number" => $product[0]->item_number,
                    "name"        => $product[0]->name,
                    "unit_price"  => $product[0]->unit_price,
                    "fixed_sp"    => $product[0]->fixed_sp,
                    "ItemTax"     => $product[0]->ItemTax,
                    "discounts"   => $product[0]->item_discount->offer_status  != 0 ? 0 :$product[0]->item_discount->$billType,
                    "offer_status"   => $product[0]->item_discount->offer_status,
                    "total_qty"   => !empty($product[0]->item_quantity) ? $product[0]->item_quantity->quantity :0,
                    "category_id" => $product[0]->category,
                    "subcategory_id" => $product[0]->subcategory,
                    "quantity"    => !empty($product[0]->item_quantity) ? 1:1,
            ];

                // dd($item);
            session()->put('item', $item);

            $this->add_free_item($cat_total,$item,$id ,$billType );
            $this->TotalBillAMT($item,$id);


            return view('sales.sales-items-display');
          }

          if(isset($item[$id])) {
            // dd('dgdgdfgdfgdfgdfgd');
          	$cat_total = session('cat') == null ? array(): session('cat') ;
          	$update = session('item') ;
              !empty($product[0]->item_quantity) ?  $product[0]->item_discount->offer_status != 0 ? ( ($update[$id]['quantity']+=1) * $product[0]->item_discount->offer_status ) : ( $update[$id]['quantity']+=1 ):1 ;
                // $item[$id]['quantity']++;
              // dd(session('cat'));
              // dd($update[$id]['quantity']);
              if(array_key_exists($product[0]->category, session('cat'))){

                  $cat_total[$product[0]->category] += $product[0]->unit_price != 0.00 ? $product[0]->item_discount->$billType !=0.00 ? ($product[0]->unit_price -  ($product[0]->unit_price * $product[0]->item_discount->$billType)/100):$product[0]->unit_price : $product[0]->item_discount->$billType;                 
                }
                else{
                  $cat_total[$product[0]->category] = $product[0]->unit_price != 0.00 ? $product[0]->item_discount->$billType  !=0.00 ? ($product[0]->unit_price -  ($product[0]->unit_price * $product[0]->item_discount->$billType )/100):$product[0]->unit_price : $product[0]->item_discount->$billType ;
                }
// dd(session('cat'));
                if(!empty($cat_total)){
                  session()->put('cat',$cat_total);
                }

//                   dd(session('cat'),'lglglglglglglglglgl');
                session()->put('item',$update);
                // dd(session('item'));
          		
                 $this->add_free_item($cat_total,$update,$id ,$billType );
                 $this->TotalBillAMT($item,$id);

                return view('sales.sales-items-display');
          }
          // dd($cat_total);
          $item[$id] = [
              "item_number" => $product[0]->item_number,
              "name"        => $product[0]->name,
              "unit_price"  => $product[0]->unit_price,
              "fixed_sp"    => $product[0]->fixed_sp,
              "ItemTax"     => $product[0]->ItemTax,
              "discounts"   => $product[0]->item_discount->offer_status != 0 ? 0 : $product[0]->item_discount->$billType ,
              "offer_status"  => $product[0]->item_discount->offer_status,
              "total_qty"   => !empty($product[0]->item_quantity) ? $product[0]->item_quantity->quantity:0,
              "category_id" => $product[0]->category,
              "subcategory_id" => $product[0]->subcategory,
              "quantity"    => !empty($product[0]->item_quantity) ? 1:1
          ];

          if(array_key_exists($product[0]->category,$cat_total)){
             $cat_total[$product[0]->category] += $product[0]->unit_price != '0.00' ? $product[0]->item_discount->$billType  !='0.00' ? ($product[0]->unit_price * $product[0]->item_discount->$billType )/100:$product[0]->unit_price : $product[0]->item_discount->$billType ;
          }
          else{
             $cat_total[$product[0]->category] = $product[0]->unit_price != '0.00' ? $product[0]->item_discount->$billType  != '0.00' ? ($product[0]->unit_price * $product[0]->item_discount->$billType )/100:$product[0]->unit_price : $product[0]->item_discount->$billType ;
          }
          if( !empty(session('cat')) ){
            session()->put('cat',$cat_total);
          }

          // dd(session('cat'));
          session()->put('item', $item); 
          $this->add_free_item($cat_total,$item,$id ,$billType );
          // dd(session('item'));
          $this->TotalBillAMT($item,$id);

          return view('sales.sales-items-display');

      }else{
        /* code for update quantity.................*/
        $item     = session()->get('item');
        $id       = $request->id;
        $quantity = $request->quantity;
        if($quantity > 0){
            if(isset($item[$id])) {
                $item[$id]['quantity'] = $quantity;
                session()->put('item', $item);
                $this->TotalBillAMT($item,$id);
            }
        }
        return view('receivings.sales-itmes-display');
      }
    }

    public function TotalBillAMT($item,$id){
      $onTotal = 0;
      foreach($item as $key => $Items){
          $disc = $Items['discounts'] != null ?  $Items['discounts']/100:1;
          $price = $Items['unit_price'] == '0' ? $Items['fixed_sp']:($Items['unit_price'] - ($Items['unit_price'] * $disc));
          $onTotal += $price * $Items['quantity'];
      };
 
      
      // dd($price.'   dfdsddf');
      // dd($item[$id]['unit_price'] == null ? 'yes':'no');
      // if(session('mytest') == 'true'){
      //   dd(session('onTotal'));
      // } 
      session()->put('onTotal',$onTotal);
      // if(session('mytest') == 'true'){
      //   dd($onTotal.'   fggffd' );
      // }
      // return $onTotal;
      $this->AddItemOnLimit($item);
    }

    public function AddItemOnLimit($item){
      $dp =  DiscountPurchase::where('amount','<',session('onTotal'))->first();
            if($dp){

                $product1  = Item::with(['ItemTax','item_quantity'=> function($query){
                    $query->where('location_id',get_shop_id_name()->id);
                  }])->where("item_number",trim($dp->item_barcode))->first();

                  $id1 = $product1->id;
                  // $qty = session('item')[$id]['quantity'];
                  // dd($dp->amount);
                  // dd(((int)($value/$dp->amount)) * $qty);
                  
                   $item[$id1]= [
                          "item_number" => $product1->item_number,
                          "name"        => $product1->name,
                          "unit_price"  => 0,
                          "ItemTax"     => $product1->ItemTax,
                          "discounts"   => 0,
                          "fixed_sp"    => 0,
                          "offer_status"   => $product1->item_discount->offer_status,
                          "total_qty"   => !empty($product1->item_quantity) ? $product1->item_quantity->quantity :0,
                          "category_id" => $product1->category,
                          "subcategory_id" => $product1->subcategory,
                          "quantity"    => (int)((int)session('onTotal')/$dp->amount) ,
                      ];
                      $cat_total = session('cat') == null ? array(): session('cat') ;
                      // dd($id1);
                      $item2 = session('item');
                      // if(!array_key_exists($id1,$item2)) {                   
                      // dd($item2);
                        session()->put('item', $item);
                          // if(session('onTotal') !=''){
                          //   dd(((int)session('onTotal')/$dp->amount) );
                          // }
                      

              }
    }

    public function add_free_item($cat_total,$item,$id,$billType  ){
      // if(session('onTotal') !=''){
      //   dd(session('onTotal').' its add free');
      // }
    	 if(!empty($cat_total)){
        // dd(session('item'));
    	 
	        foreach($cat_total as $key => $value){
	        	$dp =  DiscountPurchase::where('category_id',$key)->get();	        	
	        	if(count($dp) !=0){ 	        	
              foreach($dp as $DP){
	        	
		        	if($DP->amount <= $value){	

		        		$product1  = Item::with(['ItemTax','item_quantity'=> function($query){
					          $query->where('location_id',get_shop_id_name()->id);
					        }])->where("item_number",trim($DP->item_barcode))->get();

					        $id1 = $product1[0]->id;
                  $qty = session('item')[$id]['quantity'];
                  // dd($dp->amount);
                  // dd(((int)($value/$dp->amount)) * $qty);
                  
		        			 $item[$id1]= [
			                    "item_number" => $product1[0]->item_number,
			                    "name"        => $product1[0]->name,
			                    "unit_price"  => 0,
			                    "ItemTax"     => $product1[0]->ItemTax,
			                    "discounts"   => 0,
			                    "offer_status"   => $product1[0]->item_discount->offer_status,
			                    "total_qty"   => !empty($product1[0]->item_quantity) ? $product1[0]->item_quantity->quantity :0,
			                    "category_id" => $product1[0]->category,
                          "subcategory_id" => $product1[0]->subcategory,
			                    "quantity"    => ((int)($value/$DP->amount)) ,
					            ];
					            $cat_total = session('cat') == null ? array(): session('cat') ;
					            // dd($id1);
					            $item2 = session('item');
					            // if(!array_key_exists($id1,$item2)) {        						
                      // dd($item2);
						            session()->put('item', $item);
					            // }
                      // dd('dfgdfdfg');

	       		 					// dd(session('item'));
					            if(array_key_exists($product1[0]->category,$cat_total)){
					            	// dd($cat_total,'if');
					                   $cat_total[$product1[0]->category] += $product1[0]->unit_price != 0.00 ? $product1[0]->item_discount->$billType  !=0.00 ? ((float)$product1[0]->unit_price * (float)$product1[0]->item_discount->$billType )/100:$product1[0]->unit_price : $product1[0]->item_discount->$billType ;
					                }
					                else{
					                   $cat_total[$product1[0]->category] = $product1[0]->unit_price != 0.00 ? $product1[0]->item_discount->$billType  !=0.00 ? ((float)$product1[0]->unit_price * (float)$product1[0]->item_discount->$billType )/100:$product1[0]->unit_price : $product1[0]->item_discount->$billType ;
					                }
						            if(!empty($cat_total)){
					                  session()->put('cat',$cat_total);
					                }

	    							// dd(session('item'));

					            // dd(session('item'));

		        	}
            }
	        }
	      }
    	}

    }

    public function destroy($id)
    {
        // Removed paynote when deleting any item from return option
        //Session::remove('paynote');

        if($id || $id == false) {
          $item1 = session()->get('item');
          $item = session()->get('item');
          $cat  = session()->get('cat');
          $totalbuy = session('buyGet');         
          // dd($totalbuy);
          unset($item1[$id]);
          session()->put('item', $item1);   
          Session::remove('onTotal');         
          if(isset($item[$id])) { 
            $cat_id   = $item[$id]['subcategory_id'];
            $bulk     = BulkAction_Discount::where('subcategory',$item[$id]['subcategory_id'])->first(); 

            if($bulk){
              if(count($totalbuy[$item[$id]['subcategory_id']][$bulk->status]) > 1 ){
                unset($totalbuy[$item[$id]['subcategory_id']][$bulk->status][$id]); 
                session()->put('buyGet',$totalbuy);  
              }
              else{
                  unset($totalbuy[$item[$id]['subcategory_id']]); 
                  session()->put('buyGet',$totalbuy);
              }
              
            }
             //dd(session('cat'));
      			if(session('cat')!=null || !empty(session('cat'))) {
              if(isset(session('cat')[$cat_id])){

  	              if($item[$id]['unit_price'] < session('cat')[$cat_id] && $item[$id]['unit_price'] != 0 && count(session('item')) != 0) {    			// dd($item,'if');	          
  	              		session()->put('cat.'.$cat_id, (session('cat')[$cat_id] - $item[$id]['unit_price']));      	      	

  	              }
                  elseif(count(session('item')) == 0){
                    session()->forget('cat');
                  }
  	              else{                       
                    unset($cat[$cat_id]); 
  	              	session()->put('cat',$cat);
  	              }
  	            
  	          }	         
            }
          }

          elseif(count(session('item')) == 0){
            session()->forget('cat');
            Session::remove('paynote');
            Session::remove('credit_id');
            Session::remove('sale_id_old');
            Session::remove('paynote_total');
            Session::remove('totalAmount');
            Session::remove('cartCustomer');
            Session::remove('last_payment');
            Session::remove('onTotal');
          }


          session()->flash('success', 'Product removed successfully');
          return redirect()->route('sales.index')->with('success','Item deleted successfully');
        }
    }

    public function getSaleItem(Request $request)
    {
        $query  = $request->get('query');

        $location  = get_shop_id_name()->id;
        if($location == 19)
        {
        	$shop_id = 1;
        }
        else
        {
        	$shop_id = get_shop_id_name()->id;
        }
        // dd($shop_id);

       $data   =  Item::with(['item_quantity'=>function($query) use($shop_id){
                      $query->where('location_id',$shop_id);
                  }])->where('name', 'ILIKE', "%{$query}%")->orwhere('item_number', 'ILIKE', "%{$query}%")->get();


        $output = '<ul class="dropdown-menu" style="display:block; position:relative">';

        if(count($data) != null)
        {
              foreach($data as $row)
              {
              	if($row->item_quantity->quantity > 0){

               		$output .= '<li id="selectLI"><a id="getItemID" href="?itemId='.$row->id.'" style="pointer-events: none;" value="'.$row->id.'">'.$row->name .' | '.$row->item_number.'  </a></li>';
              	}
              	else
        {
            //$output .= '<li><a href="JavaScript:void(0);">No Items available</a></li>';
        }
              }
        }
        else
        {
            //$output .= '<li><a href="JavaScript:void(0);">No Items available</a></li>';
        }
        $output .= '</ul>';

        echo $output;
    }

    public function getCustomer(Request $request){
      
        if(session('billType') == ''){
          return '<ul class="dropdown-menu" style="display:block; position:relative"><li><a href="JavaScript:void(0);">Select Bill Type..</a></li></ul>';
        }
        $query  = $request->get('customer_name');        
        $data1   =  Customer::where('phone_number', 'ILIKE', "%{$query}%");
        
        if(session('billType') =='wholesale'){
          $data1->where('customer_type' ,'wholesale');
        }

        $data = $data1->get();
        
        $output = '<ul class="dropdown-menu" style="display:block; position:relative">';

        if(count($data) != null)
        {
              foreach($data as $row)
              {
                $output .= '<li id="selectCustomerLi" data-id="'.$row->id.'"><a id="getItemID" style="pointer-events: none;" >'.$row->first_name .'   </a></li>';
              }
        }
        else
        {
            $output .= '<li><a href="JavaScript:void(0);">No Items available</a></li>';
        }
        $output .= '</ul>';
        echo $output;
    }
                                                                        
    public function storeCustomer(Request $request)
    {
      
        $customer = Customer::where("id",$request->query_string)->get();

        $id = $customer[0]->id;

        $start_date = date("Y-m-d", strtotime(date('Y-m-d')."-14 days"));
        $end_date   = date('Y-m-d');


        $available_bal = SalesReturnHistory::where('customer_id', $id)
                          ->whereBetween('return_time', [$start_date, $end_date])
                          ->where('redeemed', 0)
                          ->orderBy('id', 'desc')
                          ->first();

        if($available_bal != null){
          
          session()->put('available_bal', $available_bal->amount);
          session()->put('credit_id', $available_bal->sale_id);

        }

        // $available_bal = SalesReturnHistory::where('customer_id', $id)
        //                   ->where('redeemed', 1)
        //                   ->whereDate('return_time', '<', $start_date)
        //                   ->whereDate('return_time', '>', $end_date)
        //                   ->first();

        // dd($available_bal);

        // if($available_bal != null){
          
        //   session()->put('available_bal', $available_bal->amount);

        // }


        $cartCustomer = session()->get('cartCustomer');
          if(!$cartCustomer) {

            $cartCustomer[$id] = [
                    "customer_name" => $customer[0]->first_name
            ];
            session()->put('cartCustomer', $cartCustomer);
            return view('sales.customer-display');
          }

          if(isset($cartCustomer[$id])) {
            session()->put('cartCustomer', $cartCustomer);
            return view('sales.customer-display');
          }

          $cartCustomer[$id] = [
            "customer_name" => $customer[0]->first_name
          ];
          session()->put('cartCustomer', $cartCustomer);

          return view('sales.customer-display');
      
    }

    public function customerCertDestroy($id){

      Session::remove('available_bal');
      Session::remove('credit_id');
      Session::remove('paynote');
      Session::remove('totalAmount');
      Session::remove('last_payment');

      if($id || $id == false) {
          $cartCustomer = session()->get('cartCustomer'); 
          if(isset($cartCustomer[$id])) { 
              unset($cartCustomer[$id]);
              session()->put('cartCustomer', $cartCustomer);
          }
          session()->flash('success', 'Customer removed successfully');
          return redirect()->route('sales.index')->with('success','Item deleted successfully');
        }
    }
 /* this function can be used to update quantity on input field */
    public function updateQty(Request $request)
    {
        $item = session()->get('item');
        $id = $request->id;

        $cat_total = session('cat') == null ? [] : session('cat');

        $quantity = $request->quantity;
        if($quantity > 0){
            if(isset($item[$id])) {
                $item[$id]['quantity'] = $quantity + $quantity * $item[$id]['offer_status'];
                if(array_key_exists($item[$id]['category_id'],$cat_total)){
		            $sum = $item[$id]['unit_price'] != 0.00 ? $item[$id]['discounts'] !=0.00 ? ($item[$id]['unit_price'] * $item[$id]['discounts'])/100:$item[$id]['unit_price'] : $item[$id]['discounts'];
		            $cat_total[$item[$id]['category_id']] = $sum * $quantity;
		        }
		        else{
		            $cat_total[$item[$id]['category_id']] = $item[$id]['unit_price'] != 0.00 ? $item[$id]['discounts'] !=0.00 ? ($item[$id]['unit_price'] * $item[$id]['discounts'])/100:$item[$id]['unit_price'] : $item[$id]['discounts'];
		        }
            session()->put('cat', $cat_total);
            session()->put('item', $item);

            // dd(session('item'),'yes');
             $this->add_free_item($cat_total,$item,$id,session('billType') );
             $this->TotalBillAMT($item,$id);
          }
        }
        // dd(session('item'));
    }

  public function updatePecen(Request $request)
    {
        $item = session()->get('item');
        $id = $request->id;
        // dd($item[$id]);
        $cat_total = session('cat');
        $disc = $request->disc;
        if($disc > 0){
            if(isset($item[$id])) {
               $item[$id]['discounts'] = $disc;                
            }
            else{
              $item[$id]['discounts'] = $disc;                
            }           
            session()->put('item', $item);
            // dd(session('item'),'yes');
             // $this->add_free_item($cat_total,$item,$id );
          }
        
        // dd(session('item'));
    }

    public function addCustomer(Request $request){

        $data = $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'phone_number'=>'required',
            'customer_type'=> 'required'
        ]);

        $data['gender'] = $request->gender;
        $data['email'] = $request->email;
        $data['address_1'] = $request->address_1;
        $data['address_2'] = $request->address_2;
        $data['city'] = $request->city;
        $data['state'] = $request->state;
        $data['postcode'] = $request->postcode;
        $data['country'] = $request->country;
        $data['comments'] = $request->comments;
        $data['gstin'] = $request->gstin;
        $data['account_number'] = $request->account_number;
        $data['customer_type'] = $request->customer_type;

       $post = Customer::create($data);
       $cartCustomer = session()->get('cartCustomer'); 
        

        return back()->with('success','added Successfully');
    }

    public function cashier_auth(Request $request){
        // dd($request);
        $cashier_id = $request->cashier_id;
        $webkey = $request->webkey;

        // dd($webkey,$cashier_id);
        // $stock_location = $request->stock_location !=null ? $request->stock_location:get_shop_id_name()->id;
        
        $data = Cashier::where(['webkey'=>$webkey,'id'=>$cashier_id])->first();
        if($data){
          session()->put('cashier_id', $data->id);
         return 'success';
        }
        else{
          session()->forget('cashier_id');
          return 'wrong';
        }
    }

    public function updateBill(Request $request){
       // dd($request->bill_id,$request->tally);
       $tayll = $request->tally;
       Sale::find($request->bill_id)->update(['tally_number'=>$tayll]);

    }
}
