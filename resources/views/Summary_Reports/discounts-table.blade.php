@extends('layouts.dbf')

@section('content')

<div class="container">
	<div id="page_title">Discount Summery Report</div><br>
	<div style="font-size: 20px"><b>Time Duration - </b> {{$date['to']}} To {{$date['from']}}</div>
	@if(isset($discounts) == true)
		<div class="row" id="catsTable">
	    <div class="col-md-12 col-xl-12">
	      <div class="card shadow-xs">
	        <div class="card-body table-responsive">
	          <table class="table table-striped table-hover" id="DiscountTable">
	            <thead>
	              <tr class="text-center">
	                <th style="text-align:center">Discount</th>
	                <th style="text-align:center">Quantity</th>
	                <th style="text-align:center">Subtotal</th>
	                <th style="text-align:center">Tax</th>
	                <th style="text-align:center">Total</th>
	                <th style="text-align:center">Wholesale</th>
	                <th style="text-align:center">Profit</th>
	              </tr>
	            </thead>
	            <tbody>
	          	{{--
		          	if('item_unit_price' != 0.00){
		                $dis_value = ($values['item_unit_price']*$values['discount_percent'])/100;
		                $gross_value = $values['item_unit_price'] - $dis_value;
		            }else{
		                $gross_value = $values['discount_percent'];
		            }
					$tax_rate = $values['taxe_rate'];
					$tax_amt = ($gross_value*$tax_rate)/(100+$tax_rate);
					$subtotal = $gross_value - $tax_amt;
				--}}
				@php
					//dd($discounts);
					$sum_tax = $sum_total = $sum_subtotal = $sum_quantity = $add_quantity = 0;

		           	foreach($discounts as $discount){

		           		$subtotal = $tax = $total = $add_quantity = 0;
	          	@endphp
	            <tr class="text-center">
	            	{{-- @if($discount->item_unit_price != '0.00') --}}
	                <td>{{$discount->discount_percent}}</td>
	                <td class="quantityTotal">{{discountShow($discount->discount_percent, $location_id, 'quantity')['quantity']}}</td>
	                {{-- @php
	                	foreach($customer['sales'] as $subtotal_index ){

	                		if($subtotal_index['item_unit_price'] != 0.00){

	                			#Gross Value after subtracting discount ONLY
								$gross_value = $subtotal_index['item_unit_price'] - ($subtotal_index['item_unit_price']*$subtotal_index['discount_percent'])/100;

								#TOTAL Amount based on quantity purchased
								$total += $subtotal_index['quantity_purchased'] * $gross_value ;

								$tax += ($total * $subtotal_index['taxe_rate'])/100;

							}else{

								$gross_value = $subtotal_index['discount_percent'];
								$total += $subtotal_index['quantity_purchased'] * $gross_value ;

								$tax += ($total * $subtotal_index['taxe_rate'])/100;
							}
	                	}
	                @endphp --}}
	   <td>₹ {{number_format(discountShow($discount->discount_percent, $location_id, 'subtotal')['amount'], 2)}}{{-- {{number_format($total - $tax, 2)}} --}}</td>               
	                <td>₹ {{number_format(discountShow($discount->discount_percent, $location_id, 'subtotal')['tax'], 2)}}</td>
	                <td>₹ {{number_format(discountShow($discount->discount_percent, $location_id, 'subtotal')['total'], 2)}}</td>
	                <td>₹ 0</td>
	                <td>₹ {{number_format(discountShow($discount->discount_percent, $location_id, 'subtotal')['amount'], 2)}}</td>
	                @php

						$sum_quantity += discountShow($discount->discount_percent, $location_id, 'quantity')['quantity'];
						$sum_subtotal += discountShow($discount->discount_percent, $location_id, 'subtotal')['amount'];
	                	$sum_tax	  += discountShow($discount->discount_percent, $location_id, 'subtotal')['tax'];
	                	$sum_total 	  += discountShow($discount->discount_percent, $location_id, 'subtotal')['total'];

	                @endphp
	           	{{-- @endif --}}
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
		                <th style="text-align:center">{{number_format($sum_quantity, 2)}}</th>
		                <th style="text-align:center">₹ {{number_format($sum_subtotal, 2)}}</th>
		                <th style="text-align:center">₹ {{number_format($sum_tax, 2)}}</th>
		                <th style="text-align:center">₹ {{number_format($sum_total, 2)}}</th>
		                <th style="text-align:center">0</th>
		                <th style="text-align:center">₹ {{number_format($sum_subtotal, 2)}}</th>
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
		
		$('#DiscountTable').dataTable({
			order: [[1, 'asc']],
			"columnDefs": [
			{'orderable': false, "target": 0}
			]
		});

	});


</script>
@endsection
