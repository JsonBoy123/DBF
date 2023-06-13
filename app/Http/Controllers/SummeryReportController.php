<?php

namespace App\Http\Controllers;

use DB;
use App\Customer;
use App\Models\Sales\Sale;
use App\Imports\ItemImport;
use Illuminate\Http\Request;
use App\Models\Sales\SalesItem;
use App\Exports\CustomersExport;
use App\Imports\CustomersImport;
use App\Models\Office\Shop\Shop;
use App\Models\Sales\SalesPayment;
use App\Models\Manager\MciCategory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomersPhoneExport;

class SummeryReportController extends Controller
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

        return view('Summary_Reports.categories_index',compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showCategories(Request $request)
    {
        $daterange = $request->daterangepicker;

        $date = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        if($request->stock_location == 'all'){

            $cats = MciCategory::whereHas('saleItems', function($query) use($request, $date)         {
                        $query->whereDate('created_at', '<=', $date['from'])
                                ->whereDate('created_at', '>=', $date['to'])
                                ->where('sale_status', '=', $request->sale_type);
                    })->get();
        }else{
            $cats = MciCategory::whereHas('saleItems', function($query) use($request, $date)         {
                        $query->whereDate('created_at', '<=', $date['from'])
                                ->whereDate('created_at', '>=', $date['to'])
                                ->where('sale_status', '=', $request->sale_type);
                    })->get();
        }
        //dd($cats);

        /***************/
        /*$date = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        $cats = MciCategory::with(['saleItems' => function($query) use($request, $date)         {
                    $query->whereBetween('created_at', [$date['to'], $date['from']])
                    ->where('sale_status', '=', $request->sale_type);
                }])
                ->has('saleItems')
                ->get(); */

        return view('Summary_Reports.categories-table',compact('cats', 'date'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexCustomer()
    {
        $shops = Shop::whereIn('id', [1, 2, 5, 6, 7, 12, 19])->get();

        return view('Summary_Reports.customers_index',compact('shops'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showCustomers(Request $request)
    {
        $daterange = $request->daterangepicker;

        $date = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        $custmores = Customer::with(['sales' => function($q) use($request, $date){
                $q->whereBetween('sales.sale_time',[$date['to'], $date['from']])
                ->where('sales.sale_status', '=', $request->sale_type);

        }])->get();

        return view('Summary_Reports.customers-table', compact('custmores', 'date'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDiscount()
    {
        $shop = all_shopes();

        return view('Summary_Reports.discounts_index',compact('shop'));
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

        $discounts   = SalesItem::whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->where('item_unit_price', '!=', '0.00')
                        ->selectRaw('distinct discount_percent')
                        ->get();

        $location_id = $request->stock_location;

        return view('Summary_Reports.discounts-table',compact('discounts', 'date', 'location_id'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexEmployees()
    {
        $shop = all_shopes();

        return view('Summary_Reports.employees_index',compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showEmployees(Request $request)
    {
        $daterange = $request->daterangepicker;

        $date = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        //$loc_id = $request->stock_location == 'all' ? '' : $request->stock_location;

        if($request->stock_location == 'all'){
            $employees = Sale::with(['shop'])
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->selectRaw('distinct employee_id')
                        ->get();
        }else{
            $employees = Sale::with(['shop'])
                        ->where('employee_id', $request->stock_location)
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->selectRaw('distinct employee_id')
                        ->get();
        }

        return view('Summary_Reports.employees-table',compact('employees', 'date', 'daterange'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexExpanses()
    {
        return view('Summary_Reports.expenses_index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showExpanses(Request $request)
    {
        $date = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        return view('Summary_Reports.expenses-table',compact('cats', 'date'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexItems()
    {
        $shop = all_shopes();

        return view('Summary_Reports.items_report_table',compact('shop'));
    }

    public function getItemTotal(Request $request){

        $daterange = explode(' ', $request->daterangepicker);
        $to   = date('Y-m-d', strtotime($daterange[0]));
        $from = date('Y-m-d', strtotime($daterange[2]));
        $location_id = $request->stock_location;
        $date = $request->daterangepicker;

        if($location_id == 'all'){
            $items = SalesItem::with(['item','sale', 'report_category'])
                        ->select('item_id',DB::raw('SUM(quantity_purchased) AS quantity'))                    
                        ->whereDate('created_at','>=',$to)
                        ->whereDate('created_at','<=',$from)                    
                        ->groupBy('item_id')
                        ->get();
        }else{
            $items = SalesItem::whereHas('sale',function($q) use($location_id){
                        $q->where('employee_id',$location_id);
                    })
                        ->with(['item' => function($query){
                            $query->with('categoryName', 'subcategoryName');
                        }])
                        ->select('item_id',DB::raw('SUM(quantity_purchased) AS quantity'))                    
                        ->whereDate('created_at','>=',$to)
                        ->whereDate('created_at','<=',$from)                    
                        ->groupBy('item_id')
                        ->get();
        }        

        return view('Summary_Reports.items-table',compact('items','date','location_id','to','from'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showItems(Request $request)
    {
        $date = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        //$items = SalesItem::where()

        return view('Summary_Reports.employees-table',compact('cats', 'date'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPayments()
    {
        $shop = all_shopes();

        return view('Summary_Reports.payments_index',compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showPayments(Request $request)
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
        // dd($payments);
        /* ->select('item_id',DB::raw('SUM(quantity_purchased) AS quantity'))
                    ->whereDate('created_at','>=',$to)
                    ->whereDate('created_at','<=',$from)                    
                    ->groupBy('item_id')
                    ->get();*/

        return view('Summary_Reports.payments-table',compact('payments', 'date', 'daterange'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexSuppliers()
    {
        $shop = all_shopes();

        return view('Summary_Reports.suppliers_index',compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showSuppliers(Request $request)
    {
        $date = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        return view('Summary_Reports.suppliers-table',compact('cats', 'date'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTaxes()
    {
        $shop = all_shopes();

        return view('Summary_Reports.taxes_index',compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showTaxes(Request $request)
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

        return view('Summary_Reports.taxes-table',compact('taxe_rate', 'date','daterange','location'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTransactions()
    {
        $shop = all_shopes();

        return view('Summary_Reports.transactions_index',compact('shop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showTransactions(Request $request)
    {
        $daterange = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($daterange[0]));
        $date['from'] = date('Y-m-d', strtotime($daterange[2]));
        $daterange = $request->daterangepicker;
        $location = $request->stock_location;

        if($request->stock_location == 'all'){
            $payments = SalesPayment::whereHas('sale' ,function($q) use($request){
                        $q->where('sale_status', $request->sale_type);
                    })         
                        ->select('created_at', DB::raw('COUNT(sale_id) AS count'))
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->groupBy('created_at')
                        ->get();
        }else{

            $payments = SalesPayment::whereHas('sale' ,function($q) use($request){
                        $q->where('employee_id', $request->stock_location)
                        ->where('sale_status', $request->sale_type);
                    })         
                        ->select('created_at', DB::raw('COUNT(sale_id) AS count'))                        
                        ->whereDate('created_at', '<=', $date['from'])
                        ->whereDate('created_at', '>=', $date['to'])
                        ->groupBy('created_at')
                        ->get();
        }

        return view('Summary_Reports.transactions-table',compact('payments', 'daterange','date','location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       
    }
    
}
