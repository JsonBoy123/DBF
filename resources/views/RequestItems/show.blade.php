<div class="col-md-12">
	<div class="row card-body text-center">
		<div class="bootstrap-table">
			<h4><b> {{-- {{stockRequest($shop, "shop_name")['name']}} --}}</b></h4>
			@if(count($stockTemp) != 0)
			<form action="{{route('stock-request.store')}}" method="post">
				<div class="row">
					<div class="col-md-12">
						<table class="table table-striped table-hover">
							<thead>
								<tr class="text-center">
									{{-- <th class="text-center">STATUS</th> --}}
									<th class="text-center">SHOP</th>
									<th class="text-center">ITEM NO</th>
									<th class="text-center">ITEM</th>
									<th class="text-center">QUANTITY</th>
								</tr>
							</thead>
							<tbody>
								@csrf()
								@php $count = 0; @endphp
								@foreach($stockTemp as $shop)
								<tr class="text-center">
									<input type="hidden" value="{{$shop->id}}" name="itemCheck[]">
									<input type="hidden" name="destination" value="{{$shop->destination_shop}}">
									<input type="hidden" name="shops[]" value="{{$shop->shop_id}}">
									<td>{{$shop['itemShop']->name}}</td>
									<td>{{$shop['item']->item_number}}</td>
									<td>{{$shop['item']->name}}</td>
									<td>{{$shop->quantity}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="col-md-12">
						<div><br>
							<label>COMMENT</label>
						</div>
						<textarea cols="140" id="comment" rows="3" name="comment"> </textarea>
					</div>
			<br>
			<button name="submit" class="btn btn-primary btn-sm">Submit</button>
			</div>
			</form>
			@else
				<b> THERE ARE NO ITEMS HERE, PLEASE SELECT AN ITEM FIRST. </b>
			@endif
		</div>
	</div>
</div>