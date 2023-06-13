<div class="content" style="margin-top:30px;">
   <div class="row">
      <div class="col-md-10">
      	<span class="successMsg" id="successMsg"></span>
      </div>
      <div class="col-md-2">
	    <button class="btn btn-info modal-dlg" style="float: right;" data-toggle="modal" data-target="#AddLocation" title="Add Locations">Add Locations</button>
      </div>  
   </div>
   <hr>
   <div id="cashier_table_area">
        <table id="cashier_list" class="table table-hover" style="width: 100%;" role="grid" aria-describedby="cashier_list_info">
          <thead>
             <tr role="row" style="height: 0px;">
                <th>Id</th>
                <th>Title</th>
                <th>Location</th>
                <th>Action</th>
             </tr>
          </thead>

          <tbody>
          	@if(!empty($location))
          		@foreach($location as $key => $locations)
		            <tr id="{{ $locations->id }}" role="row" class="odd">
		                <td class="sorting_1">{{ $locations->id }}</td>
		                <td>{{ $locations->title }}</td>
		                <td>
		                	@if(!empty($location_name))
			                	@foreach($location_name[$key] as $name)
		                			{{ $name->shop_name.",  " }}
		                		@endforeach
			                @else
			                @endif
		                </td>
		                <td></td>
		            </tr>
		        @endforeach
		    @endif
          </tbody>
       </table>
   </div>

   	<!-- Add Modal -->
	<div class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" id="AddLocation" role="dialog">
	    <div class="modal-dialog">
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">ADD Locations</h4>
	        </div>
	        <div class="modal-body">
		        <form id="locationAdd">
		        	@csrf
				    <div class="form-group">
				        <label for="title">Title</label>
				        <input type="text" class="form-control" id="title" name="title" placeholder="Title">
				    </div>

				    <div class="form-group">
				        <label for="location">Select Location</label>
				        <select class="form-control" name="location[]" id="location" multiple="multiple">
				        	<option disabled="">Select Shop</option>
				        	@if(!empty($shop))
				        		@foreach($shop as $shops)
				        			<option value="{{ $shops->id }}">{{ $shops->shop_name }}</option>
				        		@endforeach
				        	@endif
				        </select>
				    </div>

				    <button type="submit" name="submit" class="btn btn-primary" style="float: right">ADD</button>
				</form>
	        </div>
	      </div>   
	    </div>
	</div>
	<!-- Modal -->


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
		
		$("#locationAdd").validate({
		  	errorElement: 'p',
        	errorClass: 'help-inline',
			
    		rules: {
		      title:{
		      	required:true,
		      	name_regex:true
		      },
		      location:{
		      	required:true
		      }
		    },
		    
		    messages: {
		    },
      		submitHandler: function(form) {
    			$.ajax({
	      			type: "post",
	      			url: "add_locations",
	      			data: $("#locationAdd").serialize(),
	      			success: function(data){
	      				// alert(data);
	      				$('#locationAdd').trigger("reset");
	      				$('#AddLocation').modal("hide");
	      				$("#successMsg").html(data.successMsg).delay(2000).fadeOut();
	      				setTimeout(function() {
						    location.reload();
						}, 2000);
	      			}
	      		});
    		}
 		});

	  	$(document).ready(function() {
	      	$('#cashier_list').DataTable();
	      	$('.toggle-one').bootstrapToggle();
	      	$('#location').select2();
	    });
	</script>
</div>