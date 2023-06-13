@extends('layouts.dbf')

@section('content')
<div class="container">
	<div id="page_title">Receivings Items List</div><br>
	<div ><a href="{{route('receivings-check.index')}}" class="btn btn-info fa fa-long-arrow-left" style="float:right"><b>&nbsp Back </b></a></div><br>
	<div class="row">
		<div class="col-md-2">
			<label><h4>BIll No. - {{$receiving->id}}</h4></label>
		</div>
		<div class="col-md-3">
			<label><h4>Quantity - {{$recv_qty}} </h4></label>
		</div>
	</div>
	<div class="col-md-12">
      	<label for="">
			@error('item_check')
		   		<span style="color: red">YOU MUST CHECK All FIELDS</span> 
		   		<span for="item_check" generated="true" class="dangerCls"></span>
			@enderror
		</label>
    </div>
		<form action="{{route('receivings-check.update', $items[0]->receiving_id)}}" method="post">
			@csrf()
			@method('patch')
		    <input type="submit" class="btn btn-sm btn-primary" style="float: right;margin-bottom: 13px;" name="confirmCheck" value="Confirm Check">
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
		                	<input type="checkbox" id="item_checkbox" required="true" name="item_check[{{$item->id}}]" value='1'>
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
	  	</form>
  	<br><br>
</div>
<script>
$(document).ready(function() {
	$('#ItemsTable').dataTable({

		order: [[0, 'asc']],
		"columnDefs": [
		{'orderable': false, "target": 0}
		],
		"bPaginate": false
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