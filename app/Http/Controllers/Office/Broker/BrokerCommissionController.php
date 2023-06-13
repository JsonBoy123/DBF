<?php

namespace App\Http\Controllers\Office\Broker;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Office\Broker\BrokerCommission;

class BrokerCommissionController extends Controller
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
        $broker_commisssion = BrokerCommission::get();
        //$module = Module::all();
         //dd($broker);
        return view("office.brokerCommission.index", compact('broker_commisssion'));
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
       $in      = $request->item_number;
       $cp     = $request->commission_percent;

      if($in!=null && $cp!=null)
      {
        $data = array(
            'item_number' => $in,
            'commission_percent' => $cp
        );

        BrokerCommission::create($data);

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
        /*$id = $request->id;
        $broker = Broker::where('id', $id)->first();*/
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
        $id     = $request->emp_id;
        $in     = $request->item_number;
        $cp     = $request->commission_percent;
        if($id !=null)
        {
            BrokerCommission::where('id', $id)
                    ->update([
                        'item_number' => $in,
                        'commission_percent' => $cp
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
        $id = $request->id;
        Broker::where('id', $id)->delete();
        return back()->with('success','Deleted Successfully');
    }
}