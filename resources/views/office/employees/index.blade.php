@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row">
      <!-- <script type="text/javascript">
         $(document).ready(function()
         {
         	dialog_support.init("button.modal-dlg-wide");
         
         	(function ($) {
         	'use strict';
         
         	$.fn.bootstrapTable.locales['en-US'] = {
         		formatLoadingMessage: function () {
         			return "Loading, please wait...";
         		},
         		formatRecordsPerPage: function (pageNumber) {
         			return "{0} rows per page".replace('{0}', pageNumber);
         		},
         		formatShowingRows: function (pageFrom, pageTo, totalRows) {
         			return "Showing {0} to {1} of {2} rows".replace('{0}', pageFrom).replace('{1}', pageTo).replace('{2}', totalRows);
         		},
         		formatSearch: function () {
         			return "Search";
         		},
         		formatNoMatches: function () {
         			return "There are no people to display.";
         		},
         		formatPaginationSwitch: function () {
         			return "Hide/Show pagination";
         		},
         		formatRefresh: function () {
         			return "Refresh";
         		},
         		formatToggle: function () {
         			return "Toggle";
         		},
         		formatColumns: function () {
         			return "Columns";
         		},
         		formatAllRows: function () {
         			return "All";
         		},
         		formatConfirmDelete : function() {
         			return "Are you sure you want to delete the selected employee(s)?";
         		},
         		formatConfirmRestore : function() {
         		return "Are you sure you want to restore selected employee(s)?";
         		}
         	};
         
         	$.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales["en-US"]);
         
         })(jQuery);
         	table_support.init({
         		resource: 'http://newpos.dbfindia.com/employees',
         		headers: [{"field":"checkbox","title":"select","switchable":true,"sortable":false,"checkbox":"select","class":"print_hide","sorter":""},{"field":"people.person_id","title":"Id","switchable":true,"sortable":true,"checkbox":false,"class":"","sorter":""},{"field":"first_name","title":"First Name","switchable":true,"sortable":true,"checkbox":false,"class":"","sorter":""},{"field":"last_name","title":"Last Name","switchable":true,"sortable":true,"checkbox":false,"class":"","sorter":""},{"field":"email","title":"Email","switchable":true,"sortable":true,"checkbox":false,"class":"","sorter":""},{"field":"phone_number","title":"Phone Number","switchable":true,"sortable":true,"checkbox":false,"class":"","sorter":""},{"field":"messages","title":"","switchable":false,"sortable":false,"checkbox":false,"class":"print_hide","sorter":""},{"field":"edit","title":"","switchable":false,"sortable":false,"checkbox":false,"class":"print_hide","sorter":""}],
         		pageSize: 20,
         		uniqueId: 'people.person_id',
         		showRefresh: true,
         		sortName: 'people.person_id',
         		sortOrder: 'desc',
         		enableActions: function()
         		{
         			var email_disabled = $("td input:checkbox:checked").parents("tr").find("td a[href^='mailto:']").length == 0;
         			$("#email").prop('disabled', email_disabled);
         		}
         	});
         
         	$("#email").click(function(event)
         	{
         		var recipients = $.map($("tr.selected a[href^='mailto:']"), function(element)
         		{
         			return $(element).attr('href').replace(/^mailto:/, '');
         		});
         		location.href = "mailto:" + recipients.join(",");
         	});
         });
      </script> -->

      <div id="title_bar" class="btn-toolbar">
         <button class="btn btn-info btn-sm pull-right modal-dlg" data-btn-submit="Submit" title="New Employee"  data-toggle="modal" data-target="#addEmployee">
         <span class="glyphicon glyphicon-user">&nbsp;</span>New Employee</button>
         <a class="btn btn-info btn-sm " href="http://newpos.dbfindia.com/employees/get_datatable">Data Table</a>
         <a class="btn btn-info btn-sm " href="http://newpos.dbfindia.com/manager/fetch_valid_customers_contact_no">Contact Numbers</a>
      </div>
      <div id="table_holder">
         <div class="bootstrap-table">
            <div class="fixed-table-toolbar">
               <div class="bs-bars pull-left">
                  <div id="toolbar">
                     <div class="pull-left btn-toolbar">
                        <button id="delete" class="btn btn-default btn-sm" disabled="disabled">
                        <span class="glyphicon glyphicon-trash">&nbsp;</span>Delete</button>
                        <button id="email" class="btn btn-default btn-sm" disabled="">
                        <span class="glyphicon glyphicon-envelope">&nbsp;</span>Email</button>
                     </div>
                  </div>
               </div><br>

               <div class="col-md-12">
                  <table id="table" class="table table-hover table-striped">
                     <thead id="table-sticky-header">
                        <tr>
                           <th class="bs-checkbox print_hide" style="width: 36px; " data-field="checkbox">
                              <div class="th-inner "><input name="btSelectAll" type="checkbox"></div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="people.person_id">
                              <div class="th-inner sortable both desc">Id</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="first_name">
                              <div class="th-inner sortable both">First Name</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="last_name">
                              <div class="th-inner sortable both">Last Name</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="email">
                              <div class="th-inner sortable both">Email</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Phone Number</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="print_hide" style="" data-field="messages">
                              <div class="th-inner "></div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="print_hide" style="" data-field="edit">
                              <div class="th-inner "></div>
                              <div class="fht-cell"></div>
                           </th>
                        </tr>
                     </thead>
                     <tbody>
                     	@if(!empty($employees))
                     		@foreach($employees as $emp)
		                        <tr data-index="1" data-uniqueid="{{ $emp->id }}">
		                           <td class="bs-checkbox print_hide"><input data-index="1" name="btSelectItem" type="checkbox"></td>
		                           <td class="" style="">{{ $emp->id }}</td>
		                           <td class="" style="">{{ $emp->first_name }}</td>
		                           <td class="" style="">{{ $emp->last_name }}</td>
		                           <td class="" style="">{{ $emp->email }}</td>
		                           <td class="" style="">{{ $emp->phone_number }}</td>
		                           <td>
		                           		<button class="btn btn-info btn-sm modal-dlg" data-btn-submit="Submit" title="New Employee"  data-toggle="modal" data-target="#sendMessage{{ $emp->id }}"><span class="glyphicon glyphicon-phone"></span></button>
		                           
		                           		<button class="btn btn-primary btn-sm modal-dlg" data-btn-submit="Submit" title="New Employee"  data-toggle="modal" data-target="#updateEmployee{{ $emp->id }}"><span class="glyphicon glyphicon-edit"></span></button>
		                           
                                       <a href="{{route('permissions_show',$emp->user_id)}}" class="btn btn-success btn-sm modal-dlg" data-btn-submit="Submit" title="New Employee"  data-toggle="modal" id="permission"><span class="glyphicon glyphicon-user"></span></a>
                                       <a href="{{route('location_permission',$emp->user_id)}}" class="btn btn-warning btn-sm modal-dlg" data-btn-submit="Submit" title="New Employee"  data-toggle="modal" id="permission"><span class="fa fa-map-marker"></span></a>
                                 </td>
		                        </tr>

<!-- Message sent model -->
<div class="modal bootstrap-dialog modal-dlg type-primary fade size-normal" id="sendMessage{{ $emp->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;"><button class="close" aria-label="close" data-dismiss="modal">×</button></div>
               <div class="bootstrap-dialog-title" id="ffc16994-c0a1-4b94-84e9-c3f1151c9a95_title">Send SMS</div>
            </div>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
               <div class="bootstrap-dialog-message">
                    <div id="required_fields_message">Fields in red are required</div>
                    <ul id="error_message_box" class="error_message_box"></ul>
                    <form action="" id="send_sms_form" class="form-horizontal" method="post">
                        @csrf
                        <fieldset>
                           <div class="form-group row">
                              <label for="first_name_label" class="control-label col-md-2">First name</label>			
                              <div class="col-md-10">
                                 <input type="text" name="first_name" value="{{ $emp->first_name }}" class="form-control input-sm" readonly="true">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="last_name_label" class="control-label col-md-2">Last name</label>			
                              <div class="col-md-10">
                                 <input type="text" name="last_name" value="{{ $emp->last_name }}" class="form-control input-sm" readonly="true">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="phone_label" class="control-label col-md-2 required" aria-required="true">Phone number</label>			
                              <div class="col-md-10">
                                 <div class="input-group">
                                    <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-phone-alt"></span></span>
                                    <input type="text" name="phone" value="{{ $emp->phone_number }}" class="form-control input-sm required" aria-required="true">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="message_label" class="control-label col-md-2 required" aria-required="true">Message</label>			
                              <div class="col-md-10">
                                 <textarea name="message" cols="40" rows="10" class="form-control input-sm required" id="message" aria-required="true"></textarea>
                              </div>
                           </div>
                       		<button class="btn btn-primary" style="float: right" id="submit">Submit</button>
                        </fieldset>
                    </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Message sent model -->


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
                     <form action="{{ route('employees.update',$emp->id ?? old('emp_id')) }}" id="employee_form" class="form-horizontal" method="post">
                        @csrf
                        @method('patch')
                        <ul class="nav nav-tabs nav-justified mb-3" data-tabs="tabs">
                           <li class="active" role="presentation">
                              <a data-toggle="tab" href="#employee_basic_info{{ $emp->id }}">Information</a>
                           </li>
                           <li role="presentation">
                              <a data-toggle="tab" href="#employee_login_info{{ $emp->id }}">Login</a>
                           </li>
                        </ul>
                        <div class="tab-content">
                           <div class="tab-pane fade in active" id="employee_basic_info{{ $emp->id }}">
                              <fieldset>
                                 <div class="form-group row">
                                    <label for="first_name" class="required control-label col-xs-3" aria-required="true">First Name</label>	
                                    <div class="col-xs-8">
                                       <input type="hidden" name="emp_id" value="{{ old('emp_id') ??  $emp->id  }}" >
                                       <input type="text" name="first_name" value="{{  old('first_name') ?? $emp->first_name }}" id="first_name" class="form-control input-sm">
                                       @error('first_name')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="last_name" class="required control-label col-xs-3" aria-required="true">Last Name</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="last_name" value="{{old('last_name') ?? $emp->last_name }}" id="last_name" class="form-control input-sm">
                                       @error('last_name')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="gender" class="control-label col-xs-3">Gender</label>	
                                    <div class="col-xs-4">
                                       <label class="radio-inline">
                                       <input type="radio" name="gender" value="1" id="gender" {{ old('gender') == '1' ? 'checked' : ($emp->gender == '1' ? 'checked' : '')}}>
                                       M</label>
                                       <label class="radio-inline">
                                       <input type="radio" name="gender" value="0" id="gender"  {{ old('gender') == '0' ? 'checked' : ($emp->gender == '0' ? 'checked' : '')}} >

                                       F</label>
                                       @error('gender')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="email" class="control-label col-xs-3">Email</label>	
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-envelope"></span></span>
                                          <input type="text" name="email" value="{{ old('email') ?? $emp->email  }}" id="email" class="form-control input-sm">
                                          @error('email')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="phone_number" class="required control-label col-xs-3" aria-required="true">Phone Number</label>	
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-phone-alt"></span></span>
                                          <input type="text" name="phone_number" value="{{ old('phone_number') ?? $emp->phone_number  }}" id="phone_number" class="form-control input-sm">
                                          @error('phone_number')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="address_1" class="control-label col-xs-3">Address 1</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="address_1" value="{{ old('address_1') ?? $emp->address_1   }}" id="address_1" class="form-control input-sm">
                                       @error('address_1')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="address_2" class="control-label col-xs-3">Address 2</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="address_2" value="{{ old('address_2') ?? $emp->address_2 }}" id="address_2" class="form-control input-sm">
                                       @error('address_2')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="city" class="control-label col-xs-3">City</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="city" value="{{ old('city') ?? $emp->city   }}" id="city" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                       @error('city')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="state" class="control-label col-xs-3">State</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="state" value="{{old('state') ?? $emp->state   }}" id="state" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                       @error('state')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="postcode" class="control-label col-xs-3">Postal Code</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="postcode" value="{{old('postcode')  ?? $emp->postcode  }}" id="postcode" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                       @error('postcode')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="country" class="control-label col-xs-3">Country</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="country" value="{{  old('country') ?? $emp->country  }}" id="country" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                       @error('country')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="comments" class="control-label col-xs-3">Comments</label>	
                                    <div class="col-xs-8">
                                       <textarea name="comments" cols="40" rows="10" id="comments" class="form-control input-sm">{{old('comments') ?? $emp->comments   }}</textarea>


                                    </div>
                                 </div>	
                              </fieldset>
                           </div>

                           <div class="tab-pane" id="employee_login_info{{ $emp->id }}">
                              <fieldset>
                                 <div class="form-group row">
                                    <label for="username" class="required control-label col-xs-3" aria-required="true">Username</label>					
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-user"></span></span>
                                          <input type="text" name="username" id="username" value="{{ old('username')  ?? $emp['usersInfo']->name  }}" class="form-control input-sm">
                                          @error('username')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="password" class="control-label col-xs-3">Password</label>					
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-lock"></span></span>
                                          <input type="password" name="password" value="" id="password" class="form-control input-sm">
                                          @error('password')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="repeat_password" class="control-label col-xs-3">Password Again</label>					
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-lock"></span></span>
                                          <input type="password" name="repeat_password" value="" id="repeat_password" class="form-control input-sm">
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
               <div class="bootstrap-dialog-title" id="843c6dbe-5fbb-46b4-949e-d82a725b4154_title">New Employee</div>
            </div>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
               <div class="bootstrap-dialog-message">
                  <div>
                     <div id="required_fields_message">Fields in red are required</div>
                     <ul id="error_message_box" class="error_message_box"></ul>
                     <form action="{{ route('employees.store') }}" id="employee_form" class="form-horizontal" method="post">
                        @csrf
                        
                        <ul class="nav nav-tabs nav-justified" data-tabs="tabs">
                           <li class="active" role="presentation">
                              <a data-toggle="tab" href="#employee_basic_info">Information</a>
                           </li>
                           <li role="presentation">
                              <a data-toggle="tab" href="#employee_login_info">Login</a>
                           </li>
                        </ul>
                        <div class="tab-content">
                           <div class="tab-pane fade in active" id="employee_basic_info">
                              <fieldset>
                                 <div class="form-group form-group-sm">
                                    <label for="first_name" class="required control-label col-xs-3" aria-required="true">First Name</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="first_name" value="{{ old('first_name') }}" id="first_name" class="form-control input-sm">
                                    @error('first_name')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="last_name" class="required control-label col-xs-3" aria-required="true">Last Name</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="last_name" value="{{ old('last_name') }}" id="last_name" class="form-control input-sm">
                                       @error('last_name')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="gender" class="control-label col-xs-3">Gender</label>	
                                    <div class="col-xs-4">
                                       <label class="radio-inline">
                                       <input type="radio" name="gender" value="0" id="gender">
                                       M		</label>
                                       <label class="radio-inline">
                                       <input type="radio" name="gender" value="1" id="gender">
                                       F		</label>
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="email" class="control-label col-xs-3">Email</label>	
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-envelope"></span></span>
                                          <input type="text" name="email" value="{{ old('email') }}" id="email" class="form-control input-sm">
                                       @error('email')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="phone_number" class="required control-label col-xs-3" aria-required="true">Phone Number</label>	
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-phone-alt"></span></span>
                                          <input type="text" name="phone_number" value="{{ old('phone_number') }}" id="phone_number" class="form-control input-sm">
                                      @error('phone_number')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="address_1" class="control-label col-xs-3">Address 1</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="address_1" value="{{ old('address_1') }}" id="address_1" class="form-control input-sm">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="address_2" class="control-label col-xs-3">Address 2</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="address_2" value="{{ old('address_2') }}" id="address_2" class="form-control input-sm">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="city" class="control-label col-xs-3">City</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="city" value="{{ old('city') }}" id="city" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="state" class="control-label col-xs-3">State</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="state" value="{{ old('state') }}" id="state" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="zip" class="control-label col-xs-3">Postal Code</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="zip" value="{{ old('zip') }}" id="postcode" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="country" class="control-label col-xs-3">Country</label>	
                                    <div class="col-xs-8">
                                       <input type="text" name="country" value="{{ old('country') }}" id="country" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="comments" class="control-label col-xs-3">Comments</label>	
                                    <div class="col-xs-8">
                                       <textarea name="comments" cols="40" rows="10" id="comments" class="form-control input-sm">{{ old('comments') }}</textarea>
                                    </div>
                                 </div>	
                              </fieldset>
                           </div>

                           <div class="tab-pane" id="employee_login_info">
                              <fieldset>
                                 <div class="form-group form-group-sm">
                                    <label for="username" class="required control-label col-xs-3" aria-required="true">Username</label>					
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-user"></span></span>
                                          <input type="text" name="username" id="username" class="form-control input-sm">
                                       @error('username')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="password" class="control-label col-xs-3">Password</label>					
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-lock"></span></span>
                                          <input type="password" name="password" value="" id="password" class="form-control input-sm">
                                       @error('password')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                       @enderror
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="repeat_password" class="control-label col-xs-3">Password Again</label>					
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-lock"></span></span>
                                           <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
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