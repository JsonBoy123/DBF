<?php

namespace App\Http\Controllers;

use DB;
use App\Customer;
use App\Models\Sales\Sale;
use Illuminate\Http\Request;
use App\Models\Sales\SalesItem;
use App\Models\Sales\SalesPayment;
use App\Models\Manager\MciCategory;
use App\Models\Sales\SaleTaxe;
use App\Models\Sales\SaleItemTaxe;
use App\Models\Office\Shop\Shop;
use App\Models\Receivings\Receiving;
use App\Models\Receivings\ReceivingItem;
use App\Exports\CustomersPhoneExport;

class GraphicalReportController extends Controller
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

    public function indexCategory()
    {
        $shop = all_shopes();

        return view('Graphical_Reports.categories',compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showCategory(Request $request)
    {
        $daterange = $request->daterangepicker;

        $date = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));
        $location = $request->stock_location;

        if($request->stock_location == 'all'){
            $categories = SalesItem::with(['sale'=>function($q) use($request){
                $q->where('sale_status', '=', $request->sale_type);
            }])
                ->whereBetween('created_at', [$date['to'], $date['from']])
                ->selectRaw('distinct category_id')
                ->get();
        }else{
            $categories = SalesItem::whereHas('sale',function($q) use($request){
                $q->where('employee_id',$request->stock_location);
            })  ->whereBetween('created_at', [$date['to'], $date['from']])
                ->where('sale_status', '=', $request->sale_type)
                ->selectRaw('distinct category_id')
                ->get();
        }

        $cat_name = [];
        $cat_id = [];
        foreach($categories as $category){
            $data = MciCategory::where('id', $category->category_id)
                            ->select('id' ,'category_name')
                            ->first();

            $cat_id[] = $data->id;
            $cat_name[] = $data->category_name;

        }
        
        return view('Graphical_Reports.categories-graph', compact('cat_id', 'cat_name', 'date', 'daterange', 'location'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexCustomer()
    {
        $shop = all_shopes();

        return view('Graphical_Reports.customers',compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showCustomer(Request $request)
    {
        $date         = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        $daterange = $request->daterangepicker;
        $location = $request->stock_location;

        // dd($location);
         if($request->stock_location == 'all'){
            $customer = Sale::with(['customer'])
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->selectRaw('distinct customer_id')
                        ->get();
        }else{
            $customer = Sale::with(['customer'])
                        ->where('employee_id', $request->stock_location)
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->selectRaw('distinct customer_id')
                        ->get();
        }   
        $customers_name = [];          
        $customers_id = [];          
        foreach($customer as $customers){            
            $customers_name[] = $customers->customer->first_name.' '.$customers->customer->last_name;
            $customers_id[] = $customers->customer_id;
        }     

        //return view('Graphical_Reports.items-graph',compact('item_id','daterange','item_name','date','location','to','from'));    
        return view('Graphical_Reports.customers-graph',compact('customers_id','daterange','customers_name','date','location','to','from'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDiscount()
    {
        $shop = all_shopes();

        return view('Graphical_Reports.discounts',compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showDiscount(Request $request)
    {

        $date         = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        $daterange = $request->daterangepicker;
        $location = $request->stock_location;

        if($request->stock_location == 'all'){

            $discount   = SalesItem::with(['sale'=>function($q) use($request){
                                $q->where('sale_status', '=', $request->sale_type);
                        }])
                            ->whereBetween('created_at', [$date['to'], $date['from']])
                            ->where('item_unit_price', '!=', '0.00')
                            ->selectRaw('distinct discount_percent')
                            ->get();
        }else{

            $discount   = SalesItem::whereHas('sale',function($q) use($request){
                                $q->where('employee_id',$request->stock_location)
                                ->where('sale_status', $request->sale_type);
                            })  
                            ->whereBetween('created_at', [$date['to'], $date['from']])
                            ->where('item_unit_price', '!=', '0.00')
                            ->selectRaw('distinct discount_percent')
                            ->get();
        }

        $disc_name = [];
        foreach($discount as $disc){

            $disc_name[] = $disc->discount_percent;

        }

        return view('Graphical_Reports.discounts-graph',compact('disc_name', 'date', 'daterange', 'location'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexEmployee()
    {
        $shop = all_shopes();

        return view('Graphical_Reports.employees',compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showEmployee(Request $request)
    {
        $date         = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        $daterange = $request->daterangepicker;
        $location = $request->stock_location;

         if($request->stock_location == 'all'){
            $employees = Sale::with(['employee_shop'])
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->selectRaw('distinct employee_id')
                        ->get();
        }else{
            $employees = Sale::with(['employee_shop'])
                        ->where('employee_id', $request->stock_location)
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->selectRaw('distinct employee_id')
                        ->get();
        }

        // return $employees;

        $emp_id = [];
        $emp_name = [];

        //dd($employees);

        foreach($employees as $emp){

            $emp_id[] = $emp->employee_id;
            //$emp_name[] = $emp['employee']->first_name.' '.$emp['employee']->last_name;
            $emp_name[] = $emp['employee_shop']->name;
        }

        // dd([$emp_id, $emp_name]);
        return view('Graphical_Reports.employees-graph',compact('emp_id', 'date', 'emp_name','daterange','location'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexExpense()
    {
        $shop = all_shopes();

        return view('Graphical_Reports.expenses', compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showExpense(Request $request)
    {
        $date = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        return view('Graphical_Reports.expenses-graph',compact('cats', 'date'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function indexSupplier()
    {
        $shop = all_shopes();

        return view('Graphical_Reports.suppliers',compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showSupplier(Request $request)
    {
        $date = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));


        return view('Graphical_Reports.suppliers-graph',compact('cats', 'date'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTax()
    {
        $shop = all_shopes();

        return view('Graphical_Reports.taxes',compact('shop'));
    }

    public function showTax(Request $request)
    {
        $daterange = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($daterange[0]));
        $date['from'] = date('Y-m-d', strtotime($daterange[2]));

        $daterange = $request->daterangepicker;
        $location = $request->stock_location;

        if($request->stock_location == 'all'){
            $taxe_rate = SalesItem::whereHas('sale')
                        ->select('taxe_rate', DB::raw('COUNT(sale_id) AS count'))
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->groupBy('taxe_rate')
                        ->get();
        }else{

            $taxe_rate = SalesItem::whereHas('sale' ,function($q) use($request){
                        $q->where('employee_id', $request->stock_location);
                    })         
                        ->select('taxe_rate', DB::raw('COUNT(sale_id) AS count'))                        
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->groupBy('taxe_rate')
                        ->get();
        }

        // return $taxe_rate;

        $tax = [];        
        foreach($taxe_rate as $tax_tr){
            $tax[] = $tax_tr->taxe_rate;

        }

        return view('Graphical_Reports.taxes-graph',compact('tax', 'date','daterange','location'));
    }

/*---------------------------------------------------------------------*/

    public function indexTransactionsRepo()
    {
        $shop = all_shopes();

        return view('Graphical_Reports.transactions',compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showTransactionsRepo(Request $request)
    {
        $daterange = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($daterange[0]));
        $date['from'] = date('Y-m-d', strtotime($daterange[2]));
        $daterange = $request->daterangepicker;
        $location = $request->stock_location;
        //dd($location);
        if($request->stock_location == 'all'){
            $payments = SalesPayment::whereHas('sale')
                        ->select('created_at', DB::raw('COUNT(sale_id) AS count'))
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->groupBy('created_at')
                        ->get();
        }else{

            $payments = SalesPayment::whereHas('sale' ,function($q) use($request){
                        $q->where('employee_id', $request->stock_location);
                    })         
                        ->select('created_at', DB::raw('COUNT(sale_id) AS count'))                        
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->groupBy('created_at')
                        ->get();
        }
// dd($payments);
        $payt = [];   
        $date_label = [];     
        foreach($payments as $pay){
            $payt[] = $pay->created_at;
            $date_label[] = date('Y-m-d',strtotime($pay->created_at));

        }
        // dd($date_label);

        return view('Graphical_Reports.transactions-graph',compact('payt', 'daterange','date','date_label','location'));
    }



/*--------------=================-------------------------------------------*/


    public function indexPaymentRepo()
    {
        $shop = all_shopes();

        return view('Graphical_Reports.payments',compact('shop'));
    }
    public function showPaymentRepo(Request $request)
    {
        $daterange = $request->daterangepicker;

        $date = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        if($request->stock_location == 'all'){
            $payments = SalesPayment::whereHas('sale')
                        ->select('payment_type', DB::raw('SUM(payment_amount) AS total_amount'),DB::raw('COUNT(sale_id) AS total_row'))
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->groupBy('payment_type')
                        ->get();
        }else{

            $payments = SalesPayment::whereHas('sale' ,function($q) use($request){
                        $q->where('employee_id', $request->stock_location);
                    })         
                        ->select('payment_type', DB::raw('SUM(payment_amount) AS total_amount'),DB::raw('COUNT(sale_id) AS total_row'))                        
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->groupBy('payment_type')
                        ->get();
        }
       
       

        return view('Graphical_Reports.payments-graph',compact('payments','date'));
    }

    /*------------------------------------------------------*/

    public function indexItemRepo()
    {
        $shop = all_shopes();

        return view('Graphical_Reports.items',compact('shop'));
    }

    public function showItemRepo(Request $request){
        $daterange = explode(' ', $request->daterangepicker);
        $to   = date('Y-m-d', strtotime($daterange[0]));
        $from = date('Y-m-d', strtotime($daterange[2]));
        $location = $request->stock_location;
        $daterange = $request->daterangepicker;
        // dd($to,$from,$location_id);
        if($location == 'all'){
            $items = SalesItem::with(['item','sale'])
                        ->select('item_id',DB::raw('SUM(quantity_purchased) AS quantity'))                    
                        ->whereDate('created_at','>=',$to)
                        ->whereDate('created_at','<=',$from)                    
                        ->groupBy('item_id')
                        ->get();
        }else{
            $items = SalesItem::whereHas('sale',function($q) use($location_id){
                        $q->where('employee_id',$location);
            })          ->with(['item'])
                        ->select('item_id',DB::raw('SUM(quantity_purchased) AS quantity'))                    
                        ->whereDate('created_at','>=',$to)
                        ->whereDate('created_at','<=',$from)                    
                        ->groupBy('item_id')
                        ->get();
        }   
// dd($)
        $item_name = [];          
        $item_id = [];          
        foreach($items as $Item){            
            $item_name[] = $Item->item->name;
            $item_id[] = $Item->item_id;
            

        }     

        return view('Graphical_Reports.items-graph',compact('item_id','daterange','item_name','date','location','to','from'));            

    }
    
}
