@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row">
      <div id="title_bar" class="btn-toolbar">
         <button class="btn btn-info btn-sm pull-right modal-dlg" data-btn-submit="Submit" title="New Employee"  data-toggle="modal" data-target="#addEmployee">
         <span class="glyphicon glyphicon-user">&nbsp;</span>New Broker</button>
         <!-- <a class="btn btn-info btn-sm " href="http://newpos.dbfindia.com/employees/get_datatable">Data Table</a>
         <a class="btn btn-info btn-sm " href="http://newpos.dbfindia.com/manager/fetch_valid_customers_contact_no">Contact Numbers</a> -->
      </div>
      <div id="table_holder">
         <div class="bootstrap-table">
            <div class="fixed-table-toolbar">
               {{-- <div class="bs-bars pull-left">
                  <div id="toolbar">
                     <div class="pull-left btn-toolbar">
                        <button id="delete" class="btn btn-default btn-sm" disabled="disabled">
                        <span class="glyphicon glyphicon-trash">&nbsp;</span>Delete</button>
                        <button id="email" class="btn btn-default btn-sm" disabled="">
                        <span class="glyphicon glyphicon-envelope">&nbsp;</span>Email</button>
                     </div>
                  </div>
               </div> --}}<br>

               <div class="col-md-12">
                  <table id="table" class="table table-hover table-striped">
                     <thead id="table-sticky-header">
                        <tr>
                           
                           <th class="" style="" data-field="people.person_id">
                              <div class="th-inner sortable both desc">Id</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="first_name">
                              <div class="th-inner sortable both">Broker Name</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Phone Number</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Address</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">City</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">State</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Pin</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="print_hide" style="" data-field="edit">
                              <div class="th-inner ">Action</div>
                              <div class="fht-cell"></div>
                           </th>
                        </tr>
                     </thead>
                     <tbody>
                     	@if(!empty($broker))
                     		@foreach($broker as $emp)
		                        <tr data-index="1" data-uniqueid="{{ $emp->id }}">
		                           
		                           <td class="" style="">{{ $emp->id }}</td>
                                 <td class="" style="">{{ $emp->name }}</td>
		                           <td class="" style="">{{ $emp->contact_no }}</td>
		                           <td class="" style="">{{ $emp->address }}</td>
		                           <td class="" style="">{{ $emp->city }}</td>
		                           <td class="" style="">{{ $emp->state }}</td>
                                 <td class="" style="">{{ $emp->pincode }}</td>
		                           <td>
                              		<button class="btn btn-info btn-sm modal-dlg" data-btn-submit="Submit" title="Edit Broker"  data-toggle="modal" data-target="#updateEmployee{{ $emp->id }}"><span class="glyphicon glyphicon-edit"></span></button>
                              
                              		<a href="{{ route('broker_destroy',$emp->id) }}" class="btn btn-primary btn-sm modal-dlg" title="Delete Broker"><span class="glyphicon glyphicon-trash"></span></a>
                                    <a href="{{ route('broker.show',$emp->id)}}" class="btn btn-warning btn-sm modal-dlg" data-btn-submit="Submit" title="Delete Broker"><span class="glyphicon glyphicon-eye-open"></span></a>
                                 </td>

                                  <!-- update Employee model -->

               <div class="modal bootstrap-dialog modal-dlg type-primary fade size-normal" id="updateEmployee{{ $emp->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <form action="{{ route('broker.update',$emp->id) }}" id="employee_form" class="form-horizontal" method="post">
                                       @csrf
                                       @method('patch')
                                       <ul class="nav nav-tabs nav-justified mb-3" data-tabs="tabs">
                                          <li class="active" role="presentation">
                                             <a data-toggle="tab" href="#employee_basic_info{{ $emp->id }}">Information</a>
                                          </li>
                                       </ul>
                                       <div class="tab-content">
                                          <div class="tab-pane fade in active" id="employee_basic_info{{ $emp->id }}">
                                             <fieldset>
                                                <div class="form-group row">
                                                   <label for="first_name" class="required control-label col-xs-3" aria-required="true">Broker Name</label>  
                                                   <div class="col-xs-8">
                                                      <input type="hidden" name="emp_id" value="{{ $emp->id  }}" >
                                                      <input type="text" name="name" value="{{ $emp->name }}" id="name" class="form-control input-sm">
                                                      @error('first_name')
                                                         <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                         </span>
                                                      @enderror
                                                   </div>
                                                </div>
                                                <div class="form-group row">
                                                   <label for="contact_no" class="required control-label col-xs-3" aria-required="true">Phone Number</label> 
                                                   <div class="col-xs-8">
                                                      <div class="input-group">
                                                         <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-phone-alt"></span></span>
                                                         <input type="text" name="contact_no" value="{{ $emp->contact_no  }}" id="contact_no" class="form-control input-sm">
                                                         @error('contact_no')
                                                         <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                         </span>
                                                      @enderror
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="form-group row">
                                                   <label for="address_1" class="control-label col-xs-3">Address </label> 
                                                   <div class="col-xs-8">
                                                      <input type="text" name="address" value="{{ $emp->address }}" id="address" class="form-control input-sm">
                                                      @error('address')
                                                         <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                         </span>
                                                      @enderror
                                                   </div>
                                                </div>
                                                <div class="form-group row">
                                                   <label for="city" class="control-label col-xs-3">City</label>  
                                                   <div class="col-xs-8">
                                                      <input type="text" name="city" value="{{ $emp->city   }}" id="city" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                                      @error('city')
                                                         <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                         </span>
                                                      @enderror
                                                   </div>
                                                </div>
                                                <div class="form-group row">
                                                   <label for="state" class{{--  --}}="control-label col-xs-3">State</label>   
                                                   <div class="col-xs-8">
                                                      <input type="text" name="state" value="{{ $emp->state }}" id="state" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                                      @error('state')
                                                         <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                         </span>
                                                      @enderror
                                                   </div>
                                                </div>
                                                <div class="form-group row">
                                                   <label for="pincode" class="control-label col-xs-3">Postal Code</label>   
                                                   <div class="col-xs-8">
                                                      <input type="text" name="pincode" value="{{ $emp->pincode  }}" id="pincode" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                                      @error('pincode')
                                                         <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                         </span>
                                                      @enderror
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
               <div class="bootstrap-dialog-title" id="843c6dbe-5fbb-46b4-949e-d82a725b4154_title">New Broker</div>
            </div>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
               <div class="bootstrap-dialog-message">
                  <div>
                     <div id="required_fields_message">Fields in red are required</div>
                     <ul id="error_message_box" class="error_message_box"></ul>
                     <form action="{{ route('broker.store') }}" id="employee_form" class="form-horizontal" method="post">
                        @csrf
                        
                        <ul class="nav nav-tabs nav-justified" data-tabs="tabs">
                           <li class="active" role="presentation">
                              <a data-toggle="tab" href="#employee_basic_info">Information</a>
                           </li>
                        </ul>
                        <div class="tab-content">
                           <div class="tab-pane fade in active" id="employee_basic_info">
                              <fieldset>
                                 <div class="form-group form-group-sm">
                                    <label for="first_name" class="required control-label col-xs-3" aria-required="true">Broker Name</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="name" id="name" class="form-control input-sm" required="">
                                    @error('name')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="mobile_no" class="required control-label col-xs-3" aria-required="true">Phone Number</label>	
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-phone-alt"></span></span>
                                          <input type="text" name="mobile_no" id="mobile_no" class="form-control input-sm" required="">
                                      @error('mobile_no')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="address_1" class="control-label col-xs-3">Address :</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="address" id="address" class="form-control input-sm" required="">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="city" class="control-label col-xs-3">City :</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="city" id="city" class="form-control input-sm ui-autocomplete-input" autocomplete="off" required="">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="state" class="control-label col-xs-3">State : </label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="state" id="state" class="form-control input-sm ui-autocomplete-input" autocomplete="off" required="">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="zip" class="control-label col-xs-3">Postal Code</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="pincode" id="pincode" class="form-control input-sm ui-autocomplete-input" autocomplete="off" required="">
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