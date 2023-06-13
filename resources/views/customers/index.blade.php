@extends('layouts.dbf')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <label class="alert alert-success "  id="msg" style="display: none;"></label>
    </div>
    <div class="col-md-12">
      @if($message = Session::get('success'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
      @endif
    </div>
  </div>
    <div class="row">
      <div id="title_bar" class="btn-toolbar">
          <button class="btn btn-info btn-sm pull-right modal-dlg" data-btn-submit="Submit" data-toggle="modal" data-target="#importExcel"  data-href="" title="Customer Import from Excel">
            <span class="glyphicon glyphicon-import">&nbsp;</span>Excel Import
          </button>

          <button class="btn btn-info btn-sm pull-right modal-dlg"  title="New Customer" data-toggle="modal" id="new_customer" >
              <span class="glyphicon glyphicon-user">&nbsp;</span>New Customer 
          </button>

            <a class="btn btn-info btn-sm " href="{{route('export')}}">Data Table</a>

            <a class="btn btn-info btn-sm " href="{{route('phone-export')}}">Contact Numbers</a>

          <div class="col-xs-3 mb-2" align="center">
            <p>
              
            </p>
          </div>
      </div>

{{-- For New Customer Modal --}}

      <div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" >
              <h5 class="modal-title" id="exampleModalLabel">New Customer</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="bootstrap-dialog-body">
                <div class="bootstrap-dialog-message">

                      <div id="required_fields_message">Fields in red are required</div>

                   <ul id="error_message_box" class="error_message_box"></ul>

                  <form class="form-horizontal" method="post" accept-charset="utf-8" novalidate="novalidate" action="{{ route('customers.store') }}" >
                   @csrf
                  
                      <ul class="nav nav-tabs nav-justified" data-tabs="tabs">
                         <li class="active" role="presentation">
                            <a data-toggle="tab" href="#customer_basic_info">Information</a>
                         </li>
                      </ul>

                      <div class="tab-content">
                        <div class="tab-pane fade in active" id="customer_basic_info">
                          <fieldset>
                              <div class="form-group form-group-sm"> 
                               <label for="first_name" class="required control-label col-xs-3" aria-required="true">First Name</label>  
                                <div class="col-xs-8">
                                  <input type="text" name="first_name" value="" id="first_name" class="form-control input-sm">
                                </div>
                              </div>
                                @error('first_name')
                                  <span class="text-danger" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                              <div class="form-group form-group-sm"> 
                                <label for="last_name" class="required control-label col-xs-3" aria-required="true">Last Name</label> 
                                <div class="col-xs-8">
                                   <input type="text" name="last_name" value="" id="last_name" class="form-control input-sm">
                                </div>
                              </div>
                                 @error('last_name')
                                    <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror

                              <div class="form-group form-group-sm"> 
                                  <label for="gender" class="control-label col-xs-3">Gender</label><div class="col-xs-4">
                                      <label class="radio-inline">
                                        <input type="radio" name="gender" value="1" id="gender"> M    
                                      </label>
                                      <label class="radio-inline">
                                        <input type="radio" name="gender" value="0" id="gender">F     
                                      </label>

                                  </div>
                              </div>

                              <div class="form-group form-group-sm"> 
                                <label for="email" class="control-label col-xs-3">Email</label>   <div class="col-xs-8">
                                   <div class="input-group">
                                      <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-envelope"></span></span>
                                      <input type="text" name="email" value="" id="email" class="form-control input-sm">
                                   </div>
                                </div>
                              </div>
                              <div class="form-group form-group-sm">
                                <label for="customer_type" class="required control-label col-xs-3">Type </label><div class="col-xs-8">
                                  <select name="customer_type" class="show-menu-arrow" id="customer_type">
                                    <option value="">&nbsp &nbsp Select Type &nbsp &nbsp</option>
                                    <option value="employee">EMPLOYEE</option>
                                    <option value="wholesale">WHOLESALE</option> 
                                    <option value="franchise">FRANCHISE</option>
                                    <option value="retail">RETAIL</option>
                                  </select>
                                </div>
                            </div>
                                @error('customer_type')
                                    <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror

                              <div class="form-group form-group-sm"> 
                                <label for="phone_number" class="required control-label col-xs-3" aria-required="true">Phone Number</label> <div class="col-xs-8">
                                   <div class="input-group">
                                      <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-phone-alt"></span></span>
                                      <input type="text" name="phone_number" value="" id="phone_number" class="form-control input-sm">
                                   </div>
                                </div>
                              </div>

                                 @error('phone_number')
                                    <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror

                              <div class="form-group form-group-sm"> 
                                <label for="address_1" class="control-label col-xs-3">Address 1</label> <div class="col-xs-8">
                                   <input type="text" name="address_1" value="" id="address_1" class="form-control input-sm">
                                </div>
                              </div>

                              <div class="form-group form-group-sm"> 
                                <label for="address_2" class="control-label col-xs-3">Address 2</label> <div class="col-xs-8">
                                   <input type="text" name="address_2" value="" id="address_2" class="form-control input-sm">
                                </div>
                              </div>

                              <div class="form-group form-group-sm"> 
                                <label for="city" class="control-label col-xs-3">City</label>  <div class="col-xs-8">
                                   <input type="text" name="city" value="" id="city" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                </div>
                              </div>

                              <div class="form-group form-group-sm"> 
                                <label for="state" class="control-label col-xs-3">State</label>   <div class="col-xs-8">
                                   <input type="text" name="state" value="" id="state" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                </div>
                              </div>

                              <div class="form-group form-group-sm"> 
                                <label for="zip" class="control-label col-xs-3">Postal Code</label>  <div class="col-xs-8">
                                   <input type="text" name="zip" value="" id="postcode" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                </div>
                              </div>

                              <div class="form-group form-group-sm"> 
                                <label for="country" class="control-label col-xs-3">Country</label>  <div class="col-xs-8">
                                   <input type="text" name="country" value="" id="country" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                </div>
                              </div>

                              <div class="form-group form-group-sm"> 
                                <label for="comments" class="control-label col-xs-3">Comments</label>   <div class="col-xs-8">
                                   <textarea name="comments" cols="40" rows="10" id="comments" class="form-control input-sm"></textarea>
                                </div>
                              </div>

                        
                              <div class="form-group form-group-sm">
                                <label for="company_name" class="control-label col-xs-3">Company</label>               <div class="col-xs-8">
                                   <input type="text" name="company_name" value="" id="company_name" class="form-control input-sm">
                                </div>
                              </div>

                              <div class="form-group form-group-sm">
                                <label for="gstin" class="control-label col-xs-3">GSTIN</label>               <div class="col-xs-8">
                                   <input type="text" name="gstin" value="" id="gstin" class="form-control input-sm">
                                </div>
                              </div>
                              <div class="form-group form-group-sm">
                                <label for="ifsc_code" class="control-label col-xs-3">IFSC Code</label><div class="col-xs-8">
                                   <input type="text" name="ifsc_code" value="" id="ifsc_code" class="form-control input-sm">
                                </div>
                              </div>
                              <div class="form-group form-group-sm">
                                <label for="account_number" class="control-label col-xs-3">Account #</label>              <div class="col-xs-4">
                                   <input type="text" name="account_number" value="" id="account_number" class="form-control input-sm">
                                </div>
                              </div>
                              

                              
                                <input type="hidden" name="taxable" value="1">
                               
                          </fieldset>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                  </form>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
{{-- End New Customer Modal --}}
        <div id="table_holder">
          <div class="bootstrap-table">
            <div class="fixed-table-toolbar">
               <div class="bs-bars pull-left">
                  <div id="toolbar">
                     <div class="pull-left btn-toolbar">
                        <button id="delete" class="btn btn-default btn-sm deleteAllCustomer">
                        <span class="glyphicon glyphicon-trash">&nbsp;</span>Delete</button>
                        <button id="email" class="btn btn-default btn-sm" disabled="">
                        <span class="glyphicon glyphicon-envelope">&nbsp;</span>Email</button>
                     </div>
                  </div>
               </div>
            </div>

{{-- Record Table Start --}}
            <div class="fixed-table-container" style="padding-bottom: 0px;">
               <div class="fixed-table-header" style="display: none;">
                
               </div>
                <div class="table-body">
                  <div class="fixed-table-loading" style="top: 41px; display: none;">Loading, please wait...</div>
                  <div id="table-sticky-header-sticky-header-container" class="hidden"></div>
                  <div id="table-sticky-header_sticky_anchor_begin"></div>
                    <table id="myTable" class="table table-hover table-striped ">
                      <thead id="table-sticky-header">
                        <tr>
                           <th class="bs-checkbox print_hide checkall" style="width: 36px; " data-field="checkbox" >
                              <div class="th-inner "><input name="btSelectAll" type="checkbox" ></div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="people.person_id">
                              <div class="th-inner sortable both desc">Id</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="last_name">
                              <div class="th-inner sortable both">Last Name</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="first_name">
                              <div class="th-inner sortable both">First Name</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Phone Number</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="total">
                              <div class="th-inner ">Total Spent</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="created_at">
                              <div class="th-inner sortable both">Created At</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="print_hide" style="" data-field="edit">
                              <div class="th-inner "> Action</div>
                              <div class="fht-cell"></div>
                           </th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $count =1; @endphp
                       @foreach ($data as $datas)
                          <tr data-index="0" data-uniqueid="13158">
                             <td class="bs-checkbox print_hide"><input data-index="0" name="btSelectItem" value="{{$datas->id}}" type="checkbox" class="checkhour"></td>
                             <td class="" style="">{{$count++}}</td>
                             <td class="" style="">{{$datas->last_name}}</td>
                             <td class="" style="">{{$datas->first_name}}</td>
                             <td class="" style="">{{$datas->phone_number}}</td>
                             <td class="" style="">₹&nbsp;</td>
                             <td class="" style="">{{$datas->created_at}}</td>
                           {{--   <td class="print_hide" style="">
                                <button type="button" class="glyphicon glyphicon-phone btn btn-primary send_sms" data-id="{{$datas->id}}">
                                </button>
                             </td> --}}
                             <td class="print_hide" style="">
                                <button type="button" {{-- data-toggle="modal" data-target="#updateModal" --}} data-id="{{$datas->id}}" class="fa fa-pencil-square-o btn btn-primary edit" >
                                </button>
                             </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
{{-- Record Table End --}}


{{-- Send Message for customer............ --}}

         {{--    <div class="modal fade" id="sendSMS" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                       <div class="bootstrap-dialog-header">
                          <div class="bootstrap-dialog-close-button" style="display: block;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="bootstrap-dialog-title" id="">Send SMS</div>
                       </div>
                    </div>
                    <form action="" id="send_sms_form" class="form-horizontal" method="post" accept-charset="utf-8" novalidate="novalidate">
                      <div class="modal-body">
                        <div class="bootstrap-dialog-body">
                          <div class="bootstrap-dialog-message">
                            <div id="required_fields_message">Fields in red are required</div>

                            <ul id="error_message_box" class="error_message_box"></ul>           
                              <fieldset>
                                 <div class="form-group form-group-sm">
                                    <label for="sms_first_name" class="control-label col-xs-2">First name</label>        
                                    <div class="col-xs-10">
                                       <input type="text" name="first_name" value="" class="form-control input-sm" readonly="true" id="sms_first_name">
                                    </div>
                                 </div><br><br>
                                 <div class="form-group form-group-sm">
                                    <label for="sms_last_name" class="control-label col-xs-2">Last name</label>       
                                    <div class="col-xs-10">
                                       <input type="text" name="last_name" value="" class="form-control input-sm" readonly="true" id="sms_last_name">
                                    </div>
                                 </div> <br><br>
                                 <div class="form-group form-group-sm">
                                    <label for="sms_phone" class="control-label col-xs-2 required" aria-required="true">Phone number</label>       
                                     <div class="col-xs-10">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-phone-alt"></span></span>
                                          <input type="text" name="phone" value="" class="form-control input-sm required" aria-required="true" id="sms_phone">
                                       </div>
                                    </div>
                                 </div><br><br>
                                 <div class="form-group form-group-sm">
                                    <label for="message_label" class="control-label col-xs-2 required" aria-required="true">Message</label>        
                                    <div class="col-xs-10">
                                       <textarea name="message" cols="40" rows="10" class="form-control input-sm required" id="message" aria-required="true"></textarea>
                                    </div>
                                 </div>
                              </fieldset>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer" style="display: block;">
                        <div class="bootstrap-dialog-footer">
                          <div class="bootstrap-dialog-footer-buttons">
                             <button class="btn btn-primary" id="submit">Submit
                             </button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>        
            </div> --}}

{{-- End Send Sms For Customer --}}

{{-- Import for excel.............. --}}

            <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                     <div class="bootstrap-dialog-header">
                        <div class="bootstrap-dialog-close-button" style="display: block;">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="bootstrap-dialog-title" id="fc752a45-7237-4604-ac1e-90116c45dbc5_title">Customer Import from Excel</div>
                     </div>
                  </div>
                  <form action="{{route('import') }}" id="excel_form" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate="novalidate">
                      {{ csrf_field() }}
                      <div class="modal-body">
                        <div class="bootstrap-dialog-body">
                          <div class="bootstrap-dialog-message">
                              <ul id="error_message_box" class="error_message_box">
                              </ul>
                            <div class="form-group form-group-sm">
                                <input type="file" name="file" class="form-control">
                                  <br>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer" style="display: block;">
                        <div class="bootstrap-dialog-footer">
                          <div class="bootstrap-dialog-footer-buttons">
                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                          </div>
                        </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>

{{-- End Import --}}
          </div>
        </div>
   </div>
</div>

{{-- For Update Customer --}}

<div class="modal"  id="updateModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Update Customer</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        <form action="{{route('update_customer')}}" id="customer_form" class="form-horizontal" method="post" accept-charset="utf-8" novalidate="novalidate">
          @csrf
          <input type="hidden" name="customer_id" id="customer_id">
          <div class="modal-body">
            <div class="bootstrap-dialog-body">
              <div class="bootstrap-dialog-message">
                  <div id="required_fields_message">Fields in red are required</div>
                    <ul id="error_message_box" class="error_message_box"></ul>

                      <input type="hidden" name="" value="">
                    <ul class="nav nav-tabs nav-justified" data-tabs="tabs">
                      <li class="active" role="presentation">
                        <a class="btn btn-default info" aria-expanded="true" >Information</a>
                      </li>
                      <li role="presentation" class="">
                        <a class="btn btn-default status" aria-expanded="true" id="customer_status_info">Status</a>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade active in"  >
                        <fieldset >
                          <div id="information" style="display: block;">
                            <div class="form-group form-group-sm">  
                              <label for="first_name" class="required control-label col-xs-3" aria-required="true" >First Name
                              </label> 
                              <div class="col-xs-8">
                                <input type="text" name="first_name" value="" id="first_name_edit" class="form-control input-sm">
                              </div>
                            </div>

                            <div class="form-group form-group-sm">  
                              <label for="last_name_edit" class="required control-label col-xs-3" aria-required="true">Last Name</label> <div class="col-xs-8">
                                <input type="text" name="last_name" value="" id="last_name_edit" class="form-control input-sm">
                              </div>
                            </div>

                            <div class="form-group form-group-sm">  
                              <label for="gender" class="control-label col-xs-3">Gender</label> <div class="col-xs-4">
                                <label class="radio-inline">
                                  <input type="radio" name="gender" value="1" id="gender_m">
                             M    </label>
                                <label class="radio-inline">
                                  <input type="radio" name="gender" value="0" id="gender_f">
                             F    </label>

                              </div>
                            </div>

                            <div class="form-group form-group-sm">  
                              <label for="email_edit" class="control-label col-xs-3">Email</label> <div class="col-xs-8">
                                <div class="input-group">
                                  <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-envelope"></span></span>
                                  <input type="text" name="email" value="" id="email_edit" class="form-control input-sm">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-group-sm">  
                              <label for="phone_number_edit" class="required control-label col-xs-3" aria-required="true">Phone Number</label> <div class="col-xs-8">
                                <div class="input-group">
                                  <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-phone-alt"></span></span>
                                  <input type="text" name="phone_number" value="" id="phone_number_edit" class="form-control input-sm">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-group-sm">
                                <label for="customer_type" class="required control-label col-xs-3">Type </label><div class="col-xs-8">
                                  <select name="customer_type" class="show-menu-arrow" id="customer_type_edit">
                                    <option value="">&nbsp &nbsp Select Type &nbsp &nbsp</option>
                                    <option value="employee">EMPLOYEE</option>
                                    <option value="wholesale">WHOLESALE</option> 
                                    <option value="franchise">FRANCHISE</option>
                                    <option value="retail">RETAIL</option>
                                  </select>
                                </div>
                              </div>
                                @error('customer_type')
                                    <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror

                            <div class="form-group form-group-sm">  
                              <label for="address_1_edit" class="control-label col-xs-3">Address 1</label> <div class="col-xs-8">
                                <input type="text" name="address_1" value="" id="address_1_edit" class="form-control input-sm">
                              </div>
                            </div>

                            <div class="form-group form-group-sm">  
                              <label for="address_2_edit" class="control-label col-xs-3">Address 2</label> <div class="col-xs-8">
                                <input type="text" name="address_2" value="" id="address_2_edit" class="form-control input-sm">
                              </div>
                            </div>

                            <div class="form-group form-group-sm">  
                              <label for="city_edit" class="control-label col-xs-3">City</label> <div class="col-xs-8">
                                <input type="text" name="city" value="" id="city_edit" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                              </div>
                            </div>

                            <div class="form-group form-group-sm">  
                              <label for="state_edit" class="control-label col-xs-3">State</label> <div class="col-xs-8">
                                <input type="text" name="state" value="" id="state_edit" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                              </div>
                            </div>

                            <div class="form-group form-group-sm">  
                              <label for="postcode_edit" class="control-label col-xs-3">Postal Code</label> <div class="col-xs-8">
                                <input type="text" name="postcode" value="" id="postcode_edit" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                              </div>
                            </div>

                            <div class="form-group form-group-sm">  
                              <label for="country_edit" class="control-label col-xs-3">Country</label> <div class="col-xs-8">
                                <input type="text" name="country" value="" id="country_edit" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                              </div>
                            </div>

                            <div class="form-group form-group-sm">  
                              <label for="comments_edit" class="control-label col-xs-3">Comments</label> <div class="col-xs-8">
                                <textarea name="comments" cols="40" rows="10" id="comments_edit" class="form-control input-sm"></textarea>
                              </div>
                            </div>

                            <div class="form-group form-group-sm">
                              <label for="company_name_edit" class="control-label col-xs-3">Company</label>          
                              <div class="col-xs-8">
                                <input type="text" name="company_name" value="" id="company_name_edit" class="form-control input-sm">
                              </div>
                            </div>

                            <div class="form-group form-group-sm">
                              <label for="gstin_edit" class="control-label col-xs-3">GSTIN</label>         
                              <div class="col-xs-8">
                                <input type="text" name="gstin" value="" id="gstin_edit" class="form-control input-sm">
                              </div>
                            </div>

                            <div class="form-group form-group-sm">
                              <label for="account_number_edit" class="control-label col-xs-3">Account #</label>       
                              <div class="col-xs-4">
                                <input type="text" name="account_number" value="" id="account_number_edit" class="form-control input-sm">
                              </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <label for="ifsc_code" class="control-label col-xs-3">IFSC Code</label><div class="col-xs-8" id="ifsc_code">
                                   <input type="text" name="ifsc_code" value="" id="ifsc_code_edit" class="form-control input-sm">
                                </div>
                              </div>
                              

                          <div id="status" style="display:none;">
                            <div class="form-group form-group-sm">
                              <label for="total" class="control-label col-xs-3">Total spent</label>           
                              <div class="col-xs-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon input-sm"><b>₹</b></span>
                                  <input type="text" name="total" value="" id="total" class="form-control input-sm" disabled="">
                                </div>
                              </div>
                            </div>
                            
                            <div class="form-group form-group-sm">
                              <label for="max" class="control-label col-xs-3">Max. spent</label>           
                               <div class="col-xs-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon input-sm"><b>₹</b></span>
                                  <input type="text" name="max" value="" id="max" class="form-control input-sm" disabled="">
                                </div>
                              </div>
                            </div>
                            
                            <div class="form-group form-group-sm">
                              <label for="min" class="control-label col-xs-3">Min. spent</label>          
                                <div class="col-xs-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon input-sm"><b>₹</b></span>
                                  <input type="text" name="min" value="" id="min" class="form-control input-sm" disabled="">
                                </div>
                              </div>
                            </div>
                            
                            <div class="form-group form-group-sm">
                              <label for="average" class="control-label col-xs-3">Average spent</label>         
                              <div class="col-xs-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon input-sm"><b>₹</b></span>
                                  <input type="text" name="average" value="" id="average" class="form-control input-sm" disabled="">
                                </div>
                              </div>
                            </div>
                            
                            <div class="form-group form-group-sm">
                              <label for="quantity" class="control-label col-xs-3">Quantity</label>           
                              <div class="col-xs-4">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="quantity" value="" id="quantity" class="form-control input-sm" disabled="">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-group-sm">
                              <label for="avg_discount" class="control-label col-xs-3">Average discount</label>           <div class="col-xs-3">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="avg_discount" value="" id="avg_discount" class="form-control input-sm" disabled="">
                                  <span class="input-group-addon input-sm"><b>%</b></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </fieldset>
                      </div>
                    </div>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="bootstrap-dialog-footer">
              <div class="bootstrap-dialog-footer-buttons">
                <button class="btn btn-primary" id="submit">Submit</button>
              </div>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>

{{-- End Update Customer --}}

<script type="text/javascript">
   
   $(document).ready( function () {
 
    $('#myTable').DataTable({
      dom: 'Bfrtip',
       buttons: [ { extend: 'copyHtml5' },
            { extend: 'excelHtml5' },
            { extend: 'print'},
            { extend: 'pdfHtml5'}
            ]
    });

    $('.info').on('click',function(){
      $('#msg').hide();
      $('#customer_status_info').removeClass('active');
      $('.info').addClass('active');
      $('#status').hide();
      $('#information').show();
    });

    $('.status').on('click',function(){
      $('#msg').hide();
      $('#customer_status_info').addClass('active');
      $('.info').removeClass('active');
      $('#status').show();
      $('#information').hide();
    });

    $(document).on('click', '.edit', function(e){
      e.preventDefault();

      $('#msg').hide();

      var id = $(this).attr('data-id');
      $.ajax({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'customers_update',
            data:{'id':id},
            success:function(data){
              $('#customer_id').val(data.id ? data.id : 'No Record');
              $('#first_name_edit').val(data.first_name ? data.first_name : 'No Record');
              $('#last_name_edit').val(data.last_name ? data.last_name : 'No Record');
              $('#email_edit').val(data.email ? data.email : 'No Record');
              $('#phone_number_edit').val(data.phone_number ? data.phone_number : 'No Record');
              $('#address_1_edit').val(data.address_1 ? data.address_1 : 'No Record');
              $('#address_2_edit').val(data.address_2 ? data.address_2 : 'No Record');
              $('#city_edit').val(data.city ? data.city : 'No Record');
              $('#state_edit').val(data.state ? data.state : 'No Record');
              $('#postcode_edit').val(data.postcode ? data.postcode : 'No Record');
              $('#country_edit').val(data.country ? data.country : 'No Record');
              $('#comments_edit').val(data.comments ? data.comments : 'No Record');
              $('#company_name_edit').val(data.company_name ? data.company_name : 'No Record');
              $('#gstin_edit').val(data.gstin ? data.gstin : 'No Record');
              $('#account_number_edit').val(data.account_number ? data.account_number : 'No Record');
              $('#ifsc_code_edit').val(data.ifsc_code ? data.ifsc_code : 'No Record')
              $('#customer_type_edit').val(data.customer_type ? data.customer_type : 'No Record')


               if(data.gender == 1){
                 var $radios = $('input:radio[name=gender]');
                 $radios.filter('[value=1]').prop('checked', true);

               }

               if(data.gender == 0){
                 var $radios = $('input:radio[name=gender]');
                 $radios.filter('[value=0]').prop('checked', true);

               }

               $('#updateModal').modal('show');
            }
         }) 
    });

    // $('.send_sms').on('click',function(){
    //   var id = $(this).attr('data-id');
    //   $.ajax({
    //     headers: {
    //          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //       },
    //       type:'post',
    //       url:'/sms_data',
    //       data:{'id':id},
    //       success:function(data){
    //         $('#sms_first_name').val(data.first_name ? data.first_name : 'No Record');
    //         $('#sms_last_name').val(data.last_name ? data.last_name : 'No Record');
    //         $('#sms_phone').val(data.phone_number ? data.phone_number : 'No Record');
            
    //         $('#sendSMS').modal('show');

    //       }
    //   })
    // });
   
} );

// Code for checked or unchecked all data.................

$(document).ready(function(){


  $('#new_customer').on('click',function(){
      $('#msg').hide();
      $('#addCustomer').modal('show');

  }) 
   $('#delete').prop("disabled", true);


     var clicked = false;

      $(".checkall").on("click", function() {

      $('#msg').hide();
         
        $(".checkhour").prop("checked", !clicked);
          clicked = !clicked;

         if (clicked) {
            $('#delete').prop("disabled", false);
             
           } else{
            $('#delete').prop("disabled", true);

           }
        
   });

     $(".checkhour").on("click", function() { 

              $('#msg').hide();

              var cus = [];
                $. each($("input[name='btSelectItem']:checked"), function(){
                cus.push($(this). val());
                });
            if(cus.length > 0){

                $('#delete').prop("disabled", false);

          }else{

              $('#delete').prop("disabled", true);

          }

     });

      $(".deleteAllCustomer").click(function(){
            
            $('#msg').hide();

             var cus = [];
                $. each($("input[name='btSelectItem']:checked"), function(){
                cus. push($(this). val());
                });
                 $.ajax({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'delete',
            data:{'id':cus},
            success:function(data){
              $('#msg').show();
              $('#msg').text(data);
              location.reload();
            }
         })
         
      });
});
</script>

@endsection