@extends('layouts.dbf')

@section('content')
<div class="container">
	<div class="row" style="margin-left: -29px;">
		<div class="col-md-2">
			<input type="text" name="daterangepicker" value="" id="daterangepicker"class="form-control " style="width: 190px;" >
		</div>
		<div class="col-md-2">
			<select id="filters" class="form-control" @permission('pos_superadmin') style="width: 190px;" @endpermission>
				<option value="Cash" selected="selected">Cash</option>
				<option value="PayTM">PayTM/UPI</option>
				<option value="Credit Card">Credit Card</option>
				<option value="Debit Card">Debit Card</option>
				<option value="Half Payment">Half Payment</option>
				<option value="Credit Note">Credit Note</option>
				<option value="Cheque">Cheque</option>
				@if(auth()->user()->can('cancel_bill'))
					<option value="cancelled">Cancelled</option>
				@endif
				<option value="All">All Payments</option>

			</select>
		</div>
		@permission('sales-search')
			<div class="col-md-2">
				<select id="shops" class="form-control">
					@foreach($shops as $shop)
						<option value="{{$shop->id}}">{{$shop->name}}</option>
					@endforeach
				</select>
			</div>
		@endpermission
		<button type="button" class="btn btn-primary btn-sm" id="searchItems" style="font-size: 14px;"><b><i class="fa fa-search" aria-hidden="true"></i></b></button>
	</div><br>
	<div class="row">
		<div id="table_holder">
			<div class="bootstrap-table">
				<div class="fixed-table-toolbar" id="daily_sales">
					<table class="table table-bordered dataTables_wrapper" id="dailySales">
					  <thead class="thead-dark">
					    <tr>
					      <td class="text-center"><b>POS</b></td>
					      <td class="text-center"><b>CUSTOMERr</b></td>
					      <td class="text-center" style="display: none;" ><b>Contact No.</b></td>
					      <td class="text-center"><b>&nbsp TYPE &nbsp</b></td>
					      <td class="text-center"><b>TENDERED AMT.</b></td>
					      <td class="text-center"><b>DISCOUNT</b></td>
					      <td class="text-center"><b>PAID &nbsp</b></td>
					      <td class="text-center"><b>DUE &nbsp</b></td>
					      <td class="text-center"><b>REF. NO</b></td>
					      <td class="text-center"><b>INVOICE NO.</b></td>
					      <td class="text-center"><b>DATE</b></td>
					      <td ><b>INVOICE</b></td>
					      @if(auth()->user()->can('cancel_bill'))
					      	<td><b>STATUS</b></td>
					      @endif
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($salesManage as $value)
					    <tr>
					    	<td class="text-center">{{$value->id}}</td> 
							<td >{{ucwords($value->customer->first_name)}} {{ucwords($value->customer->last_name)}}</td>
							<td style="display: none;"> {{$value->customer->phone_number}} </td>
							<td class="text-center">{{$value->sale_payment !=null ?  $value->sale_payment->payment_type : '0'}}{{-- <br>{{$value->sale_payment !=null ? $value->sale_payment->payment_amount : '0'}}	 --}}</td> 	
							<td class="text-center">₹&nbsp;{{$value->sale_payment !=null ? $value->sale_payment->payment_amount :'0' }}</td>

							@php

								if(!empty($value['discount_amt'])){

									$discounts = $value['discount_amt']->damage + $value['discount_amt']->special + $value['discount_amt']->refrence + $value['discount_amt']->other ;
									$total_disc = $value['discount_amt'] == true ? $discounts : '' ;
								}else{
									$total_disc = 0;
								}
							@endphp
							<td class="text-center">₹&nbsp{{$total_disc}}</td>

							@php 
								if($value->sale_payment !=null){
									$payment_amount_due = $value->sale_payment->payment_amount - $total_disc; 

								}

								if($value['half_payment'] != null){

									$payment_amount_due = round($value->sale_payment->payment_amount) - $total_disc - round($value['half_payment']->due_amount);
								}
							@endphp
							<td class="text-center">₹&nbsp{{$value->sale_payment !=null ? $payment_amount_due :'0' }}</td> 
							<td class="text-center">₹&nbsp{{$value['half_payment'] != null ? $value['half_payment']->due_amount : 0 }}</td>
							
							<td class="text-center">{{$value->invoice_number}}</td>
							<td class="text-center">
								
								@if(in_array($value->employee_id, [1, 19]) == true)
									YIPL/{{$value->tally_number}}
								@else
									{{$value->tally_number}}
								@endif

							</td>
							
							<td class="text-center">{{date('M d, Y : h.i A', strtotime($value->created_at))}}</td> 

					      	<td class="print_hide text-center" style="">
								<a href="{{route('sales-invoice',$value->id)}}" target="_blank" class="print_hide" title="invoice_excel (TBD)"><span class="glyphicon glyphicon-barcode"></span></a>
							</td>
							{{-- <td></td> --}}
							@if(auth()->user()->can('cancel_bill'))
								<td class="text-center">
									@if($value->cancelled == 0)
										<a  class="btn btn-danger btn-sm cancel" id="cancelBtn_{{$value->id}}" type="button" data-request="{{$value->id}}">Cancel</a>

										<div style="color: red; display: none" id="cancelMsg_{{$value->id}}" ><b>CANCELLED</b></div>
									@else
										<div style="color: red"><b>CANCELLED</b></div>
									@endif
								</td>
							@endif
							{{-- @else
								<td class="text-center">
									@if($value->cancelled == 1)
										<div class="fa fa-danger"><b>CANCELLED</b></div>
									@else
										<div class="fa fa-danger"><b>--</b></div>
									@endif
								</td> --}}

							{{-- <td class="print_hide text-center" style=""><a href="#" class="modal-dlg print_hide" data-btn-delete="Delete" data-btn-submit="Submit" title="Update"><span class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#exampleModalLong{{ $value->id }}"></span></a></td> --}}
					    </tr>
					    @endforeach
					  </tbody>
					</table><br>

				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	
$(document).ready( function(){

	$('#dailySales').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'pdfHtml5'
          ],
          order:[[0, 'desc']]
      } );

	var start = moment().subtract(29, 'days');
    var end   = moment();

    function cb(start, end) {
		$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		}
		$('#daterangepicker').daterangepicker(
			{
	        startDate: start,
	        endDate: end,
	        ranges: {
	           'Today': [moment(), moment()],
	           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	           'This Month': [moment().startOf('month'), moment().endOf('month')],
	           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	        },
		        //startDate: moment().add(-1, 'day'),
		        //endDate: moment().add(-1, 'day'),
		}, cb);

 		cb(start, end);

 	$(document).on('click','#searchItems',function(){
	
		var date 		= $('#daterangepicker').val()
		var startdate 	= date.split('-')[0];
		var enddate 	= date.split('-')[1];
		var type 		= $('#filters').val()
		var shop 		= $('#shops').val()

		$.ajax({
			headers: {
	        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    	},
			method:'POST',
			url:'{{route('sales.search')}}',
			data:{startdate:startdate, enddate:enddate, type:type, shop:shop},
			success:function(data){
				$('#daily_sales').html(data)
			}
		})
	})



});
$(document).on('click', '.cancel', function(){

	var request_id	= $(this).data('request')
	var reason		= prompt('Please mention reason.')

	if(reason.length != 0){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: 'post',
			url: '{{route('sale-cancellation')}}',
			data: {request_id:request_id, reason:reason},
			success:function(data){

				$('#cancelBtn_'+request_id).hide()
				$('#cancelMsg_'+request_id).show()
			}
		})
	}else{
		alert('You must give any reason.')
	}

})
</script>

@endsection
