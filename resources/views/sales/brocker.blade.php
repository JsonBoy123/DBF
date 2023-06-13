<form id="brocker_form" method="post">
	@csrf	
	<div class="row">
		<div class="col-sm-12">
			<select name="person_id" class="form-control">
				<option value="">Select Person...</option>
				@foreach($data as $Data)
					<option value="{{$Data->id}}">{{$Data->name}}</option>
				@endforeach	
			</select>
		</div>
		<div class="col-sm-12">
			<label>Item Barcode</label>
			<input name="item_id" class="form-control">
			<input type="hidden" value="{{$sale_id}}" name="sale_id" class="btn btn-success mt-3">
		</div>
		<div class="col-sm-12 text-right ">
			<input type="submit" value="submit" class="btn btn-success mt-3">
		</div>
	</div>
</form>
