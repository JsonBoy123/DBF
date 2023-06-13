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
				<th class="" style="" data-field="payment_type"><div class="th-inner sortable both">Refre.</div><div class="fht-cell"></div></th>								
				<th class="" style="" data-field="payment_type"><div class="th-inner sortable both">Type</div><div class="fht-cell"></div></th>								
				
				<th class="print_hide" style="" data-field="invoice_excel"><div class="th-inner ">&nbsp;</div><div class="fht-cell"></div></th>
				<th class="print_hide" style="" data-field="edit"><div class="th-inner "></div><div class="fht-cell"></div></th></tr>
			</thead>
			<tbody>
				<?php $count = 0; ?>
				@foreach($salesManage as $value)
				{{-- {{ dd($value) }} --}}
				<tr data-index="0" data-uniqueid="27878"> 
					<td class="bs-checkbox print_hide">
					<input data-index="0" name="btSelectItem" type="checkbox"></td> 
					<td class="" style="">{{++$count}}</td> 
					<td class="" style="">{{$value->created_at}}</td> 
					<td class="" style="">{{$value->customer->first_name}} {{$value->customer->last_name}}</td>
					<td class="" style="">₹&nbsp;{{$value->sale_payment ? $value->sale_payment->payment_amount:'No Record'}}</td> 
					<td class="" style="">₹&nbsp;{{$value->sale_payment ? $value->sale_payment->payment_amount:'No Record'}}</td> 						 
					<td class="" style="">{{$value->invoice_number}}</td> 					
					<td class="" style="">{{$value->sale_payment ? $value->sale_payment->payment_type :''}}<br>{{$value->sale_payment ? $value->sale_payment->payment_amount:''}}	</td> 					
					
					<td class="print_hide" style=""><a href="{{route('sales-invoice',$value->id)}}" class="print_hide" title="invoice_excel (TBD)"><span class="glyphicon glyphicon-barcode"></span></a></td>
					 
					<td class="print_hide" style=""><a href="#" class="modal-dlg print_hide" data-btn-delete="Delete" data-btn-submit="Submit" title="Update"><span class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#exampleModalLong{{ $value->id }}"></span></a></td>
				 
				</tr>
				@endforeach
			</tbody>
		</table>