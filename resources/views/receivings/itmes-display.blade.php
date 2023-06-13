
<?php //print_r(session('cart')); die; 
 ?>
@if(session('receiving_data') != null)
	<?php
	
		$session_data = session('receiving_data');
		?>
	@foreach($session_data as $data)
	{{-- @php	dd($data); @endphp --}}
	<tr>
			<td>
		      <form action="{{ route('remove_entry_session',$data['item_id']) }}" method="POST">
		        @csrf
		        <button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
		      </form>
			</td>
			<td>
				
				<input type="hidden" name="actual_qty[]" id="actual_qty_{{$data['item_id']}}" data-id="{{$data['item_id']}}" value="{{$data['actual_qty']}}">
				<input type="hidden" name="item_id[]" id="item_id_{{$data['item_id']}}" data-id="{{$data['item_id']}}" value="{{$data['item_id']}}">
				<input type="text" name="item_number" value="{{ $data['item_number'] ? $data['item_number'] : '' }}" class="form-control" readonly="true"></td>
			<td>
				<label class="form-control">{{ $data['name'] ? $data['name'] : ''}}</label><span>[In Stock: {{$data['actual_qty'] - $data['qty']}}]</span>
			</td>
			<td>
				<input type="text" name="unit_price[]" id="unit_price_{{$data['item_id']}}" value="{{$data['unit_price'] ? $data['unit_price'] : ''}}" class="form-control" readonly="true">
			</td>
			<td>
				<input type="number" name="qty[]" id="qty_{{$data['item_id']}}" data-id="{{$data['item_id']}}" value="{{ $data['qty'] ? $data['qty'] : ''}}" class="form-control qty_item">
			</td>
			<td>
				@if(session('mode')=='repair' && $data['repair_cat'] !='null')
					<select class="repair_select">
						<option value="">Select..</option>
						@foreach($data['repair_cat'] as $repair_cat)
							<option data-item_id = '{{$data['item_id']}}' {{ $data['repair_cat_id'] === $repair_cat->id ? 'selected':''}} data-cat_id='{{$repair_cat->id}}' id="repair_id_{{$repair_cat->id}}" value="{{$repair_cat->id}}">{{$repair_cat->name}}</option>
						@endforeach	
					</select>
				@else	
					<input type="text" name="total_cost[]" value="{{($data['unit_price'] * $data['qty']) }}" id="total_cost_{{$data['item_id']}}" data-id="{{$data['item_id']}}" class="form-control" readonly="true">
				@endif
			</td>
	{{-- {{dd($data)}} --}}
	</tr>
@endforeach

@else
	<tr>
		<td colspan="8">
			<div class="alert alert-dismissible alert-info">There are no Items in the cart.</div>
		</td>
	</tr>
@endif

