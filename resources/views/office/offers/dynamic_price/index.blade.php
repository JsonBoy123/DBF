@extends('layouts.dbf')
@section('content')
<div class="container" id="container">
   <div class="row">
      <div id="title_bar" class="btn-toolbar">
         <div class="col-md-10">
            <div class="text-center successMsg" id="successMsg"></div>
         </div>
         <div class="col-md-2">
            <button class="btn btn-info btn-sm pull-right modal-dlg" data-toggle="modal" data-target="#AddPricing" title="New Shop"><span class="glyphicon glyphicon-user">&nbsp;</span>New Pricing</button>
         </div>
      </div>
      <table id="table" class="table table-hover table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="table_info">
         <thead id="table-sticky-header">
            <tr>
               <th role="row">S.No.</th>
               <th>Pointer</th>
               <th>Location</th>
               <th>Title</th>
               <th>Discount</th>
               <th>Start Time</th>
               <th>End Time</th>
               <th>Status</th>
            </tr>
         </thead>
         <tbody>
            @if(!empty($pricing))
               @foreach($pricing as $pricings)
                  <tr role="row" class="odd">
                     <td class="sorting_1">{{ $pricings->id }}</td>
                     <td>{{ $pricings['pointers']->title }}</td>
                     <td>{{ $pricings['locations']->title }}</td>
                     <td>{{ $pricings->title }}</td>
                     <td>{{ $pricings->discount }}</td>
                     <td>{{ $pricings->start_date }}</td>
                     <td>{{ $pricings->end_date }}</td>
                     <td>
                        @if($pricings->status == 0)
                           <span class="dot1"></span>
                        @else
                           <span class="dot2"></span>
                        @endif
                     </td>
                  </tr>
               @endforeach
            @endif
         </tbody>
      </table>
   </div>
   <!-- Add Modal -->
   <div class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" id="AddPricing" role="dialog">
      <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">×</button>
               <h4 class="modal-title">Create New Offer</h4>
            </div>
            <div class="modal-body">
               <form id="PricingAdd">
               	@csrf			    
                  <div class="form-group">
                     <label for="title">Title</label>
                     <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                  </div>
                  <div class="form-group">
                     <label for="location">Locations Title</label>
                     <select class="form-control" name="location" id="location">
                     	<option selected="" disabled="">Select</option>
                     	@if(!empty($location))
                     		@foreach($location as $locations)
                     			<option value="{{ $locations->id }}">{{ $locations->title }}</option>
                     		@endforeach
                     	@endif
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="pointer">Pointer Title</label>
                     <select class="form-control" name="pointer" id="pointer">
                     	<option selected="" disabled="">Select</option>
                     	@if(!empty($bundle))
                     		@foreach($bundle as $bundles)
                     			<option value="{{ $bundles->id }}">{{ $bundles->title }}</option>
                     		@endforeach
                     	@endif
                     </select>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="start_date">Start Date</label>
                           <input type="datetime-local" name="start_date" class="form-control" id="start_date">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="end_date">End Date</label>
                           <input type="datetime-local" name="end_date" class="form-control" id="end_date">
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="discount">Discount</label>
                     <input type="text" name="discount" id="discount" class="form-control" placeholder="Discount">
                  </div>
                  <button type="submit" name="submit" class="btn btn-primary" style="float: right">ADD</button>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal -->
</div>
<style type="text/css">
	/*.datepicker-days{
		display: block !important;
	}*/
   .dot2 {
      height: 15px;
      width: 15px;
      background-color: #00FF00;
      border-radius: 50%;
      display: inline-block;
   }
   .dot1 {
       height: 15px;
       width: 15px;
       background-color: #FF0000;
       border-radius: 50%;
       display: inline-block;
   }
</style>
<script type="text/javascript">
	
	$.validator.addMethod("mobile_regex", function(value, element) {
	return this.optional(element) || /^\d{10}$/i.test(value);
	}, "Please Enter No Only.");
	
	$.validator.addMethod("password_regex", function(value, element) {
	return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/i.test(value);
	}, "Password must contain at least 1 lowercase, 1 uppercase, 1 numeric and 1 special character");
	
	$.validator.addMethod("email_regex", function(value, element) {
	return this.optional(element) || /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/i.test(value);
	}, "The Email Address Is Not Valid Or In The Wrong Format");
	
	$.validator.addMethod("name_regex", function(value, element) {
	return this.optional(element) || /^[a-zA-Z ]{2,100}$/i.test(value);
	}, "Please choose a name with only a-z 0-9.");
	
	$("#PricingAdd").validate({
	  	errorElement: 'p',
    	errorClass: 'help-inline',
		
		rules: {
	      title:{
	      	required:true,
	      	name_regex:true
	      },
	      location:{
	      	required:true
	      },
	      pointer:{
	      	required:true
	      },
	      start_date:{
	      	required:true
	      },
	      end_date:{
	      	required:true
	      },
	      discount:{
	      	required:true
	      }
	    },
	    
	    messages: {
	    },
  		submitHandler: function(form) {
			$.ajax({
      			type: "post",
      			url: "add_pricing",
      			data: $("#PricingAdd").serialize(),
      			success: function(data){
      				// alert(data);
      				$('#locationAdd').trigger("reset");
      				$('#AddPricing').modal("hide");
      				$("#successMsg").html(data.successMsg).delay(2000).fadeOut();
      				setTimeout(function() {
					    location.reload();
					}, 2000);
      			}
      		});
		}
	});

 	$(document).ready(function() {
    	$('#table').DataTable();
  	  	$('.datepicker').datepicker({
  	  		autoclose: true,
  	  		orientation: "bottom"
  	  	});
  	});
</script>   
@endsection