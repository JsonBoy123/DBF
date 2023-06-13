<?php

namespace App\Http\Controllers\Manager\ManageItem;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager\ItemRack;
use App\Models\Manager\ManageItemRack;
use App\Models\Item\Item;
// use App\Models\Manager\ManageItemRack;

class ManageItemByRack extends Controller
{
   
    public function index()
    {
        $rack = ItemRack::all();
       /* $column_rack = ManageItemRack::with(['rack_name'=>function($query){
            $query->select('rack_number','id');
        }])->selectRaw('distinct rack_id')->get();

        $item =  ManageItemRack::with(['rack_item'=>function($query){
            $query->select('name','id','item_number');
        }])->selectRaw('distinct item_id')->get();*/

        
        return view('manager.manage_item_by_rack.index',compact('rack'));
    }

    public function create()
    {
        $rack = ItemRack::all();
        $item = Item::all();
        $id = '';
        return view('manager.manage_item_by_rack.item_rack',compact('item','rack','id'));
    }

 
    public function store(Request $request)
    {
        $item_barcode = $request->item_id;
        $rack_id = $request->rack_id;
        $quantity = $request->quantity;

        $data = Item::where('item_number',$item_barcode)->first();
        if($data){
            $manage = ManageItemRack::where(['rack_id'=>$rack_id,'item_id'=>$data->id])->first();
            if($manage){
                ManageItemRack::where(['rack_id'=>$rack_id,'item_id'=>$data->id])->update(['quantity'=>$quantity]);
            }
            else{
                ManageItemRack::create(['rack_id'=>$rack_id,'item_id'=>$data->id,'quantity'=>$quantity]);
            }
        }else{
            return response(null, 403);
        }


    }

    public function show($id)
    {
        //
    }

    public function searchItems(Request $request){

        $items = ManageItemRack::with(['items', 'rack_name'])
                    ->where('rack_id', $request->category2)
                    ->orderBy('id', 'desc')
                    ->get();

        $rack = ItemRack::all();

        // return $items;
        return view('manager.manage_item_by_rack.index', compact('items', 'rack'));


    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        ItemRack::destroy($id);

        return redirect()->back()->with('success','Rack Deleted Successfully');


    }

    public function getItems(Request $request){
        return 'adasfdas';
    }

    public function create_rack(){
        $data = ItemRack::all();
        // return $data
        return view('manager.manage_item_by_rack.rack.index',compact('data'));
    }

    public function edit_rack($id){  
        $data = ItemRack::find($id);
        return view('manager.manage_item_by_rack.rack.create_update',compact('data','id'));
    }

    public function create_update(Request $request){
        $data = array();
        $id = '';
        return view('manager.manage_item_by_rack.rack.create_update',compact('data','id'));   
    }

    public function save_rack(Request $request){
        $data = $request->validate(['rack_number'=>'required']);
      
        if($request->flag == 'add') {
            $rack = ItemRack::where('rack_number',strtolower($request->rack_number))->first();
            if(!empty($rack)) {
               ItemRack::find($rack->id)->update($data);
            }            
            else{
                ItemRack::create($data);
            }
            return redirect()->back()->with('success','Rack Created Successfully');
        }else{
            ItemRack::find($request->rack_id)->update($data);
            return redirect()->back()->with('success','Rack Updated Successfully');
        }
       


    }

    public function delete(Request $request)
    {
        $id = $request->id;
        ManageItemRack::where('item_id',$id)->delete();
        return redirect()->back()->with('success','Rack Deleted Successfully');

    }

    public function itemsInRack(){

        $items = ManageItemRack::with(['items' => function($query){
                    $query->select('id', 'name', 'item_number');
        }, 'rack_name' => function($q){
                    $q->select('id', 'rack_number');
        }])->where('quantity', '<>', 0)->select('rack_id', 'item_id', 'quantity')->get();

        //return $items;

        return view('manager.manage_item_by_rack.items-rack', compact('items'));

    }
}
