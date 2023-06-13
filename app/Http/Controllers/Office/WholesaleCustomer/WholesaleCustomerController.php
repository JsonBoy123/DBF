<?php

namespace App\Http\Controllers\Office\WholesaleCustomer;

use DB;
use Session;
use App\Customer;
use App\Models\Sales\Sale;
use Illuminate\Http\Request;
use App\Models\Sales\BrokerBenefit;
use App\Models\Office\Broker\Broker;
use App\Http\Controllers\Controller;
use App\Models\Office\Broker\BrokerCommission;
use App\Models\Office\wholesaleCustomer\WholesaleCustomer;
use App\Models\Office\wholesaleCustomer\CustomerDuePaymentRecord;
use App\Models\Office\wholesaleCustomer\CustomerAdjustedAmtRecord;


class WholesaleCustomerController extends Controller
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
       $customer = WholesaleCustomer::with(['customer' => function($query){
                      //$query->where('due_balance', '>', 0);
                    }])->select('customer_id')->distinct()->get();
       //return $customer;
       //dd($customer);
        //$customer = Customer::where('due_balance', '>', '0')
                    //->where('customer_type' ,'wholesale')
                    //->get();

        //$module = Module::all();
         //dd($broker);
        return view("office.WholesaleCustomer.index", compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $customer_name = Customer::where('id', $id)->first();
        $name = $customer_name['first_name'].' '.$customer_name['last_name'];
        $paid_amt  = $customer_name['paid_balance'];
        $customer = WholesaleCustomer::where('customer_id', $id)->get();
        //dd($broker);
        return view("office.WholesaleCustomer.show", compact('customer', 'name', 'paid_amt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function completePayment($id)
    {
        //dd($id);
        WholesaleCustomer::where('id',$id)->update(['status' => 1]);
        return back(); 
    }*/

    public function paymentInstallment(Request $request)
    {
        $customer_id = $request->cust_id;
        $paid_amount = $request->paid_amount;
        $payment_type = $request->payment_type;

        $data = $request->validate([
                'paid_amount'=>'required',
                'payment_type'=>'required',
                'remark'=>'required'
            ]);
        $data['customer_id'] = $request->cust_id;
        $save = CustomerDuePaymentRecord::create($data);

        if($save == true)
        {
            $inc_dec = Customer::where('id', $customer_id);
              //->where('customer_type', 'wholesale');

              $inc_dec->decrement('due_balance', $paid_amount); 
              $inc_dec->increment('paid_balance', $paid_amount); 
        }

        return back();
    }


    public function adjustAmount(Request $request)
    {
        $cust_id = $request->cust_id;
        $sale_id = $request->sale_id;
        $adjust_amt = $request->adjust_amt;
        $date = date('Y-m-d');

        $query = WholesaleCustomer::where('customer_id', $cust_id)
                ->where('sale_id', $sale_id)->first();
        $pending_amount = $query['pending_amount'];
        $parent_id = $query['id'];

        if($adjust_amt <= $pending_amount)
        {
            $inc_dec = WholesaleCustomer::where('customer_id', $cust_id)
                     ->where('sale_id', $sale_id);

              $inc_dec->decrement('pending_amount', $adjust_amt); 
              $inc_dec->increment('paid_amount', $adjust_amt);

          /*------------------------------------------------*/
            if($inc_dec == true)
            { 
                $dec = Customer::where('id', $cust_id);
                  //->where('customer_type', 'wholesale');

                  $dec->decrement('paid_balance', $adjust_amt); 
            }
          /*------------------------------------------------*/
            if($inc_dec == true)
            { 
                $data = array(
                    'parent_id'     =>   $parent_id,
                    'sale_id'       =>   $sale_id,
                    'adjusted_amt'  =>   $adjust_amt,
                    'date'          =>   $date
                );
                $save = CustomerAdjustedAmtRecord::create($data);
            }

          /*------------------------------------------------*/   
          return back();
        }
        else
        {
            return back();   
        }
        return back();
    }

    public function duePaymentHistory($id)
    {
        $customer_id = $id;
        $customer_name = Customer::where('id', $customer_id)->first();
        $name = $customer_name['first_name'].' '.$customer_name['last_name'];
        $due_history = CustomerDuePaymentRecord::where('customer_id', $customer_id)->get();
        //dd($broker);
        return view("office.WholesaleCustomer.due_payment_history", compact('due_history', 'name'));
    }

    public function adjustedPaymentHistory($id)
    {
        $sale_id = $id;
        $adjust_history = CustomerAdjustedAmtRecord::where('sale_id', $sale_id)->get();
        //dd($broker);
        return view("office.WholesaleCustomer.adjusted_payment_history", compact('adjust_history'));
    }
}