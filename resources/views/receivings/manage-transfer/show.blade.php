<table id="myTable" class="table table-hover">
	<thead>
		<tr>
			<th class="text-center">Barcode</th>
			<th class="text-center">Name</th>
			<th class="text-center">Quantity</th>
		</tr>
	</thead>
	<tbody>

	@foreach($data as $index)
	@if($index->line%2 == 0)
		<tr>
			<td class="text-center">{{$index['item']->item_number}}</td>
			<td class="text-center">{{$index['item']->name}}</td>
			<td class="text-center">{{$index->quantity_purchased}}</td>
			{{-- <td class="text-center">{{$index->line}}</td> --}}
		</tr>
	@endif
	@endforeach
	</tbody>
</table>
<script type="text/javascript">
	var val = '{{$index}}'
	console.log(val)
</script>