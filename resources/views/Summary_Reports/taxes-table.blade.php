@extends('layouts.dbf')

@section('content')

<div class="container">
	<div id="page_title">Tax Summery Report</div><br>
	<div style="font-size: 20px"><b>Time Duration - </b> {{$date['to']}} To {{$date['from']}}</div>
	@if(isset($taxe_rate) == true)
		<div class="row" id="catsTable">
	    <div class="col-md-12 col-xl-12">
	      <div class="card shadow-xs">
	        <div class="card-body table-responsive">
	          <table class="table table-striped table-hover" id="PaymentTable">
	            <thead>
	              <tr class="text-center">
	                <th style="text-align:center">Rate </th>
	                <th style="text-align:center">Count </th>
	                <th style="text-align:center">Subtotal </th>
	                <th style="text-align:center">Tax </th>
	                <th style="text-align:center">Total </th>
	              </tr>
	            </thead>
	            <tbody>
	          
				@php
					$sum_subtotal = $sum_quantity =  $sum_tax = $sum_total = 0;

		           	foreach($taxe_rate as $rate){
		           		$tax = tax($daterange, $location, $rate->taxe_rate ,'taxe');
                        $total = total($daterange, $location, $rate->taxe_rate ,'taxe');
                        // dd($total);

	          	@endphp
	            <tr class="text-center">
	                <td>{{$rate->taxe_rate}}%</td>	                
	                <td> {{$rate->count}}</td>
	                <td>₹ {{number_format($total-$tax,2)}} </td>
	                <td>₹ {{number_format($tax, 2)}}</td>
                    <td>₹ {{number_format($total, 2)}}</td>
	                @php

	                	$sum_quantity += $rate->count;	                	
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
	                <th style="text-align:center">Profit</th>
	            </tr>
				<tbody>
					<tr>
				    	<th style="text-align:center">TOTAL</th>
		                <th style="text-align:center">{{$sum_quantity}}</th>
		                <th style="text-align:center">{{number_format($sum_subtotal,2)}} </th>
		                <th style="text-align:center">₹ {{number_format($sum_tax,2)}} </th>
		                <th style="text-align:center">₹ {{number_format($sum_total,2)}} </th>
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
