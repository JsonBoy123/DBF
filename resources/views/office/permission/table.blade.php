<table id="table" class="table table-hover table-striped">
  	<thead>
      	<tr>
      		<th>Sno.</th>                  		
      		<th>Display Name</th>
      		<th>Name</th>
      		<th>Module</th> 
      	</tr>
    </thead>  	
    <tbody>
    <?php $count =0; ?>
      @foreach($data as $Pers)
        <tr>
          <th>{{++$count}}</th>
          <th>{{$Pers->display_name}}</th>
          <th>{{$Pers->name}}</th>
          <th>{{$Pers->module->name}}</th>
        </tr>
      @endforeach
    </tbody>
</table>