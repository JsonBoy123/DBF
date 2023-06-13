@extends('layouts.dbf')

@section('content')

<div class="container">
	<div class="row">
      	<div>
      		<h5><b>Total Quantity - {{$qty}}</b></h5>
      	</div>
		
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
	              </tr>
	            </thead>
	            <tbody>
	           	@foreach($items as $index)
	              <tr class="text-center">
	                <td>{{$index['item']->id}}</td>
	                <td> {{$index['item']->item_number}}</td>
	                <td> {{$index['item']->name}}</td>
	                <td> {{$index['item']['categoryName']->category_name}}</td>
	                <td> {{$index['item']['subcategoryName']->sub_categories_name}}</td>
	                <td>{{round($index->quantity)}}</td>
	              </tr>
	            @endforeach
	            </tbody>
	          </table>
	        </div>
	      </div>
	    </div>
	    @if($request->decline_admin_reason != '')
		    <div class="row">
		    	<div class="col-md-4">
		    		<h5 style="color: #d43f3a"><b>Reason for declination (by Laxyo House) -</b></h5>
		    	</div>
		    	<div class="col-md-12">
		    		<b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{ucwords($request->decline_admin_reason)}}</b>
		    	</div>
		    </div>
	    @endif
		{{-- @if($request->decline_admin_reason != '')
			<div class="row">
		    	<div class="col-md-4">
		    		<h5><b>Reason for declination (by Laxyo House) -</b></h5>
		    	</div>
		    	<table class="table table-striped table-hover" id="ChallanTable">
		            <thead>
		              <tr class="text-center">
		                <th style="text-align:center">SN.</th>
		                <th style="text-align:center">Barcode</th>
		                <th style="text-align:center">Name of Goods</th>
		                <th style="text-align:center">Category</th>
		                <th style="text-align:center">Subcategory</th>
		                <th style="text-align:center">Quantity</th>
		              </tr>
		            </thead>
		          </table>
		    </div>
	    @endif --}}
		
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