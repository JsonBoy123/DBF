
@extends('layouts.dbf')

@section('content')

<div class="container">

	<div class="print_hide" id="control_buttons" style="text-align:right">
		
		<a href="javascript:printdoc();" onclick="window.print()">
			<div class="btn btn-info btn-sm", id="show_print_button">
				<span class="glyphicon glyphicon-print">&nbsp</span>Print
			</div>
		</a>
		 
	</div>
</div>

	<div class="container" id="remove-border">
		<div class="b col-md-3"></div>
		<div class="b col-md-6" style="outline: 1px solid #cfcfcf;outline-offset: -15px;">
			<section style="margin-bottom: -20px">
				<div class="row" align="center">
					<h3><b>Yolax InfraEnergy Private Limited</b></h3>
				</div>
			</section>
			<hr>
			<section style="margin-bottom: -20px">
				<div class="row">
					<div class="col-md-6">
						<span style="font-size:0.9em; margin-left: 20px">
							YOLAX INFRAENARGY PVT. LTD 
							</span><br><span style="font-size:0.9em; margin-left: 20px">
							Laxyo House, Plot No. 2 County Park,
							</span><br><span style="font-size:0.9em; margin-left: 20px">
							Mahalaxmi Nagar, Indore M.P.
						</span>
					</div>
					<div class="col-md-6">
						<table class="table table-bordered" style="margin: 0px; border-right: 0px; font-size: 10px">
							<tr>
								<td colspan="2" align="center">Invoice/Bill #<br>  <b>YIPL/21-22/@if(!empty($challan)){{$challan->id}}@endif<b/></td>
								<td align="center">Date #<br> <b> @if(!empty($challan)){{$challan->bill_date}}@endif</b></td>
							</tr>
						</table>
					</div>
				</div>
			</section><hr>
			<section style="margin-top: -10px">
				<div class="row">
					<div class="col-md-6" style="margin-left: 10px">
						<b>Name : DBF Repairing Panel</b><br>
					</div>
				</div>
				
			</section>
			<section style="margin-top: 10px">
				<table class="table table-bordered table-condensed" style="font-size: 10px;">
					<thead>
						<tr>
							<td style="text-align:center; font-weight:bold;" colspan="2">Particulars</td>
							<td style="text-align:center; font-weight:bold;" colspan="2">Model number</td>
							<td style="text-align:center; font-weight:bold;" colspan="2">Quantity</td>
							<td style="text-align:center; font-weight:bold;" colspan="2">Repair Cost</td>
						</tr>
	            	</thead>
		            <tbody>
		              @if(!empty($challan))
		            	@foreach($challan['repairItems'] as $data)
		                <tr>
		                	<td style="text-align:left;" colspan="2" class="blank-bottom">{{ $data['item']->name }}</td>
		                	<td style="text-align:center;" colspan="2" class="blank-bottom">{{ $data['item']->model }}</td>
		                	<td style="text-align:center;" colspan="2" class="blank-bottom">{{ $data->qty }}</td>
		                	<td style="text-align:center;" colspan="2" class="blank-bottom">{{ $data->repair_cost }}</td>
		                </tr>
		                @endforeach
			            <tr>
							<td colspan="6" class="blank-bottom"></td> <!-- KEYS -->
							<td style="font-size:0.9em; width: 20%"></td>
			                <td style="text-align:right; font-size:0.9em;"></td>
		             	</tr>

		                <tr>
		                   <td style="text-align:right;"><b>Total</b></td>
		                   <td colspan="4"> </td>
		                   <td style="text-align:center">{{ $challan->quantity }}</td>
		                   <td colspan="2" style="text-align:center;">{{ $challan->bill_amount }}</td>
		                </tr>
						<tr>
							<td style="text-align:right;"><b>Amount in words</b></td>
							<td></td>
							<td colspan="6" style="text-align:center;">  </td>
						</tr>
					  @else
					  	<tr>
							<td colspan="6" class="blank-bottom"></td> <!-- KEYS -->
							<td style="font-size:0.9em; width: 20%"></td>
			                <td style="text-align:right; font-size:0.9em;"></td>
		             	</tr>
					  	<tr>
							<td style="text-align:right;"><b>Note : </b></td>
							<td></td>
							<td colspan="6" style="text-align:center;"><p style="color: red"> No Item Found...... </p></td>
						</tr>
					  @endif
						<tr>
		                	<td style="text-align:right;"><b>Payment Details</b></td>
		                	<td colspan="4" align="center">Cash : <i class="fa fa-square-o fa-lg" aria-hidden="true"></i></td>
		                	<td colspan="4" align="center">Account : <i class="fa fa-square-o fa-lg" aria-hidden="true"></i></td>
		                </tr>
		            </tbody>
				</table>
			</section>
			<section style="font-size: 10px;">
				<div class="text-center" style="width: 30%;float: left;border: 1px solid #ddd; padding: 5px;">
					Cashier Signature <br><br>
					_______________
				</div>
				<div class="text-center" style="width: 40%;float: left;border: 1px solid #ddd;border-left: 0px;border-right: 0px; padding: 5px;">
					Authority Signature <br><br>
					_______________
				</div>
				<div class="text-center" style="width: 30%;float: left;border: 1px solid #ddd;border-right: 0px; padding: 5px;">
					Reciever Signature<br><br>
					_______________
				</div>
			</section>
			<div class="clearfix"></div>
			<br>
			
		</div>
	</div>


@endsection
