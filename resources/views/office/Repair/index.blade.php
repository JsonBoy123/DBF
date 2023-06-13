@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row">
      <div id="title_bar" class="btn-toolbar">
         <button class="btn btn-info btn-sm pull-right modal-dlg" data-btn-submit="Submit" title="New Employee"  data-toggle="modal" data-target="#addEmployee">
         <span class="glyphicon glyphicon-user">&nbsp;</span>New Entry</button>
    </div>
      <div id="table_holder">
         <div class="bootstrap-table">
            <div class="fixed-table-toolbar">
               <br>
               <div class="col-md-12">
                  <table id="table" class="table table-hover table-striped">
                     <thead id="table-sticky-header">
                        <tr>
                           
                           <th class="" style="" data-field="people.person_id">
                              <div class="th-inner sortable both desc">Id</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="first_name">
                              <div class="th-inner sortable both">Name</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Cost</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Action</div>
                              <div class="fht-cell"></div>
                           </th>
                        </tr>
                     </thead>
                     <tbody>
                     	@if(!empty($data))
                     		@foreach($data as $Data)
		                        <tr data-index="1" data-uniqueid="{{ $Data->id }}">
		                           
		                           <td class="" style="">{{ $Data->id }}</td>
                                 <td class="" style="">{{ $Data->name }}</td>
		                           <td class="" style="">{{ $Data->cost }} </td>
		                           <td>
                              		<button class="btn btn-info btn-sm modal-dlg" data-btn-submit="Submit" title="Edit Broker"  data-toggle="modal" data-target="#updateEmployee{{ $Data->id }}"><span class="glyphicon glyphicon-edit"></span></button>
                              
                              		<a href="#{{-- {{ route('broker_commisssion.destroy',$emp->id) }} --}}" class="btn btn-primary btn-sm modal-dlg" data-btn-submit="Submit" title="Delete Broker"><span class="glyphicon glyphicon-trash"></span></a>
		                           
                                 </td>

                                  <!-- update Employee model -->

               <div class="modal bootstrap-dialog modal-dlg type-primary fade size-normal" id="updateEmployee{{ $Data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <div class="bootstrap-dialog-header">
                              <div class="bootstrap-dialog-close-button" style="display: block;"><button class="close" data-dismiss="modal" aria-label="Close">×</button></div>
                              <div class="bootstrap-dialog-title" id="843c6dbe-5fbb-46b4-949e-d82a725b4154_title">Update Employee</div>
                           </div>
                        </div>
                        <div class="modal-body">
                           <div class="bootstrap-dialog-body">
                              <div class="bootstrap-dialog-message">
                                 <div>
                                    <div id="required_fields_message">Fields in red are required</div>
                                    <ul id="error_message_box" class="error_message_box"></ul>
                                    <form action="{{ route('repair.update',$Data->id) }}" id="employee_form" class="form-horizontal" method="post">
                                       @csrf
                                       @method('patch')
                                       <ul class="nav nav-tabs nav-justified mb-3" data-tabs="tabs">
                                          <li class="active" role="presentation">
                                             <a data-toggle="tab" href="#employee_basic_info{{ $Data->id }}">Information</a>
                                          </li>
                                       </ul>
                                       <div class="tab-content">
                                          <div class="tab-pane fade in active" id="employee_basic_info{{ $Data->id }}">
                                             <fieldset>
                                                <div class="form-group row">
                                                   <label for="item_number" class="required control-label col-xs-3" aria-required="true">Name</label>  
                                                   <div class="col-xs-8">
                                                      <input type="text" name="name" value="{{ $Data->name }}" id="item_number" class="form-control input-sm">
                                                      @error('item_number')
                                                         <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                         </span>
                                                      @enderror
                                                   </div>
                                                </div>
                                                <div class="form-group row">
                                                   <label for="commission_percent" class="required control-label col-xs-3" aria-required="true">Cast</label> 
                                                   <div class="col-xs-8">
                                                      <div class="input-group">                                        
                                                         <input type="text" name="cost" value="{{ $Data->cost  }}" id="commission_percent" class="form-control input-sm">
                                                         @error('commission_percent')
                                                         <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                         </span>
                                                      @enderror
                                                      </div>
                                                   </div>
                                                </div>
                                                
                                             </fieldset>
                                          </div>
                                          <button class="btn btn-primary" style="float: right" id="submit">Submit</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-1" tabindex="0" style="display: none;"></ul>
                        <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-2" tabindex="0" style="display: none;"></ul>
                        <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-3" tabindex="0" style="display: none;"></ul>
                        <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-4" tabindex="0" style="display: none;"></ul>
                     </div>
                  </div>
               </div>
                
               <!-- update Employee model -->

		                        </tr>
		                    @endforeach
                        @endif
                     </tbody>
                  </table>
            </div>
         </div>
         <div class="clearfix"></div>
      </div>
   </div>
</div>


<!-- Add Employee Model -->
<div class="modal bootstrap-dialog modal-dlg type-primary fade size-normal" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;"><button class="close" data-dismiss="modal" aria-label="Close">×</button></div>
               <div class="bootstrap-dialog-title" id="843c6dbe-5fbb-46b4-949e-d82a725b4154_title">New Repair Category</div>
            </div>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
               <div class="bootstrap-dialog-message">
                  <div>
                     <div id="required_fields_message">Fields in red are required</div>
                     <ul id="error_message_box" class="error_message_box"></ul>
                     <form action="{{ route('repair.store') }}" id="employee_form" class="form-horizontal" method="post">
                        @csrf
                        
                        <div class="tab-content">
                           <div class="tab-pane fade in active" id="employee_basic_info">
                              <fieldset>
                                 <div class="form-group form-group-sm">
                                    <label for="item_number" class="required control-label col-xs-3" aria-required="true">Name</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="name" id="item_number" class="form-control input-sm" required="">
                                    
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="commission_percent" class="required control-label col-xs-3" aria-required="true">Price</label>   
                                    <div class="col-xs-8">
                                       <input type="text" name="cost" id="commission_percent" class="form-control input-sm" required="">
                                    
                                    </div>
                                 </div>
                              </fieldset>
                           </div>
                        	<button class="btn btn-primary" style="float: right" id="submit">Submit</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-1" tabindex="0" style="display: none;"></ul>
         <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-2" tabindex="0" style="display: none;"></ul>
         <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-3" tabindex="0" style="display: none;"></ul>
         <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-4" tabindex="0" style="display: none;"></ul>
      </div>
   </div>
</div>
<!-- Add Employee Model -->


<script type="text/javascript">
   
	$("document").ready(function(){
		$("#table").DataTable({
			dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
		});
      @if(old('emp_id')== '')
         @if($errors->any()) 
            $('#addEmployee').modal('show');
         @endif
      @else
         @if($errors->any()) 
         $('#updateEmployee'+"{{ old('emp_id')}}").modal('show');
         @endif
      @endif
	})

    $(document).on('change','#getpermission',function(){
    let id = $('#getpermission').val()
    alertt('addd')
    $.ajax({
      method:'get',
      url:'acl/get/'+id,
      success:function(data){
        console.log(data)
        // $('#puttable').html(data)
      }
    })
  })

    $(document).on('click','#employee_permission_info',function(){
      alert('sddsd')
    })
</script>
@endsection