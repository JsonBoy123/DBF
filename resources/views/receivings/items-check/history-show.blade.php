@extends('layouts.dbf')

@section('content')
<div class="container">
	<div id="page_title"><b>Receivings Items List</b></div>
	<div ><a href="{{route('receiving-check.history')}}" class="btn btn-info fa fa-long-arrow-left" style="float:right"><b>&nbsp Back </b></a></div>
	<div class="row">
		<div class="col-md-2">
			<label><h4>BIll No. - {{$receiving->id}}</h4></label>
		</div>
		<div class="col-md-2">
			<label><h4>Quantity - {{$recv_qty}} </h4></label>
		</div>
		<div class="col-md-3">
			<label><h4>Status - 
				@if($receiving->security_check == 1)
					<span style="color: #81d481"><b><i class="fa fa-check" aria-hidden="true"></i> APPROVED </b></span>
				@else
					<span style="color: #ff6060"><b><i class="fa fa-times" aria-hidden="true"></i> REJECTED </b></span>
				@endif
			</h4></label>
		</div>
	</div>
			<div class="row" id="catsTable">
		    <div class="col-md-12 col-xl-12">
		      <div class="card shadow-xs">
		        <div class="card-body table-responsive">
		          <table class="table table-striped table-hover" id="ItemsTable">
		            <thead>
		              <tr class="text-center">
		                <th style="text-align:center">#</th>
		                <th style="text-align:center">BARCODE</th>
		                <th style="text-align:center">NAME</th>
		                <th style="text-align:center">QUANTITY</th>
		                <th style="text-align:center">ACTION</th>	
		              </tr>
		            </thead>
		            <tbody>
		            @php $count = 0; @endphp
					@foreach($items as $item)
						@if($item->line % 2 == '0' )
		              <tr class="text-center">
		                <td>{{++$count}}</td>
		                <td>{{$item['item']->item_number}}</td>
		                <td>{{$item['item']->name}}</td>
	                    <td>{{$item->quantity_purchased}}</td>
	                    <input type="hidden" name="receive_id[]" value="{{$item->id}}">
		                <td>
		                	@if($item->security_check == 1)
		                		<i style="color: #81d481" class="fa fa-check fa-lg" aria-hidden="true"></i>
		                	@else
		                		<i style="color: #ff6060" class="fa fa-times fa-lg" aria-hidden="true"></i>
		                	@endif
		                </td>
		              </tr>
		              @endif
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
	$('#ItemsTable').dataTable({

		order: [[0, 'asc']],
		"columnDefs": [
		{'orderable': false, "target": 0}
		],
		"iDisplayLength" : 25
	});

	
});


$(document).on('keyup','#ItemsTable_filter label input',function(){
	if($(this).val().length >= 10){
		$('#ItemsTable tr td input').attr('checked','checked')

		setTimeout(function(){
           $('#ItemsTable_filter label input').val('')            
        }, 1000);
	}
	
})
</script>
@endsection('content')