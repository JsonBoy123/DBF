<?php

namespace App\Http\Controllers\Manager\ListAction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item\Item;
use App\Models\Item\items_taxes;
use App\Models\Manager\MciCategory;
use App\Models\Manager\MciBrand;
use App\Models\Manager\MciSize;
use App\Models\Manager\MciColor;
use App\Models\Manager\MciSubCategory;
use App\Models\Office\Shop\Shop;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ListActionExport;

class ListAction extends Controller
{ 
    public function index(){
    	$shop = Shop::get();
        //dd($shop);
        $category = MciCategory::get();
        $brand = MciBrand::get();
    	return view("manager.list_actions.index", compact("shop", "category", "brand"));
    }

    public function CSVDownload($id){
    	$shop = $id;
    	$date = date("d-m");
    	$file_name = 'DBF '.$shop.' POS'.$date.'.csv';
    	return Excel::download(new ListActionExport, $file_name);
    }

    public function GettListActionMCI(Request $request){
        $cid = $request->cat_id;
        return MciSubCategory::where("parent_id", $cid)->get();
    }

    public function GettListActionData(Request $request){
        // dd($request);
        $category = $request->category;
        $subcategory = $request->subcategory;
        $brand = $request->brand;
        
        if(!empty($category)){
            $items = Item::with(["ItemTax", "brandName", "categoryName", "subcategoryName", "sizeName", "colorName"])->where('category', $category)->get(); 
        }
        if(!empty($brand)){
            $items = Item::with(["ItemTax", "brandName", "categoryName", "subcategoryName", "sizeName", "colorName"])->where('brand', $brand)->get(); 
        }
        if(!empty($category) && !empty($subcategory)){
            $items = Item::with(["ItemTax", "brandName", "categoryName", "subcategoryName", "sizeName", "colorName"])
                    ->where('category', $category)
                    ->where('subcategory', $subcategory)
                    ->get(); 
        }
        if(!empty($category) && !empty($brand)){
            $items = Item::with(["ItemTax", "brandName", "categoryName", "subcategoryName", "sizeName", "colorName"])
                    ->where('category', $category)
                    ->where('brand', $brand)
                    ->get(); 
        }
        if(!empty($subcategory) && !empty($category) && !empty($brand)){
            $items = Item::with(["ItemTax", "brandName", "categoryName", "subcategoryName", "sizeName", "colorName"])
                    ->where('category', $category)
                    ->where('subcategory', $subcategory)
                    ->where('brand', $brand)
                    ->get(); 
        }

        $table = '<table id="extras_sublist" class="table table-hover" style="width: 100%;" role="grid" aria-describedby="cashier_list_info">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Barcode</th>
                        <th>Items Name</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Brand</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Expiry Date</th>
                        <th>Stock Edition</th>
                        <th>Model</th>
                        <th>MRP</th>
                        <th>HSN</th>
                        <th>CGST %</th>
                        <th>IGST %</th>
                        <th>GST %</th>
                        <th>Retail</th>
                        <th>Wholesale</th>
                        <th>Franchise</th>
                        <th>Special</th>
                     </tr>
                  </thead>
                  <tbody>';
        if(!empty($items)){
            foreach ($items as $val) {
                // dd($val);
                $table .= '<tr>
                    <td>'.$val->id.'</td>
                    <td>'.$val->item_number.'</td>
                    <td>'.$val->title.'</td>
                    <td>'.$val->categoryName['category_name'].'</td>
                    <td>'.$val->subcategoryName['sub_categories_name'].'</td>
                    <td>'.$val->brandName['brand_name'].'</td>
                    <td>'.$val->sizeName['sizes_name'].'</td>
                    <td>'.$val->colorName['color_name'].'</td>
                    <td>'.$val->custom5.'</td>
                    <td>'.$val->custom6.'</td>
                    <td>'.$val->model.'</td>
                    <td>'.$val->unit_price.'</td>
                    <td>'.$val->hsn_no.'</td>
                    <td>'.$val->ItemTax[0]->percent.'</td>
                    <td>'.$val->ItemTax[1]->percent.'</td>
                    <td>'.$val->ItemTax[2]->percent.'</td>
                    <td>'.json_decode($val->discounts)->retail.'</td>
                    <td>'.json_decode($val->discounts)->wholesale.'</td>
                    <td>'.json_decode($val->discounts)->franchise.'</td>
                    <td>'.json_decode($val->discounts)->special.'</td>
                </tr>';
            }
        }

        $table .= '</tbody>
               </table>';
        return $table;
    }
}
