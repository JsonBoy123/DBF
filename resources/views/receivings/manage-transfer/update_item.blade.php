@extends('layouts.dbf')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12 col-xl-12 text-right ">
		@if($receivingDetails->repair != 2)	
			<button id="complete_repair" class="btn btn-primary">Complete</button>		
		@endif	
	</div>
		<div style="margin-top: 15px;" class="col-md-12 col-xl-12 mt-5">
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
	                <th style="text-align:center">Repair Quantity</th>
	                <th style="text-align:center">Damage Quantity</th>
	                <th style="text-align:center">Quantity</th>
	              </tr>
	            </thead>
	            <tbody>
	           	@foreach($receiving_items as $index)
	              <tr class="text-center">	              	
	           		
	                <td>{{$index['item']->id}}<input type="hidden" class="item_id" value="{{$index['item']->id}}"></td>
	                <td> {{$index['item']->item_number}}<input type="hidden" class="repair_id" value="{{$index->repair_price}}"></td>
	                <td> {{$index['item']->name}}</td>
	                <td> {{$index['item']['categoryName']->category_name}}</td>
	                <td> {{$index['item']['subcategoryName']->sub_categories_name}}</td>
	                <td> <input style="width: 112px;" {{$index->repair_status ==1 ? 'readonly':''}} value="{{ RepairItems($index->receiving_id,$index->item_id) != null ? RepairItems($index->receiving_id,$index->item_id)->complete:''}}" placeholder="Repair Done" class="repair form-control" ></td>
	                <td> <input style="width: 112px;" {{$index->repair_status ==1 ? 'readonly':''}} value="{{ RepairItems($index->receiving_id,$index->item_id) != null ? RepairItems($index->receiving_id,$index->item_id)->uncomplete:''}}" placeholder="Damage" class="damage form-control"></td>
	                <td>{{round($index->quantity_purchased)}}</td>
	              </tr>
	            @endforeach
	            </tbody>
	          </table>
	        </div>
	      </div>  
	    </div>
		@csrf
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

$(document).on('click','#complete_repair',function(){
	var repair = [];
	var item_id = [];
	var damage = [];
	var repair_id = [];
	var rec_id = {{$id}};

	$('.repair').each(function(){
		repair.push($(this).val())
	})

	$('.damage').each(function(){
		damage.push($(this).val())
	})

	$('.item_id').each(function(){
		item_id.push($(this).val())
	})

	$('.repair_id').each(function(){
		repair_id.push($(this).val())
	})
	alert(repair_id);
	var _token = $('input[name="_token"]').val()
	$.ajax({
		method:'post',
		url:'{{route('ReturnRepairItem')}}',
		data:{'item_id':item_id, 'repair':repair,'damage':damage,'repair_id':repair_id,'rec_id':rec_id, '_token': _token},
		success:function(data){
			console.log(data)
		}
	});
})
</script>
@endsection