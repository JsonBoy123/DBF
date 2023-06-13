@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row">
   		<div class="col-md-2"></div>  
   		<div class="col-md-8">
        <div id="title_bar" class="btn-toolbar">
	         <button class="btn btn-info btn-sm  modal-dlg" data-btn-submit="Submit" title="New Employee"  data-toggle="modal" id="add_permission" data-target="#addEmployee">
	         <span class="glyphicon glyphicon-user">&nbsp;</span>New Permission</button>
           <a class="btn btn-info btn-sm  modal-dlg" href="{{route('module.index')}}">Module </a>
           <div class="pull-right">
          </div>  
        </div>
        <hr>
        <div>
        </div>
      	<div id="table_holder">
        	<div class="bootstrap-table">
            	<div class="fixed-table-toolbar">
              	<br>
               		<div id="puttable">	                  
                  <table id="table" class="table table-hover table-striped mb-3">
                      <thead>
                          <tr>
                            <th>Sno.</th>                     
                            <th>Module Name</th>                     
                            <th>Display Name</th>
                            <th>Permission Name</th>
                          </tr>
                      </thead>    
                      <tbody>
                      <?php $count =0; ?>
                        @foreach($data as $Pers)
                          <tr>
                            <th>{{++$count}}</th>
                            <th>{{$Pers->module->name}}</th>
                            <th>
                              <input <?php if(in_array($Pers->id,$ids)){ echo 'checked'; } ?> type="checkbox" class="check_perm" value="{{$Pers->id}}" name="permission_id[]">
                            </th>
                            <th>{{$Pers->name}} </th>          
                          </tr>
                        @endforeach
                      </tbody>
                  </table>
                  <input type="hidden" id="user_id" value="{{$id}}">
                  <div style="margin-top:15px; ">
                    <input type="submit" name="Save" value="Save" class="btn btn-success " id="save_permission">
                  </div>  
	                </div>
	                </div>
          		</div>
      		</div>
      		
  		</div>
  		<div class="col-md-2"></div> 
	</div>
</div>	

<script>
	$(document).on('change','#getpermission',function(){
		let id = $(this).val();
		let user_id = {{$id}}
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			method:'post',
			url:'/get_model_permission/',
			data:{'user_id':user_id,'id':id},
			success:function(data){
				$('#puttable').html(data)
			}
		})
	})

	$(document).on('click','#save_permission',function(){
		let user_id = $('#user_id').val();
		let model_id = $('#model_id').val()		
		let ids = [];  
    	$(".check_perm:checked").each(function(){
        	ids.push($(this).val()); //this.id
        });
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			method:'post',
			url:'/give_permission/',
			data:{'user_id':user_id,'permission_id':ids},
			success:function(data){
				alert(data)			
			}
		})	
	})
</script>


@endsection