<table>
	@foreach($data as $Data)
		<tr>
			<th><input type="checkbox" name="permission_id[]">{{$Data->name}}</th>
		</tr>
	@endforeach
</table>