@extends('layouts.dbf')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-6">
			<div id="page_title"><b>Receivings History </b></div>
		</div>
		<div class="col-6">
			<div style="float: right"><a href="{{route('receivings-check.index')}}" class="btn btn-info fa fa-long-arrow-left"><b> &nbsp Back</b> </a></div>
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
	          <table class="table table-striped table-hover" id="SecurityCheckTable">
	            <thead>
	              <tr class="text-center">
	                <th style="text-align:center">ID</th>
	                <th style="text-align:center">DC</th>
	                <th style="text-align:center">FROM</th>
	                <th style="text-align:center">TO</th>
	                <th style="text-align:center">DISPATCHER</th>
	                <th style="text-align:center">DATE</th>
	                <th style="text-align:center">NOTE</th>
	                <th style="text-align:center">Receving Date</th>
	                <th style="text-align:center">DETAIL</th>	
	              </tr>
	            </thead>
	            <tbody>
	            @php $count = 0; @endphp
				@foreach($receivings as $receiving)
	              <tr class="text-center">
	                <td>{{++$count}}</td>
	                <td>{{$receiving->id}}</td>
	                <td>{{get_shop_name($receiving->employee_id)['name']}}</td>
                    <td>{{get_shop_name($receiving->destination)['name']}}</td>
	                <td>{{get_cashier_name($receiving->dispatcher_id)['name']}}</td>
                    <td>{{$receiving->created_at}}</td>
                    <td>{{$receiving->comment}}</td>
	                <td>{{ date('d-m-Y', strtotime($receiving->receiving_time)) }}</td>
	                <td><a href="{{route('receiving-show.history', $receiving->id)}}"><span title="Show Items list" class="glyphicon glyphicon-list-alt"></span></a></td>
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
	$('#SecurityCheckTable').dataTable({
		order: [[5, 'desc']],
		"columnDefs": [
		{'orderable': false, "target": 0}
		]
	});

});

</script>
@endsection('content')