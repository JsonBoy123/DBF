@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row">
   		<div class="col-md-2"></div>  
   		<div class="col-md-8">
        <div id="title_bar" class="btn-toolbar">
	         <button class="btn btn-info btn-sm  modal-dlg" data-btn-submit="Submit" title="New Employee"  data-toggle="modal" id="add_permission" data-target="#addEmployee">
	         <span class="glyphicon glyphicon-user">&nbsp;</span>New Module</button>
           <a href="{{route('acl.index')}}" class="btn-sm btn btn-primary">Back</a>
        </div>
      	<div id="table_holder">
        	<div class="bootstrap-table">
            	<div class="fixed-table-toolbar">
               		<br>

               		<div  id="puttable">
	                  <table id="table" class="table table-hover table-striped">
	                  	<thead>
		                  	<tr>
		                  		<th>Sno.</th>                  		
		                  		<th>Name</th>
                          <th>Action</th>
		                  	</tr>
		                </thead>  	
		                <tbody>
                      <?php $count = 0; ?>
                      @foreach($data as $Data)
                        <tr>
                          <th>{{++$count}}</th>
                          <th>{{$Data->name}}</th>
                          <th>
                            <a data-id="{{$Data->id}}" class="edit text-info fa fa-pencil"></a>                            
                          </th>
                        </tr>
                      @endforeach
		                </tbody>
	                  </table>
	              </div>
	                </div>
          		</div>
      		</div>
  		</div>
  		<div class="col-md-2"></div> 
	</div>
</div>	


<div id="myModal" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;">
                     <button class="close" data-dismiss="modal">×</button>
               </div>
               <div class="bootstrap-dialog-title" id="c0535119-0563-480e-a1ee-c9f1f55db5f3_title">New Item</div>
            </div>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
               <div class="bootstrap-dialog-message">
                  <div>
                    <div id="required_fields_message">Fields in red are required</div>
                    <form id="formValidate" class="form-horizontal" >
                     @csrf
                        <fieldset id="item_basic_info">
                           <div class="form-group col-md-12">
                              <label for="name" class="required" aria-required="true">Name</label>        
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="name" id="name" class="form-control input-sm">
                                 <input type="hidden" id="update_id" >
                              </div>
                           </div>
                        </fieldset>
                        
                     <div class="modal-footer" style="display: block;">
                        <div class="bootstrap-dialog-footer">
                           <div class="bootstrap-dialog-footer-buttons">
                              <button class="btn btn-primary" id="submit" name="submit">Submit</button>
                           </div>
                        </div>
                     </div>
                    </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Add Modal --> 
<script>
	$(document).on('click','#add_permission',function(){
		$('#myModal').show();
	})
	$(document).on('click','.close',function(){
		$('#myModal').hide()
	})

	$(document).on('click','#submit',function(event){
		event.preventDefault()
    let update_id = $('#update_id').val()
    if(update_id ==''){
  		$.ajax({
  			method:'post',
  			url:"{{route('module.store')}}",
  			data:$('#formValidate').serialize(),
  			success:function(data){
  				$('#puttable').html(data)
  				$('#myModal').hide();

  			}
  		})
    }
    else{
        $.ajax({
          method:'post',
          url:"module/update/"+update_id,
          data:$('#formValidate').serialize(),
          success:function(data){
            $('#puttable').html(data)
            $('#myModal').hide();

          }
      })
    }
	});


  $(document).on('click','.edit',function(){
    let id = $(this).attr('data-id');
    $.ajax({
      method:'get',
      url:"/Office/module/edit/"+id,
      success:function(data){
        console.log(data.name)
        $('#name').val(data.name)
        $('#update_id').val(data.id)
        $('#myModal').show();

      }

    })


  })

</script>
@endsection