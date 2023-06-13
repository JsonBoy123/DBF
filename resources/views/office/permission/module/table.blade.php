<table id="table" class="table table-hover table-striped">
	<thead>
  		<tr>
  			<th>Sno.</th>                  		
  			<th>Name</th>
  		</tr>
	</thead>  	
	<tbody>
		<?php $count=0; ?>
		@foreach($data as $Data)
			<tr>
				<th>{{++$count}}</th>
				<th>{{$Data->name}}</th>
			</tr>
		@endforeach
	</tbody>
</table>