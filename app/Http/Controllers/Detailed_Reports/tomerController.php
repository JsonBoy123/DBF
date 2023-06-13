<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use App\Exports\CustomersExport;
use App\Imports\CustomersImport;
use App\Exports\CustomersPhoneExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ItemImport;

class Transc extends Controller
{
    
    // public function __construct()
    // {
    //     $this->middleware('permission:god');
    // }

    public function index()
    {
        $data =  Customer::orderBy('id')->get();
        return view("customers.index",compact('data'));
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
        $data = $request->validate([
                'first_name'=>'required',
                'last_name'=>'required',
                'phone_number'=>'required'

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

       Customer::create($data);
        return back()->with('success','added Successfully');

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
        $data =  Customer::where('id',$request->id)->first();
        return $data;
    }

    // public function sms_data(Request $request)
    // {
    //     $data =  Customer::where('id',$request->id)->first();
    //     return $data;
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update_customer(Request $request)
    {

        $data = $request->validate([
                'first_name'=>'required',
                'last_name'=>'required',
                'phone_number'=>'required'

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
 // dd( $data);
       $post = Customer::find($request->customer_id)->update($data);
        return back()->with('success','Update Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        Customer::whereIn('id',$request->id)->delete();
        return "Customer Deleted Successfully....";
    }

    public function getCustomer()
    {

        $data = Customer::get();

        $view = view("customers.all-customer",compact('data'))->render();
        //dd( $view );

        return response()->json(['response'=>$view]);

    }

    public function import() 
    {
        // dd( $_POST );

        Excel::import(new CustomersImport,request()->file('file'));

        return back()->with('success','Customers Imported Successfully');
        
    }

    public function export() 
    {
        return Excel::download(new CustomersExport, 'customers.xlsx');
    }

    public function exportPhonenumber() 
    {
        return Excel::download(new CustomersPhoneExport, 'customers-phone.xlsx');
    }
    
}
