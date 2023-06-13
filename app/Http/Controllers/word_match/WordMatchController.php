<?php

namespace App\Http\Controllers\word_match;

use Illuminate\Http\Request;
use App\Models\Item\Item;
use App\Http\Controllers\Controller;
use Session;

class WordMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function word_match(Request $request)
    {
        $word   = $request->term;
        $items  = Item::where('name', 'like', '%'.$word. '%')->get();
        foreach($items as $item){
            $data[] = array(
      "label" => $item->name.' '.$item->item_number,
      "value" => $item->id
    );
        }
         return response()->json($data);

    }

    public function save_item_session(Request $request){
        $data = Item::find($request->item);

        $data1['item_id']               = $data->id;
        $data1['name']                  = $data->name;
        $data1['item_number']           = $data->item_number;
        $data1['unit_price']            = $data->unit_price;
        $data1['qty']                   = 1;
        $data1['receiving_quantity']    = $data->receiving_quantity;

        if(session('data') != ''){
            session()->put('data.'.$data->id, $data1);
        }
        else{
            session()->put('data.'.$data->id, $data1);   
        }
        return redirect()->back();

    }
    

}
