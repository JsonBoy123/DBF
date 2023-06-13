@extends('layouts.dbf')

@section('content')

<div class="container">
	<div class="row">
		
		<div class="col-md-12 col-xl-12">
	      <div class="card shadow-xs">
	        <div class="card-body table-responsive">
	          <table class="table table-striped table-hover" id="ChallanTable">
	            <thead>
	              <tr class="text-center">
	                <th style="text-align:center">SN.</th>
	                <th style="text-align:center">Barcode</th>
	                <th style="text-align:center">Name of Goods</th>
	                <th style="text-align:center">Category</th>
	                <th style="text-align:center">Subcategory</th>
	                <th style="text-align:center">Quantity</th>
	                <th style="text-align:center; display: none">MRP</th>
	                <th style="text-align:center; display: none">Fixed SP</th>
	                <th style="text-align:center; display: none">PP</th>
	              </tr>
	            </thead>
	            <tbody>
	           	@foreach($receiving_items as $index)
	              <tr class="text-center">
	                <td>{{$index['item']->id}}</td>
	                <td> {{$index['item']->item_number}}</td>
	                <td> {{$index['item']->name}}</td>
	                <td> {{$index['item']['categoryName']->category_name}}</td>
	                <td> {{$index['item']['subcategoryName']->sub_categories_name}}</td>
	                <td>{{round($index->quantity_purchased)}}</td>
	                <td style="text-align:center; display: none">{{$index['item']->unit_price}}</td>
	                <td style="text-align:center; display: none">{{$index['item']->fixed_sp}}</td>
	                <td style="text-align:center; display: none">{{$index['item']->actual_cost}}</td>
	              </tr>
	            @endforeach
	            </tbody>
	          </table>
	        </div>
	      </div>
	    </div>
		
	</div>
</div>
<script type="text/javascript">
   
   $(document).ready( function () {
 
    $('#ChallanTable').DataTable({
      dom: 'Bfrtip',
       buttons: [ { extend: 'copyHtml5' },
            { extend: 'excelHtml5' },
            { extend: 'print'},
            { extend: 'pdfHtml5'}
            ]
    });
});
</script>
@endsection