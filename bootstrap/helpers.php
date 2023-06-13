<?php 

use App\Models\Sales\Sale;
use App\Models\Sales\SalesItem;
use App\Models\Office\Shop\Shop;
use NumberToWords\NumberToWords;
use App\Models\Item\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Manager\MciSubCategory;
use App\Models\Office\Employees\Employees;
use App\Models\Manager\ControlPanel\Cashier;
use App\Models\Manager\ManageItemRack;
use App\Models\Item\item_quantities;
use App\Models\Repair\RepairComplete;
//use DB;
if(!function_exists('get_shop_id_name')){
	function get_shop_id_name(){
		$emp = Employees::select('id')->where('user_id',Auth::user()->id)->first();
		// return $emp_id;
		return Shop::where('shop_owner_id',$emp->id)->select('name','id','inv_prefix','shop_owner_id')->first();

	}
}

if(!function_exists('get_shop_name')){
	function get_shop_name($id){
		return Shop::find($id);
	}
}

if(!function_exists('get_cashier_name')){
	function get_cashier_name($id){
		return Cashier::find($id);
	}
}


if(!function_exists('number_to_word')){
	function number_to_word($num){
		$numberToWords = new NumberToWords();
		$numberTransformer = $numberToWords->getNumberTransformer('en');
		return $numberTransformer->toWords($num);;
	}
}


if(!function_exists('all_shopes')){
	function all_shopes(){
		return Shop::all();
	}

	}

if(!function_exists('get_subcategory')){

	function get_subcategory($id){

		$data = MciSubCategory::where('parent_id',$id)->get(); ?>
		<option value="">...Select...</option>

		<?php 	foreach ($data as $Data) { ?>
				<option value="<?php echo $Data->id; ?>"><?php echo $Data->sub_categories_name ;?></option>
		<?php 	}

		}
 }

 if(!function_exists('discountShow')){

	function discountShow($percent, $loc_id, $type){

		if($type == 'quantity'){

			$data['quantity'] = SalesItem::with(['sale'=>function($q) use($loc_id){
				$q->where('employee_id',$loc_id);
			}])
				->where('discount_percent', $percent)
				->sum('quantity_purchased');

			return $data;

		}else if($type == 'subtotal'){

			$loc_id = $loc_id == 'all' ? null : $loc_id;

			$data = SalesItem::with(['sale'=>function($q) use($loc_id){
				$q->where('employee_id',$loc_id);
			}])
				->orWhere('discount_percent', $percent)
				->get();

			$total = $tax = 0;
			foreach($data as $index){

				if($index['item_unit_price'] != 0.00){

					#Gross Value after subtracting discount ONLY
					$gross_value = $index['item_unit_price'] - ($index['item_unit_price']*$index['discount_percent'])/100;

					#TOTAL Amount based on quantity purchased
					$total += $index['quantity_purchased'] * $gross_value ;

					$tax += ($total * (float)$index['taxe_rate'])/((float)$index['taxe_rate']+100);

				}else{

					$gross_value = $index['discount_percent'];
					$total += $index['quantity_purchased'] * $gross_value ;

					$tax += ($total * (float)$index['taxe_rate'])/((float)$index['taxe_rate']+100);
				}

			}

			$subtotal['amount'] = $total - $tax;
			$subtotal['tax'] 	= $tax;
			$subtotal['total'] 	= $total;

			return $subtotal;

		}					
	}
}

	if(!function_exists('shopShow')){
		
		function shopShow($daterange, $employee, $type){

			$date = explode(' ', $daterange);
	        $date['to']   = date('Y-m-d', strtotime($date[0]));
	        $date['from'] = date('Y-m-d', strtotime($date[2]));
			
			//return $employee;

			$sale_ids = [];
			$sub = [];

			if($type == 'quantity'){
				// return 1;

				// $query = 'SUM(quantity_purchased) AS quantity';      

	        	$sales = Sale::withCount(['sale_items as sumsales_item' => function($q) {
	        				$q->select(DB::raw('SUM(quantity_purchased) AS quantity'));
	        			}])
	        			->where('employee_id', $employee->employee_id)
			         	->whereBetween('sale_time', [$date['to'], $date['from']])
			         	->get()
			         	->sum('sumsales_item');

				return $sales;

			}else if($type == 'subtotal'){
				$id = $employee->employee_id;

 					$data = SalesItem::whereHas('sale',function($q) use($id){
							$q->where('employee_id',$id);                        	
				})
							->whereDate('created_at', '<=', $date['from'])
                        	->whereDate('created_at', '>=', $date['to'])
							->get();

				$total = $tax = 0;
				foreach($data as $index_data){

					if($index_data['item_unit_price'] != 0.00){

                        #Gross Value after subtracting discount ONLY
                        $gross_value = $index_data['item_unit_price'] - ($index_data['item_unit_price']*$index_data['discount_percent'])/100;
                        

                        #TOTAL Amount based on quantity purchased
                        $total += $index_data['quantity_purchased'] * $gross_value ;

                        $tax += ( ($gross_value * $index_data['quantity_purchased']) * $index_data['taxe_rate'])/($index_data['taxe_rate']+100);

                    }else{

                        $gross_value = $index_data['discount_percent'];
                        $total += $index_data['quantity_purchased'] * $gross_value ;

                        $tax += (($index_data['quantity_purchased'] * $gross_value) * $index_data['taxe_rate'])/($index_data['taxe_rate']+100);
                    }

				}
					//$subtotal['amount'] = $total > $tax ? ($total - $tax) : ($tax - $total);
					$sub['amount'] = number_format(($total - $tax),2);
					$sub['tax'] 	= number_format($tax,2);
					$sub['total'] 	= number_format($total,2);

					return $sub;
			}
		}
	}

	if(!function_exists('total')){

		function total($daterange, $employee, $type='',$flag=''){

			$date = explode(' ', $daterange);
	        $date['to']   = $flag !='transactions' ? date('Y-m-d', strtotime($date[0])):$type;
	        $date['from'] = $flag !='transactions' ? date('Y-m-d', strtotime($date[2])):$type;

			$id = $flag == 'employee' ? $type:$employee;
			
			$query['employee_id'] = $id ;
			if($flag == 'customer'){
				$query['customer_id'] = $type;
			}

				// $data = SalesItem::with(['sale']
				// 		->whereDate('created_at', '<=', $date['from'])							
    //                		->whereDate('created_at', '>=', $date['to']);
			

			if($id == 'all'){
            	$data = SalesItem::whereHas('sale',function($q) use($flag,$type){
            			if($flag == 'customer'){
            				$q->where('customer_id',$type);
            			}	
            	})
            			->whereDate('created_at', '<=', $date['from'])							
                   		->whereDate('created_at', '>=', $date['to']);	
            }
            if($id != 'all'){
 				$data = SalesItem::whereHas('sale',function($q) use($id,$query){
 						$q->where($query);
				})
						->whereDate('created_at', '<=', $date['from'])							
                   		->whereDate('created_at', '>=', $date['to']);

            }								
			
            
            if($flag =='item'){
            	$data->where('item_id',$type);
            } 
            if($flag =='category'){
            	// dd($type);
            	$data->where('category_id',$type);
            	// return 'sfsdf';
            }  

            if($flag == 'taxe'){
      			$data->where('taxe_rate',$type);      			
            }
            if($flag == 'discount'){
      			$data->where('discount_percent',$type);      			
            }
            // dd($data->get());
				$total = 0;
				foreach($data->get() as $index_data){

					if($index_data['item_unit_price'] != 0.00){

                        
                        #Gross Value after subtracting discount ONLY
                        $gross_value = $index_data['item_unit_price'] - ($index_data['item_unit_price']*$index_data['discount_percent'])/100;


                        #TOTAL Amount based on quantity purchased
                        $total += $index_data['quantity_purchased'] * $gross_value ;
                    	// dd($total);

                        // $tax += ( ($gross_value * $index_data['quantity_purchased']) * $index_data['taxe_rate'])/($index_data['taxe_rate']+100);

                    }else{
                        $gross_value = $index_data['discount_percent'];
                        $total += $index_data['quantity_purchased'] * $gross_value ;
                        // dd($total);

                        // $tax += (($index_data['quantity_purchased'] * $gross_value) * $index_data['taxe_rate'])/($index_data['taxe_rate']+100);
                        // dd($index_data['quantity_purchased'] * $gross_value);
                    }

				} return  ($total); 
			}

	}

	if(!function_exists('tax')){

		function tax($daterange, $employee, $type='',$flag=''){
			// return $flag;

			$date = explode(' ', $daterange);
	        $date['to']   = $flag !='transactions' ? date('Y-m-d', strtotime($date[0])):date('Y-m-d', strtotime($type));
	        $date['from'] = $flag !='transactions' ? date('Y-m-d', strtotime($date[2])):date('Y-m-d', strtotime($type));

	       $id = $employee;
			// dd($date['to']);
            // dd($employee);   		
            if($employee == 'all'){
            	$data = SalesItem::whereHas('sale')
            			->whereDate('created_at', '<=', $date['from'])							
                   		->whereDate('created_at', '>=', $date['to']);	
            }
            if($employee != 'all'){
			
 				$data = SalesItem::whereHas('sale',function($q) use($id){
						$q->where('employee_id',$id);                        	
				})
						->whereDate('created_at', '<=', $date['from'])							
                   		->whereDate('created_at', '>=', $date['to']);
            }
			
      		
      		if($flag == 'item'){
      			$data->where('item_id',$type);      			
            }  
            if($flag == 'taxe'){
      			$data->where('taxe_rate',$type);      			
            }
            if($flag == 'discount'){
      			$data->where('discount_percent',$type);      			
            }  		
			// dd($data->get());

				$tax = 0;
				foreach($data->get() as $index_data){

					if($index_data['item_unit_price'] != 0.00){
						// dd($index_data);
                        #Gross Value after subtracting discount ONLY
                        $gross_value = $index_data['item_unit_price'] - ($index_data['item_unit_price'] * $index_data['discount_percent']) / 100;
                        

                        #TOTAL Amount based on quantity purchased
                        // $total += $index_data['quantity_purchased'] * $gross_value ;

                        $tax += ( ($gross_value * $index_data['quantity_purchased']) * (float)$index_data['taxe_rate'])/((float)$index_data['taxe_rate']+100);
                        // dd($tax); 

                    }else{

                        // dd($index_data);
                        $gross_value = $index_data['discount_percent'];
                        // $total += $index_data['quantity_purchased'] * $gross_value ;

                        $tax += (($index_data['quantity_purchased'] * $gross_value) * (float)$index_data['taxe_rate'])/((float)$index_data['taxe_rate']+100);
                    }

				}
				return ($tax);
		}

	}

	if(!function_exists('paymentShow')){

		function paymentShow($date){

				// $data = SalesItem::with(['sale']
				// 		->whereDate('created_at', '<=', $date['from'])							
    //                		->whereDate('created_at', '>=', $date['to']);
			

			if($employee == 'all'){
            	$data = SalesItem::whereHas('sale')
            			->whereDate('created_at', '<=', $date['from'])							
                   		->whereDate('created_at', '>=', $date['to']);	
            }
            if($employee != 'all'){
			
 				$data = SalesItem::whereHas('sale',function($q) use($id){
						$q->where('employee_id',$id);                        	
				})
						->whereDate('created_at', '<=', $date['from'])							
                   		->whereDate('created_at', '>=', $date['to']);
            }

									
			
            
            if($flag =='item'){
            	$data->where('item_id',$type);
            } 
            if($flag =='category'){
            	// dd($type);
            	$data->where('category_id',$type);
            	// return 'sfsdf';
            }       	
				// dd($data->get());

				$total = 0;
				foreach($data->get() as $index_data){

					if($index_data['item_unit_price'] != 0.00){

                        
                        #Gross Value after subtracting discount ONLY
                        $gross_value = $index_data['item_unit_price'] - ($index_data['item_unit_price']*$index_data['discount_percent'])/100;


                        #TOTAL Amount based on quantity purchased
                        $total += $index_data['quantity_purchased'] * $gross_value ;
                    	// dd($total);

                        // $tax += ( ($gross_value * $index_data['quantity_purchased']) * $index_data['taxe_rate'])/($index_data['taxe_rate']+100);

                    }else{
                        $gross_value = $index_data['discount_percent'];
                        $total += $index_data['quantity_purchased'] * $gross_value ;
                        // dd($total);

                        // $tax += (($index_data['quantity_purchased'] * $gross_value) * $index_data['taxe_rate'])/($index_data['taxe_rate']+100);
                        // dd($index_data['quantity_purchased'] * $gross_value);
                    }

				} return  ($total); 
			}

	}

	if(!function_exists('totalNumberOfItem')){

		function totalNumberOfItem($item_id,$rack_id){
			// return $rack_id;
			$data = ManageItemRack::where('item_id',$item_id)
									->where('rack_id',$rack_id)
									->sum('quantity');
			return $data;						
		}
	}

	if(!function_exists('itemQuantity')){

		function itemQuantity($item_id,$location_id){
			// return $rack_id;
			$data = item_quantities::where('item_id',$item_id)
									->where('location_id',$location_id)
									->select('quantity')->first();
			//dd($data->quantity);
			return $data;						
		}
	}

	if(!function_exists('getItem')){

		function getItem($item_id){
			// return $rack_id;
			$data = Item::where('id',$item_id)->first();
			//dd($data->quantity);
			return $data;						
		}
	}

	if(!function_exists('stockRequest')){
		function stockRequest($shop_id, $string){

			if($string == 'shop_name'){

				$data = Shop::where('id', $shop_id)
							->select('id', 'name')
							->first();
			}

			return $data;

		}
	}

	if(!function_exists('RepairItems')){
		function RepairItems($rec_id,$item_id){
			return RepairComplete::where(['rec_id'=>$rec_id,'item_id'=>$item_id])->first();
		}
	}


?>