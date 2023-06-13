@extends('layouts.dbf')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<table class="table table-bordered" style="margin: 0px; border-right: 0px; font-size: 15px">
				<tbody><tr>
					<td style="padding: 5px;text-align: center;" class="text-right">Date <br> <b>{{$sale->sale_time}}</b></td>
					<td style="padding: 5px;text-align: center;">POS #<br> <b><span id="number">{{$sale->id}}</span><input type="" style="width:21px ; display: none" > <b></b></b></td>
					<td style="padding: 5px;text-align: center;">Refre. #<br> <b> {{$sale->invoice_number}} <b></b></b></td></tr>
				</tbody>
			</table>
		</div>
		<div class="col-md-6 text-right">
			<button class="btn btn-sm btn-primary" id="printBtn" onclick="window.print();return false;" />Print</button>
		</div>
	</div>
	<br>
	<div class="row">
		<div id="table_holder">
			<div class="bootstrap-table">
				<div class="fixed-table-toolbar" id="daily_sales">
					@if(count($rack_history) != 0)
						<table class="table table-bordered dataTables_wrapper" id="dailySales">
						  <thead class="thead-dark">
						    <tr>
						      <td class="text-center"><b>#</b></td>
						      <td class="text-center"><b>Name</b></td>
						      <td class="text-center"><b>Barcode</b></td>
						      <td class="text-center"><b>Quantity</b></td>
						      <td class="text-center"><b>Rack Info</b></td>
						    </tr>
						  </thead>
						  <tbody>
						  	@php $count = 0; @endphp
							  	@foreach($rack_history as $data)
							    <tr>
									<td class="text-center">{{++$count}}</td> 
									<td class="text-center">{{$data['item']->name}}</td>
							    	<td class="text-center">{{$data['item']->item_number}}</td>
							    	<td class="text-center">{{$data->quantity}}</td>
									<td class="text-center">{{$data['rack']->rack_number}}</td>
								 </tr>
							    @endforeach
						  </tbody>
						</table><br>
					@else
						<tr>
							<b><h4>No Items available here.</h4></b>
						 </tr>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	
$(document).ready( function(){

	$('#dailySales').DataTable( {
		"bPaginate": false,
		"paging": false
          /*dom: 'Bfrtip',
          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'pdfHtml5'
          ],*/
          order:[[0, 'asc']]
      } );

	$('#printBtn').on('click', function(){
		//$('#printBtn').hide();
		alert()
	})
});

</script>

@endsection
