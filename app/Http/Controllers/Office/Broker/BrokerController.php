<?php

namespace App\Http\Controllers\Office\Broker;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Office\Broker\Broker;
use App\Models\Office\Broker\BrokerCommission;
use App\Models\Sales\BrokerBenefit;
use Session;


class BrokerController extends Controller
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
       
        $broker = Broker::get();
        //$module = Module::all();
         //dd($broker);
        return view("office.Broker.index", compact('broker'));
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
        //dd($request->all());
       $n      = $request->name;
       $cn     = $request->mobile_no;
       $a      = $request->address;
       $c      = $request->city;
       $s      = $request->state;
       $p      = $request->pincode;

      if($n!=null && $cn!=null && $a!=null && $s!=null && $p!=null)
      {
      	$data = array(
      		'name' => $n,
      		'contact_no' => $cn,
      		'address' => $a,
      		'city' => $c,
      		'state' => $s,
      		'pincode' => $p
      	);

      	Broker::create($data);

        return back()->with('success','added Successfully');
      }
       else{
        return back()->with('success','added Successfully');
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
        $broker = BrokerBenefit::with(['person_sale_detail','item_name','discount','shop_name', 'item_discounts'])->where('brok_id', $id)->get();
         //dd($broker[0]['item_discounts']->wholesale);
        return view("office.Broker.show", compact('broker'));
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
    	$id 	= $request->emp_id;
        $n      = $request->name;
        $cn     = $request->contact_no;
        $a      = $request->address;
        $c      = $request->city;
        $s      = $request->state;
        $p      = $request->pincode;

		if($id !=null)
		{
			Broker::where('id', $id)
                    ->update([
                        'name' => $n,
			      		'contact_no' => $cn,
			      		'address' => $a,
			      		'city' => $c,
			      		'state' => $s,
			      		'pincode' => $p
                    ]);
		}

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
        Broker::where('id', $id)->delete();
        return back()->with('success','Deleted Successfully');
    }

    public function completeCommission($id)
    {
        BrokerBenefit::where('id', $id)->update([
            'status' => '1'
        ]);
        return back()->with('success','Completed Successfully');
    }
}