@extends('layouts.dbf')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-6">
			<div id="page_title"><b>Sales History</b></div>
		</div>
		<div class="col-6">
			<div style="float: right"><a href="{{route('sales-check.index')}}" class="btn btn-info fa fa-long-arrow-left"><b> &nbsp Back </b></a></div><br>
		</div>
	</div>
		<div class="row" id="catsTable">
	    <div class="col-md-12 col-xl-12">
	    	@if($message = Session::get('success'))
		    	<div class="alert alert-success alert-block">
	              <button type="button" class="close" data-dismiss="alert">×</button>
	              {{$message}}
	            </div>
		    @endif
	      <div class="card shadow-xs">
	        <div class="card-body table-responsive">
	          <table class="table table-striped table-hover" id="SaleCheckTable">
	            <thead>
	              <tr class="text-center">
	                <th style="text-align:center">#</th>
	                <th style="text-align:center">Bill</th>
	                <th style="text-align:center">Customer</th>
	                <th style="text-align:center">Invoice No</th>
	                <th style="text-align:center">Sale Type</th>
	                <th style="text-align:center">Date</th>
	                <th style="text-align:center">Comment</th>
	                <th style="text-align:center">Detail</th>	
	              </tr>
	            </thead>
	            <tbody>
	            @php $count = 0; @endphp
				@foreach($sales_history as $sale)
	              <tr class="text-center">
	                <td>{{++$count}}</td>
	                <td>{{$sale->id}}</td>
	                <td>{{ucwords($sale['customer']->first_name).' '.ucwords($sale['customer']->last_name)}}</td>
                    <td>{{'LEL/'.$sale->tally_number}}</td>
	                <td>{{strtoupper($sale->sale_type)}}</td>
                    <td>{{$sale->created_at}}</td>
                    <td>{{$sale->comment}}</td>
	                <td><a href="{{route('sales-show.history', $sale->id)}}"><span title="Show Items" class="glyphicon glyphicon-list-alt"></span></a></td>
	              </tr>
	            @endforeach
	            </tbody>
	          </table>

	        
	        </div>
	      </div>
	    </div>
  	</div>
  	
</div>
<script>
$(document).ready(function() {
	$('#SaleCheckTable').dataTable({
		order: [[5, 'desc']],
		"columnDefs": [
		{'orderable': false, "target": 0}
		]
	});

});

</script>
@endsection('content')