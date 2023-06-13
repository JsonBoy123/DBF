<div class="content" style="margin-top:30px;">
   <div class="row">
      <div class="col-md-10">
      	<span class="successMsg" id="successMsg"></span>
      </div>
      <div class="col-md-2">
	    <button class="btn btn-info modal-dlg" style="float: right;" data-toggle="modal" data-target="#AddBundle" title="Add Bundle">Add Bundle</button>
      </div>  
   </div>
   <hr>
   <div id="cashier_table_area">
        <table id="cashier_list" class="table table-hover" style="width: 100%;" role="grid" aria-describedby="cashier_list_info">
          <thead>
             <tr role="row" style="height: 0px;">
                <th>Id</th>
                <th>Title</th>
                <th>Type</th>
                <th>Bundle</th>
                <th>Action</th>
             </tr>
          </thead>
          <tbody>
          	@if(!empty($bundles))
          		@foreach($bundles as $key => $bundle)
		            <tr id="{{ $bundle->id }}" role="row" class="odd">
		                <td class="sorting_1">{{ $bundle->id." ".$key }}</td>
		                <td>{{ $bundle->title }}</td>
		                <td>{{ $bundle->type }}</td>
		                <td>
		                	@if(!empty($cat))
			                	@foreach($cat[$key] as $cats) 
			                		@if($bundle->type == "Category")
			                			@if(!empty($cats->category_name))
			                				{{ $cats->category_name.", " }}
			                			@endif
			                		@endif
			                		@if($bundle->type == "Subcategory")
				                		@if(!empty($cats->sub_categories_name))
				                			{{ $cats->sub_categories_name.", " }}
				                		@endif
			                		@endif
			                		@if($bundle->type == "Brand")
				                		@if(!empty($cats->brand_name))
				                			{{ $cats->brand_name.", " }}
				                		@endif
			                		@endif
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
	<div class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" id="AddBundle" role="dialog">
	    <div class="modal-dialog">
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">ADD Bundle</h4>
	        </div>
	        <div class="modal-body">
		        <form id="bundleAdd">
		        	@csrf
				    <div class="form-group">
				        <label for="title">Title</label>
				        <input type="text" class="form-control" id="title" name="title" placeholder="Title">
				    </div>

				    <div class="form-group">
				        <label for="barcode">Barcode</label>
				        <input type="text" class="form-control" name="barcode" id="barcode" placeholder="Add Barcode">
				    </div>
				    
		    		<div class="form-group">
		    			<div class="row">
		    				<div class="col-md-6">
						        <label for="contact_no">Select Type</label>
						        <select class="form-control" name="type" id="type_id" onchange="selectType(this);">
						        	<option selected="" disabled="">Select</option>
						        	<option>Tag</option>
						        	<option>Category</option>
						        	<option>Subcategory</option>
						        	<option>Brand</option>
						        	<option>Barcode</option>
						        </select>
						    </div>

						    <div class="col-md-6" style="display: none;" id="hideDiv">
						    	<label for="contact_no">Select Category</label>
						        <select class="form-control" name="cat_id" id="cat_id" onchange="selectCat(this);">
						        	<option value="0" selected="" disabled="">Select Category</option>
						        	@if(!empty($category))
						        		@foreach($category as $cat)
						        			<option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
						        		@endforeach
						        	@endif
						        </select>
						        <p for="cat_id" id="catErrorMsg" generated="true" class="help-inline"></p>
						    </div>
						</div>
				    </div>

				    <div class="form-group">
				        <label for="mySelect">Select</label>
				        <select name="select[]" class="form-control" id="mySelect" multiple="multiple"></select>
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
		
		$("#bundleAdd").validate({
		  	errorElement: 'p',
        	errorClass: 'help-inline',
			
    		rules: {
		      title:{
		      	required:true,
		      	name_regex:true
		      },
		      type:{
		      	required:true
		      },
		      select:{
		      	required:true
		      },
		    },
		    
		    messages: {
		    },
      		submitHandler: function(form) {
      			$.ajax({
	      			type: "post",
	      			url: "add_bundle",
	      			data: $("#bundleAdd").serialize(),
	      			success: function(data){
	      				console.log(data);
	      				$('#bundleAdd').trigger("reset");
	      				$('#AddBundle').modal("hide");
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
	      	$('#mySelect').select2();
	    });

	    function selectType(){
	    	var type_id = document.getElementById("type_id").value;
			if(type_id == 'Subcategory'){
				$("#hideDiv").css("display", "block");
				$("#cat_id").on("change", function(e){
					$('#mySelect').empty();
					var _token = $('input[name="_token"]').val();
					var cat_id = document.getElementById("cat_id").value;
					if(cat_id == 0){
						$("#catErrorMsg").text("This field is required.");
					}
					$.ajax({
						type: "post",
						url: "get_list",
						data: { type:'Subcategory', cat_id:cat_id, _token:_token },
						success: function(data) {
							console.log(data);
							$.each(data, function(key, value) {
								console.log(value);
								if(type_id == "Subcategory"){
							    	$('#mySelect').append($("<option></option>").attr("value", value.id).text(value.sub_categories_name)); 
							    }
							});
						}
					});
				});
			} else {
				$("#hideDiv").css("display", "none");
			}
			selectCat(type_id);
		}

		function selectCat(id){
			$('#mySelect').empty();
			var cat_id = document.getElementById("cat_id").value;
			var _token = $('input[name="_token"]').val();
			$.ajax({
				type: "post",
				url: "get_list",
				data: { type:id, cat_id:cat_id, _token:_token },
				success: function(data) {
					console.log(data);
					$.each(data, function(key, value) {
						if(id == "Category"){
					    	$('#mySelect').append($("<option></option>").attr("value", value.id).text(value.category_name)); 
					    }
					    if(id == "Brand"){
					    	$('#mySelect').append($("<option></option>").attr("value", value.id).text(value.brand_name)); 
					    }
					});
				}
			});
		}
	</script>
</div>