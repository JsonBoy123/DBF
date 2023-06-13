<?php

namespace App\Http\Controllers\Summary_Reports;

use App\Customer;
use Illuminate\Http\Request;
use App\Models\Office\Shop\Shop;
use App\Http\Controllers\Controller;


class CustomersReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$customer = Customer::with(['sales'])->get();

        return view('Summary_Reports.customers_index',compact('shop'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = explode(' ', $request->daterangepicker);
        $date['to']   = date('Y-m-d', strtotime($date[0]));
        $date['from'] = date('Y-m-d', strtotime($date[2]));

        $custmores = Customer::with(['sales' => function($q) use($request,$date){
                $q->whereBetween('sales.sale_time',[$date['to'], $date['from']])
                ->where('sales.sale_status', '=', $request->sale_type);
           
        }])->get();

        //return $custmores;

        return view('Summary_Reports.customers-table', compact('custmores', 'date'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
