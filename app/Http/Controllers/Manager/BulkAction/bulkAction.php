<?php

namespace App\Http\Controllers\Manager\BulkAction;

use Illuminate\Http\Request;
use App\Models\Office\Shop\Shop;
use App\Http\Controllers\Controller;
use App\Models\Manager\MciCategory;
use App\Models\Manager\MciSubCategory;
use App\Models\Manager\MciBrand;
use App\Models\Manager\BulkAction\BulkAction_Discount;
use App\Models\Manager\BulkAction\BulkAction_HSN;
use App\Models\Item\Item;
use App\Models\Item\items_taxes;
use App\Models\Item\Item_Discount;
use Auth;

class bulkAction extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = MciCategory::get();
        $brand = MciBrand::get();

        return view("manager.bulkActions.index", compact("category", "brand"));
    }

/* ==================================================================== */
   public function bulkHsnUpdate(Request $request)
   {
       
       $category    = $request->category;
       $subcategory = $request->subcategory;
       $hsn         = $request->hsn_code;
       $input_tax   = $request->tax;


        $CGST = $input_tax/2;
        $SGST = $input_tax/2;
        $IGST = $input_tax;
     
      
        $array = array(
            'category' => $category,
            );
        if(!empty($subcategory))
        {
            $array['subcategory'] = $subcategory;
        }

        $items_query = Item::where($array)->get();

        //$item_id = [];
        foreach($items_query as $item_data ) {
            $itemid = $item_data->id;
            /*--------------------------------------------------------*/       
            if(!empty($hsn))
            {
                $hsn_data = array( 
                    'hsn_no' => $hsn
                );
                Item::where('id', $itemid)->update($hsn_data);
            }
            /*----------------------------------------------------------*/
            
            /*----------------------------------------------------------*/
            $items_taxes = items_taxes::where('item_id',$itemid)->get();
            
            if(count($items_taxes) !=0){
                items_taxes::where('item_id', $itemid)
                    ->update([
                        'CGST' =>  $CGST,
                        'SGST' =>  $SGST,
                        'IGST' =>  $IGST
                    ]);
            }    
            else
            {
               $model_tax = new items_taxes;
               $model_tax->item_id      = $itemid;
               $model_tax->CGST         = $CGST;
               $model_tax->SGST         = $SGST;
               $model_tax->IGST         = $IGST;
               $model_tax->save();

            }
        /*-----------------------------------------------------------*/
        }

        $items_hsn = BulkAction_HSN::where(['category'=>$category, 'subcategory'=>$subcategory])->get();
            
        if(count($items_hsn) !=0){
            BulkAction_HSN::where(['category'=>$category, 'subcategory'=>$subcategory])
            ->update([
                    'user_id' =>  Auth::id(),
                    'category' =>  $category,
                    'subcategory' =>  $subcategory,
                    'hsn'       =>    $hsn,
                    'input_tax' =>  $input_tax,
                    'date_time' =>  date('Y-m-d H:i:s')
                ]);
        }    
        else
        {

           $model = new BulkAction_HSN;

           //$user_id     = Auth::user()->name;
           $model->user_id     = Auth::id();
           $model->method      = "Bulk_HSN";
           $model->category     = $category;
           $model->subcategory  = $subcategory;
           $model->hsn          = $hsn;
           $model->input_tax    = $input_tax;
           $model->date_time    = date('Y-m-d H:i:s');
           $model->save();

        }
       
   }

/* ===================================================================== */
   public function bulkDiscountUpdate(Request $request)
   {
       
       $radio_btn_id    = $request->radio_btn_id;
       $bdu_cat         = $request->bdu_cat;
       $bdu_sub_cat     = $request->bdu_sub_cat;
       $bdu_brand       = $request->bdu_brand;
       $bdu_type        = $request->bdu_type;
       $bdu_value       = $request->bdu_value;




        /*-------------------------------------------------------------*/
       if($radio_btn_id == 1)
       {
            $radio_btn_name = 'category';

            $subcat = null;
            $brands = null;
            
            $items_dis = BulkAction_Discount::where(['category'=>$bdu_cat, 'subcategory'=>$subcat, 'brand'=>$brands, 'method'=>'Bulk_Discount'])->get();
            
            if(count($items_dis) !=0)
            {
                BulkAction_Discount::where(['category'=>$bdu_cat, 'subcategory'=>$subcat, 'brand'=>$brands])
                ->update([
                        'user_id' =>  Auth::id(),
                        'type'      =>  $radio_btn_name,
                        'category' =>  $bdu_cat,
                        'subcategory' =>  $bdu_sub_cat,
                        'brand'     =>  $bdu_brand,
                        'discount_type' =>  $bdu_type,
                        'discount_value' =>  $bdu_value,
                        'date_time' =>  date('Y-m-d H:i:s')
                    ]);
            }    
            else
            {
               $model = new BulkAction_Discount;

               //$user_id     = Auth::user()->name;
               $model->user_id     = Auth::id();
               $model->method      = "Bulk_Discount";
               $model->type         = $radio_btn_name;
               $model->category     = $bdu_cat;
               $model->subcategory  = $bdu_sub_cat;
               $model->brand          = $bdu_brand;
               $model->discount_type   = $bdu_type;
               $model->discount_value    = $bdu_value;
               $model->date_time    = date('Y-m-d H:i:s');
               $model->save();

            }

            /*-----------category wise discount updat-------------*/
            $Items = Item::where('category', $bdu_cat)
                            ->where('unit_price', '!=','0')
                            ->get();
            foreach($Items as $item_data ) 
            {
                $itemid = $item_data->id;

                Item_Discount::where('item_id', $itemid)
                  ->update([
                        $bdu_type      =>  $bdu_value
                    ]);
            }
            /*-----------category wise discount updat-------------*/
       }

       /*-------------------------------------------------------------*/

       else if($radio_btn_id == 2)
       {
            $radio_btn_name = 'brand';

            $cat = null;
            $subcat = null;
            
            $items_dis = BulkAction_Discount::where(['category'=>$cat, 'subcategory'=>$subcat, 'brand'=>$bdu_brand, 'method'=>'Bulk_Discount'])->get();
            
            if(count($items_dis) !=0)
            {
                BulkAction_Discount::where(['category'=>$cat, 'subcategory'=>$subcat, 'brand'=>$bdu_brand])
                ->update([
                        'user_id' =>  Auth::id(),
                        'type'      =>  $radio_btn_name,
                        'category' =>  $bdu_cat,
                        'subcategory' =>  $bdu_sub_cat,
                        'brand'     =>  $bdu_brand,
                        'discount_type' =>  $bdu_type,
                        'discount_value' =>  $bdu_value,
                        'date_time' =>  date('Y-m-d H:i:s')
                    ]);
            }    
            else
            {

               $model = new BulkAction_Discount;

               //$user_id     = Auth::user()->name;
               $model->user_id     = Auth::id();
               $model->method      = "Bulk_Discount";
               $model->type         = $radio_btn_name;
               $model->category     = $bdu_cat;
               $model->subcategory  = $bdu_sub_cat;
               $model->brand          = $bdu_brand;
               $model->discount_type   = $bdu_type;
               $model->discount_value    = $bdu_value;
               $model->date_time    = date('Y-m-d H:i:s');
               $model->save();

            }

            /*-----------Brand wise discount updat-------------*/
            $Items = Item::where('brand', $bdu_brand)
                            ->where('unit_price', '!=','0')
                            ->get();
            foreach($Items as $item_data ) 
            {
                $itemid = $item_data->id;

                Item_Discount::where('item_id', $itemid)
                  ->update([
                        $bdu_type      =>  $bdu_value
                    ]);
            }
            /*-----------Brand wise discount updat-------------*/
       }

       /*--------------------------------------------------------*/
       
       else if($radio_btn_id == 3)
       {
            $radio_btn_name = 'subcategory';

            $brands = null;
            
            $items_dis = BulkAction_Discount::where(['category'=>$bdu_cat, 'subcategory'=>$bdu_sub_cat, 'brand'=>$brands, 'method'=>'Bulk_Discount'])->get();
            
            if(count($items_dis) !=0)
            {
                BulkAction_Discount::where(['category'=>$bdu_cat, 'subcategory'=>$bdu_sub_cat, 'brand'=>$brands])
                ->update([
                        'user_id' =>  Auth::id(),
                        'type'      =>  $radio_btn_name,
                        'category' =>  $bdu_cat,
                        'subcategory' =>  $bdu_sub_cat,
                        'brand'     =>  $bdu_brand,
                        'discount_type' =>  $bdu_type,
                        'discount_value' =>  $bdu_value,
                        'date_time' =>  date('Y-m-d H:i:s')
                    ]);
            }    
            else
            {

               $model = new BulkAction_Discount;

               //$user_id     = Auth::user()->name;
               $model->user_id     = Auth::id();
               $model->method      = "Bulk_Discount";
               $model->type         = $radio_btn_name;
               $model->category     = $bdu_cat;
               $model->subcategory  = $bdu_sub_cat;
               $model->brand          = $bdu_brand;
               $model->discount_type   = $bdu_type;
               $model->discount_value    = $bdu_value;
               $model->date_time    = date('Y-m-d H:i:s');
               $model->save();

            }

            /*-----------Subcategory wise discount updat-------------*/
            $Items = Item::where(['category'=>$bdu_cat, 'subcategory'=>$bdu_sub_cat])
                          ->where('unit_price', '!=','0')
                          ->get();
            foreach($Items as $item_data ) 
            {
                $itemid = $item_data->id;

                Item_Discount::where('item_id', $itemid)
                  ->update([
                        $bdu_type      =>  $bdu_value
                    ]);
            }
            /*-----------Subcategory wise discount updat-------------*/
       }

       /*$cat = MciCategory::where('id', $bdu_cat)->first();
       $bdu_cat_name = $cat['category_name'];
       $sub_cat = MciSubCategory::where('id', $bdu_sub_cat)->first();
       $bdu_sub_cat_name = $sub_cat['sub_categories_name'];
       $brand = MciBrand::where('id', $bdu_brand)->first();
       $bdu_brand_name = $brand['brand_name'];
       */

      
   }

   /*======================================================================*/

    public function createOffer(Request $request)
    {
      $cat = $request->offer_cat; 
      $sub_cat = $request->offer_sub_cat;
      $offer_type = $request->offer_type;
      //dd($cat, $offer_type);

      $data = BulkAction_Discount::where('category',$cat)
              ->where('subcategory',$sub_cat)
              ->get();
            
            if(count($data) !=0)
            {
                BulkAction_Discount::where(['category'=>$cat])
                ->update([
                        'user_id' =>  Auth::id(),
                        'type'   =>  "category",
                        'method' =>  "Offer",
                        'category' =>  $cat,
                        'subcategory' =>  $sub_cat,
                        'status' =>  $offer_type,
                        'date_time' =>  date('Y-m-d H:i:s')
                    ]);
            }    
            else
            {

               $model = new BulkAction_Discount;

               //$user_id     = Auth::user()->name;
               $model->user_id     = Auth::id();
               $model->method      = "Offer";
               $model->type         = "category";
               $model->category     = $cat;
               $model->subcategory  = $sub_cat;
               $model->status       = $offer_type;
               $model->date_time    = date('Y-m-d H:i:s');
               $model->save();

            }

        $data = Item_Discount::whereIn('item_id', function($q) use ($cat, $sub_cat)
							{
						   $q->from('items')
						   	 ->select('id')
						    ->where('category', $cat)						   
                ->where('subcategory', $sub_cat);               
						})->update([
                  'offer_status' =>   $offer_type
              ]);
    }

/* ======================================================================= */

	public function deleteOffer(Request $request)
    {
        $offer_id = $request->offer_id; 
        $offer_status = '0';
        $cat = BulkAction_Discount::where(['id'=>$offer_id])->select('category','subcategory')->first();
        
        //$c = $cat->category;
        $data = Item_Discount::whereIn('item_id', function($q) use ($cat)
				{
				   $q->from('items')
				   	 ->select('id')
				    ->where('category', $cat->category)						   
            ->where('subcategory', $cat->subcategory);               
				})->update([
          				'offer_status' =>  $offer_status
      				]);

		if($data == true)
		{
			$cat = BulkAction_Discount::where(['id'=>$offer_id])->delete();
		}
    }

/* ======================================================================= */


    public function GettBulkActionSubCatData(Request $request)
    {
        $sub_cat = MciSubCategory::where('parent_id', $request->cat_id)->pluck('id', 'sub_categories_name');
        
        //dd($sub_cat);
        return response()->json($sub_cat);
    }

/* ======================================================================= */
    public function GetBulkActionData(Request $request)
    {
        $category = $request->cat_id;
        if($category == "Bulk_HSN")
        {
            $items  =  BulkAction_HSN::where('method', $category)->get();
            if(!empty($items))
            {
                $table = '<table id="extras_sublist" class="table table-hover" style="width: 100%;" role="grid" aria-describedby="cashier_list_info">
                      <thead>
                         <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Method</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>HSN</th>
                            <th>Tax</th>
                            <th>Time and date</th>
                         </tr>
                      </thead>
                      <tbody>';
                if(!empty($items)){
                    foreach ($items as $val) {
                        $cat = MciCategory::where('id', $val->category)->first();
                        $cat_name = $cat['category_name'];

                        $sub_cat = MciSubCategory::where('id', $val->subcategory)->first();
                        $sub_cat_name = $sub_cat['sub_categories_name'];
                        $table .= '<tr>
                            <td>'.$val->id.'</td>
                            <td>'.$val->user_id.'</td>
                            <td>'.$val->method.'</td>
                            <td>'.$cat_name.'</td>
                            <td>'.$sub_cat_name.'</td>
                            <td>'.$val->hsn.'</td>
                            <td>'.$val->input_tax.'</td>
                            <td>'.$val->date_time.'</td>
                        </tr>';
                    }
                }

                $table .= '</tbody>
                       </table>';
                return $table;
            
            }
        }
        else if($category == "Bulk_Discount")
        {
            $items  =  BulkAction_Discount::where('method', $category)->get();
            if(!empty($items))
            {
                $table = '<table id="extras_sublist" class="table table-hover" style="width: 100%;" role="grid" aria-describedby="cashier_list_info">
                      <thead>
                         <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Method</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Brand</th>
                            <th>Discount type</th>
                            <th>Discount</th>
                            <th>Time and date</th>
                         </tr>
                      </thead>
                      <tbody>';
                if(!empty($items)){
                    foreach ($items as $val) {
                        $cat = MciCategory::where('id', $val->category)->first();
                        $cat_name = $cat['category_name'];

                        $sub_cat = MciSubCategory::where('id', $val->subcategory)->first();
                        $sub_cat_name = $sub_cat['sub_categories_name'];

                        $cat = MciBrand::where('id', $val->brand)->first();
                        $brand_name = $cat['brand_name'];
                        $table .= '<tr>
                            <td>'.$val->id.'</td>
                            <td>'.$val->user_id.'</td>
                            <td>'.$val->method.'</td>
                            <td>'.$val->type.'</td>
                            <td>'.$cat_name.'</td>
                            <td>'.$sub_cat_name.'</td>
                            <td>'.$brand_name.'</td>
                            <td>'.$val->discount_type.'</td>
                            <td>'.$val->discount_value.'</td>
                            <td>'.$val->date_time.'</td>
                        </tr>';
                    }
                }

                $table .= '</tbody>
                       </table>';
                return $table;
            
            }
        }

        else if($category == "Offer")
        {
            $items  =  BulkAction_Discount::where('method', $category)->get();

            if(!empty($items))
            {
                $table = '<table id="extras_sublist" class="table table-hover" style="width: 100%;" role="grid" aria-describedby="cashier_list_info">
                      <thead>
                         <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Method</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Time and date</th>
                            <th>Status</th>
                            <th>Action</th>
                         </tr>
                      </thead>
                      <tbody>';
                if(!empty($items)){
                    foreach ($items as $val) {
                        $cat = MciCategory::where('id', $val->category)->first();

                        $subcat = MciSubCategory::where('id', $val->subcategory)->first();
                                              
                        $cat_name = $cat['category_name'];                   
                       
                        $table .= '<tr>
                            <td>'.$val->id.'</td>
                            <td>'.$val->user_id.'</td>
                            <td>'.$val->method.'</td>
                            <td>'.$val->type.'</td>
                            <td>'.$cat->category_name.'</td>
                            <td>'.$subcat->sub_categories_name.'</td>
                            <td>'.$val->date_time.'</td>
                            <td> Buy one get '.$val->status.' free</td>
                            <td> <a onclick="offerDelete('.$val->id.')" title="remove"><span class="glyphicon glyphicon-trash"></span></a></td>
                            </tr>';
                    }
                }

                $table .= '</tbody>
                       </table>';
                return $table;
            
            }
        }
        
    }
}
