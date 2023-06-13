@extends('layouts.dbf')

@section('content')

<div class="container">
<div class="row">

<div id="title_bar" class="print_hide btn-toolbar">
	<button onclick="javascript:printdoc()" class="btn btn-info btn-sm pull-right">
		<span class="glyphicon glyphicon-print">&nbsp;</span>Print	</button>
	<a href="{{route('sales.index')}}" class="btn btn-info btn-sm pull-right" id="show_sales_button"><span class="glyphicon glyphicon-shopping-cart">&nbsp;</span>Sales Register</a></div>

<div id="table_holder">
	<div class="bootstrap-table"><div class="fixed-table-toolbar"><div class="bs-bars pull-left"><div id="toolbar">
	<div class="pull-left form-inline" role="toolbar">
		<button id="delete" class="btn btn-default btn-sm print_hide" disabled="disabled">
			<span class="glyphicon glyphicon-trash">&nbsp;</span>Delete		</button>

		<input type="text" name="daterangepicker" value="" id="daterangepicker" class="form-control input-sm" style="width: 180px;">
		<select id="filters" class="form-control">
			<option value="Cash" selected="selected">Cash</option>
			<option value="PayTM">PayTM</option>
			<option value="Credit Card">Credit Card</option>
			<option value="Debit Card">Debit Card</option>
			<option value="Due">Due</option>
			<option value="Check">Check</option>
			<option value="Invoices">Invoices</option>
			<option value="Credit Note">Credit Note</option>
		</select>
	</div>
</div>
</div>
</div>
<div class="col-xs-3 mb-2" align="center">
<p>
  @if($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
  @endif
</p>
 </div>
<div class="columns columns-right btn-group pull-right">
	<div class="keep-open btn-group" title="Columns">
		<button type="button" aria-label="columns" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="glyphicon glyphicon-th icon-th"></i> 
			<span class="caret"></span></button>
			<ul class="dropdown-menu" role="menu">
				<li role="menuitem"><label><input type="checkbox" data-field="sale_id" value="1" checked="checked"> Id</label></li><li role="menuitem"><label>
					<input type="checkbox" data-field="sale_time" value="2" checked="checked"> Time</label></li><li role="menuitem"><label>
					<input type="checkbox" data-field="customer_name" value="3" checked="checked"> Customer</label></li><li role="menuitem"><label>
					<input type="checkbox" data-field="amount_due" value="4" checked="checked"> Amount Due</label></li><li role="menuitem"><label><input type="checkbox" data-field="amount_tendered" value="5" checked="checked"> Amount Tendered</label></li><li role="menuitem"><label>
					<input type="checkbox" data-field="change_due" value="6" checked="checked"> Change Due</label></li><li role="menuitem"><label>
					<input type="checkbox" data-field="payment_type" value="7" checked="checked"> Type</label></li><li role="menuitem">
					<label>
						<input type="checkbox" data-field="invoice_number" value="8" checked="checked"> Ref #</label>
					</li>
				</ul>
			</div>
			<div class="export btn-group">
				<button class="btn btn-default btn-sm dropdown-toggle" aria-label="export type" title="Export data" data-toggle="dropdown" type="button"><i class="glyphicon glyphicon-export icon-share"></i> <span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu">
					<li role="menuitem" data-type="json"><a href="javascript:void(0)">JSON</a></li>
					<li role="menuitem" data-type="xml"><a href="javascript:void(0)">XML</a></li>
					<li role="menuitem" data-type="csv"><a href="javascript:void(0)">CSV</a></li>
					<li role="menuitem" data-type="txt"><a href="javascript:void(0)">TXT</a></li>
					<li role="menuitem" data-type="sql"><a href="javascript:void(0)">SQL</a></li>
					<li role="menuitem" data-type="excel"><a href="javascript:void(0)">MS-Excel</a></li>
					<li role="menuitem" data-type="pdf"><a href="javascript:void(0)">PDF</a></li>
				</ul>
			</div>
			</div>
			<div class="pull-right search"><input class="form-control input-sm" type="text" placeholder="Search"></div></div>
			<div class="fixed-table-container" style="padding-bottom: 0px;"><div class="fixed-table-header" style="display: none;">
			<table></table>
		</div>
	<div class="fixed-table-body">
	<div class="fixed-table-loading" style="top: 42px; display: none;">Loading, please wait...</div>
	<div id="table-sticky-header-sticky-header-container" class="fixed-table-container hidden" style="top: 0px; width: 749px;">
	<div style="position:absolute;width:100%;overflow-x:hidden;">
	<thead>
		<tr>
		<th class="bs-checkbox print_hide" style="width: 36px; min-width: 30px;" data-field="checkbox">
			<div class="th-inner ">
				<input name="btSelectAll" type="checkbox"></div>
				<div class="fht-cell"></div></th>
				<th class="" style="min-width: 52px;" data-field="sale_id">
					<div class="th-inner sortable both">Id</div>
					<div class="fht-cell"></div></th>
					<th class="" style="min-width: 81px;" data-field="sale_time"><div class="th-inner sortable both">Time</div>
					<div class="fht-cell"></div></th>
					<th class="" style="min-width: 99px;" data-field="customer_name">
					<div class="th-inner sortable both">Customer</div><div class="fht-cell"></div></th>
					<th class="" style="min-width: 115px;" data-field="amount_due">
					<div class="th-inner sortable both">Amount Due</div>
					<div class="fht-cell"></div></th>
					<th class="" style="min-width: 148px;" data-field="amount_tendered"><div class="th-inner sortable both">Amount Tendered</div>
					<div class="fht-cell"></div></th>
					<th class="" style="min-width: 114px;" data-field="change_due"><div class="th-inner sortable both">Change Due</div><div class="fht-cell"></div></th>
					<th class="" style="min-width: 67px;" data-field="payment_type"><div class="th-inner sortable both">Type</div><div class="fht-cell"></div></th>
					<th class="" style="min-width: 80px;" data-field="invoice_number"><div class="th-inner sortable both">Ref #</div><div class="fht-cell"></div></th>
					<th class="print_hide" style="min-width: 29px;" data-field="invoice"><div class="th-inner ">&nbsp;</div><div class="fht-cell"></div></th>
					<th class="print_hide" style="min-width: 20px;" data-field="credit_note"><div class="th-inner ">&nbsp;</div><div class="fht-cell"></div></th>
					<th class="print_hide" style="min-width: 29px;" data-field="invoice_excel"><div class="th-inner ">&nbsp;</div><div class="fht-cell"></div></th>
					<th class="print_hide" style="min-width: 29px;" data-field="edit"><div class="th-inner "></div><div class="fht-cell"></div></th>
				</tr>
			</thead>
		</div>
	</div>
	<div id="table-sticky-header_sticky_anchor_begin"></div>
	<div id="daily_table">
		<table id="salesManage" class="table table-hover table-striped">
			<thead id="table-sticky-header">
				<tr>
					<th class="bs-checkbox print_hide" style="width: 36px; " data-field="checkbox">
						<div class="th-inner ">
							<input name="btSelectAll" type="checkbox">
						</div>
						<div class="fht-cell"></div></th>
						<th class="" style="" data-field="sale_id">
							<div class="th-inner sortable both">Id</div><div class="fht-cell"></div></th>
							<th class="" style="" data-field="sale_time"><div class="th-inner sortable both">Time</div><div class="fht-cell"></div></th>
							<th class="" style="" data-field="customer_name"><div class="th-inner sortable both">Customer</div><div class="fht-cell"></div></th>
							<th class="" style="" data-field="amount_due"><div class="th-inner sortable both">Amount Due</div><div class="fht-cell"></div></th>
							<th class="" style="" data-field="amount_tendered"><div class="th-inner sortable both">Amount Tendered</div><div class="fht-cell"></div></th>						
							<th class="" style="" data-field="payment_type"><div class="th-inner sortable both">Refer.</div><div class="fht-cell"></div></th>								
							<th class="" style="" data-field="payment_type"><div class="th-inner sortable both">Type</div><div class="fht-cell"></div></th>								
							
							<th class="print_hide text-center" style="" data-field="invoice_excel"><div class="th-inner ">&nbsp; Invoice</div><div class="fht-cell"></div></th>
							<th class="print_hide" style="" data-field="edit"><div class="th-inner "></div><div class="fht-cell"></div></th></tr>
						</thead>
						<tbody>

							<?php $count = 0; ?>
							@foreach($salesManage as $value)
							<tr data-index="0" data-uniqueid="27878"> 
							<td class="bs-checkbox print_hide">
							<input data-index="0" name="btSelectItem" type="checkbox"></td> 
							<td class="" style="">{{++$count}}</td> 
							<td class="" style="">{{$value->created_at}}</td> 
							<td class="" style="">{{$value->customer->first_name}} {{$value->customer->last_name}}</td>
							<td class="" style="">₹&nbsp;{{$value->sale_payment !=null ? $value->sale_payment->payment_amount :'0' }}</td> 
							<td class="" style="">₹&nbsp;{{$value->sale_payment !=null ? $value->sale_payment->payment_amount :'0' }}</td> 
							<td class="" style="">{{$value->invoice_number}}</td> 	 						 
							<td class="" style="">{{$value->sale_payment !=null ?  $value->sale_payment->payment_type : '0'}}<br>{{$value->sale_payment !=null ? $value->sale_payment->payment_amount : '0'}}	</td> 					
							
							<td class="print_hide text-center" style="">
							<a href="{{route('sales-invoice',$value->id)}}" class="print_hide" title="invoice_excel (TBD)"><span class="glyphicon glyphicon-barcode"></span></a>
							</td>
							
							<td class="print_hide" style=""><a href="#" class="modal-dlg print_hide" data-btn-delete="Delete" data-btn-submit="Submit" title="Update"><span class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#exampleModalLong{{ $value->id }}"></span></a></td>
							 
						</tr>
				

{{-- Code for Edit........................ --}}
<!-- Modal -->
<div class="modal fade" id="exampleModalLong{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="bootstrap-dialog-body">
			<div class="bootstrap-dialog-message"><div><div id="required_fields_message">Fields in red are required</div>

	<ul id="error_message_box" class="error_message_box"></ul>

	<form action="{{ route('sales-manage.update',$value->id) }}" id="sales_edit_form" class="form-horizontal" method="post" accept-charset="utf-8" novalidate="novalidate">
	 @csrf
    @method('PUT')                                                                                               
	<fieldset id="sale_basic_info">
		<div class="form-group form-group-sm">
			<label for="receipt_number" class="control-label col-xs-3">Sale #</label>				
			<a href="http://newpos.dbfindia.com/sales/receipt/27878" target="_blank" class="control-label col-xs-8" style="text-align:left">POS {{$value->id}}</a><br>	
		</div>
		
		<div class="form-group form-group-sm">
			<label for="date" class="control-label col-xs-3">Sale Date</label>
			<div class="col-xs-8">
				<input type="text" name="created_at" value="{{$value->created_at}}" id="datetime" class="form-control input-sm">
			</div><br><br>	
		</div>
			<div class="form-group form-group-sm">
				<label for="invoice_number" class="control-label col-xs-3">Ref #</label>	
				<div class="col-xs-8">
					<input type="text" name="ref_invoice_number" value="{{$value->ref_invoice_number}}" id="invoice_number" class="form-control input-sm">
				</div><br><br>	
			</div>
		
				<div class="form-group form-group-sm">
				<label for="payment_0" class="control-label col-xs-3">Payment Type</label>					
				<div class="col-xs-4">
				<select name="payment_types" id="payment_types_0" class="form-control">
				<option value="{{$value->payment_types}}" selected="selected">{{$value->payment_types}}</option>
				<option value="Cash">Cash
				</option>
				<option value="Debit Card">Debit Card</option>
				<option value="Credit Card">Credit Card</option>
				<option value="PayTM">PayTM</option>
				</select>	
				</div>
				<div class="col-xs-4">
					<div class="input-group input-group-sm">
						<span class="input-group-addon input-sm"><b>₹</b></span>
						<input type="text" name="amount_tendered1" value="{{$value->amount_tendered1}}" id="amount_tendered1" class="form-control input-sm" readonly="true">
					</div>
				</div>
			</div>
		
		<input type="hidden" name="number_of_payments" value="1">
		<div class="form-group form-group-sm">
			<label for="customer" class="control-label col-xs-3">Name</label><br><br>
			<div class="col-xs-8">
				<input type="text" name="customer_name" value="{{$value->customer_name}}" id="customer_name" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
				<input type="hidden" name="customer_id" value="12447">
			</div>	
		</div><br>
		
		<div class="form-group form-group-sm">
			<label for="employee" class="control-label col-xs-3">Employee</label>	
			<div class="col-xs-8">
				
				<input type="hidden" name="employee_id" value="{{ $value->employee_id }}">
				<select name="dropdown_employee_id" id="employee_id" class="form-control" disabled="true">
					{{-- <option value="11306">Ahmedabad Login</option>
					<option value="10">DBF Annapurna Login</option>
					<option value="11">DBF Bhanvarkuan Login</option>
					<option value="4">DBF Indraprastha Login</option>
					<option value="13">DBF Mahalaxmi Login</option>
					<option value="8">YS Sir Login</option>
					<option value="1439">JP Sir  Login</option>
					<option value="7562">Shop 114 Login</option>
					<option value="12393">Material Mgmt</option> --}}

					<option value="{{ $value->employee_id }}" selected="selected">{{ $value->shop->name }}</option>
					{{-- <option value="9">DBF Accounts Panel</option>
					<option value="16">DBF Admin Panel</option>
					<option value="11143">DBF Admin2 Panel</option>
					<option value="15">DBF Main Panel</option>
					<option value="7">LH Warehouse Panel</option>
					<option value="10544">DBF Airport Road Shop</option>
					<option value="8138">DBF Khandwa Road Shop</option>
					<option value="3">Amazon Stock</option>
					<option value="2141">Apnagps Stock</option>
					<option value="14">DN Warehouse Stock</option> --}}
				</select>
			</div> <!-- Set Employee dropdown not editable -->
		</div><br><br>
		
		<div class="form-group form-group-sm">
			<label for="comment" class="control-label col-xs-3">Comment</label>	
				<div class="col-xs-8">
				<textarea name="comment" cols="40" rows="10" id="comment" class="form-control input-sm"></textarea>
			</div>
		</div>
	</fieldset>
</div>
	</div>
		</div>
			</div>
				<div class="modal-footer" style="display: block;">
					<div class="bootstrap-dialog-footer">
						<div class="bootstrap-dialog-footer-buttons">
							
							<button class="btn btn-primary" id="submit">Submit</button>
						</div>
					</div>
				</div>
			</form>
			<form action="{{ route('sales-manage.destroy',$value->id) }}" method="post">
			@csrf
			@method('DELETE')
			<button class="btn btn-danger" id="delete">Delete</button>
			</form>
				<ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-1" tabindex="0" style="display: none;"></ul>
			</div>
		</div>
	</div>
			@endforeach
			</tbody>
		</table>
	 </div>
	</div>
</div>



{{-- <link rel="stylesheet" type="text/css" href="style.css" media="screen" /> --}}


{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script> --}}

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
		        },
		        //startDate: moment().add(-1, 'day'),
		        //endDate: moment().add(-1, 'day'),

		}, cb);

 cb(start, end);
	});

$(document).on('change','#filters',function(){
	
	var date = $('#daterangepicker').val()
	var startdate = date.split('-')[0];
	var enddate = date.split('-')[1];
	var type = $(this).val()

	//alert(type)
	$.ajax({
		headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	},
		method:'POST',
		url:'getSales',
		data:{startdate:startdate,enddate:enddate,type:type},
		success:function(data){
			console.log(data)
			$('#daily_table').html(data)
		}
	})
})

</script>

@endsection
