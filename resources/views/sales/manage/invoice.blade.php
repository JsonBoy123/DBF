@extends('layouts.dbf')

@section('content')

<div class="container">
<div class="row">

<div class="print_hide" id="control_buttons" style="float:left">
		<button id="inv_cp_toggle" class="btn btn-warning btn-sm">Print Customer Copy</button>
</div>
<div class="print_hide" id="control_buttons" style="text-align:right">
	<a href="javascript:printdoc();"><div class="btn btn-info btn-sm" ,="" id="show_print_button"><span class="glyphicon glyphicon-print">&nbsp;</span>Print</div></a>
	<a href="javascript:void(0);"><div class="btn btn-info btn-sm" ,="" id="show_email_button"><span class="glyphicon glyphicon-envelope">&nbsp;</span>Send Invoice</div></a>
	<a href="{{ route('sales.index') }}" class="btn btn-info btn-sm" id="show_sales_button"><span class="glyphicon glyphicon-shopping-cart">&nbsp;</span>Sales Register</a>	
	<a href="{{ route('sales-manage.index') }}" class="btn btn-info btn-sm" id="show_takings_button"><span class="glyphicon glyphicon-list-alt">&nbsp;</span>Daily Sales</a></div>

	<div class="container" id="remove-border">
		<div class="a col-md-3"></div>
			<div class="b col-md-6" style="outline: 1px solid #cfcfcf;outline-offset: -15px;">
				<br>
				<section style="padding-left: 5px;">
					<div class="row">
						<div style="width:55%; float: left; padding-left: 20px ">
							<h6 style="font-size: 8px;">
								{{-- <b>{{ $cashierShop->shop_name }}</b><br> AH-27, Bapat Square, Sukhliya, Indore M.P.<br>PIN : 452001<br> GSTIN/UIN:23AABCL3031E1Z9<br> State Name : Madhya Pradesh, Code : 23<br> Contact : +91-8815218225<br> E-mail : sales@laxyo.com<br> --}}<b> Laxyo Energy Limited</b><br> {{ $Shop->shop_address }}<br>
							</h6>
						</div>
						<div style="width:40%; float: left;">
							<p id="inv_cp" style="text-align:center; font-size: 0.8em">Seller Copy</p>
							<table class="table table-bordered" style="margin: 0px; border-right: 0px; font-size: 10px">
								<tbody><tr>
									<td style="padding: 5px;">Invoice #<br> <b>{{ $salesManage->id }}<b></b></b></td>
									<td style="padding: 5px;">Ref #<br> <b>BT-1090-2604<b></b></b></td>
									<td style="padding: 5px;" class="text-right">Date <br> <b>{{ $salesManage->created_at }}</b></td>
								</tr>
							</tbody></table>
							<div class="col-md-12 pull-right" style="padding: 0px;">
							<h5 style="font-size: 10px"> <br> Cashier: {{ $cashiers->name }}<br>Shop Incharge: {{ $shopIncharge->name }}<br>Sale Code: 13		<!-- <br>
									Bill Type:  -->
								</h5>
							</div>
						</div>
					</div>
				</section>
				<section>
					<div style="height: 1px;background-color: #dddddd; width: 100%;"></div>
					<p style="font-size: 0.9em ;padding: 5px 10px;margin: 0px;">
						<b>{{ $customerDetails->first_name }}&nbsp;{{ $customerDetails->last_name }}</b><br>
						Ph.: {{ $customerDetails->phone_number }}<br></p>
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
            			$totalQty = 1;
            			$Subtotal = 0;
            			foreach($certItem as $value){ ?>

                        <tr class="item-row">
                    		<td style="font-size:0.9em; text-align:center">
							{{ $value->name }}</td>
                    		<td style="font-size:0.8em; text-align:center">{{ $value->itemsDetails->hsn_no }}</td> 
                    		<td style="font-size:0.8em; text-align:center">₹&nbsp;{{ $value->unit_price }} </td>
							<td style="font-size:0.9em; text-align:center">{{ $value->itemTaxes->percent }}%</td>
                    		<td style="font-size:0.9em; text-align:center"> 46.2</td>
                    		<td style="font-size:0.9em; text-align:center">{{ $value->quantity }}</td>
                    		<td style="font-size:0.8em; text-align:center">{{ $value->itemTaxes->percent }}%</td>
                    		<td style="font-size:0.9em; text-align:right"><?php echo $TaxableAmt = $value->unit_price / 100 * $value->itemTaxes->percent ?>	</td>
                  		</tr>

						<tr>
							<td colspan="8" class="blank-bottom"></td>
						</tr>
						{{-- <div id='sub_total'>
							<span style="display: none;"><?php  $Subtotal+=  $TaxableAmt; ?></span>
						</div>
						<div id='CGST'>
							<span style="display: none;"><?php  echo $CGST = $value->unit_price / 100 * $value->itemTaxes->percent; ?></span>
						</div>
						<div id='SGST'>
							<span style="display: none;"><?php echo $SGST = $value->unit_price / 100 * $value->itemTaxes->percent; ?></span>
						</div>
						<div id='Total'>
							<span style="display: none;"><?php  $SGST = $value->unit_price / 100 * $value->itemTaxes->percent; ?></span>
						</div> --}}
						<?php } ?>

              			<tr>
							<td colspan="6" class="blank-bottom"></td> <!-- KEYS -->
							<td style="font-size:0.9em" >Subtotal<br>
							 9% CGST<br>9% SGST<br></td>
                			<td style="text-align:right; font-size:0.9em;"> <!-- VALUES --><span id="">{{ $Subtotal }}</span><br> <!-- SUBTOTAL -->13.5<br>13.5<br></td>
              			</tr>

			            <tr>
			                <td style="text-align:right;"><b>Total</b></td>
			                <td colspan="4"></td>
			                <td style="text-align:center"><?php echo $totalQty += $value->quantity; ?></td>
			                <td colspan="2" style="text-align:right;"><b>₹&nbsp;177</b></td>
			            </tr>
						<tr>
							<td style="text-align:right;"><b>Amount in words:</b></td>
							<td></td>
							<td colspan="6" style="text-align:right;">One hundred  and seventy seven  Rupees  Only</td>
						</tr>
						<tr>
				            <td style="text-align:right;"><b>Payment Details</b></td>
				            <td colspan="3"></td>
				            <td colspan="4" style="font-size:0.9em;">Cash: 177 | </td>
              			</tr>
            </tbody>
		</table>
	</section>

				<section class="text-center" style="font-size: 11px; padding: 10px"> 
					<!-- Earned VC Details --></section>
				<section style="font-size: 10px;">
					<div class="text-center" style="width: 50%;float: left;border: 1px solid #ddd;border-left: 0px;border-right: 0px; padding: 5px;">
						Seller's Signature <br><br>
						<img id="image" style="position:absolute" src="http://newpos.dbfindia.com/images/lel_stamp.png" alt="company_stamp" width="64" height="64"><br>
						_______________
					</div>
					<div class="text-center" style="width: 50%;float: left;border: 1px solid #ddd;border-right: 0px; padding: 5px;">
						Customer's Signature<br><br><br>
						_______________
					</div>
				</section>
				<div class="clearfix"></div>
				<br>
				<section style="padding: 0px 5px;">
					<section>
					<p style="font-size: 0.8em; padding: 0px 5px; margin: 0px;">TERMS AND CONDITIONS</p>
					<h6 style="font-size: 0.7em; padding: 5px; margin: 0px">
					1. The Goods sold are at Taxable value. GST, local taxes, if any, will be charged as applicable.<br> 
					2. Credit Sale is not allowed. Any delayed payment will be charged 18 % interest for delayed period.<br> 
					3. Goods once sold will not be returned but at the discretion of management can be exchanged for genuine reasons with similar item or item/items of equivalent value.<br> 
					4. Replacement (Only One Time) for manufacturing defect (if any) shall be allowed within Fifteen (15) days from date of billing subject to merchandise return in original packed saleable and sealed pack condition only with original bill.<br> 
					5. No refund in form of Cash will be made. Only Credit Note can be issued instead of Cash refund. The amount of Credit Note is to be adjusted from future purchases to be made within a period of Fifteen (15) days from its issue and the amount of Credit Note cannot be converted in cash refund. In case of loss of Credit Note, duplicate shall not be issued.<br> 
					6.  Goods sold at discount do not carry any warranty or guarantee from the seller (LEL) and no claim/complain can be entertained about any defect or damage or on quality after completion of sale transaction.<br> 
					7. We are operating on discounted and lower price basis which are non-negotiable.<br> 
					8. While we would try and deal with any situation keeping our customers interest on priority: any dispute there under shall be subject to Indore jurisdiction only.<br> 
					9. The discretion of management of Laxyo Energy Ltd. shall be final and binding on customer.<br>  
					10. E. &amp; O. E.</h6>
					</section>
				</section>
				<div style="width: 200px;margin: auto;display: block">
			<center>
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAAyAQMAAADcGHRpAAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAQklEQVQ4je3KsQkAIAwEwAdbIas4gODqQtpAVhG+sbAQl7D6qw8A4WRY9jPp7itzjLYOSbNausXGo6ampqampvanXa/+C/tpfAuDAAAAAElFTkSuQmCC" width="150"><br>
			      POS {{ $salesManage->id }}	</center>
				<br>
				</div>
			</div>
		<div class="c col-md-3"></div>
	</div>

		</div>
	</div>

	<div id="footer">
		<!-- <div class="jumbotron push-spaces"> -->
			<!-- <strong>  			 - </strong>.
						<a href="https://github.com/jekkos/opensourcepos" target="_blank"></a>
			 -->
		<!-- </div> -->
	</div>
</div>
<script src="jquery-3.5.1.min.js"></script>

<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script type="text/javascript">
alert();

var subTotal = $('#sub_total span').text();
	$("#subTotal").text(subTotal);
$(window).on("load", function()
{
	// install firefox addon in order to use this plugin
	if(window.jsPrintSetup)
	{
					// set page header
			jsPrintSetup.setOption('headerStrLeft', '');
			jsPrintSetup.setOption('headerStrCenter', '');
			jsPrintSetup.setOption('headerStrRight', '');
					// set empty page footer
			jsPrintSetup.setOption('footerStrLeft', '');
			jsPrintSetup.setOption('footerStrCenter', '');
			jsPrintSetup.setOption('footerStrRight', '');
			}
});

$('#inv_cp_toggle').on('click',  function(){
	$(this).text($(this).text() == 'Print Seller Copy' ? 'Print Customer Copy' : 'Print Seller Copy');
	$('#inv_cp').text($('#inv_cp').text() == 'Seller Copy' ? 'Customer Copy' : 'Seller Copy');
});
</script>
<script type="text/javascript">
function printdoc()
{
	// install firefox addon in order to use this plugin
	if (window.jsPrintSetup)
	{
		// set top margins in millimeters
		jsPrintSetup.setOption('marginTop', '');
		jsPrintSetup.setOption('marginLeft', '');
		jsPrintSetup.setOption('marginBottom', '');
		jsPrintSetup.setOption('marginRight', '');

					// set page header
			jsPrintSetup.setOption('headerStrLeft', '');
			jsPrintSetup.setOption('headerStrCenter', '');
			jsPrintSetup.setOption('headerStrRight', '');
					// set empty page footer
			jsPrintSetup.setOption('footerStrLeft', '');
			jsPrintSetup.setOption('footerStrCenter', '');
			jsPrintSetup.setOption('footerStrRight', '');
		
		var printers = jsPrintSetup.getPrintersList().split(',');
		// get right printer here..
		for(var index in printers) {
			var default_ticket_printer = window.localStorage && localStorage['invoice_printer'];
			var selected_printer = printers[index];
			if (selected_printer == default_ticket_printer) {
				// select epson label printer
				jsPrintSetup.setPrinter(selected_printer);
				// clears user preferences always silent print value
				// to enable using 'printSilent' option
				jsPrintSetup.clearSilentPrint();
									// Suppress print dialog (for this context only)
					jsPrintSetup.setOption('printSilent', 1);
								// Do Print
				// When print is submitted it is executed asynchronous and
				// script flow continues after print independently of completetion of print process!
				jsPrintSetup.print();
			}
		}
	}
	else
	{
		window.print();
	}
}

</script>


@endsection

