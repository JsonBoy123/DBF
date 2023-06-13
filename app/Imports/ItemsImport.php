<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use App\Models\Item\Item;
// use App\Models\Item\items_taxes;
// use App\Models\Manager\MciCategory;
// use App\Models\Manager\MciBrand;
// use App\Models\Manager\MciSize;
// use App\Models\Manager\MciColor;
// use App\Models\Manager\MciSubCategory;
// use App\Models\Office\Shop\Shop;
// use DB;

class ItemsImport implements ToCollection,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   public function collection(Collection $rows)
   {  
   	
   		// foreach ($rows as $items) {
   		// 	$category_id = MciCategory::where('category_name', $items['category'])->first();
   		// 	if(!empty($category_id)){
   		// 		$subcategory_id = MciSubCategory::where('sub_categories_name', $items['subcategory'])
   		// 											->where('parent_id', $category_id->id)
   		// 											->first();
   		// 		if(!empty($subcategory_id)){
					// $brand_id = MciBrand::where('brand_name', $items['brand'])->first();
					// if(!empty($brand_id)){
					// 	$size_id = MciSize::where('sizes_name', $items['size'])->first();
					// 	if(!empty($size_id)){
					// 		$color_id = MciColor::where('color_name', $items['color'])->first();
					// 		if(!empty($color_id)){
					// 			$item_name = item::where('name',$items['item_name'])
					// 								->where('category',$category_id->id)
					// 								->where('subcategory',$subcategory_id->id)
					// 								->where('brand',$brand_id->id)
					// 								->first();
					// 			if(!empty($item_name)){
					// 				$error = "Item already exists";
					// 			}else{
					// 				$price_type = 'fixed';
					// 		        if($items['retail_price'] == "0.00"){
					// 		            $price_type = "discounted";
					// 		        }

					// 		        $discounts = array(
					// 		            'retail' => $items['retail_discount'].".00",
					// 		            'wholesale' => $items['wholesale_discount'].".00",
					// 		            'franchise' => $items['franchise_discount'].".00",
					// 		            'special' => $items['special_discount'].".00",
					// 		        );

					// 		        $autoId = DB::select(DB::raw("SELECT nextval('items_id_seq')"));
					// 		        $nextval = $autoId[0]->nextval;

					// 		        $item_number = str_pad($category_id->id, 2, '0', STR_PAD_LEFT).str_pad($subcategory_id->id, 3, '0', STR_PAD_LEFT).str_pad($brand_id->id, 4, '0', STR_PAD_LEFT).str_pad($nextval, 6, '0', STR_PAD_LEFT);

					// 		        $arr = array(
					// 		            'item_number'   	=>   $item_number,
					// 		            'name'              =>   $items['item_name'],
					// 		            'category'          =>   $category_id->id,
					// 		            'subcategory'       =>   $subcategory_id->id,
					// 		            'brand'             =>   $brand_id->id,
					// 		            'size'              =>   is_null($items['size']) ? 0 : $size_id->id,
					// 		            'color'             =>   is_null($items['color']) ? 0 : $color_id->id,
					// 		            'model'             =>   $items['model'],
					// 		            'unit_price'        =>   $items['retail_price'],
					// 		            'receiving_quantity'=>   $items['receiving_quantity'],
					// 		            'reorder_level'     =>   $items['reorder_level'],
					// 		            'description'       =>   $items['description'],
					// 		            'hsn_no'            =>   $items['hsn_code'],
					// 		            // 'custom5'           =>   date('d-m-Y',strtotime($items['expiry_date'])),
					// 		            'custom6'           =>   $items['stock_edition'],
					// 		            'price_type'        =>   $price_type,
					// 		            'discounts'         =>   json_encode($discounts)
					// 		        );  

					// 		        $item_data = Item::create($arr);
					// 		        $LastId = $item_data->id;
					// 		        if($LastId){
					// 		        	$tax_names = ['CGST', 'SGST', 'IGST'];
					// 		        	$tax_percents = [$items['tax_1'], $items['tax_2'], $items['tax_3']];
					// 		            $count = count($tax_names);
					// 		            if($count != 0){
					// 		                $x = 0;
					// 		                $data = array();
					// 		                while($x < $count){
					// 		                    if($tax_names[$x] !=''){
					// 		                        $taxes = array(
					// 		                            'item_id' => $LastId,
					// 		                            'name' => $tax_names[$x],
					// 		                            'percent' => $tax_percents[$x]
					// 		                        );
					// 		                        $data[] = $taxes;
					// 		                    }
					// 		                    $x++;
					// 		                }
					// 		            }
					// 		            foreach ($data as $datas) {
					// 		                items_taxes::create($datas);
					// 		                return "Item Added";
					// 		            }
					// 				}
		 		// 				}
		 		// 			}else{
		 		// 				return "Color Name is not valid";
		 		// 			}
		 		// 		}else{
	 			// 			return "Size Name is not valid";
	 			// 		}
   		// 			}else{
   		// 				return "Brand Name is not valid";
   		// 			}
   		// 		}else{
   		// 			return "Subcategory Name is not valid";
   		// 		}
   		// 	}else{
   		// 		return "Category Name is not valid";
   		// 	}

   		// 	// return $error;
   		// }
	}
}
