@extends('layouts.dbf')

@section('content')

<div class="container">
	<div id="page_title">Transaction Summery Report</div><br>
	<div style="font-size: 20px"><b>Time Duration - </b> {{$date['to']}} To {{$date['from']}}</div>
	@if(isset($payments) == true)
		<div class="row" id="catsTable">
	    <div class="col-md-12 col-xl-12">
	      <div class="card shadow-xs">
	        <div class="card-body table-responsive">
	          <table class="table table-striped table-hover" id="PaymentTable">
	            <thead>
	              <tr class="text-center">
	                <th style="text-align:center">Date</th>
	                <th style="text-align:center">Quantity </th>
	                <th style="text-align:center">Subtotal </th>
	                <th style="text-align:center">Tax </th>
	                <th style="text-align:center">Total </th>
	                <th style="text-align:center">Wholesale </th>
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
					$sum_subtotal = $sum_quantity =  $sum_tax = $sum_total = 0;

		           	foreach($payments as $payment){
		           		// dd($payment);
		           		$tax = tax($daterange, $location, $payment->created_at ,'transactions');
                        $total = total($daterange, $location, $payment->created_at ,'transactions');

	          	@endphp
	            <tr class="text-center">
	                <td>{{date('Y-m-d',strtotime($payment->created_at))}}</td>	                
	                <td> {{$payment->count}}</td>
	                <td>₹ {{number_format($total-$tax,2)}} </td>
	                <td>₹ {{number_format($tax, 2)}}</td>
                    <td>₹ {{number_format($total, 2)}}</td>
                    <td>₹ 0</td>
                    <td>₹ {{number_format($total - $tax, 2)}}</td>
	                @php

	                	$sum_quantity += $payment->count;	                	
	                	$sum_subtotal += $total - $tax ;
	                	$sum_tax      += $tax;
                        $sum_total    += $total;

	                @endphp

	              </tr>

	            @php } @endphp
	            </tbody>
	          	</table>

	         	<table class="table table-bordered">
  				<tr class="text-center">
	                <th style="text-align:center"></th>
	                <th style="text-align:center">Quantity</th>
	                 <th style="text-align:center">Subtotal </th>
	                <th style="text-align:center">Tax </th>
	                <th style="text-align:center">Total </th>
	                <th style="text-align:center">Wholesale </th>
	                <th style="text-align:center">Profit</th>
	            </tr>
				<tbody>
					<tr>
				    	<th style="text-align:center">TOTAL</th>
		                <th style="text-align:center">{{$sum_quantity}}</th>
		                <th style="text-align:center">{{number_format($sum_subtotal,2)}} </th>
		                <th style="text-align:center">₹ {{number_format($sum_tax,2)}} </th>
		                <th style="text-align:center">₹ {{number_format($sum_total,2)}} </th>
		                <th style="text-align:center">₹ 0 </th>
		                <th style="text-align:center">₹ {{number_format($sum_subtotal,2)}} </th>
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
		
		$('#PaymentTable').dataTable({
			order: [[0, 'asc']],
			"columnDefs": [
			{'orderable': false, "target": 0}
			]
		});

	});


</script>
@endsection
