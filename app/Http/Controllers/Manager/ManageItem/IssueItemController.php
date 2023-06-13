<?php

namespace App\Http\Controllers\Manager\ManageItem;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager\IsseuItems;
use App\Models\Manager\IsseuItemsList;
use App\Models\Manager\ManageItemRack;
use App\Models\Item\Item;
use session;

class IssueItemController extends Controller
{
    
    public function index()
    {
        return view('manager.manage_item_by_rack.issue_item.index');
    }

    public function create()
    {
       
        // dd(session('item_list'));
        return view('manager.manage_item_by_rack.issue_item.add_item');
    }

  
    public function store()
    {
        // session()->forget('item_list');
        // dd(session('item_list'));
        $data = session('item_list');
        $status = true;
        $store = [];
        // $lastId = IsseuItems::create(['quantity'=>0])->id;
        $totalqty = 0;
        foreach($data as $key => $Data){

            $qty = $Data['quantity'];
            $racks  = ManageItemRack::with(['rack_name','rack_item'])->where('item_id',$key)->orderBy('quantity','desc')->get();   
            // dd($store);  
            if(count($racks) !=0){       
                foreach ($racks as $rack) {

                    if($qty !=0 ){
                        if($rack->quantity > 0)
                            if($qty > $rack->quantity){
                                $qty   = $qty - $rack->quantity ;                                           
                                ManageItemRack::find($rack->id)->update(['quantity'=>0]);
                                $store[$rack->rack_item->name][trim($rack->rack_name->rack_number)]['qty'] =  $rack->quantity; 
                                $totalqty += $rack->quantity; 
                            }
                            else{                             

                                if($qty > $rack->quantity){
                                    $qty   = $qty - $rack->quantity;
                                    ManageItemRack::find($rack->id)->update(['quantity'=>0]);
                                    $store[$rack->rack_item->name][trim($rack->rack_name->rack_number)]['qty'] =  $rack->quantity; 
                                    $totalqty +=$rack->quantity;
                                }
                                else{
                                    $qty1   = $rack->quantity - $qty;
                                    $qty2   = $qty; 
                                    $qty   = 0;                            
                                    ManageItemRack::find($rack->id)->update(['quantity'=>$qty1]);
                                     $store[$rack->rack_item->name][trim($rack->rack_name->rack_number)]['qty'] = $qty2 ;
                                    $totalqty +=$qty2; 
                                }
                            }
                    }
                }
            }           

        }
         dd($totalqty);  
        // dd($totalqty);
    }

   
    public function show($id)
    {
        //
    }

 
    public function edit($id)
    {
        //
    }

 
    public function update(Request $request, $id)
    {

    }

   
    public function destroy($id)
    {
        $data = session('item_list');
        if(!empty($data)){
            unset($data[$id]);
            session()->put('item_list',$data);
        } 
    }

    public function itemInSession(Request $request){
        $data = Item::where('item_number',$request->item_name)->first();
        $ses_item = session('item_list') != null ? session('item_list'):session()->put('item_list',array());
        // dd($ses_item);

        if($ses_item == null){
            $ses_item[$data->id] = ['item_name'=>$data->name,
                                    'item_nummber'=>$data->item_number,
                                    'item_id'=>$data->id,
                                    'quantity'=>1,                                    
                                ];
            session()->put('item_list',$ses_item);
        }
        else{
            // dd('elsae');
            $ses_item[$data->id] = ['item_name'=>$data->name,
                                    'item_nummber'=>$data->item_number,
                                    'item_id'=>$data->id,
                                    'quantity'=> isset($ses_item[$data->id]) ? $ses_item[$data->id]['quantity']+1:1,                                    
                                ];
            session()->put('item_list',$ses_item);
        }


    }

    public function add_qty($id,$qty){
        $ses_item = session('item_list');
        $ses_item[$id]['quantity'] =$qty;
        session()->put('item_list',$ses_item);
    }
}
