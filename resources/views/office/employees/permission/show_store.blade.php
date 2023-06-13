@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row">
   		<div class="col-md-2"></div>  
   		<div class="col-md-8">
        <div id="title_bar" class="btn-toolbar mb-2">
        	<label>Select Module</label>
        	<select class="form-control" id="module_list">
        		<option>...Select...</option>
        		@foreach($module as $Module)
        			<option value="{{$Module->id}}">{{$Module->name}}</option>
        		@endforeach
        	</select>
	    
        </div>
        <div class="mt-3" style="margin-top: 48px;">
        	<hr>
        </div>
      	<div id="table_holder">
        	<div class="bootstrap-table">
            	<div class="fixed-table-toolbar">
              	<br>
               		<div id="puttable">	                  
                  
	                </div>
	                </div>
          		</div>
      		</div>
      		
  		</div>
  		<div class="col-md-2"></div> 
	</div>
</div>	

<script>
	$(document).on('change','#module_list',function(){
		let id = $(this).val();
		let user_id = {{$id}}
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			method:'post',
			url:'/get_shop/',
			data:{'user_id':user_id,'id':id},
			success:function(data){
				$('#puttable').html(data)
			}
		})
	})

	$(document).on('click','#save_permission',function(){
		let user_id = $('#user_id').val();
		let model_id = $('#module_list').val()		
		let ids = [];  
    	$(".check_perm:checked").each(function(){
        	ids.push($(this).val()); //this.id
        });
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			method:'post',
			url:'/give_shop_permission/',
			data:{'user_id':user_id,'ids':ids,'model_id':model_id},
			success:function(data){
				alert(data)			
			}
		})	
	})
</script>


@endsection