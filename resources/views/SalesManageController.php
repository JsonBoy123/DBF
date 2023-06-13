<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sales\SalesManage;
use App\Models\Sales\SalesItem;
use App\Models\Office\Employees\Employees;
use App\Models\Sales\Sale;
use App\Models\Sales\SaleItemTaxe;
use App\Models\Sales\SaleTaxe;
use App\Models\Sales\SalesPayment;
use App\Models\Sales\CertItem;
use App\Models\Office\Shop\Shop;
use App\Models\Manager\ControlPanel\Cashier;
use App\Models\Manager\ControlPanel\CashierShop;
use App\Models\Manager\ControlPanel\ShopLocation;
use App\Customer;
use App\Models\Item\Item;
use App\Models\Item\items_taxes;
use App\Models\Item\item_quantities;
use Auth;
use Session;

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
       
        $salesManage = Sale::with(['sale_payment','customer','shop'])->where('employee_id',get_shop_id_name()->id)->where('sale_time',date('Y-m-d'))->get();
        // dd($salesManage);
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
        $location_id = $request->stock_location ? $request->stock_location: get_shop_id_name()->id;
       
        $data = $request->validate([
                'bill_type'=>'required',
                'customer_id'=>'required',
                'cashier_id'=>'required'
            ]);
        $data['sale_time'] = date('Y-m-d');
        $data['cashier_id'] = (int)$data['cashier_id'];
        $data['invoice_number'] = 'LEL/1094';
        $data['employee_id'] =  $location_id;        
        $data['sale_status'] = 0;
        
        $lastId = Sale::create($data)->id;

        $lastid = $lastId;

        $total = 0;
        // dd(session('item')[59]['ItemTax']);
        foreach(session('item') as $id => $item){
            if($item['discounts'] !=0.00){

                $unit_price  = $item['unit_price'] - ($item['unit_price']/100)* (int)$item['discounts'];
            }
            else{
                $unit_price = $item['unit_price'];
            }
            $total += ($item['unit_price'] == 00 ? $item['discounts']:$unit_price) * session('item')[$id]['quantity'];
            $saveItem['sale_id'] = $lastId;
            $saveItem['item_id'] = $id;            
            $saveItem['item_location'] = $location_id;
            $saveItem['description'] = $item['name'];
            $saveItem['quantity_purchased'] = session('item')[$id]['quantity'];
            $saveItem['category_id'] = session('item')[$id]['category_id'];
            $saveItem['item_unit_price'] = $item['unit_price'];
            $saveItem['discount_percent'] = $item['discounts'];
            $saveItem['print_option'] = 0;
            $saveItem['taxe_rate'] = $item['ItemTax']->SGST * 2;
            $saveItem['created_at'] = date('Y-m-d H:i:s');
            $name = ['SGST','CGST'];
            SalesItem::insert($saveItem);
            $count = 0;
            while($count < count($name)){
                $dd = $name[$count];                
                $sl_tx_mt = ($item['unit_price'] != 00 ? $item['unit_price']:$item['discounts'] )* session('item')[$id]['quantity'];
                if($item['unit_price'] != 0.00){
                       $sl_tx_mt =  $item['unit_price'] - ($item['unit_price']/100) * $item['discounts'];
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
                $ItemTaxe['item_tax_amount'] = ($sl_tx_mt / 100) * $item['ItemTax']->$dd;
                $ItemTaxe['created_at'] = date('Y-m-d H:i:s');

                $SaleTaxe['sale_id'] = $lastId;
                $SaleTaxe['tax_type'] = 0;
                $SaleTaxe['tax_group'] = $item['ItemTax']->$dd.' '.$dd ;
                $SaleTaxe['sale_tax_basis'] = $item['unit_price'];
                $SaleTaxe['sale_tax_amount'] = ($sl_tx_mt / 100) * $item['ItemTax']->$dd ;
                $SaleTaxe['print_sequence'] = 0;
                $SaleTaxe['name'] = $item['name'];
                $SaleTaxe['tax_rate'] = $item['ItemTax']->$dd;               
                $SaleTaxe['rounding_code'] = 1; 
                $SaleTaxe['created_at'] = date('Y-m-d H:i:s');                   

                SaleItemTaxe::insert($ItemTaxe);
                SaleTaxe::insert($SaleTaxe);                   


                //update(['quantity'=>session('item')[$id]['quantity']]);

                $count++;
            }

            $itm_qty = item_quantities::where(['location_id'=>$location_id,'item_id'=>$id])->first();
            $old_qty = $itm_qty->quantity;
            $new_qty = $old_qty - (session('item')[$id]['quantity']);
               
            item_quantities::where(['location_id'=>$location_id,'item_id'=>$id])->update(['quantity'=> $new_qty]);


        }

        $SalePymt['sale_id'] = $lastId;
        $SalePymt['payment_type'] = $data['bill_type'];      
        $SalePymt['payment_amount'] = $total;  
        $SalePymt['created_at'] = date('Y-m-d H:i:s'); 
        SalesPayment::insert($SalePymt);
        // $data['igst_sub_total'] = $request->igst_sub_total;
        // $saveItem['sale_id'] = $lastId;
        // $saveItem['sale_id'] = $lastId;

        if ($lastId) {
            $last_id = session()->get('lastId');
            if(!$last_id) {
                $lastId = ["lastId" => $lastId];
             
                Session::remove('item');
                Session::remove('cartCustomer'); 
                return $lastId['lastId'] ;    
          
            }
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
        $salesData = SalesItem::with(['item'])->where('sale_id',$id)->get();
        $salesTaxe = SaleItemTaxe::where('sale_id',$id)->get();
        $cust = Sale::with(['customer','cashier'])->find($id);
        
        $shop_location = ShopLocation::where('shop_id',$cust->employee_id)->first();
 
        return view('sales.invoice',compact('salesTaxe','salesData','cust','shop_location'));     
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
       $request->session()->forget('totalAmount');
       return "Items Added Succefully";
    }

    public function RemoveSession(){
        Session::remove('item');
        Session::remove('cartCustomer'); 
        return redirect()->back();
    }
}
