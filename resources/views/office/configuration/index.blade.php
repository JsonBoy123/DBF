@extends('layouts.dbf')

@section('content')

<div class="container">
	<div class="row">
	   <ul class="nav nav-tabs" data-tabs="tabs">
	      <li class="active" role="presentation">
	         <a data-toggle="tab" href="#info_tab" title="Store Information">Information</a>
	      </li>
	   </ul>
	   <div class="tab-content">
	      <div class="tab-pane fade in active" id="info_tab">
	         <form action="{{-- {{route('configuration.update',$data->id)}} --}}" enctype="multipart/form-data" class="form-horizontal" method="post" accept-charset="utf-8" novalidate="novalidate">
	         	@csrf
	         	@method('PUT')
	            <input type="hidden" name="csrf_ospos_v3" value="cafb801a67c59c2e490c06e48e2ef030">                                                                                       
	            <div id="config_wrapper">
	               <fieldset id="config_info">
	                  <div id="required_fields_message">Fields in red are required</div>
	                  <ul id="info_error_message_box" class="error_message_box"></ul>
	                  <div class="form-group form-group-sm">
	                     <label for="company_name" class="control-label col-xs-2 required" aria-required="true">Company Name</label>				
	                     <div class="col-xs-6">
	                        <div class="input-group">
	                           <span class="input-group-addon input-sm" data-original-title="" title=""><span class="glyphicon glyphicon-home" data-original-title="" title=""></span></span>
	                           <input type="text" name="company_name" value="{{$data != null ? $data->company_name : 'no record'}}" id="company" class="form-control input-sm required" aria-required="true">
	                        </div>
	                     </div>
	                  </div>
	                  <div class="form-group form-group-sm">
	                     <label for="company_logo" class="control-label col-xs-2">Company Logo</label>				
	                     <div class="col-xs-6">
	                        <div class="fileinput fileinput-exists" data-provides="fileinput">
	                              	<input type="file" name="company_logo" value="" id="image" class="required image" data-errormsg="PhotoUploadErrorMsg">
									<br/><br/>

									<div  class="image">
		                            	@if(!empty($data->company_logo))
		                                 <img class="img-thumbnail" src="{{asset("storage/logo/$data->company_logo")}}" alt="" title="" width="100" height="200">
		                                @endif
	                                </div>
	                        </div>
	                     </div>
	                  </div>
	                  <div class="form-group form-group-sm">
	                     <label for="address" class="control-label col-xs-2 required" aria-required="true">Company Address</label>				
	                     <div class="col-xs-6">
	                        <textarea name="address" cols="40" rows="5" id="address" class="form-control input-sm required" aria-required="true" >{{$data != null ? $data->address : 'no record'}}</textarea>
	                     </div>
	                  </div>
	                  <div class="form-group form-group-sm">
	                     <label for="website" class="control-label col-xs-2">Website</label>				
	                     <div class="col-xs-6">
	                        <div class="input-group">
	                           <span class="input-group-addon input-sm" data-original-title="" title=""><span class="glyphicon glyphicon-globe" data-original-title="" title=""></span></span>
	                           <input type="text" name="website" value="{{$data != null ? $data->website : 'no record'}}" id="website" class="form-control input-sm">
	                        </div>
	                     </div>
	                  </div>
	                  <div class="form-group form-group-sm">
	                     <label for="email" class="control-label col-xs-2">Email</label>				
	                     <div class="col-xs-6">
	                        <div class="input-group">
	                           <span class="input-group-addon input-sm" data-original-title="" title=""><span class="glyphicon glyphicon-envelope" data-original-title="" title=""></span></span>
	                           <input type="email" name="email" value="{{$data != null ? $data->email : 'no record'}}" id="email" class="form-control input-sm">
	                        </div>
	                     </div>
	                  </div>
	                  <div class="form-group form-group-sm">
	                     <label for="phone" class="control-label col-xs-2 required" aria-required="true">Company Phone</label>				
	                     <div class="col-xs-6">
	                        <div class="input-group">
	                           <span class="input-group-addon input-sm" data-original-title="" title=""><span class="glyphicon glyphicon-phone-alt" data-original-title="" title=""></span></span>
	                           <input type="text" name="phone" value="{{$data != null ? $data->phone : 'no record'}}" id="phone" class="form-control input-sm required" aria-required="true">
	                        </div>
	                     </div>
	                  </div>
	                  <div class="form-group form-group-sm">
	                     <label for="fax" class="control-label col-xs-2">Fax</label>				
	                     <div class="col-xs-6">
	                        <div class="input-group">
	                           <span class="input-group-addon input-sm" data-original-title="" title=""><span class="glyphicon glyphicon-phone-alt" data-original-title="" title=""></span></span>
	                           <input type="text" name="fax" value="{{$data != null ? $data->fax : 'no record'}}" id="fax" class="form-control input-sm">
	                        </div>
	                     </div>
	                  </div>
	                  <div class="form-group form-group-sm">
	                     <label for="return_policy" class="control-label col-xs-2 required" aria-required="true">Return Policy</label>				
	                     <div class="col-xs-6">
	                        <textarea name="return_policy" cols="40" rows="5" id="return_policy" class="form-control input-sm required" aria-required="true">{{$data != null ? $data->return_policy : 'no record'}}</textarea>
	                     </div>
	                  </div>
	                  <input type="submit" name="submit_info" value="Submit" id="submit_info" class="btn btn-primary btn-sm pull-right" style="margin-bottom: 10px;">
	               </fieldset>
	            </div>
	         </form>
	      </div>
	   </div>
	</div>
</div>
<script>
$(document).ready( function () {
    $(".image").change(function () {
        var img_id = $(this).attr('id');
        filePreview(this,img_id);
    });
});

  function filePreview(input,img_id) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+img_id+' + img').remove();
            $('.'+img_id).html('<img class="img-thumbnail" src="'+e.target.result+'" width="100" height="200"/>');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection