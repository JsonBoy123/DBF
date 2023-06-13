@if(session('item'))

<?php 
	$ItemTax = 0;
	$totalAmount = 0;	
	session()->put('totalAmount',$totalAmount);
	$count = 0;

	foreach(session('item') as $id => $sales){ 
       
		$tot_qty = $sales['total_qty'] - $sales['quantity']

?>
	<tr id="id">
		<td>
	      <form action="{{ route('sales.destroy',$id) }}" method="POST">
	        @csrf
	        @method('DELETE')
	        <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
	      </form>
		</td>
		<td id="item_number" class="{{$tot_qty >=0 ? '' :'text-danger'}}">{{ $sales['item_number'] }}</td>
		
		<td class="{{$tot_qty >=0 ? '' :'text-danger'}}">{{ $sales['name'] }}<br><span>[instock: {{$tot_qty >=0 ? $tot_qty :'out of stock'}} ]</span></td>
		<td>{{ (float)$sales['unit_price'] != 00 ? $sales['unit_price'] :$sales['fixed_sp']}}</td>
		<td class="{{$tot_qty >=0 ? '' :'text-danger'}}">
			<input id="chngQty{{ $id }}" type="number" value="{{ $sales['quantity'] }}" style="width:50px" onchange="myFunction({{ $id }},{{$sales['total_qty']}})" >
			<input type="hidden" name="salesItems_id" id="salesItems_id" value="{{ $id }}">
			<img src="https://konferencja.jemi.edu.pl/application-form/web/img/loader.gif" id="loading{{ $id }}" width="30px" class="load-cls" />
		</td> 

		<!-- <td>{{$discount = $sales['discounts'] }}</td>  -->
		@if(auth()->user()->can('edit'))
			<td class="{{$tot_qty >=0 ? '' :'text-danger'}}"><input id="Disco{{$id}}" onchange = 'UpdateDiscount({{ $id }})' type="number" value="<?php if( (float)$sales['unit_price'] != 00 && $sales['discounts'] != 0) 
										{
										   echo $sales['discounts'];
										}else{
											echo $sales['discounts'] !=0 ? $sales['discounts']: '0' ;
										} 
									?>" name=""></td>		
		@else		
		<td class="{{$tot_qty >=0 ? '' :'text-danger'}}">{{ (float)$sales['unit_price'] == 00 ? $sales['discounts']:$sales['unit_price']}}

		</td>
		@endif 

		<td class="{{$tot_qty >=0 ? '' :'text-danger'}}">
			<?php 
				
				if((float)$sales['unit_price'] != 00){									
					
				$totAmt = (float)($sales['unit_price'] - (float)( ($sales['unit_price'] / 100 ) * (float)$discount) ) * $sales['quantity']; 	
				
				 $totalAmount += (float)$totAmt;	
				 $count++;				 

				}
				else
				{
				 
					$amt = (float)($sales['fixed_sp'] - (float)( ($sales['fixed_sp'] / 100 ) * (float)$discount) ) * $sales['quantity'];
					//$amt = (float)$sales['fixed_sp'] * $sales['quantity'];

					$totAmt = (float)$amt;
										
				 	$totalAmount += (float)$totAmt;

				}

				$tot = (float)$sales['unit_price']== 00 ? (float)$sales['fixed_sp']: (float)$sales['unit_price'] - (float)( ($sales['unit_price'] / 100 ) * (float)$discount) ;
				echo (float)$totAmt;
									

			?>
		</td>
	</tr>

<?php } 

session()->put('totalAmount', $totalAmount);

?>
@else
	<tr>
		<td colspan="8">
			<div class="alert alert-dismissible alert-info">There are no Items in the cart.</div>
		</td>
	</tr>
@endif

