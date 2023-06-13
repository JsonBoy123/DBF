<?php

namespace App\Http\Controllers\Sales;

use DB;
use Auth;
use Session;
use App\Customer;
use Carbon\Carbon;
use App\Models\Item\Item;
use App\Models\Sales\Sale;
use Illuminate\Http\Request;
use App\Models\Sales\CertItem;
use App\Models\Sales\SaleTaxe;
use App\Models\Sales\SalesItem;
use App\Models\Office\Shop\Shop;
use App\Models\Item\items_taxes;
use App\Models\Sales\HalfPayment;
use App\Models\Sales\SalesManage;
use App\Models\Item\Item_Discount;
use App\Models\Sales\SaleItemTaxe;
use App\Models\Sales\SalesPayment;
use App\Models\Sales\OtherDiscount;
use App\Models\Sales\BrokerBenefit;
use App\Models\Office\Broker\Broker;
use App\Models\Item\item_quantities;
use App\Http\Controllers\Controller;
use App\Models\Office\Offer\Vouchers;
use App\Models\Manager\ManageItemRack;
use App\Models\Sales\SalesRackHistory;
use App\Models\Sales\SalesReturnHistory;
use App\Models\Office\Employees\Employees;
use App\Models\Manager\ControlPanel\Cashier;
use App\Models\Office\Broker\BrokerCommission;
use App\Models\Manager\ControlPanel\CashierShop;
use App\Models\Manager\ControlPanel\ShopLocation;
use App\Models\Manager\BulkAction\BulkAction_Discount;
use App\Models\Office\wholesaleCustomer\WholesaleCustomer;

class SalesManageController extends Controller
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
        /*$salesManage = Sale::with(['sale_payment','customer','shop','half_payment', 'discount_amt'])
                              ->where('employee_id',get_shop_id_name()->id)
                              ->where('sale_time', date('Y-m-d'))
                              ->get();

      if(Auth::user()->hasPermission('show_all_bill')){

          $salesManage = Sale::with(['sale_payment','customer','shop','half_payment', 'discount_amt', 'customer_due'])
                        ->where('sale_time', date('Y-m-d'))
                        ->get();
          
      }*/
      $shop = Auth::user()->hasPermission('sales-search') == true ? [1, 2, 5, 6, 7, 12, 19] : [get_shop_id_name()->id] ;

      $salesManage = Sale::with(['customer', 'customer_due'])
                        ->where('sale_time', date('Y-m-d'))
                        //->whereIn('employee_id', $shop)
                        ->get();
      
        return view('sales.manage.index',compact('salesManage'));       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $saveItem = array();
        $ItemTaxe = array();
        $SaleTaxe = array();
        $SalePymt = array();
        $Discountamt = array();
        $lastinvoice = Sale::where('employee_id',get_shop_id_name()->id)->orderBy('id','desc')->first();
        $tally = Sale::orderBy('id','desc')->first();
        $tally_number = $tally->tally_number+1;
        // dd($lastinvoice);
        // /if(){
          $count = $lastinvoice != null ? count(explode('-', $lastinvoice->invoice_number)) : 0;      

        // }
          if($lastinvoice !=null){

       
          $last_number_invoice = count(explode('-', $lastinvoice->invoice_number)) > 1 ? (int)explode('-', $lastinvoice->invoice_number)[2]+1:1;
          }
          else{
            $last_number_invoice = '001';
          }
          
        
        $number = $last_number_invoice;
        if(strlen((string)$last_number_invoice) < 3){
            $number = str_repeat('0', 3-(strlen((string)$last_number_invoice))).''.$last_number_invoice;
        }

        $shop_first = explode('_',get_shop_id_name()->inv_prefix)[0]; 
        $shop_owner_id = get_shop_id_name()->shop_owner_id; 
      // dd($shop_owner_id);
        $invoice = $shop_first.'-'.$shop_owner_id.'-'.$number;     
        $location_id = $request->stock_location ? $request->stock_location: get_shop_id_name()->id;
        $shop_first = explode('_',get_shop_id_name()->inv_prefix); 
        // $lastinvoice = Sale::orderBy('desc')->first();
       
        $data = $request->validate([
                'customer_id'=>'required',
                'cashier_id'=>'required'
            ]);

        $half_credit_number = $request->half_credit_number;
        $half_paytm_number  = $request->half_paytm_number;
        $half_debit_number = $request->half_debit_number;
        $cheque_number = $request->cheque_number;


        $remaning_amount = $request->remaning_amount;
        $half_case = $request->half_case;
        $half_paytm = $request->half_paytm;
        $cheque_amt = $request->cheque_amt;
        $half_debit = $request->half_debit;
        $half_credit = $request->half_credit;


        $arr = [];
        if(!empty($half_case) || $half_case > 0)
        {
          $arr['half_case'] = $half_case;
        }
        if(!empty($half_paytm) || $half_paytm > 0)
        {
          $arr['half_paytm'] = $half_paytm;
        }
        if(!empty($cheque_amt) || $cheque_amt > 0)
        {
          $arr['cheque_amt'] = $cheque_amt;
        }
        if(!empty($half_debit) || $half_debit > 0)
        {
          $arr['half_debit'] = $half_debit;
        }
        if(!empty($half_credit) || $half_credit > 0)
        {
          $arr['half_credit'] = $half_credit;
        }
        if(!empty($remaning_amount) || $remaning_amount > 0)
        {
          $arr['remaning_amount'] = $remaning_amount;
        }

        if(count($arr) > 1){
          $data['bill_type']      = 'Half Payment';
        }else{
          if($half_case != 0){
            $data['bill_type']      = 'Cash';
          }elseif($half_paytm != 0)
          {
            $data['bill_type']      = 'PayTM';
          }elseif($half_debit != 0)
          {
            $data['bill_type']      = 'Debit Card';
          }elseif($half_credit != 0)
          {
            $data['bill_type']      = 'Credit Card';
          }elseif($cheque_amt != 0)
          {
            $data['bill_type']      = 'Cheque';
          }else{
            $data['bill_type']      = 'Half Payment';
          }
        }
/*
        if($request->check_half == 1){

          $data['bill_type']      = 'Half Payment' ;
        }else{
          $data['bill_type']      = $request->bill_type;
        }*/

      $data['sale_time']      = date('Y-m-d');
      $data['cashier_id']     = (int)$data['cashier_id'];
      $data['invoice_number'] = $invoice;//''!empty($shop_first) ? $shop_first[0]:'LEL1094';
      $data['employee_id']    = $location_id;        
      $data['tally_number']   = $tally_number;        
      $data['sale_status']    = 0;
      $data['sale_type']      = $request->sale_type;
      $data['comment']        = $request->sale_comment;
      $data['credit_card_no'] = $half_credit_number;
      $data['debit_card_no']  = $half_debit_number;
      $data['cheque_no']      = $cheque_number;
      $data['upi_no']        = $half_paytm_number;

      if(session('paynote') === 1 ){
        $data['sale_status']       = 2;
        $data['bill_type']         = 'Credit Note';
        $data['reference_sale_id'] = session('saleID');
      }


      $lastId = Sale::create($data)->id;
      
      $lastid = $lastId;

      ###################Update Return Records here#######################
      if(session('paynote') === 1 ){
        //1. Update Sales Status with 1
        Sale::where('id', session('saleID'))->update(['sale_status' => 1]);


        SalesReturnHistory::insert([
                'sale_id'           => $lastid,
                'customer_id'       => $request->customer_id,
                'location_id'       => get_shop_id_name()->id,
                'reference_sale_id' => session('saleID'),
                'return_time'       => date('Y-m-d'),
                'amount'            => (float)$request->amount_tendered1,
              ]);

      }

      

        $total = 0;
        foreach(session('item') as $id => $item){  
          /*if(session('mytest')){
            }*/
          if($item['discounts'] !='0.00')
          {
              if($item['fixed_sp'] !='0.00'){
                  $unit_price  = (float)$item['fixed_sp'] - (float)$item['discounts']/100* (float)$item['fixed_sp'];
              }else{
                  $unit_price  = (float)$item['unit_price'] - (float)$item['discounts']/100* (float)$item['unit_price'];
              }

          }else{
              if($item['fixed_sp'] !='0.00'){
                  $unit_price = $item['fixed_sp'];
              }else{
                  $unit_price = $item['unit_price'];
              }  
          }

        /* if($item['unit_price'] !='0.00' && $item['discounts'] =='0.00'){
            $unit_price = $item['unit_price'];
          }        

          if($item['fixed_sp'] !='0.00'){
            $unit_price = $item['fixed_sp'];
            
          }   */

            $bulk = BulkAction_Discount::where('subcategory',$item['subcategory_id'])->first();
            $totalValue = session('buyGet');
            
            if($bulk){
                $totGet = $totalValue[$item['subcategory_id']][$bulk->status];                
                $unit_price  = $item['unit_price'] ;
                $unit_price === 0 ? $item['discounts'] = $unit_price :$unit_price;
                // dd($totGet);

                 if($totGet != null){
                               
                  if($bulk->status < count($totGet)){
                  // dd($totGet);           
                      $lim = 0;
                      $baise = ($bulk->status)+1;

                     if( ($totGet % $baise) != 0){
                        $mod = (int)(count($totGet) % $baise) ;
                        $div = (int)(count($totGet) / $baise);
                        
                        $lim = count($totGet) - ($mod+$div);
                      }
                      else{
                          $lim = $totGet - ($totGet / $baise);
                      }
                      
                      // dd($lim);
                    $count1 = 1;
                    foreach($totGet as $key => $value){                          
                      if($key == $id){                      
                          $lim +=1 ;
                          $totGet[$key] = session('buyGet')[$item['subcategory_id']][$bulk->status][$key];
                      }
                      if( $lim >= $count1){
                        if((int)$totGet[$key] == (int)$unit_price){
                            $totGet[$key] = $unit_price;
                        }

                        if((int)$totGet[$key] > (int)$unit_price){
                            $totGet[$key] = (int)$totGet[$key] / ($bulk->status+1) ; 
                        }


                        // $totGet[$key] =  ? (int)$totGet[$key] % (int)$unit_price : (int)$totGet[$key] / ($bulk->status+1);
                          // dd($totGet);
                        // dd($totGet);
                      }
                      else{
                        break;
                      }
                      $count1++;
                    }
                    $totalValue[$item['subcategory_id']][$bulk->status] = $totGet;
                    session()->put('buyGet',$totalValue);

                    if($bulk){
                      if(isset($totalValue[$item['subcategory_id']][$bulk->status])) {          
                         $item['unit_price'] = $totalValue[$item['subcategory_id']][$bulk->status][$id];
                         $item['discounts'] = $item['discounts'];
                      }
                  } 
                    
                }
                  else{
                  // dd'sdf($totalValue[$item['subcategory_id']][$bulk->status]);
                    $totGet[$id] = (int)$unit_price < (int)$totGet[$id]  ? (int)$totGet[$id] / (int)($bulk->status+1): (int)$unit_price;                     
                }
              }              
          }

          // if(session('mytest')){
          //   dd($totGet);
          // }
         
            $total += ($unit_price) * session('item')[$id]['quantity'];
            $saveItem['sale_id'] = $lastId;
            $saveItem['item_id'] = $id;            
            $saveItem['item_location'] = $location_id;
            $saveItem['description'] = $item['name'];
            $saveItem['quantity_purchased'] = session('item')[$id]['quantity'];
            $saveItem['category_id'] = session('item')[$id]['category_id'];
            $saveItem['item_unit_price'] = $item['unit_price'];
            $saveItem['discount_percent'] = $item['discounts'];
            $saveItem['fixed_selling_price'] = $item['fixed_sp'];
            $saveItem['sale_status'] = 0;
            $saveItem['print_option'] = 0;
            $saveItem['offer_status'] = $bulk ? $bulk->status:0;
            $saveItem['taxe_rate'] = $item['ItemTax']->SGST * 2;
            $saveItem['created_at'] = date('Y-m-d H:i:s');
            $name = ['SGST','CGST'];
            //if(!session('mytest') ){
              SalesItem::insert($saveItem);
            //}

            ###################Update Return Records here#######################
        

            ############# End of updating sale return 

            $count = 0;
            while($count < count($name)){
                 $dd = $name[$count];         
                // dd($item['unit_price']);        

                $sl_tx_mt = ($item['unit_price'] != 0.00 ? $item['unit_price']:$item['discounts'] ) * session('item')[$id]['quantity'];  
                // dd($item['unit_price']);
                if($item['unit_price'] != 0){               
                       $sl_tx_mt = $item['unit_price'] -( ($item['unit_price']/100) *$item['discounts']);
                       $sl_tx_mt = $sl_tx_mt * session('item')[$id]['quantity'];
                }
                
              
                $ItemTaxe['sale_id'] = $lastId;
                $ItemTaxe['item_id'] = $id;
                $ItemTaxe['name'] = $name[$count];                
                $ItemTaxe['percent'] = $item['ItemTax']->$dd;
                $ItemTaxe['tax_type'] = 0;
                $ItemTaxe['rounding_code'] = 1;
                $ItemTaxe['cascade_tax'] = 0;
                $ItemTaxe['cascade_sequence'] = 0;
                $ItemTaxe['item_tax_amount'] = ((float)$sl_tx_mt / (100 + ((float)$item['ItemTax']->$dd*2) )) * (float)$item['ItemTax']->$dd;
                $ItemTaxe['created_at'] = date('Y-m-d H:i:s');

                $SaleTaxe['sale_id'] = $lastId;
                $SaleTaxe['tax_type'] = 0;
                $SaleTaxe['tax_group'] = $item['ItemTax']->$dd.' '.$dd ;
                $SaleTaxe['sale_tax_basis'] = $sl_tx_mt;
                $SaleTaxe['sale_tax_amount'] = ((float)$sl_tx_mt / (100 + ((float)$item['ItemTax']->$dd*2)) ) * (float)$item['ItemTax']->$dd;
                $SaleTaxe['print_sequence'] = 0;
                $SaleTaxe['name'] = $item['name'];
                $SaleTaxe['tax_rate'] = $item['ItemTax']->$dd;               
                $SaleTaxe['rounding_code'] = 1; 
                $SaleTaxe['created_at'] = date('Y-m-d H:i:s');                   
                //if(!session('mytest') ){
                  SaleItemTaxe::insert($ItemTaxe);
                  SaleTaxe::insert($SaleTaxe);            
                //}

                $count++;
            }            

            if($location_id == 19)
            {
              $loc_id = 1;
            }else{
              $loc_id = $location_id;
            }

            $itm_qty = item_quantities::where(['location_id'=>$loc_id,'item_id'=>$id])->first();
        
            $old_qty = $itm_qty->quantity;

            if(session('paynote') === 1 ){
              $new_qty = $old_qty + (int)(session('item')[$id]['quantity']);
            }else{
              $new_qty = $old_qty - (int)(session('item')[$id]['quantity']);
            }

            if($location_id == 19)
            {
              $loc_id = 1;
            }else{
              $loc_id = $location_id;
            }
        //   if(!session('mytest') ){    
            item_quantities::where(['location_id'=>$loc_id,'item_id'=>$id])->update(['quantity'=> $new_qty]);
          //  }

        }
        if(Session::has('paynote') == false)
        {
          if( (count($arr) != 1)){

            $half_credit = $request->half_credit == "" ? 0 : $request->half_credit; 
            $half_paytm = $request->half_paytm == "" ? 0 : $request->half_paytm;
            $half_debit = $request->half_debit == "" ? 0 : $request->half_debit;
            $half_case = $request->half_case == '' ? 0 : $request->half_case ;
            $remaning_amount = $request->remaning_amount == '' ? 0 : $request->remaning_amount ;


              HalfPayment::create(['sale_id'=>$lastId,'debit'=>$half_debit,'credit'=>$half_credit,'case'=>$half_case,'paytm'=>$half_paytm,'due_amount'=>$remaning_amount,'cheque'=>$cheque_amt]);

            /*============    wholesaler Due Payment  Function Call   =============*/
              if(Auth::user()->hasPermission('wholesale'))
              {

                  $due_amount = $request->remaning_amount == '' ? 0 :$request->remaning_amount;
                  $cust_id    = $request->customer_id;
                  $this->wholesalerDuePayment($total, $lastId, $cust_id, $due_amount);
              }
            /*===========wholesaler Due Payment==============*/
          }elseif($remaning_amount > 0){
            $half_credit = $request->half_credit == "" ? 0 : $request->half_credit; 
            $half_paytm = $request->half_paytm == "" ? 0 : $request->half_paytm;
            $half_debit = $request->half_debit == "" ? 0 : $request->half_debit;
            $half_case = $request->half_case == '' ? 0 : $request->half_case ;
            $remaning_amount = $request->remaning_amount == '' ? 0 : $request->remaning_amount ;


              HalfPayment::create(['sale_id'=>$lastId,'debit'=>$half_debit,'credit'=>$half_credit,'case'=>$half_case,'paytm'=>$half_paytm,'due_amount'=>$remaning_amount,'cheque'=>$cheque_amt]);

            /*============    wholesaler Due Payment  Function Call   =============*/
              if(Auth::user()->hasPermission('wholesale'))
              {
                  $due_amount = $request->remaning_amount == '' ? 0 :$request->remaning_amount;
                  $cust_id    = $request->customer_id;
                  $special_dis = $request->amount;
                  $this->wholesalerDuePayment($total, $lastId, $cust_id, $due_amount);
              }
          }
        }


        /*====================================================================*/

        $SalePymt['sale_id'] = $lastId;
        $SalePymt['payment_type'] = $data['bill_type']; 

        $payment_amt =  session('billType') == '1rupee' ? 1 : $total - ($request->check_balance == 1 ? (float)session('available_bal'):0) - (session('voucher_amount') !=null ? (float)session('voucher_amount'):0);

        if($request->payment_total_credit != null){

            $total_payment_amt = $request->payment_total_credit + $payment_amt;
        }else{
          $total_payment_amt = $payment_amt;
        }

        $SalePymt['payment_amount'] =  $total_payment_amt;
        $SalePymt['created_at'] = date('Y-m-d');
        $SalePymt['credit_balance'] = $request->payment_total_credit == null ? 0 : $request->payment_total_credit;
        $save = SalesPayment::insert($SalePymt);
        
        /*====================================================*/

        /************* Broker Commission *************/

        if($request->add_broker == "1"){

			$person_id 	= $request->broker_id;
          	$item_ids 	= $request->commission_barcode;

          	foreach($item_ids as $item_barcod){

            	$refered_item = Item::with(['item_quantity','item_discount'])
            						->where('item_number',$item_barcod)
            						->first();

            	if($refered_item){

            		$brokerage = BrokerCommission::where('item_number',$refered_item->item_number)
            						->first();

              		if($brokerage){

                		$benefit = [
		                	'brok_id'			=>  $person_id,
		                	'item_id'			=>  $refered_item->id,
		                	'discount_id'		=>  $com->id,
		                	'item_discount'		=>  $refered_item->item_discount->retail,
		                	'item_price'		=>  $refered_item->unit_price != 0 ? $refered_item->unit_price : $refered_item->fixed_sp,
		                	'location_id'		=>  get_shop_id_name()->id,
		                	'sale_id'			=>  $lastId
		               	];

		                BrokerBenefit::create($benefit);
              		}
            	}
          	}
        }

        /***** Broker commission ends here *****/


        /***********Update Rack record and store************/

        if(Auth::user()->hasPermission('rs_shop_billing')){

            foreach (session('item') as $key => $value) {


               /**** Update Sales Rack History Table*** */

               $qty = session('item')[$key]['quantity'];

               /*$item = [
                   'sales_id'  => $lastId,
                   'item_id'   => $id,
                   'quantity'  => $qty,
               ];

               SalesRackHistory::create($item);*/

               $rak = []; 
               $totalqty     = 0 ;
               $store[$key]  = '' ;
               $racks        = ManageItemRack::with(['rack_name','rack_item'])->where('item_id',$key)->orderBy('quantity','asc')->get();  

               if(count($racks) !=0){
                  foreach ($racks as $rack){

                     if($qty !=0 ){
                        if($rack->quantity > 0){
                           if($qty > $rack->quantity){

                              $qty   = $qty - $rack->quantity ;

                              $item = [
                                        'sales_id'  => $lastId,
                                        'item_id'   => $key,
                                        'rack_id'   => $rack->rack_id,
                                        'quantity'  => $rack->quantity,
                                    ];          

                              SalesRackHistory::create($item);

                              ManageItemRack::find($rack->id)->update(['quantity' => 0]);

                                //$rak[trim($rack->rack_name->rack_number)] =  $rack->quantity; 
                              $totalqty += $rack->quantity; 
                           }else{

                              if($qty > $rack->quantity){

                                 $qty   = $qty - $rack->quantity;

                                 $item = [
                                           'sales_id'  => $lastId,
                                           'item_id'   => $key,
                                           'rack_id'   => $rack->rack_id,
                                           'quantity'  => $rack->quantity,
                                       ];          

                                 SalesRackHistory::create($item);

                                 ManageItemRack::find($rack->id)->update(['quantity' => 0]);
                                    //$rak[trim($rack->rack_name->rack_number)] =  $rack->quantity; 
                                 $totalqty +=$rack->quantity;

                              }else{

                                 $qty1   = $rack->quantity - $qty;
                                 $qty2   = $qty; 

                                 $item = [
                                           'sales_id'  => $lastId,
                                           'item_id'   => $key,
                                           'rack_id'   => $rack->rack_id,
                                           'quantity'  => $qty,
                                       ];          

                                 SalesRackHistory::create($item);

                                 $qty    = 0;
                                 ManageItemRack::find($rack->id)->update(['quantity'=>$qty1]);
                                  //$rak[trim($rack->rack_name->rack_number)] = $qty2 ;
                                 $totalqty += $qty2; 
                              }
                           }
                        }
                     }
                     //$store[$key] = $rak;
                  }  
               }
            }
         } 






        if(session('voucher_code') != null)
        {
            Vouchers::where('code', session('voucher_code'))->update(['status' => 1 , 'used_regarding_sale_id'=>$lastId]);
        }

        if($request->discount_type != '0'){
            $Discountamt['sale_id'] = $lastId;
            $Discountamt[$request->discount_type] = $request->amount; 
            if($request->discount_type != NUll){
            $request->validate([
              'remark'           => 'required',
          ]);
            $Discountamt['remark'] = $request->remark;
       }
            $Discountamt['location_id'] = $location_id;
         
            OtherDiscount::create($Discountamt);
        }
        $data['igst_sub_total'] = $request->igst_sub_total;
        $saveItem['sale_id'] = $lastId;

        if($request->check_balance == 1){
          SalesReturnHistory::where('sale_id', session('credit_id'))
            ->update(['redeemed' => 1]);
        }



        if ($lastId) {
            $last_id = session()->get('lastId');
            if(!$last_id) {
                $lastId = ["lastId" => $lastId];
             
                Session::remove('item');
                Session::remove('cartCustomer'); 
                Session::remove('cat'); 
                Session::remove('buyGet'); 
                Session::remove('voucher_amount'); 
                Session::remove('voucher_code'); 
                session()->forget('available_bal');
                session()->forget('paynote');
                session()->forget('last_payment');
                session()->forget('onTotal');
                return $lastId['lastId'] ;    
          
            }
        }

    }


  function wholesalerDuePayment($total, $lastId, $cust_id, $due_amount)
  {
    $total = round($total);
    $lastId = $lastId;
    $cust_id = $cust_id;
    $due_amount = round($due_amount);

    $paid_amount = $total - $due_amount;

    $data['date'] = date('Y-m-d');
    $data['sale_id'] = $lastId;
    $data['customer_id'] = $cust_id;
    $data['paid_amount'] = $paid_amount;
    $data['total_amount'] = $total;
    $data['advance_amount'] = 0;
    $data['pending_amount'] = $due_amount;
    
    $save = WholesaleCustomer::create($data);

    if($save){
      $increment = Customer::where('id', $cust_id)
                    ->increment('due_balance', $due_amount);
    }
  }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
                    'amount_tendered1' => 'required',
                    'customer_name'=>'required',
                    'payment_types'=>'required',
                    'ref_invoice_number'=>'required',
                    'customer_id'=>'required',
                    'employee_id'=>'required',
                    'created_at'=>'required',
                    'number_of_payments'=>'required',
                    'created_at'=>'required'
                ]);
        $data['comment'] = $request->comment;
        SalesManage::find($id)->update($data);
        return back()->with('success','Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {       
        $currentDate = date('Y-m-d H:i:s');
        $data = SalesManage::where('id', $id)->update(['status' => 1,'deleted_at'=>$currentDate]);
        return back()->with('success','Deleted Successfully');
    }

    public function salesInvoice($id){         
    // dd($tally = Sale::orderBy('id','desc')->first());          
        $salesData = SalesItem::with(['item','item.item_discount'])->where('sale_id',$id)->get();
        $salesTaxe = SaleItemTaxe::where('sale_id',$id)->get();
        $cust = Sale::with(['customer','cashier','discount_amt'])->find($id);
        $sale_payment = SalesPayment::where('sale_id',$id)->first();
        
        //Get Current sale id for checking in blade
        $statusCheck = Sale::where('id', $id)->first();

        $discount = OtherDiscount::where('sale_id',$id)->first();
        $half_pay = HalfPayment::where('sale_id',$id)->first();
        $voucher_applied = Vouchers::where('used_regarding_sale_id',$id)->first();



        
        $shop_location = ShopLocation::where('shop_id',$cust->employee_id)->first();
 
        return view('sales.invoice',compact('salesTaxe','salesData','cust','shop_location','sale_payment', 'statusCheck', 'discount','half_pay', 'voucher_applied'));     
    }

    public function certItems(Request $request){     
        $salesManageId = session('last_id')['lastId'];
        $data = $request->validate([
                'item_number' => 'required',
                'name'=>'required',
                'quantity'=>'required',
                'unit_price'=>'required',
                'item_id'=>'required',
                'customer_id'=>'required'
            ]);
       $data['sales_manage_id'] = $salesManageId;
       $certItem = CertItem::create($data);
       // $request->session()->flush();
       $request->session()->forget('last_id');
       $request->session()->forget('item');
       $request->session()->forget('cartCustomer');
       $request->session()->forget('last_payment');
       return "Items Added Succefully";
    }

    public function RemoveSession(){
        Session::remove('item');
        Session::remove('cartCustomer');
        Session::remove('voucher_amount'); 
        Session::remove('voucher_code');
        Session::remove('last_payment');
        Session::remove('available_bal');
        Session::remove('credit_id');
        Session::remove('paynote');
        Session::remove('onTotal');
        return redirect()->back();
    }

    public function getSales(Request $request){

      $startdate  = date('Y-m-d',strtotime($request->startdate));
      $enddate    = date('Y-m-d',strtotime($request->enddate));

      if(Auth::user()->hasPermission('show_all_bill')){

        $salesManage = Sale::with(['sale_payment','customer','shop','half_payment'])
                        ->where('bill_type', ucwords($request->type))
                        ->whereBetween('sale_time', [$startdate, $enddate])
                        ->get();
      }else{
        $salesManage = Sale::with(['sale_payment','customer','shop','half_payment'])
                        ->where('employee_id', get_shop_id_name()->id)
                        ->where('bill_type', ucwords($request->type))
                        ->whereBetween('sale_time', [$startdate, $enddate])
                        ->get();
      }

      return view('sales.manage.daily_sales',compact('salesManage'));
    }

    public function getBro(Request $request){
      $sale_id = $request->sale_id;
      // dd($sale_id);
      $data = Broker::all();
      return view('sales.brocker',compact('data','sale_id'));
    }

    public function addPersonPercentage(Request $request){
      $item_id = $request->item_id;
      $person_id = $request->person_id;
      $sale_id = $request->sale_id;

      $data = Item::with(['item_quantity','item_discount'])->where('item_number',$item_id)->first();
      // dd($data);
      if($data){
        $com = BrokerCommission::where('item_number',$data->item_number)->first();

        if($com){
          $save['item_id'] =  $data->id;
          $save['brok_id'] =  $person_id;
          $save['discount_id'] =  $com->id;
          $save['item_discount'] =  $data->item_discount->retail;
          $save['item_price'] =  $data->unit_price;
          $save['location_id'] =  get_shop_id_name()->id;
          $save['sale_id'] =  $sale_id;
          BrokerBenefit::create($save);
        }
        else{
          return response(null,401);
        }
      }
    }

    public function return_item($id){      
      //$data = Sale::find($id);

      $employee = Employees::where('user_id', Auth::id())->first();

      $shop = Shop::where('shop_owner_id', $employee->id)->first();
      $data = Sale::where('id', $id)->where('employee_id', $shop->id)->first();
      //return $data;
      if($data->sale_status = 0){  return response(['message' => 'Not Found'], 410); }

      $salesitem = SalesItem::with(['item','item.ItemTax'])->where('sale_id',$data->id)->get();


      foreach ($salesitem as $value) {

        $item[$value->item_id] = [
                                "item_number"  => $value->item->item_number,
                                "name"         => $value->item->name,
                                "unit_price"   => $value->item_unit_price,
                                "ItemTax"      => $value->item->ItemTax,
                                "discounts"    => $value->discount_percent,
                                "offer_status" => $value->offer_status,
                                "total_qty"    => $value->quantity_purchased,
                                "category_id"  => $value->item->category,
                                "quantity"     => $value->quantity_purchased,
                                'paynote'      => $data->sale_status,
                                "subcategory_id" => $value->item->subcategory,
                                'fixed_sp'     => $value->fixed_selling_price
                              ];
      }
      
      session()->put('item', $item);
      session()->put('paynote', 1);

      $payment = SalesPayment::where('sale_id', $id)->first();
      session()->put('last_payment', $payment->payment_amount);
      
      $customer = Sale::with('customer')->where('id', $id)->first();

      $cartCustomer[$customer['customer']->id] = ["customer_name" => $customer['customer']->first_name];

      session()->put('cartCustomer', $cartCustomer);
      session()->put('saleID', $id);
    }

    public function dailyIndex(){

      $shop = Auth::user()->hasPermission('sales-search') == true ? [1, 2, 5, 6, 7, 12, 19] : [get_shop_id_name()->id] ;

      $salesManage = Sale::with(['sale_payment','customer','shop','half_payment', 'discount_amt'])
                        ->where('sale_time', date('Y-m-d'))
                        ->whereIn('employee_id', $shop)
                        ->get();

      $shops = Shop::whereIn('id', [1, 2, 5, 6, 7, 12, 19])->get();

      //return $salesManage;
      return view('sales.manage.index-daily-sales', compact('salesManage', 'shops'));
    }

    public function dailySearch(Request $request){

      $startdate  = date('Y-m-d',strtotime($request->startdate));
      $enddate    = date('Y-m-d',strtotime($request->enddate));

      
      $payment_types = ['Cash', 'PayTM', 'Credit Card', 'Debit Card', 'Half Payment', 'Credit Note', 'Cheque'];

      if($request->type == 'All'){

        $type       = $payment_types;
        $cancelled  = 0;

      }else if($request->type == 'cancelled'){

        $type       = $payment_types;
        $cancelled  = 1;

      }else{

        $type       = [$request->type];
        $cancelled  = 0;

      }

      $shop = Auth::user()->hasPermission('sales-search') == true ? $request->shop : get_shop_id_name()->id ;

      $salesManage = Sale::with(['sale_payment','customer','shop','half_payment', 'discount_amt'])
                        ->whereIn('bill_type', $type)
                        ->whereBetween('sale_time', [$startdate, $enddate])
                        ->where('employee_id', $shop)
                        ->where('cancelled', '=', $cancelled)
                        ->get();

      return view('sales.manage.search-daily-sales',compact('salesManage', 'shop'));
    }

    public function saleCancelation(Request $request){

    	//Find bill

		$sale = Sale::where('id', $request->request_id)->first();

		//Get location, if either of the accounts(1, 16, 17, 19) then retrieve 1 as shop location

		$location = in_array($sale->employee_id, [1, 16, 17, 19]) ? 1 : $sale->employee_id;

		//Update reason to bill

		Sale::where('id', $request->request_id)->update(['cancelled' => 1, 'reason_of_cancel' => $request->reason]);

		//If record exists in wholeseller custm details, disable(0) it.

		$wholesale = WholesaleCustomer::where('sale_id', $request->request_id)->first();

		if($wholesale == true){

			WholesaleCustomer::where('sale_id', $request->request_id)->update(['status' => 0]);

			Customer::where('id', $wholesale->customer_id)->decrement('due_balance', $wholesale->pending_amount);		

		}

		//increment item quantity to its respestive shop.

		$sale_items = SalesItem::where('sale_id', $request->request_id)->get();

		// Quantity will be added only at Laxyo House

		foreach($sale_items as $item){
			item_quantities::where('location_id', $location)
		    	->where('item_id', $item->item_id)->increment('quantity', round($item->quantity_purchased));
		}

    }


    public function SalesRackInfo( $id){

      $rack_history = SalesRackHistory::with(['item' => function($query){
                        $query->select('id', 'name', 'item_number');
                      }, 'rack'])->where('sales_id', $id)->get();

      $sale = Sale::where('id', $id)->first();

      return view('sales.sales-rack-info', compact('rack_history', 'sale'));
    }

}
