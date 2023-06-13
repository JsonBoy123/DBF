
<table id="table" class="table table-hover table-striped mb-3">
  	<thead>
      	<tr>
      		<th>Sno.</th>                  		
      		<th>Display Name</th>
      		<th>Name</th>
      	</tr>
    </thead>  	
    <tbody>
    <?php $count =0; ?>
      @foreach($data as $Pers)
        <tr>
          <th>{{++$count}}</th>
          <th>
            <input <?php if(in_array($Pers->id,$ids)){ echo 'checked'; } ?> type="checkbox" class="check_perm" value="{{$Pers->id}}" name="permission_id[]">
          </th>
          <th>{{$Pers->name}} </th>          
        </tr>
      @endforeach
    </tbody>
</table>
<input type="hidden" id="model_id" value="{{$id}}">
<input type="hidden" id="user_id" value="{{$user_id}}">
<div style="margin-top:15px; ">
  <input type="submit" name="Save" value="Save" class="btn btn-success " id="save_permission">
</div>  