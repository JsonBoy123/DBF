@extends('layouts.dbf')

@section('content')

<div class="container">
	<div id="page_title">Category Summery Report</div><br>
	<div style="font-size: 20px"><b>Time Duration - </b> {{$date['to']}} To {{$date['from']}}</div>
	@if(isset($cats) == true)
		<div class="row" id="catsTable">
	    <div class="col-md-12 col-xl-12">
	      <div class="card shadow-xs">
	        <div class="card-body table-responsive">
	          <table class="table table-striped table-hover" id="CategoryTable">
	            <thead>
	              <tr class="text-center">
	                <th style="text-align:center">Category</th>
	                <th style="text-align:center">Quantity</th>
	                <th style="text-align:center">Subtotal</th>
	                <th style="text-align:center">Tax</th>
	                <th style="text-align:center">Total</th>
	                <th style="text-align:center">Wholesale</th>
	                <th style="text-align:center">Profit</th>
	              </tr>
	            </thead>
	            <tbody>
	          @php $count = 0;

	        /****************************/

	          	/*if('item_unit_price' != 0.00){
                    
                    $dis_value = ($values['item_unit_price']*$values['discount_percent'])/100;

                    $gross_value = $values['item_unit_price'] - $dis_value;

                }else{

                    $gross_value = $values['discount_percent'];
                }

				$tax_rate = $values['taxe_rate'];
				$tax_amt = ($gross_value*$tax_rate)/(100+$tax_rate);

				$subtotal = $gross_value - $tax_amt;
*/
				

			/****************************/
				$profit_sum = $total_sum = $gst_sum = $subtotal_sum = $quan_sum = 0;
	           	foreach($cats as $index){ 
	           		$quantity_total = $total = $total = $tax = 0;
	          @endphp
	              <tr class="text-center">
	                <td>{{$index->category_name}}</td>
	                @php
	                	foreach($index['saleItems'] as $index_quantity){
							$quantity_total += $index_quantity['quantity_purchased'];

							if($index_quantity['item_unit_price'] != 0.00){
								$gross_value = $index_quantity['item_unit_price'] - ($index_quantity['item_unit_price']*$index_quantity['discount_percent'])/100;

								$total += $index_quantity['quantity_purchased'] * $gross_value ;

								
								$tax += ($total * (int)$index_quantity['taxe_rate'])/100;

							}else{
								$total += $index_quantity['quantity_purchased'] * $index_quantity['discount_percent'] ;

								$tax += ($total * str_replace(' ', '', ($index_quantity['taxe_rate'])))/100;

								
							}
	                	}

	                @endphp
	                <td class="quantityTotal"> {{$quantity_total}}</td>
	               

	                <td>₹  {{number_format(($total - $tax),'2')}}</td>
	               
	               
	                <td>₹ {{number_format($tax, 2)}}</td>
	                
	                <td>₹ {{number_format($total, 2)}}</td>
	                <td>₹ 0</td>
	                <td>₹ {{number_format(($total - $tax), 2)}}</td>
	                @php 
	                	$quan_sum +=$quantity_total;
	                	$gst_sum +=$tax;
	                	$total_sum +=$total;
	                	$profit_sum += ($total - $tax) ;

	                 @endphp

	              </tr>

	            @php } @endphp
	            </tbody>
	          </table>

	         <table class="table table-bordered">
  				<tr class="text-center">
	                <th style="text-align:center"></th>
	                <th style="text-align:center">Quantity</th>
	                <th style="text-align:center">Subtotal</th>
	                <th style="text-align:center">Tax</th>
	                <th style="text-align:center">Total</th>
	                <th style="text-align:center">Wholesale</th>
	                <th style="text-align:center">Profit</th>
	            </tr>
				<tbody>
					<tr>
				    	<th style="text-align:center">TOTAL</th>
		                <th style="text-align:center">{{$quan_sum}}</th>
		                <th style="text-align:center">₹ {{number_format($profit_sum, 2)}}</th>
		                <th style="text-align:center">₹ {{number_format($gst_sum, 2)}}</th>
		                <th style="text-align:center">₹ {{number_format($total_sum, 2)}}</th>
		                <th style="text-align:center">0</th>
		                <th style="text-align:center">₹ {{number_format($profit_sum, 2)}}</th>
				    </tr>
				</tbody>
			</table>
	        </div>
	      </div>
	    </div>
  	</div>
  	@endif
</div>
<script>
	$(document).ready( function () {
		
		$('#CategoryTable').dataTable({
			order: [[1, 'asc']],
			"columnDefs": [
			{'orderable': false, "target": 0}
			]
		});

		/*$(window).bind('load', function(){

				$('.quantityTotal').each(function(){

				var sum +=  $(this).text();

				alert(sum)
			})	
		})*/
		

	});


</script>
@endsection
