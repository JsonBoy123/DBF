@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row">
   		<div class="col-md-2"></div>  
   		<div class="col-md-8">
        <div id="title_bar" class="btn-toolbar">
	         <button class="btn btn-info btn-sm  modal-dlg" data-btn-submit="Submit" title="New Employee"  data-toggle="modal" id="add_permission" data-target="#addEmployee">
	         <span class="glyphicon glyphicon-user">&nbsp;</span>New Permission</button>
           <a class="btn btn-info btn-sm  modal-dlg" href="{{route('module.index')}}">Module</a>
           <div class="pull-right">
            <select class="form-control" id="getpermission">
              <option>Select...</option>
              @foreach($data as $Data)
                <option value="{{$Data->id}}">{{$Data->name}}</option>
              @endforeach
            </select>
          </div>  
        </div>
        <hr>
        <div>
        </div>
      	<div id="table_holder">
        	<div class="bootstrap-table">
            	<div class="fixed-table-toolbar">
              	<br>
               		<div  id="puttable">
	                  
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
                              <label for="name" class="required" aria-required="true">Module</label>        
                              <div class="col-md-8" style="float: right;">
                                 <select name="moule_id" class="form-control">
                                   <option>Select</option>
                                   @foreach($data as $Data)
                                    <option value="{{$Data->id}}">{{$Data->name}}</option>
                                   @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="name" class="required" aria-required="true">Name</label>        
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="name" id="name" class="form-control input-sm">
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="name" class="" aria-required="true">Display Name</label>        
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="display_name" id="name" class="form-control input-sm">
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
		$.ajax({
			method:'post',
			url:"{{route('acl.store')}}",
			data:$('#formValidate').serialize(),
			success:function(data){
				$('#puttable').html(data)
				$('#myModal').hide();

			}
		})
	})

  $(document).on('change','#getpermission',function(event){
    var id = $(this).val()
    $.ajax({
      method:'get',
      url:"acl/get/"+id,
      data:$('#formValidate').serialize(),
      success:function(data){
        $('#puttable').html(data)
        $('#myModal').hide();

      }
    })
  })

 
</script>
@endsection