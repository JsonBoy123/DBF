@extends('layouts.dbf')

@section('content')

<div class="container">
	<div class="row">

		<div id="page_title">Taxes eport Input</div>

		<form action="{{route('taxes-report.show')}}" id="item_form" enctype="multipart/form-data" class="form-horizontal" method="post" accept-charset="utf-8">
			@csrf()
			<input type="hidden" name="csrf_ospos_v3" value="f27dc808894e188562b2c781ef012793">                                                                  
			<div class="form-group form-group-sm">
				<label for="report_date_range_label" class="control-label col-xs-2 required">Date Range</label>	
				<div class="col-xs-3">
					<input type="text" name="daterangepicker" value="" class="form-control input-sm" id="daterangepicker" style="width: 180px;">
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label for="reports_sale_type_label" class="required control-label col-xs-2">Transaction Type</label>				
				<div id="report_sale_type" class="col-xs-3">
					<select name="sale_type" id="input_type" class="form-control">
					<option value="complete" selected="selected">Completed Sales and Returns</option>
					<option value="sales">Completed Sales</option>
					<option value="quotes">Quotes</option>
					<option value="canceled">Canceled</option>
					<option value="returns">Returns</option>
					</select>
				</div>
			</div>
	
			<div class="form-group form-group-sm">
				<label for="reports_stock_location_label" class="required control-label col-xs-2">Stock Location</label>			
				<div id="report_stock_location" class="col-xs-3">
					<select name="stock_location" id="location_id" class="form-control">
						<option value="all" selected="selected">All</option>
						@foreach($shop as $data)
						<option value="{{$data->id}}" >{{$data->name}}</option>

						@endforeach
					</select>
				</div>
			</div>
	
			<button name="generate_report" id="generate_report" class="btn btn-primary btn-sm">Submit</button>
		</form>
	</div>
</div>
<script>
	$(document).ready( function () {
		 var start = moment().subtract(29, 'days');
    	var end = moment();

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
		        }
		}, cb);

 cb(start, end);
	});


</script>
@endsection
