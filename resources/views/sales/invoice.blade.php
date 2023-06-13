
@extends('layouts.dbf')

@section('content')
<?php $totalDiscount =  $cust->discount_amt !=null ? ($cust->discount_amt->damage + $cust->discount_amt->special + $cust->discount_amt->other + $cust->discount_amt->refrence) :0 ; 

?>
<input type="hidden" name="sale_id_nxt" id="sale_id_nxt" value="{{$cust->id}}">
<div class="container">
	<div class="print_hide" id="control_buttons" style="float:left">
			<button id="inv_cp_toggle" class="btn btn-warning btn-sm">Print Customer Copy</button>
	</div>

	<div class="print_hide" id="control_buttons" style="text-align:right">
		@permission('rs_shop_billing')
		<a href="{{route('sales-rack-info', $cust->id)}}" target="_blank">
			<div class="btn btn-info btn-sm", id="show_rack_info">
				<span class="glyphicon glyphicon-list-alt">&nbsp</span>Rack Info
			</div>
		</a>
		@endpermission
		<a href="javascript:printdoc();" onclick="window.print()">
			<div class="btn btn-info btn-sm", id="show_print_button">
				<span class="glyphicon glyphicon-print">&nbsp</span>Print
			</div>
		</a>
		{{-- @permission('other_bill_type') --}}
		@permission('other_bill_type')
			<a class="fa fa-edit btn btn-sm btn-primary" id="edit_field"></a>
		@endpermission

		<a href="http://newpos.dbfindia.com/sales" class="btn btn-info btn-sm" id="show_sales_button">
			<span class="glyphicon glyphicon-shopping-cart">&nbsp</span>Sales Register</a>
			<a href="http://newpos.dbfindia.com/sales/manage" class="btn btn-info btn-sm" id="show_takings_button"><span class="glyphicon glyphicon-list-alt">&nbsp</span>
			Daily Sales
		</a>
		<a class="btn btn-primary btn-sm" id="add_person" title="Daily Sales"><span class="glyphicon glyphicon-list-alt">&nbsp;</span>Add Person</a> 
	</div>
</div>

	<div class="container" id="remove-border">
		<div class="b col-md-3"></div>
		<div class="b col-md-6" style="outline: 1px solid #cfcfcf;outline-offset: -15px;">
			<br>			
		<section style="padding-left: 5px;">
			<div class="row">
				<div class="col-md-12"  align="center">
					@if($cust->reference_sale_id != null)
							<div class="col-md-12" style="padding: 0px; color: green">
								<h5><b>CREDIT NOTE</b></h5>
							</div>
						@endif 
						@if($cust->cancelled == 1)
							<div class="col-md-12" style="padding: 0px; color: red;" >
								<h5><b>CANCELLED</b></h5>
							</div>
						@endif 
				</div>
				<div style="width:55%; float: left; padding-left: 20px ">
					@if($shop_location->shop_id != 7)
					<img id="image" height="60" width="100" src="{{asset('/dbf-style/images/company_logo.png')}}"/>
                    @else
					<img id="image" height="60" width="100" src="{{asset('/dbf-style/images/dewas_shop_logo.png')}}"/>
					@endif		
					<h6 style="font-size: 8px;">					
						<?php  echo !empty($shop_location) ? $shop_location->address:'No Address Found'; ?>
						
					</h6>
				</div>
				

				
				<div style="width:40%; float: left;">
					<p id="inv_cp" style="text-align:center; font-size: 0.8em">Seller Copy</p>
					<table class="table table-bordered" style="margin: 0px; border-right: 0px; font-size: 10px">
						<tr>
							<td style="padding: 5px;">Invoice #<br> <b>@if(auth()->user()->can('other_bill_type'))TRADE/21-22/<span id="number">{{$cust->tally_number}}</span><input type="" style="width:21px ; display: none" id="update_tally_number" data-id="{{$cust->id}}"> @else {{$cust->tally_number}}@endif<b/></td>
							<td style="padding: 5px;">Refre. #<br> <b>{{$cust->invoice_number}}<b/></td>
							<td style="padding: 5px;" class="text-right">Date <br> <b>{{date('d/m/Y',strtotime($cust->created_at))}}</b></td>
						</tr>
						</table>
						<div class="col-md-12 pull-right" style="padding: 0px;">
							<h5 style="font-size: 10px">								
	            			    Shop: {{get_shop_name($cust->employee_id)->name}}<br>
	                  			Cashier: {{$cust->cashier != null ? $cust->cashier->name:''}}<br>
	                  			Shop Incharge: {{$shop_location != 'null' ? $shop_location->shop_incharge:'No Incharge Found..'}}<br>						
							</h5>
						</div>
					</div>
			</div>
			</section>
			<section>
				<div style="height: 1px;background-color: #dddddd; width: 100%;"></div>
					<p style="font-size: 0.9em ;padding: 5px 10px;margin: 0px;">Name
						<b>{{$cust->customer->first_name}} {{$cust->customer->last_name}}</b> <br> {{$cust->customer->gstin !=null ? 'GST No. :- '.$cust->customer->gstin :''}}
							<br> {{$cust->customer->gstin !=null ? 'State Name :- '.$cust->customer->state :''}}	
						<br>
						Ph.: {{$cust->customer->phone_number}} <br>
					</p>	
			</section>
			<section>
				<table class="table table-bordered table-condensed" style="font-size: 10px;">
					<thead>
						<tr>
							<td style="text-align:center; font-weight:bold;">Particulars</td>
							<td style="text-align:center; font-weight:bold;">HSN</td>
							<td style="text-align:center; font-weight:bold;">MRP</td>
							<td style="text-align:center; font-weight:bold;">Discount</td>
							<td style="text-align:center; font-weight:bold;">Discounted Price</td>
							<td style="text-align:center; font-weight:bold;">Qty</td>
							<td style="text-align:center; font-weight:bold;">Tax Rate</td>
							<td style="text-align:center; font-weight:bold;">Taxable Amt.</td>
						</tr>
	            	</thead>
	            <tbody>
	            	<?php 
	            		$sum = 0;     
	            		$qty = 0;      
	            		$tx_rt = array(); 		

	            	?>
	            	@foreach($salesData as $item)

		                <tr class="item-row">
		                    <td style="font-size:0.9em; text-align:center">{{$item->description}}</td>
		                    <td style="font-size:0.8em; text-align:center">{{$item->item->hsn_no}}</td> 
		                    <td style="font-size:0.8em; text-align:center">

{{$item->fixed_selling_price && $item->item_unit_price == 0.00 ? $item->fixed_selling_price : $item->item_unit_price}}
		                    	{{-- {{ ($item->item_unit_price == 0.00 ? $item->fixed_selling_price :$item->item_unit_price )}} --}} 
		                    </td>
		                    <td style="font-size:0.9em; text-align:center">{{$item->discount_percent }}%</td>
		                    <td style="font-size:0.9em; text-align:center">
		                    	<?php 
		                    	$tot = 0;
		                    	$act_amt = 0;
		                    	
		                    		if($item->item_unit_price == 0.00){
		                    			if($item->discount_percent == 0.00){
		                    				$tot1 = $item->fixed_selling_price;
		                    		  		$tot = $item->fixed_selling_price;
		                    		  		$sum +=($tot* (float)$item->quantity_purchased); 
		                    			}else{
		                    				$tot1 = (float)$item->fixed_selling_price - (float)$item->discount_percent/100 * $item->fixed_selling_price;
		                    		  		$tot = (float)$item->fixed_selling_price - (float)$item->discount_percent/100 * $item->fixed_selling_price;
		                    		  		$sum +=($tot* (float)$item->quantity_purchased);	
		                    			}            		
		                    		}
		                    		else{

		                    			$peramt =  ($item->item_unit_price == 0.00 ? $item->discount_percent :$item->item_unit_price );
		                    			$tot = (float)$peramt - (float)( $peramt/100)* (float)$item->discount_percent;   
		                    			$sum +=($tot* (float)$item->quantity_purchased);                	
		                    			$tot1 = (float)$peramt - (float)(($peramt/100) * (float)$item->discount_percent);

		                    			
		                    		}
		                    		echo number_format($tot,2);
		                    	?>

		                    </td>
		                    <td style="font-size:0.9em; text-align:center">
	                    	<?php 	
			                    $qty += $item->quantity_purchased;
			                    echo $item->quantity_purchased; 
		                     ?>
		                     	
		                     </td>
		                    <td style="font-size:0.8em; text-align:center">{{round($item->taxe_rate)}}%</td>
		                    <td style="font-size:0.9em; text-align:right"> <?php 
		                    	
		                    	$tot_sum = ($tot) - ($tot / (100 + (float)$item->taxe_rate)) * (float)$item->taxe_rate;
		                    	if(!isset($tx_rt[$item->taxe_rate])) {
		                    		$tx_rt[$item->taxe_rate] = ((float)$item->taxe_rate / (100 + (float)$item->taxe_rate)) * ($tot * $item->quantity_purchased);	
		                    	}
		                    	else{
		                    		
		                    		$tx_rt[$item->taxe_rate] += ((float)$item->taxe_rate / (100 + (float)$item->taxe_rate)) * ($tot * $item->quantity_purchased);
		                    	}

		                    	$tot_sum*$item->quantity_purchased;
		                    	echo number_format(($tot_sum*$item->quantity_purchased),2);
		                     ?></td>
		                </tr>
		                @endforeach	                

	                <tr>
	                	<td colspan="8" class="blank-bottom"></td>
	                </tr>
	               
		            <tr>
						<td colspan="6" class="blank-bottom"></td> <!-- KEYS -->
						<td style="font-size:0.9em; width: 20%">
						<?php 
													
							foreach($tx_rt as $key => $value){
								echo $key.' %GST<br>';
							}

	              		?>             		
							Subtotal<br>
							@if($sale_payment->credit_balance != '0.0')
								Credit Balance<br>
							@endif
							@if($voucher_applied)
							<b>Voucher Amount</b><br>
							@endif
						</td>
		                <td style="text-align:right; font-size:0.9em;"> <!-- VALUES -->
		                
						<?php $total_tax = 0; ?>	
						@foreach($tx_rt as $key => $value)
							<?php 
								echo number_format($value,2).'<br>'; 
								$total_tax += $value;
							?>
						@endforeach
							
							{{$sale_payment != null ? number_format($sale_payment->payment_amount-$total_tax,2):''}}<br> <!-- SUBTOTAL -->
							@if($sale_payment->credit_balance != '0.0')
								{{'- '.number_format($sale_payment->credit_balance,2)}}<br>
							@endif
							@if($voucher_applied)
							<b>{{ $voucher_applied['amount'] }}</b>
							@endif
						</td>
	              </tr>

	              <tr>
	                <td style="text-align:right;"><b>Total</b></td>
	                <td colspan="4">{{$cust->discount_amt != null ? 'Discountt on '.$cust->discount_amt->remark:''}} </td>
	                <td style="text-align:center">{{$qty}}</td>
	                <td colspan="2" style="text-align:right;"><b>₹ {{$cust->discount_amt != null ? round($sale_payment->payment_amount).' - '.$totalDiscount.' = ':''}} 

	                	@if($voucher_applied)
	                		<?php  
	                			$Tot = $sale_payment != null ? round ($sale_payment->payment_amount-$totalDiscount):'';
	                			$voucher_applied_amt = $voucher_applied['amount'];

	                			$Tot_Val = $Tot + $voucher_applied_amt;
	                			echo $Tot_Val.' - '.$voucher_applied_amt.' = '.$Tot;
	                			//echo $Tot_Val - $voucher_applied['amount'];
	                	 	?>
						@elseif($sale_payment->credit_balance != '0.0') @php

							$Tot = $sale_payment != null ? round ($sale_payment->payment_amount-$totalDiscount):'';
							$credit_bal = $sale_payment->credit_balance;
							$Tot_Val = $Tot -  $credit_bal;

							echo $Tot.' - '.$credit_bal.' = '.$Tot_Val;
						@endphp
						@else
	                		<?php  
	                			echo $sale_payment != null ? round ($sale_payment->payment_amount-$totalDiscount):'';
	                	 	?>
	                	 @endif
	                	 </b>
	                </td>
	              </tr>
					<tr>
						<td style="text-align:right;"><b>Amount in words</b></td>
						<td></td>
						<td colspan="6" style="text-align:right;">{{$sale_payment !=null ? number_to_word($sale_payment->payment_amount-$totalDiscount):''}}</td>
					</tr>
					@if($half_pay)
						<tr>
		                	<td style="text-align:right;"><b>Payment Details</b></td>
		                	<td colspan="1"></td>
		                	@if($half_pay->case != 0.00)
		                	<td colspan="2" style="font-size:0.9em;">
		                		<b> Cash :</b> {{$half_pay->case}}
		                	</td>
		                	@endif
		                	@if($half_pay->credit != 0.00)
		                	<td colspan="2" style="font-size:0.9em;">
		                	 	<b> Credit card :</b> {{$half_pay->credit}}
		                	</td>
		                	@endif
		                	@if($half_pay->debit != 0.00)
		                	<td colspan="2" style="font-size:0.9em;">
		                		<b> Debit card :</b> {{$half_pay->debit}}
		                	</td>
		                	@endif
		                	@if($half_pay->paytm != 0.00)
		                	<td colspan="2" style="font-size:0.9em;">
		                		<b> UPI :</b> {{$half_pay->paytm}}
		                	</td>
		                	@endif
		                	@if($half_pay->cheque != 0.00)
		                	<td colspan="2" style="font-size:0.9em;">
		                		<b> Cheque :</b> {{$half_pay->cheque}}
		                	</td>
		                	@endif 
		                	@if($half_pay->due_amount != 0.00)
		                	<td colspan="3" style="font-size:0.9em;">
		                		<b> Due Amount :</b> {{$half_pay->due_amount}}
		                	</td>
		                	@endif
		                </tr>
					@else
						<tr>
		                	<td style="text-align:right;"><b>Payment Details</b></td>
		                	<td colspan="3"></td>
		                	<td colspan="4" style="font-size:0.9em;">
								{{$cust->bill_type}} : 
								<?php

								if($statusCheck->sale_status == 1){

									echo $sale_payment !=null ? '-'.round($sale_payment->payment_amount-$totalDiscount):'';
								}else{
									echo $sale_payment != null ? round($sale_payment->payment_amount-$totalDiscount-$sale_payment->credit_balance):'';
								}
								?> |
							</td>
		                </tr>
	                @endif
	                @if($statusCheck->comment != '')
						<tr>
		                	<td style="text-align:right;"><b>Comment / Remark</b></td>
		                	<td colspan="1"></td>
		                	<td colspan="7" style="font-size:0.9em;">
								<span> {{ $statusCheck->comment }} </span>
							</td>
		                </tr>
	                @endif
	            </tbody>
			</table>
					</section>

					<section class="" style="font-size: 11px; padding: 10px"> 
						@if($statusCheck->sale_type == 1)
							We declare that this invoice shows the actual price of the goods
	  						described and that all particulars are true and correct. Material Not return
	  					@endif
					</section>
					
					<section style="font-size: 10px;">
						<div class="text-center" style="width: 50%;float: left;border: 1px solid #ddd;border-left: 0px;border-right: 0px; padding: 5px;">
							Seller's Signature <br>
							@if($shop_location->shop_id != 7)
							<img id="image" style="position:absolute" height="84" width="144" src="{{asset('/dbf-style/images/new2.png')}}" alt="company_stamp" /><br><br>
							@else
							<img id="image" style="position:absolute" height="84" width="144" src="#" alt="company_stamp" /><br><br>
							@endif
							_______________
						</div>
						<div class="text-center" style="width: 50%;float: left;border: 1px solid #ddd;border-right: 0px; padding: 5px;">
							Customer's Signature<br><br><br>
							_______________
						</div>
					</section>
					<div class="clearfix"></div>
					<br>
					@permission('account_details')
						<section style="width: 100%; border: 1px solid #ddd;border-left: 0px;border-right: 0px; padding: 0px 5px;">
							<section>
							<p style="font-size: 0.8em; padding: 0px 5px; margin: 0px;"><b>Company's Bank details :</b></p>
							<table style="font-size: 0.8em;">
								<tr style="height: 10px">
									<td>
										<p style="padding:0px; margin:0px;">&nbsp;&nbsp;&nbsp;Acc. holder name </p>
									</td>
									<td>
										&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;
									</td>
									<td>
										<p style="padding:0px; margin:0px;">Yolax Infranergy Pvt. Ltd.</p>
									</td>
								</tr>
								<tr style="height: 10px">
									<td>
										<p style="padding:0px; margin:0px;">&nbsp;&nbsp;&nbsp;Account Number </p>
									</td>
									<td>
										&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;
									</td>
									<td>
										<p style="padding:0px; margin:0px;">50200007811127</p>
									</td>
								</tr>
								<tr style="height: 10px">
									<td>
										<p style="padding:0px; margin:0px;">&nbsp;&nbsp;&nbsp;IFSC code </p>
									</td>
									<td>
										&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;
									</td>
									<td>
										<p style="padding:0px; margin:0px;">HDFC0002226</p>
									</td>
								</tr>
								<tr>
									<td>
										<p style="padding:0px; margin:0px;">&nbsp;&nbsp;&nbsp;Branch </p>
									</td>
									<td>
										&nbsp;&nbsp;&nbsp;  :  &nbsp;&nbsp;
									</td>
									<td>
										<p style="padding:0px; margin:0px;">MUDHOL, Karnataka</p>
									</td>
								</tr>
							</table>
							</section>
						</section>
					@endpermission
					<section style="padding: 0px 5px;">
						<section>
						<p style="font-size: 0.8em; padding: 0px 5px; margin: 0px;">TERMS AND CONDITIONS</p>
						<h6 style="font-size: 0.7em; padding: 5px; margin: 0px">
							<?php echo $shop_location->tnc; ?>
						</h6>
						</section>
					</section>
					
					<div style="width: 200px;margin: auto;display: block">
						<center>
	         			   <img width="150" src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAAyAQMAAADcGHRpAAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAQElEQVQ4je3KsQlAIRQDwAwgZBUHeODqH9IKDpPGwkL+Ela5+gAYsidXnc+SBtup0WWZhIpz45eWlpaWlpb2pl2Liq4sRn/K2wAAAABJRU5ErkJggg==' /><br>
				      <div>POS {{$cust->id}}</div>
				      @if($cust->reference_sale_id != null)
				      	<div>REFERENCE {{$cust->reference_sale_id}}</div>
				      @endif
				  	</center>
					<br>
					</div>
				</div>
				<div class="b col-md-3"></div>
		</div>

<div class="modal fade" id="showBrok" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header" >
            <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
            <button type="button" class="close" id="close_invoice" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
               <div class="bootstrap-dialog-message">                                
                     <div id="brocker">
                        
                     </div>   
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script >
	$(document).on('click','#add_person',function(){
		var sale_id = $('#sale_id_nxt').val()
      $.ajax({
         method:'post',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         data:{'sale_id':sale_id},
         url:'{{route('getBro')}}',
         success:function(data){
            $('#brocker').html(data)
            $('#showBrok').modal('show')
         }
      })
   })

	$(document).on('submit','#brocker_form',function(event){
      event.preventDefault()
      // console.log($('#brocker_form').serialize())
      $.ajax({
         method:'post',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         url:'{{route('addPersonPercentage')}}',
         data:$(this).serialize(),
         success:function(data){
            $('#showBrok').modal('hide')
         },
         error: function(jqXHR, textStatus, errorThrown) {
		   alert('This item has no discount...')
		 
		}
      })
   })

	$(document).on('change','#update_tally_number',function(){
		var tally = $(this).val()
		var bill_id = $(this).attr('data-id')

		 $.ajax({
         method:'post',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         url:'{{route('update_bill_number')}}',
         data:{'bill_id':bill_id,'tally':tally},
         success:function(data){
            location.reload()
         },
         error: function(jqXHR, textStatus, errorThrown) {
		   alert('This item has no discount...')
		 
		}
      })
	})

	$(document).on('click','#edit_field',function(){
		$('#number').css('display','none')
		$('#update_tally_number').css('display','inline-block')
	})
</script>
@endsection
