<?php

namespace App\Http\Controllers\Manager\Extras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item\Item;

class Extras extends Controller
{
    public function index(){
    	return view("manager.extras.index");
    }

    public function QuickConvert(Request $request){
    	$quick = $request->quick;
    	$table = '<table id="extras_sublist" class="table table-hover" style="width: 100%;" role="grid" aria-describedby="cashier_list_info">
		          <thead>
		             <tr>
		                <th>Barcode</th>
		             </tr>
		          </thead>
		          <tbody>';
    	if($quick == 'active_items'){
    		$items = Item::where('deleted', '=', '0')->get();
    		foreach ($items as $val) {
    			$table .= '<tr>
	                <td>'.$val->item_number.'</td>
	            </tr>';
    		}
    	}
    	if($quick == 'deleted_items'){
    		$items = Item::where('deleted', '!=', '0')->get();
    		foreach ($items as $val) {
    			$table .= '<tr>
	                <td>'.$val->item_number.'</td>
	            </tr>';
    		}
    	}
    	$table .= '</tbody>
		       </table>';
    	return $table;
    }
}
