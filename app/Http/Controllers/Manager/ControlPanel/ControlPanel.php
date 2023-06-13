<?php

namespace App\Http\Controllers\Manager\ControlPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager\ControlPanel\Cashier;
use App\Models\Manager\ControlPanel\CashierShop;
use App\Models\Manager\ControlPanel\ShopLocation;
use App\Models\Manager\ControlPanel\CustomTab;
use App\Models\Manager\ControlPanel\OfferBundles;
use App\Models\Manager\ControlPanel\LocationGroup;
use Illuminate\Support\Facades\Validator;
use App\Models\Office\Shop\Shop;
use App\Models\Manager\MciCategory;
use App\Models\Manager\MciBrand;
use App\Models\Manager\MciSize;
use App\Models\Manager\MciColor;
use App\Models\Manager\MciSubCategory;

class ControlPanel extends Controller
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
        $shop = Shop::get(); 
        return view("manager.control_panel.index",compact('shop'));
    }

    public function Cashier(Request $request)
    {   
        $shop  = Shop::where('deleted_at',NULL)->get();   
        // dd($shop);

        return view("manager.control_panel.cashier_index", compact('shop'));
    }

    public function getShopDetails(Request $request){        
        $shop_data      = ShopLocation::where('shop_id',$request->id)->first();
        // dd($shop_data);
        $data           = CashierShop::where('shop_id',$request->id)->select('cashier_id')->get();
        $cashier        = Cashier::whereNotIn('id',$data )->get();
        $shops          = Shop::find($request->id);   
        $shop           = Shop::get();   
        $CashierShop    = CashierShop::where('shop_id',$request->id)->with('cashier')->get();
         return view("manager.control_panel.cashier", compact('shop','shop_data','cashier','shops','CashierShop'));
    }

    public function UpdateCashierDetail(Request $request){

        $shop_data      = ShopLocation::where('shop_id',$request->shop_id)->first();
        $data           = CashierShop::where('shop_id',$request->id)->select('cashier_id')->get();
        $cashier        = Cashier::whereNotIn('id',$data )->get();
        $shops          = Shop::find($request->shop_id);   
        $shop           = Shop::get();   
        $CashierShop    = CashierShop::where('shop_id',$request->shop_id)->with('cashier')->get();

        $cashier        = Cashier::get();
        $shops          = Shop::find($request->shop_id);   
        $shop           = Shop::get();   
        $CashierShop    = CashierShop::where('shop_id',$request->shop_id)->with('cashier')->get();

        if(empty($shop_data) ){

            ShopLocation::create([
                            'login'         => $request->login,
                            'logout'        => $request->logout,
                            'shop_incharge' => $request->shop_incharge,
                            'shop_id'       => $request->shop_id,
                            'address'       => $request->address,
                            'tnc'           => $request->tnc,
                        ]);
            $shop_data      = ShopLocation::where('shop_id',$request->shop_id)->first();

            return view("manager.control_panel.cashier", compact('shop','shops','shop_data','cashier','CashierShop'));
        }else{

            ShopLocation::where('shop_id',$request->shop_id)->update([
                            'login'         => $request->login,
                            'logout'        => $request->logout,
                            'shop_incharge' => $request->shop_incharge,
                            'shop_id'       => $request->shop_id,
                            'address'       => $request->address,
                            'tnc'           => $request->tnc,
                        ]);
            $shop_data      = ShopLocation::where('shop_id',$request->shop_id)->first();

            return view("manager.control_panel.cashier", compact('shop','shops','shop_data','cashier','CashierShop'));
        }
    }

    public function AddCashier(Request $request)
    {
        // dd($request);
        $shop_data      = ShopLocation::where('shop_id',$request->shop_id)->first();

        $data           = CashierShop::where('shop_id',$request->id)->select('cashier_id')->get();
        $cashier        = Cashier::whereNotIn('id',$data )->get();
        $shops          = Shop::find($request->shop_id);   
        $shop           = Shop::get();   

        $shop_id    = $request->shop_id;

        $cashier_id = $request->cashier_id;

        $check = CashierShop::where(['shop_id'=>$request->id,'cashier_id'=>$cashier_id])->first();
        if($check){
            
        CashierShop::create([
                        'shop_id'       => $shop_id,
                        'cashier_id'    => $cashier_id
                    ]);
            
        }
        $CashierShop    = CashierShop::where('shop_id',$request->shop_id)->with('cashier')->get();
       
        return view("manager.control_panel.cashier", compact('shop','shops','shop_data','cashier','CashierShop'));
    }


    public function CashierDetail(Request $request){
        $cashier = Cashier::get();
        return view("manager.control_panel.cashier_detail", compact("cashier"));
    }


    public function OfferBundle(Request $request){
        $bundles = OfferBundles::get();
        if(!empty($bundles)){
            foreach ($bundles as $val) {
                $type = $val->type;
                $data = json_decode($val->bundle);
                if(!empty($data)){
                    if($type == "Category"){
                        $cat[] = MciCategory::whereIn("id", $data)->get();
                    }
                    if($type == "Subcategory"){
                        $cat[] = MciSubCategory::whereIn("id", $data)->get();
                    }
                    if($type == "Brand"){
                        $cat[] = MciBrand::whereIn("id", $data)->get();
                    }
                }
            }
        }
        $category = MciCategory::get();
        return view("manager.control_panel.offer_bundle", compact('category', 'bundles', 'cat'));
    }

    public function GroupLocation(Request $request){
        $shop = Shop::get();
        $location = LocationGroup::get();
        $location_name = array();
        if(!empty($location)){
            foreach ($location as $key => $val) {
                $data = json_decode($val->location);
                $location_name[] = Shop::whereIn("id", $data)->get();
            }
        }
        return view("manager.control_panel.group_location", compact("shop", "location", "location_name"));
    }


    public function CustomTab(Request $request){
        $custom = CustomTab::get();
        return view("manager.control_panel.custom_tab", compact('custom'));
    }

    public function AddCashierDetail(Request $request){
        $request->validate([
            'cashier_name'=>'required',
            'cashier_webkey'=>'required',
            'contact_no'=>'required'
        ]);
        $data = new Cashier;
        $data->name = $request->input('cashier_name');
        $data->webkey = $request->input('cashier_webkey');
        $data->contact_no = $request->input('contact_no');
        $data->save ();
        return ["successMsg" => "Cashier Added Successfully"];
    }

    public function UpdateCashierStatusDetail(Request $request){
        if($request->status == '0'){
            Cashier::where('id', $request->id)->update(['status'=> '1']);
        }else{
            Cashier::where('id', $request->id)->update(['status'=> '0']);            
        }
    }


    
    public function fetchCashierShop(Request $request){
        $shop_id = $request->shop_id;
        $CashierShop = CashierShop::where('shop_id', $shop_id)->get();
        if(count($CashierShop) > 0){
            foreach ($CashierShop as $val) {
                $cashier_id = json_decode($val->cashier_id);
                foreach ($cashier_id as $cid) {
                    $cashier[] = Cashier::where('id', $cid)->get();
                }
                $arr = array(
                    'id' => $val->id, 
                    'shop_id' => $val->shop_id,
                    'cashier_id' => json_decode($val->cashier_id), 
                    'incharge_id' => $val->incharge_id, 
                    'open_time' => $val->open_time, 
                    'close_time' => $val->close_time, 
                    'address' => $val->address, 
                    'tnc' => $val->tnc,
                    'cashier_data' => $cashier,
                );
                return $arr;
            }
        }
    }

    public function UpdateCustomTab(Request $request){
        // dd($request);
        $data = new CustomTab;
        $data->title = $request->input('title');
        $data->alias = $request->input('alias');
        $data->tag = $request->input('tag');
        $data->int_val = $request->input('int_val');
        $data->save ();
        return ["successMsg" => "Custom Added Successfully"];
    }

    public function UpdateFetchCustomData(Request $request){
        $tag = $request->tag;
        $customData = CustomTab::where('tag', $tag)->get();
        $data = array();
        if(count($customData) > 0){
            foreach ($customData as $val) {
                $data[] = $val;
            }
        }
        return $data;
    }

    public function UpdateCustomStatus(Request $request){
        if($request->status == '0'){
            CustomTab::where('id', $request->id)->update(['status'=> '1']);
        }else{
            CustomTab::where('id', $request->id)->update(['status'=> '0']);            
        }
    }

    public function GetOfferBundleTypes(Request $request){
        // dd($request);
        $type = $request->type;
        $cat_id = $request->cat_id;
        if($type == 'Category' && $cat_id == 0){
            $data = MciCategory::get();
        }
        if($type == 'Subcategory'){
            $data = MciSubCategory::where("parent_id", $cat_id)->get();
        }
        if($type == 'Brand' && $cat_id == 0){
            $data = MciBrand::get();
        }
        if($type == 'Tag'){
            $data = "";
        }
        if($type == 'Barcode'){
            $data = "";
        }
        return $data;
    }

    public function AddOfferBundle(Request $request){
        // dd($request);
        $title = $request->title;
        $type = $request->type;
        $entities = json_encode($request->select);
        $parent_id = ($request->cat_id) ? $request->cat_id : 0;
        /*if($type != "Subcategory"){
            $parent_id = 0;
        }else{
            $parent_id = $request->cat_id;
        }
        $arr = array(
            "type"      =>    $type,
            "parent_id" =>    $parent_id,
            "entities"  =>    json_encode($entities),
        );
        dd($arr);*/

        $data = new OfferBundles;
        $data->title = $title;
        $data->type = $type;
        $data->bundle = $entities;
        $data->parent_id = $parent_id;
        $data->save ();
        return ["successMsg" => "Offer Bundle Added Successfully"];
    }

    public function AddLocationGroup(Request $request){
        $title = $request->title;
        $location = json_encode($request->location);

        $data = new LocationGroup;
        $data->title = $title;
        $data->location = $location;
        $data->save ();
        return ["successMsg" => "Location Added Successfully"];
    }
}