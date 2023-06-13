<?php

namespace App\Http\Controllers\Item;

use DB;
use Auth;
use Excel;
use Helper;
use Response;
use Carbon\Carbon;
use App\Models\Item\Item;
use Illuminate\Http\Request;
use App\Imports\ItemsImport;
use App\Models\Item\temp_item;
use App\Models\Manager\MciSize;
use App\Models\Manager\MciColor;
use App\Models\Office\Shop\Shop;
use App\Models\Manager\MciBrand;
use App\Models\Item\items_taxes;
use App\Exports\ItemErrorsExport;
use App\Models\Item\Item_Discount;
use App\Models\Manager\MciCategory;
use App\Models\Inventory\inventory;
use App\Http\Controllers\Controller;
use App\Models\Item\item_quantities;
use App\Models\Item\temp_item_sheets;
use App\Models\Manager\MciSubCategory;
use App\Exports\ItemUpdateErrorsExport;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Manager\ControlPanel\CustomTab;
use App\Models\Office\Permission\ModelPermission;
use App\Models\Manager\ItemRack;
use App\Models\Manager\ManageItemRack;


class ItemController extends Controller
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
         
        // return get_shop_id_name();
        $category = MciCategory::where('status',0)->orderBy('category_name', 'ASC')->get();
        $subcategory = MciSubCategory::where('status',0)->orderBy('sub_categories_name', 'ASC')->get();
        $brand = MciBrand::where('status',0)->orderBy('brand_name', 'ASC')->get();
        $size = MciSize::where('status',0)->orderBy('sizes_name', 'ASC')->get();
        $color = MciColor::where('status',0)->orderBy('color_name', 'ASC')->get();
        $rack = ItemRack::orderBy('rack_number', 'ASC')->get();
        $custom = CustomTab::where('tag',7)->where('status',0)->get();
        $shop = ModelPermission::with(['shop'])->where(['module_id'=>1,'location_id'=>Auth::user()->id])->get();
        $stock_edition  = Item::select('custom6')->distinct()->get();

        $shop_id = get_shop_id_name()->id;
        if(in_array($shop_id, [16, 17, 18, 19]))
        {
            $shop_id = '1';
        }
        else{
            $shop_id = get_shop_id_name()->id;
        }
        // return $shop_id;
        //dd($s_id);

        $items = Item::with(["ItemTax", "brandName", "categoryName", "subcategoryName", "sizeName", "colorName",'item_quantity' => function ($query) use($shop_id) {
                    $query->where('location_id', $shop_id);
            }])->orderBy('id', 'desc')->paginate(10);


        return view("items.index",compact('category','size','brand','color','subcategory','shop','items','custom','stock_edition','rack','shop_id'));
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
        $valid = $request->validate([
          'IGST' => 'required',
          'custom6' => 'required'
        ]);

        $price_type = 'fixed';
        if($request->unit_price == "0.00"){
            $price_type = "discounted";
        }

    /*--------------------------------------------------------------*/
        
        $arr = array(
            'item_number'           =>      0,
            'name'                  =>      $request->name,
            'category'              =>      $request->category,
            'subcategory'           =>      $request->subcategory,
            'brand'                 =>      $request->brand,
            'size'                  =>      $request->size,
            'color'                 =>      $request->color,
            'model'                 =>      $request->model,
            'unit_price'            =>      $request->unit_price,
            'receiving_quantity'    =>      $request->receiving_quantity,
            'reorder_level'         =>      $request->reorder_level,
            'description'           =>      $request->description,
            'hsn_no'                =>      $request->hsn_no,
            'custom5'               =>      $request->custom5,
            'custom6'               =>      $request->custom6,
            'price_type'            =>      $price_type,
            'fixed_sp'              =>      $request->fixed_s_price,
            'stock_from'              =>      $request->stock_from,
        );        
        //dd($arr);

        $item_data = Item::create($arr);

    /*--------------------------------------------------------------*/

        $item_number = str_pad($request->category, 2, '0', STR_PAD_LEFT).str_pad($request->subcategory, 3, '0', STR_PAD_LEFT).str_pad($item_data->id, 6, '0', STR_PAD_LEFT);

        Item::find($item_data->id)->update(['item_number' => $item_number]);

    /*--------------------------------------------------------------*/

        $LastId = $item_data->id;

        $IGST = $request->IGST;
        $CGST = $IGST/2;
        $SGST = $IGST/2;

        $model_tax = new items_taxes;
        $model_tax->item_id      = $LastId;
        $model_tax->IGST         = $IGST;
        $model_tax->CGST         = $CGST;
        $model_tax->SGST         = $SGST;
        $model_tax->save();
    
    /*--------------------------------------------------------------*/

        $model_discount = new Item_Discount;
        $model_discount->item_id      = $LastId;
        $model_discount->retail       = $request->retail;
        $model_discount->wholesale    = $request->wholesale;
        $model_discount->franchise    = $request->franchise;
        $model_discount->special      = $request->special;
        $model_discount->save();

    /*--------------------------------------------------------------*/

        $shop_id = Shop::get();

        foreach ($shop_id as $shops_id) 
        {
            $item_qua_data = item_quantities::insert([
                    'location_id'       => $shops_id->id,
                    'item_id'           => $LastId
                ]);

            /*-----------------------------------------------------*/

            $inventory_data = inventory::insert([
                    'trans_user'        => Auth::id(),
                    'trans_location'    => $shops_id->id,
                    'trans_items'       => $LastId,
                    'trans_date'        => date('Y-m-d H:i:s')
                ]);
        }
            
    /*--------------------------------------------------------------*/




    /*--------------------------------------------------------------*/

    // if($request->rack !=''){
    //     ManageItemRack::create(['rack_id'=>$request->rack,'item_id'=>$LastId,'quantity'=>$request->rack_item_qty]);
    // }

    /*--------------------------------------------------------------*/

        return back()->with('success','Item created successfully');
    }

/*=========================================================================*/

    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $category = MciCategory::where('status',0)->get();
        $subcategory = MciSubCategory::where('status',0)->get();
        $brand = MciBrand::where('status',0)->get();
        $size = MciSize::where('status',0)->get();
        $color = MciColor::where('status',0)->get();
        
        $tax = items_taxes::where('item_id',$id)->first();
      
        $data = Item::find($id);
        
        $dis_data = Item_Discount::where('item_id',$id)->first();

        $racks 	   = ItemRack::orderBy('rack_number', 'ASC')->get();

        $item_rack = ManageItemRack::where('item_id', $id)->first();

        return view('items.edit',compact('data', 'dis_data', 'category', 'subcategory', 'brand', 'color', 'size', 'tax', 'racks', 'item_rack'));
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
        $price_type = 'fixed';
        if($request->unit_price == "0.00"){
            $price_type = "discounted";
        }
 

        /*-------------------------------------------------------------*/

        Item::where('id', $id)
        ->update([
                'name'                  =>      $request->name,
                'category'              =>      $request->category,
                'subcategory'           =>      $request->subcategory,
                'brand'                 =>      $request->brand,
                'size'                  =>      $request->size,
                'color'                 =>      $request->color,
                'model'                 =>      $request->model,
                'unit_price'            =>      $request->unit_price,
                'receiving_quantity'    =>      $request->receiving_quantity,
                'reorder_level'         =>      $request->reorder_level,
                'description'           =>      $request->description,
                'hsn_no'                =>      $request->hsn_no,
                'custom5'               =>      $request->custom5,
                'custom6'               =>      $request->custom6,
                'price_type'            =>      $price_type,
                'fixed_sp'              =>      $request->fixed_s_price,
            ]);

        /*-------------------------------------------------------------*/
        $IGST = $request->IGST;
        $CGST = $IGST/2;
        $SGST = $IGST/2;

        items_taxes::where('item_id', $id)
        ->update([
                'CGST'         => $CGST,
                'SGST'         => $SGST,
                'IGST'         => $IGST
            ]);
    
        /*--------------------------------------------------------------*/

        Item_Discount::where('item_id', $id)
        ->update([
                'retail'       => $request->retail,
                'wholesale'    => $request->wholesale,
                'franchise'    => $request->franchise,
                'special'      => $request->special
            ]);

		//$rack_item = ManageItemRack::where('item_id', $id)->first();

		/*****************       For Rack Item update       *****************/

		$new_rack   =   $request->rack;
		
		if(!empty($new_rack)){
			$rack_item_quantity   =   $request->rack_item_qty;
			$previous_rack  =   $request->previous_rack;

			if($new_rack == $previous_rack){
				ManageItemRack::where('item_id', $id)
					->where('rack_id', $new_rack)
					->update([
						'quantity'=> $rack_item_quantity
					]);
			}else{
				$rack_item = ManageItemRack::where('item_id', $id)->where('rack_id', $new_rack)->first();
				if($rack_item == true){
					ManageItemRack::where('item_id', $id)
						->where('rack_id', $new_rack)
						->update([
							'quantity'=> $rack_item_quantity
						]);
				}else{
					ManageItemRack::create([
						'rack_id' => $request->rack,
						'item_id' => $id,
						'quantity'=> $request->rack_item_qty
					]);
				}
			}
		}

        return back();

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


    /*   Item Receiving quantity Update     */
    
    public function updateReceivingQuantity(Request $request)
    {
        Item::where('id', $request->id)->update([
                    'receiving_quantity'=> $request->receiving_quantity 
                ]);
                            
        return back();
    // ["successMsg" => "Receiving Quantity Updated Successfully"];
    }




    public function fetchData(Request $request) 
    {
        //dd($request->$stock_location);
        $category = $request->cat_id;
        $subcategory = $request->subcat_id;
        $brand = $request->brand_id;
        //$shop = $request->stock_location;
        $search = $request->search_item;
        $edition = $request->edition_id;
        $stock_l = !empty($request->stock_location)?$request->stock_location:get_shop_id_name()->id;
       
        if(in_array($stock_l, [16, 17, 18, 19]))
        {
            $stock_location = '1';
        }
        else{
            $stock_location = !empty($request->stock_location)?$request->stock_location:get_shop_id_name()->id;
        }
        $ser = [];
        // dd($search);
        if(!empty($category)){
            $ser['category'] = $category; 
        }
        if(!empty($subcategory)){
            $ser['subcategory'] = $subcategory;
        }
        if(!empty($brand)){
            $ser['brand'] = $brand;
        }
        if($search != null){
            $items = Item::with(["ItemTax", "brandName", "categoryName", "subcategoryName", "sizeName", "colorName",'item_quantity'=>function ($query)use($stock_location) {
                    $query->where('location_id',$stock_location);
                }])
            ->where('name', 'ILIKE', "%{$search}%")
            ->orWhere('item_number', 'like', $search)
            ->orWhere('hsn_no', 'like', $search)
            ->orWhere('custom6', 'like', $search)
            ->offset(0)->limit(100)
            ->paginate(50);
            // dd($items);
        }

        if(empty($search)){
            $items = Item::with(["ItemTax", "brandName", "categoryName", "subcategoryName", "sizeName", "colorName",'item_quantity'=>function ($query)use($stock_location) {
                    $query->where('location_id',$stock_location);
                }])->where($ser)->orderBy('id', 'desc')->paginate(100);
        }
          

        return view('items.fetch', compact('items'));
    }

    public function excelImportItems(Request $request){

       	 $valid = $request->validate([
             'location_id' => 'required',
             'stockeditiondate' => 'required'
         ]);

            $status = true;
            $size_id1 = 0;
            $color_id1 = 0;
            $duplicate = true;
            $errors = array();
            $location_id = $request->location_id;
            $datas = Excel::toCollection(new ItemsImport,$request->file('file_path'));
             //dd($datas);

        /* master sheet entry */

        $sheet_name  = "DBF_Item_Imported_Sheet";
        $uploader_id = $request->sheet_uploader;

        $uploader = temp_item_sheets::create([
                    'name'         => $sheet_name,
                    'uploader_id'  => $uploader_id,
                    'stock_edition'  => $request->stockeditiondate,
                ]);

        $parent_id = $uploader->id;

        /* master sheet entry */
          
            foreach ($datas as $value) {
                foreach ($value as $items) {
                    $status = true;
                    $duplicate = true;
                    //  $request->stockeditiondate;
                    // $items['stock_edition'];
                    if($items['category'] !=''){
                        $category_id = MciCategory::where('category_name', $items['category'])->first();
                        if(!empty($category_id)){
                        
                            if($items['subcategory'] !=''){
                                $subcategory_id = MciSubCategory::where('sub_categories_name', $items['subcategory'])->where('parent_id', $category_id->id)->first();
                             
                                if(!empty($subcategory_id)){
                     
                                    if($items['brand'] !='' ){
                                        $brand_id = MciBrand::where('brand_name', $items['brand'])->first();
                                        if(!empty($brand_id)){
                                            if($items['size'] !='' || $items['size'] == null){               	       
                                               
                                
                                                $size_id = MciSize::where('sizes_name', $items['size'])->first();
                                            
                                                if(!empty($size_id) || $size_id == null) {

                                                     $size_id1 = $size_id == null ? '0' : $size_id->id;
                                                   

                                                    if($items['color'] != "" || $items['color'] == null){
                                                        $color_id = MciColor::where('color_name', $items['color'])->first();
                                            			// dd($color_id);
                                                        if(!empty($color_id) || $color_id == null){
                                            
                                                        
                                                             $color_id1 = $color_id == null ? '0' :$color_id->id;                                                            
                                                           

                                                            if($items['item_name'] != "" ){
                                                                $item_name = item::where('name',$items['item_name'])
                                                                            ->where('category',$category_id->id)                 
                                                                            ->where('subcategory',$subcategory_id->id);
                                                                            if($color_id !=null){
                                                                                $item_name->where('brand',$brand_id->id);
                                                                            }
                                                                            if($size_id !=null){
                                                                                $item_name->where('size',$size_id->id);
                                                                            }                       

                                                              
                                                                if($item_name->first() != null){                                                
                                                                 
                                                                    $status = true;
                                                                    $duplicate = false;
                                                                }                                                               
                                                            }else{
                                                             
                                                                $status = false;
                                                                $duplicate = true;
                                                          

                                                            }
                                                        }else{
                                                            $status = false;
                                                            $duplicate = true;
                                                            

                                                        }
                                                    }else{
                                                        $status = false;
                                                        $duplicate = true;
                                                       

                                                    }
                                                }else{
                                                    $status = false;
                                                    $duplicate = true;
                                           

                                                }
                                            }else{
                                                $status = false;
                                                $duplicate = true;
                                             

                                            }
                                        }else{
                                            $status = false;
                                            $duplicate = true;
                                         

                                        }
                                    }else{
                                        $status = false;
                                        $duplicate = true;
                                           

                                    }
                                }else{
                                    $status = false;
                                    $duplicate = true;
                                  

                                }
                            }else{
                                $status = false;
                                $duplicate = true;
                              

                            }
                        }else{
                            $status = false;
                            $duplicate = true;
                        

                        }
                    }else{
                        $status = false;
                        $duplicate = true;
                      
                    }
                  
                    
                    

                    $price_type = 'fixed';
                    if($items['retail_price'] == "0.00"){
                        $price_type = "discounted";
                    }

                    $error_status = "1";

                    if($status == false)
                    {
                        $error_status = "0";
                    }

                    //dd($error_status);

                    $autoId = DB::select(DB::raw("SELECT nextval('items_id_seq')"));
                    $nextval = $autoId[0]->nextval;

                    $rnd1 = rand(1, 999);
                    $rnd2 = rand(1, 999);
                    $rnd3 = rand(1, 999);

                    $item_number = str_pad($rnd1, 2, '0', STR_PAD_LEFT).str_pad($rnd2, 3, '0', STR_PAD_LEFT).str_pad($rnd3, 4, '0', STR_PAD_LEFT).str_pad($nextval, 6, '0', STR_PAD_LEFT);
                    
                    //dd($category_id->id == null ? "nothing is here" : 0);

                  
                  $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($items['stock_edition'])->format('Y-m-d');

                    $arr = array(
                        'item_number'       =>   !empty($items['item_number']) ? $items['item_number']:$item_number,
                        'name'              =>   $items['item_name'],
                        'category'          =>   $items['category'],
                        'subcategory'       =>   $items['subcategory'],
                        'brand'             =>   $items['brand'],
                        'size'              =>   $items['size'],
                        'color'             =>   $items['color'],
                        'model'             =>   $items['model'],
                        'unit_price'        =>   $items['retail_price'],
                        'cgst'              =>   $items['cgst'],
                        'sgst'              =>   $items['sgst'],
                        'igst'              =>   $items['igst'],
                        'retail_discount'   =>   $items['retail_discount'],
                        'wholesale_discount'=>   $items['wholesale_discount'],
                        'franchise_discount'=>   $items['franchise_discount'],
                        'special_discount'  =>   $items['special_discount'],
                        'receiving_quantity'=>   $items['receiving_quantity'],
                        'reorder_level'     =>   $items['reorder_level'],
                        'description'       =>   $items['description'],
                        'hsn_no'            =>   $items['hsn_code'],
                        //'rack_id'           =>   $items['rack_number'],
                        'custom1'           =>   '0000-00-00',
                        'custom2'           =>   $date,
                        'error_status'      =>   $error_status,
                        'parent_id'         =>   $parent_id,
                        'location_id'       =>   $location_id,
                        'price_type'        =>   $price_type
                    );    
                
                    $item_data = temp_item::create($arr);       
                }
            }

            if(count($errors) !=0){
                return Excel::download(new ItemErrorsExport($errors), 'pos_item_error.xls');
            }

            return redirect()->route('items.index')->with('success', 'Added successfully');
        
    } 

    /*===========================================================*/

    public function sheetDecline(Request $request)
    {
        temp_item_sheets::where('id',$request->parent_id)->update(['sheet_status' => 2]);
        return back(); 
    }

/*  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++   */


    public function sheetApproval(Request $request)
    {
        
       
            $status = true;
            $size_id1 = 0;
            $color_id1 = 0;
            $duplicate = true;
            $errors = array();
            //$location_id = $request->location_id;
            //$datas = Excel::toCollection(new ItemsImport,$request->file('file_path'));

            $value = temp_item::where('parent_id', $request->parent_id)
                            ->get();
           
                    //dd($items);
                foreach ($value as $items) {
                    //dd($items);
                    $status = true;
                    $duplicate = true;
                    if($items->custom1 != ""){
                        // dd($items['expiry_date']);
                        $date = $items->custom1 !='0000-00-00' ? Date::excelToDateTimeObject($items->custom1): Null;
                        $exp_date = $items->custom1 !='0000-00-00' ? date("d/m/Y", strtotime(get_object_vars($date)['date'])) : Null;
                    }else{
                        $exp_date = Null;
                    }
                    
                    if($items->category !=''){
                        $category_id = MciCategory::where('category_name', $items->category)->first();
                        if(!empty($category_id)){
                        
                            if($items->subcategory !=''){
                                $subcategory_id = MciSubCategory::where('sub_categories_name', $items->subcategory)->where('parent_id', $category_id->id)->first();
                                // dd($subcategory_id);
                                if(!empty($subcategory_id)){
                                    // dd($items,'sub_category');
                                    if($items->brand !='' ){
                                        $brand_id = MciBrand::where('brand_name', $items->brand)->first();
                                        if(!empty($brand_id)){
                                            if($items->size !='' || $items->size == null){                         
                                               
                                
                                                $size_id = MciSize::where('sizes_name', $items->size)->first();
                                                // dd($size_id);
                                                if(!empty($size_id) || $size_id == null) {

                                                     $size_id1 = $size_id == null ? '0' : $size_id->id;
                                                   

                                                    if($items->color != "" || $items->color == null){
                                                        $color_id = MciColor::where('color_name', $items->color)->first();
                                                        // dd($color_id);
                                                        if(!empty($color_id) || $color_id == null){
                                            // dd($items,'size');
                                                        
                                                             $color_id1 = $color_id == null ? '0' :$color_id->id;                                                       

                                                            if($items->name != "" ){
                                                                $item_name = item::where('name',$items->name)
                                                                            ->where('category',$category_id->id)                 
                                                                            ->where('subcategory',$subcategory_id->id);
                                                                            if($color_id !=null){
                                                                                $item_name->where('brand',$brand_id->id);
                                                                            }
                                                                            if($size_id !=null){
                                                                                $item_name->where('size',$size_id->id);
                                                                            }                       

                                                                if($items->item_number != ''){
                                                                    $item_name->where('item_number',$items->item_number);
                                                                }
                                                            // dd($items);
                                                                // dd($item_name->first());
                                                                if($item_name->first() != null){                                                
                                                                 // dd($item_name->first());
                                                                    // $msg = "Item already exist";
                                                                    $status = false;
                                                                    $duplicate = false;
                                                                }                                                               
                                                            }else{
                                                             
                                                                $status = false;
                                                                $duplicate = true;
                                                                return 'my';

                                                            }
                                                        }else{
                                                            $status = false;
                                                            $duplicate = true;
                                                            return 'Color is not in record';

                                                        }
                                                    }else{
                                                        $status = false;
                                                        $duplicate = true;
                                                        return 'Color is zero in excel';

                                                    }
                                                }else{
                                                    $status = false;
                                                    $duplicate = true;
                                            //dd($items);
                                                    return 'Size is not in record';

                                                }
                                            }else{
                                                $status = false;
                                                $duplicate = true;
                                                return 'size is zero in excel';

                                            }
                                        }else{
                                            $status = false;
                                            $duplicate = true;
                                            dd($items,'Brand is not in record');

                                        }
                                    }else{
                                        $status = false;
                                        $duplicate = true;
                                            dd($items,'brand is zero in excel');

                                    }
                                }else{
                                    $status = false;
                                    $duplicate = true;
                                    dd($items,'subcategory is not in record');

                                }
                            }else{
                                $status = false;
                                $duplicate = true;
                                // dd($items);
                                dd($items,'subcategory is zero or blank in excel');

                            }
                        }else{
                            $status = false;
                            $duplicate = true;
                           dd($items,'category is not in record');

                        }
                    }else{
                        $status = false;
                        $duplicate = true;
                        dd($items,'category is zero or blank in excel');
                    }
                     // dd(5287);

                    if($status == true)
                    {
                        $price_type = 'fixed';
                        if($items['retail_price'] == "0.00"){
                            $price_type = "discounted";
                        }


                        $autoId = DB::select(DB::raw("SELECT nextval('items_id_seq')"));
                        $nextval = $autoId[0]->nextval;

                        $item_number = str_pad($category_id->id, 2, '0', STR_PAD_LEFT).str_pad($subcategory_id->id, 3, '0', STR_PAD_LEFT).str_pad($nextval, 6, '0', STR_PAD_LEFT);
                       
                        $arr = array(
                            'item_number'       =>   $item_number,
                            'name'              =>   $items->name,
                            'category'          =>   $category_id->id,
                            'subcategory'       =>   $subcategory_id->id,
                            'brand'             =>   $brand_id->id,
                            'size'              =>   $size_id1,
                            'color'             =>   $color_id1,
                            'model'             =>   $items->model,
                            'unit_price'        =>   $items->unit_price,
                            'receiving_quantity'=>   $items->receiving_quantity,
                            'reorder_level'     =>   $items->reorder_level,
                            'description'       =>   $items->description,
                            'hsn_no'            =>   $items->hsn_no,
                            'custom5'           =>   $exp_date,
                            'custom6'           =>   $items->custom2,
                            'parent_id'         =>   $items->parent_id,
                            'location_id'       =>   $items->location_id,
                            'price_type'        =>   $price_type
                        );
                        
                        $item_data = Item::create($arr);
                        $LastId = $item_data->id;

                        
                                           
                        $shops = Shop::with(['employee.usersInfo'])->get();
                        foreach($shops as $Shops){ 
                            $qty = '';
                            if( $Shops->id == $items->location_id){
                               $qty = $items->receiving_quantity;
                            }
                            else{
                                $qty = 0;
                            }
                            item_quantities::insert(['item_id'=>$LastId,'location_id'=>$Shops->id,'quantity'=>$qty]);
                            $inventory_data = inventory::insert([
                             'trans_user'        => Auth::id(),
                             'trans_location'    => $Shops->id,
                             'trans_items'       => $LastId,
                             'trans_date'        => date('Y-m-d H:i:s')
                             ]);

                        }

                        

                        $LastId = $item_data->id;

                        $model_tax = new items_taxes;
                        $model_tax->item_id      = $LastId;
                        $model_tax->CGST         = $items->cgst;
                        $model_tax->SGST         = $items->sgst;
                        $model_tax->IGST         = $items->igst;
                        $model_tax->save();
                    
                      
                        $model_discount = new Item_Discount;
                        $model_discount->item_id      = $LastId;
                        $model_discount->retail       = $items->retail_discount.".00";
                        $model_discount->wholesale    = $items->wholesale_discount.".00";
                        $model_discount->franchise    = $items->franchise_discount.".00";
                        $model_discount->special      = $items->special_discount.".00";
                        $model_discount->save();

                      	/*$model_rack = new ManageItemRack;
                      	$model_rack->rack_id = $items->rack_id;
                      	$model_rack->item_id = $LastId;
                      	$model_rack->quantity = $items->receiving_quantity;
                      	$model_rack->save();*/

                    }
                    else
                    {
                        if($duplicate){
                            $errors[] = [
                                'item_name'         =>   $items->name,
                                'item_nmber'        =>   $item_number,
                                'category'          =>   $items->category,
                                'subcategory'       =>   $items->subcategory,
                                'brand'             =>   $items->brand,
                                'color'             =>   $items->color,
                                'size'              =>   $items->size,
                                'model'             =>   $items->model,
                                'retail_price'      =>   $items->retail_price,
                                'cgst'              =>   $items->cgst,
                                'sgst'              =>   $items->sgst,
                                'igst'              =>   $items->igst,
                                'receiving_quantity'=>   $items->receiving_quantity,
                                'reorder_level'     =>   $items->reorder_level,
                                'description'       =>   $items->description,
                                'hsn_code'          =>   $items->hsn_code,
                                'expiry_date'       =>   $exp_date,
                                'stock_edition'     =>   $items->custom2,
                                'retail_discount'   =>   $items->retail_discount !=0 ? $items->retail_discount : '0', 
                                'wholesale_discount'=>  $items->wholesale_discount !=0 ? $items->wholesale_discount : '0',
                                'franchise_discount'=>  $items->franchise_discount !=0 ? $items->franchise_discount : '0',
                                'special_discount'  =>   $items->special_discount !=0 ? $items->special_discount : '0',
                                //'empty'             =>   $items->empty !=0 ? $items->empty : '0'
                                'empty'             =>   '0'
                            ];
                        }
                    }
                }
            /*}*/

                //dd($errors);
            if(count($errors) !=0){
                return Excel::download(new ItemErrorsExport($errors), 'pos_item_error.xls');
            }else{
                temp_item_sheets::where('id',$request->parent_id)->update(['sheet_status' => 1]); 
            }

            return back();
        }


/*  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++   */


    public function excelUpdateImportItems(Request $request)
    //public function testExcelUpdateImportItems(Request $request)
    {
        //return "test";
        $status = true;
        $errors = array();
        $datas = Excel::toCollection(new ItemsImport,$request->file('file_path'));
        $location_id = $request->location_upload;
		//dd($location_id);
        foreach ($datas as $data) {
            foreach ($data as $item) {
                $item_num = (string)$item['item_number'];
                   $itemData =  Item::where('item_number',$item_num)->first();
                if($item['item_number'] !='' && $item['quantity'] !=''){
                    $item_num = (string)$item['item_number'];
                   $items =  Item::where('item_number',$item_num)->first();

                   if(!empty($items)){
                        item_quantities::where('location_id', $request->location_upload)
                            ->where('item_id',$items->id)
                            ->increment('quantity', $item['quantity']); 
                            // item_quantities::where('location_id', $request->location_upload)
                            // ->where('item_id',$items->id)
                            // ->decrement('quantity', $item['quantity']); 

                            // ->increment('quantity' ,$item['quantity']);
                   }else{
                   	//dd($item);
                        $status = false;
                   }
                }else{
                    $status = false;
                }

                if($status == false){
                    $errors[] = [
                        'item_number' => $item['item_number'],
                        'quantity' => $item['quantity'],
                    ];
                }
            }
        }

        if(count($errors) !=0){
            return Excel::download(new ItemUpdateErrorsExport($errors), 'pos_item_update_error.xls');
        }
        return redirect()->route('items.index')->with('success','Item Quantity Updated Successfully.');

    }



    public function getValidPasswordItems(Request $request){
        $sheet_uploader = $request->sheet_uploader;
        $password = $request->password;
        $data = CustomTab::where("id", $sheet_uploader)->get();
        $fetch_password = $data[0]->int_val;
        if($fetch_password != $password){
            return "Password is incorect";
        }
    }

    public function downloadSheetFormat(){
        $path = storage_path('pos_import_items.xls');
        return Response::download($path);
    }

    public function getSubcategory(Request $request){
        $id = $request->cat_id;
        return get_subcategory($id);
    }

    public function updateQty(Request $request){
        $item_id = $request->item_id;
        $location_id = $request->loc_id;
        $qty = $request->qty;

        if(in_array($location_id, [16, 17, 18, 19]))
        {
            $loc_id = '1';
        }
        else{
            $loc_id = $request->loc_id;
        }

        item_quantities::where(['item_id'=>$item_id,'location_id'=>$loc_id])->increment('quantity',$qty);
        
        return back();
    }


    public function excelTaxesUpdate(Request $request)
    //public function excelUpdateImportItems(Request $request)
    {

        //return ;
        $status = true;
        $errors = array();
        $datas = Excel::toCollection(new ItemsImport,$request->file('file_path'));
        // return $request->location_upload;
        //return $datas;
        foreach ($datas as $data) 
        {
            foreach ($data as $item)
            {
                $item_number = (string)$item['item_number'];
                $IGST = $item['gst'];

                $items =  Item::where('item_number',$item_number)->get();

                if(!empty($items)){
                   foreach ($items as $item_no)
                   {
                       //dd($item_no);
                       items_taxes::where('item_id', $item_no->id)->update([
                            'IGST'=>$IGST
                        ]); 
                   }
                }
            }
        }

        
        return redirect()->route('items.index')->with('success','Item Quantity Updated Successfully.');

    }

    public function excelDiscountUpdate(Request $request)
    //public function excelUpdateImportItems(Request $request)
    {

        //return 'test';
        $status = true;
        $errors = array();
        $datas = Excel::toCollection(new ItemsImport,$request->file('file_path'));
        // return $request->location_upload;
        //return $datas;
        foreach ($datas as $data) 
        {
            foreach ($data as $item)
            {
                $item_no = $item['item_number'];
                $retail = $item['retail'];
                $wholesale = $item['wholesale'];
                $franchise = $item['franchise'];
                $special = $item['special'];

                $items =  Item::where('item_number',$item_no)->get();

                if(!empty($items)){
                   foreach ($items as $item_data)
                   {
                       Item_Discount::where('item_id', $item_data->id)->update([
                            'retail'=>$retail,
                            'wholesale'=>$wholesale,
                            'franchise'=>$franchise,
                            'special'=>$special
                        ]); 
                   }
                }
            }
        }

        
        return redirect()->route('items.index')->with('success','Item Quantity Updated Successfully.');

    }



    /*****Update Purchase Price********/


    public function ExcelPurchasePriceUpdate(Request $request)
    //public function testExcelPurchasePriceUpdate(Request $request)
    {
        //return $request->file('file_path');
        $status = true;
        $errors = array();
        $datas  = Excel::toCollection(new ItemsImport,$request->file('file_path'));

        foreach ($datas as $data) {
            foreach ($data as $item) {

                $item_num = (string)$item['item_number'];
                $purchase_price = (string)$item['pp'];

                   //$itemData =  Item::where('item_number',$item_num)->first();

                if($item['item_number'] !='' && $item['pp'] !=''){

                    $item_num = (string)$item['item_number'];
                    $items    =  Item::where('item_number', $item_num)
                                ->update(['actual_cost' => $purchase_price]);
                }else{
                    $status = false;
                }

                if($status == false){
                    $errors[] = [
                        'item_number'     => $item['item_number'],
                        'purchase_price'  => $item['pp'],
                    ];
                }
            }
        }

        if(count($errors) !=0){
            return Excel::download(new ItemUpdateErrorsExport($errors), 'pos_item_update_error.xls');
        }
        return redirect()->route('items.index')->with('success','Item Quantity Updated Successfully.');

    }

/* ***********update fixed price************* */


	public function ExcelFixedPriceUpdate(Request $request)
	//public function ExcelPurchasePriceUpdate(Request $request)
    {
        $status = true;
        $errors = array();
        $datas  = Excel::toCollection(new ItemsImport,$request->file('file_path'));

        foreach ($datas as $data) {
            foreach ($data as $item) {

                $item_num = (string)$item['item_number'];
                $fixed_price = (string)$item['fixed_sp'];

                   //$itemData =  Item::where('item_number',$item_num)->first();

                if($item['item_number'] !='' && $item['fixed_sp'] !=''){

                    $item_num = (string)$item['item_number'];

                    $items    =  Item::where('item_number', $item_num)
                                ->update(['fixed_sp' => $fixed_price, 'unit_price' => '0']);

                    $itemData =  Item::where('item_number',$item_num)->get();
                    	//dd($itemData->id);
                    if(!empty($itemData))
                    {
	                   foreach ($itemData as $item_data)
	                   {
	                       Item_Discount::where('item_id', $item_data->id)->update([
	                            'retail'=>'0'
	                        ]); 
	                   }
	                }
                }else{
                    $status = false;
                }

                if($status == false){
                    $errors[] = [
                        'item_number'     => $item['item_number'],
                        'fixed_price'  => $item['fixed_sp'],
                    ];
                }
            }
        }

        if(count($errors) !=0){
            return Excel::download(new ItemUpdateErrorsExport($errors), 'pos_item_update_error.xls');
        }
        return redirect()->route('items.index')->with('success','Item Quantity Updated Successfully.');

    }


     public function updateRepairCost(Request $request)
    {
        $status = true;
        $errors = array();
        $datas  = Excel::toCollection(new ItemsImport,$request->file('file_path'));

        foreach ($datas as $data) {
            foreach ($data as $item) {
                //dd($item);
                $item_num = (string)$item['item_number'];
                $item_name = (string)$item['item_name'];
                $item_model = (string)$item['item_model'];
                $repair_cost = (string)$item['repair_cost'];

                if($item['item_number'] !='' && $item['repair_cost'] !=''){

                    $item_num = (string)$item['item_number'];
                    $items    =  Item::where('item_number', $item_num)
                                ->update(['repair_cost' => $repair_cost]);
                }else{
                    $status = false;
                }
                if($status == false){
                    $errors[] = [
                        'item_number'     => $item['item_number'],
                        'repair_cost'     => $item['repair_cost'],
                    ];
                }
            }
        }
        if(count($errors) !=0){
            return Excel::download(new ItemUpdateErrorsExport($errors), 'pos_item_update_error.xls');
        }
        return redirect()->route('items.index')->with('success','Item Repair Cost Updated Successfully.');
    }
}
