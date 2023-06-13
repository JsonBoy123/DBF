<?php

namespace App\Http\Controllers\Office\Shop;

use App\Models\Office\Employees\Employees;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Item\item_quantities;
use App\Models\Office\Shop\Shop;
use Illuminate\Http\Request;
use App\Models\Item\Item;
use App\User;
use Hash;


class ShopController extends Controller
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
        $shop = Shop::with(['employee'])->get();
        // $shop1 = Shop::all();

        // return json_decode(json_encode(['1:2']));
        $users = [];
        foreach($shop as $user){
            $users[] = $user->shop_owner_id;
        }

        $employees = Employees::whereNotIn('id', $users)->get();

        return view("office.shop.index",compact('shop', 'employees'));
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
        // return $request->all();
        $validation = Validator::make($request->all(), [
            'contact_no' => 'unique:shops'
        ]);
        $validation1 = Validator::make($request->all(), [
            'email' => 'unique:shops'
        ]);

        if ($validation->fails()){
            return ["contactErr" => "contact number has already been taken"]; 
        }elseif($validation1->fails()){
            return ["emailErr" => "The email has already been taken"];
        }
        else
        {
            $arr = array(
            'name'                  =>      $request->input('shop_name'),
            'shop_owner_id'         =>      $request->input('shop_owner_name'),
            'alias'                 =>      $request->input('alias'),
            'inv_prefix'            =>      $request->input('inv_prefix'),
            'address'               =>      $request->input('address')
            ); 

            $shop_data = Shop::create($arr);

            $LastId = $shop_data->id;

            $items = Item::all();

            foreach ($items as $items_id) 
            {
                $item_qua_data = item_quantities::insert([
                        'item_id'       => $items_id->id,
                        'location_id'   => $LastId
                    ]);
            }

            return ["successMsg" => "Shop Added Successfully"];
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
        /*$request->validate([
            'contact_no' => 'required|unique:shops,contact_no,'.$id,
        ]);
  */
        Shop::where('id', $id)->update([
                                    'name'=> $request->input('name'), 
                                    'shop_owner_id' => $request->input('shop_owner_id'),
                                    'alias' => $request->input('alias'),
                                    'inv_prefix' => $request->input('inv_prefix'),
                                    'address' => $request->input('address')
                                ]);
                            
        return ["successMsg" => "Shop Updated Successfully"];
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

    public function testUser()
    {
        $shop = Shop::all();
        return view("office.shop.test",compact('shop'));
    }
}
