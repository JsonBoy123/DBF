@extends('layouts.dbf')

@section('content')

<div class="container">
	<div id="page_title">Category Summery Report</div><br>

	@if(isset($items) == true)
		<div class="row" id="catsTable">
	    <div class="col-md-12 col-xl-12">
	      <div class="card shadow-xs">
	        <div class="card-body table-responsive">
	          <table class="table table-striped table-hover" id="CategoryTable">
	            <thead>
	              <tr class="text-center">
	                <th style="text-align:center">Item Name</th>
	                <th style="text-align:center">Barcode</th>
	                <th style="text-align:center">Quantity</th>
	                <th style="text-align:center">Reorder Level</th>
	                <th style="text-align:center">Stock Location</th>
	                <th style="text-align:center">Wholesale Price</th>
	                <th style="text-align:center">Retail Price</th>
	                <th style="text-align:center">Subtotal</th>
	              </tr>
	            </thead>
	            <tbody>
	          @php $count = 0;
	          //dd($items);
	           	foreach($items as $val){ 
	          @endphp
	              <tr class="text-center">
	                <td>{{ $val['item']->name }}</td>
	                <td>{{ $val['item']->item_number }}</td>
	                <td>{{ $val['quantity'] }}</td>
	                <td>{{ $val['item']->reorder_level }}</td>
	                <td>{{ $val['shop']->name }}</td>
	                <td>{{ $val['item_discount']->retail }}</td>
	                <td>{{ $val['item_discount']->wholesale }}</td>
	                <td>₹ 0</td>
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
