<table class="table table-bordered dataTables_wrapper" id="dailySales">
					  <thead class="thead-dark">
					    <tr>
					      <td class="text-center"><b>POS</b></td>
					      <td class="text-center"><b>CUSTOMER</b></td>
					      <td class="text-center" style="display: none;"><b>Contact No.</b></td>
					      <td class="text-center"><b>TYPE</b></td>
					      <td class="text-center"><b>TENDERED AMT. </b></td>
					      <td class="text-center"><b>DISCOUNT</b></td>
					      <td class="text-center"><b>PAID &nbsp</b></td>
					      <td class="text-center"><b>DUE &nbsp</b></td>
					      <td class="text-center"><b>REF. NO</b></td>
					      <td class="text-center"><b>INVOICE NO.</b></td>
					      <td class="text-center"><b>DATE</b></td>
					      <td ><b>INVOICE</b></td>
					      {{-- @if(auth()->user()->can('cancel_bill') && in_array($shop, [1, 17, 19]))
					      	<td><b>STATUS</b></td>
					      @endif --}}
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
							<td >{{$value->sale_payment !=null ?  $value->sale_payment->payment_type : '0'}}{{-- <br>{{$value->sale_payment !=null ? $value->sale_payment->payment_amount : '0'}} --}}
							</td>
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
							<td class="text-center">₹&nbsp{{$value['half_payment'] != null ? $value['half_payment']->due_amount : '0.00' }}</td>
							<td class="text-center">{{$value->invoice_number}}</td>
							<td class="text-center">
								
								@if(in_array($value->employee_id, [1, 19]) == true)
									YIPL/{{$value->tally_number}}
								@else
									{{$value->tally_number}}
								@endif

							</td>
							
							<td class="text-center">{{date('M d, Y : h.i A', strtotime($value->created_at))}}
							</td> 
					      	<td class="print_hide text-center" style="">
								<a href="{{route('sales-invoice',$value->id)}}" target="_blank" class="print_hide" title="invoice_excel (TBD)"><span class="glyphicon glyphicon-barcode"></span></a>
							</td>

							{{-- @permission('cancel_bill')
								<td>
									@if($value->cancelled == 0)
										<a href="{{route('sale-cancellation', $value->id)}}" class="fa fa-danger" type="button">testing</a>
									@else
										<div class="fa fa-danger"><b>CANCELLED</b></div>
									@endif
								</td>
							@endpermission
							<td>
								@if($value->cancelled == 0)
									<div class="fa fa-danger"><b>CANCELLED</b></div>
								@else
									<div class="fa fa-danger"><b>CANCELLED</b></div>
								@endif
							</td> --}}

							{{-- @if(auth()->user()->can('cancel_bill') && in_array($value->employee_id, [1, 17, 19])) --}}
							@if(auth()->user()->can('cancel_bill'))
								<td class="text-center">
									@if($value->cancelled == 0)
										<a  class="btn btn-danger btn-sm cancel" id="cancelBtn_{{$value->id}}" type="button" data-request="{{$value->id}}">Cancel</a>

										<div style="color: #d43f3a; display: none" id="cancelMsg_{{$value->id}}" ><b>CANCELLED</b></div>
									@else
										<div style="color: #d43f3a"><b>CANCELLED</b></div>
									@endif
								</td>
							@endif
							{{-- @else
								<td class="text-center">
									@if($value->cancelled == 0)
										<div class="fa fa-danger"><b>--</b></div>
									@else
										<div class="fa fa-danger"><b>CANCELLED</b></div>
									@endif
								</td> --}}
							{{-- <td class="print_hide text-center" style=""><a href="#" class="modal-dlg print_hide" data-btn-delete="Delete" data-btn-submit="Submit" title="Update"><span class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#exampleModalLong{{ $value->id }}"></span></a></td> --}}
					    </tr>
					    @endforeach
					  </tbody>
					</table>
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
});
</script>
	