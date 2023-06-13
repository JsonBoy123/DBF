@extends('layouts.dbf')

@section('content')

<div class="container">
	<div id="page_title">Category Summery Report</div><br>
	{{-- <div style="font-size: 20px"><b>Time Duration - </b> {{$date['to']}} To {{$date['from']}}</div> --}}
	@if(isset($items) == true)
		<div class="row" id="catsTable">
	    <div class="col-md-12 col-xl-12">
	      <div class="card shadow-xs">
	        <div class="card-body table-responsive">
	          <table class="table table-striped table-hover" id="CategoryTable">
	            <thead>
	              <tr class="text-center">
	                <th style="text-align:center">Item Id</th>
	                <th style="text-align:center">Barcode</th>
	                <th style="text-align:center">Item Name</th>
	                <th style="text-align:center">Quantity</th>
	                <th style="text-align:center">Item Age (In days)</th>
	              </tr>
	            </thead>
	            <tbody>
	          @php $count = 0;
	           	foreach($items as $val){ 
	           		$fromDate = date('Y-m-d');
					$toDate = $val['updated_at'];
					$diff = strtotime($fromDate) - strtotime($toDate);
					$days  = abs(round($diff / 86400));
					/*$interval = $fromDate->diff($toDate);
					$days = $interval->format('%a');*/
/*					$datetime1 = strtotime($fromDate); // convert to timestamps
					$datetime2 = strtotime($toDate); // convert to timestamps
					$days = (int)(($datetime1 - $datetime2)/86400);*/
	          @endphp
	              <tr class="text-center">
	                <td>{{ $val['item']->id }}</td>
	                <td>{{ $val['item']->item_number }}</td>
	                <td>{{ $val['item']->name }}</td>
	                <td>{{ $val['quantity'] }}</td>
	                <td>{{ $days }}</td>
	              </tr>

	            @php } @endphp
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
		
		$('#CategoryTable').dataTable({
			order: [[1, 'asc']],
			"columnDefs": [
			{'orderable': false, "target": 0}
			],
			dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
		});
	});


</script>
@endsection
