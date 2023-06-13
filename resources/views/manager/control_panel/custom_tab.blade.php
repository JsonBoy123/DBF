<div style="margin-bottom: 24px; text-align: end;padding-bottom: 50px;border-bottom: 1px solid #dce4ec;">
	<div class="col-md-6">
      	<span class="successMsg" id="successMsg"></span>
    </div>
    <div class="col-md-6">
	   <select style=" margin-right: 14px;padding: 7px 26px;background-color: #fff;color: #000;border: 2px solid #dce4ec;border-radius: 4px;" id="custom_field" class="show-menu-arrow custom_field" onchange="custom(this);">
	      <option value="">Select Tag..</option>
	      <option value="1">BILLTYPE</option>
	      <option value="2">TAXTYPE</option>
	      <option value="3">SPECIAL_PRICING</option>
	      <option value="4">FRANCHISE</option>
	      <option value="5">SPL_OFFER</option>
	      <option value="6">VC_EXPIRY_DURATION</option>
	      <option value="7">SHEET_UPLOADER</option>
	      <option value="8">SHEET_UPLOADER_ADMIN</option>
	   </select>

	   <span class="pull-right add_tag_btn">
	   		<button id="add_tag" class="btn btn-info btn-sm modal-dlg-1"  data-toggle="modal" data-target="#addCustom" title="Add Tag">Add New</button>
	   </span>
	</div>
</div>

<?php
	for($i=1; $i <= 8; $i++){
?>
<div class="custom_field_tbl hideDiv" id="customDiv{{ $i }}" style="display: none;">
  	<table id="table_custom{{ $i }}" class="table table-hover" style="width: 100%;" role="grid" aria-describedby="cashier_list_info">
     	<thead>
	        <tr role="row">
	           <th>id</th>
	           <th>Title</th>
	           <th>Alias</th>
	           <th>Tag </th>
	           <th>Int</th>
	           <th>Status</th>
	        </tr>
	    </thead>
	    <tbody id="tbody{{ $i }}"></tbody>
  	</table>
</div>

<script type="text/javascript">
	$(document).ready(function() {
      	$('#table_custom{{ $i }}').DataTable();
      	$('.toggle-ones').bootstrapToggle();
    });
</script>
<?php } ?>

<!-- Add Modal -->
<div class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" id="addCustom" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ADD TAG</h4>
        </div>
        <div class="modal-body">
	        <form id="customAdd">
	        	@csrf
			    <div class="form-group">
			        <label>Title</label>
			        <input type="text" class="form-control" name="title" placeholder="Title">
			    </div>

			    <div class="form-group">
			        <label>Alias</label>
			        <input type="text" class="form-control" name="alias" placeholder="Alias">
			    </div>

			    <div class="form-group">
			        <label>Tag Name</label>
			        <select class="form-control" name="tag">
			        	<option value="" selected="" disabled="disabled">Select Tag..</option>
					    <option value="1">BILLTYPE</option>
					    <option value="2">TAXTYPE</option>
					    <option value="3">SPECIAL_PRICING</option>
					    <option value="4">FRANCHISE</option>
					    <option value="5">SPL_OFFER</option>
					    <option value="6">VC_EXPIRY_DURATION</option>
					    <option value="7">SHEET_UPLOADER</option>
					    <option value="8">SHEET_UPLOADER_ADMIN</option>
			        </select>
			    </div>

			    <div class="form-group">
			        <label>Int Value</label>
			        <input type="text" class="form-control" name="int_val" placeholder="Int Value">
			    </div>

			    <button type="submit" class="btn btn-primary" style="float: right">ADD</button>
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
	
	$("#customAdd").validate({
	  	errorElement: 'p',
    	errorClass: 'help-inline',
		
		rules: {
	      title:{
	      	required:true
	      },
	      tag:{
	      	required:true
	      }
	    },
	    
	    messages: {
	    },
  		submitHandler: function(form) {
  			$.ajax({
      			method: 'post',
      			url: 	'custom',
      			data: 	$("#customAdd").serialize(),
      			success: function(data){
      				$('#customAdd').trigger("reset");
			      	$('#addCustom').modal("hide");
      				$("#successMsg").html(data.successMsg).delay(2000).fadeOut();
      				setTimeout(function() {
					    location.reload();
					}, 2000);
      			}
      		});
		}
	});

    function custom(){
		var tagID = document.getElementById("custom_field").value;
		var tagName = document.getElementById("custom_field");
		var strUser = tagName.options[tagName.selectedIndex].text;
		var _token = $('input[name="_token"]').val();
		$(".hideDiv").hide();
		document.getElementById("customDiv"+tagID).style.display = "block";
		
		$.ajax({
	        type: "post",
	        url: "fetchCustom",
	        data: { tag:tagID, _token:_token },
	        success: function(res){ 
	        	$("#tbody"+tagID).empty();
	        	$.each(res, function(i,e){
	        		if(e.status == 0){
	        			btn = '<div class="toggle btn btn-primary btn-xs" data-toggle="toggle" style="width: 34.0156px; height: 22px;"><input checked onchange="updateStatus('+e.id+', '+e.status+')" value="'+e.status+'" class="toggle-one" name="status" type="checkbox" data-size="mini"><div class="toggle-group"><label class="btn btn-primary btn-xs toggle-on">On</label><label class="btn btn-default btn-xs active toggle-off">Off</label><span class="toggle-handle btn btn-default btn-xs"></span></div></div>';
	        		} else {
	        			btn = '<div class="toggle btn btn-xs btn-default off" data-toggle="toggle" style="width: 34.0156px; height: 22px;"><input onchange="updateStatus('+e.id+', '+e.status+')" value="'+e.status+'" class="toggle-one" name="status" type="checkbox" data-size="mini"><div class="toggle-group"><label class="btn btn-primary btn-xs toggle-on">On</label><label class="btn btn-default btn-xs active toggle-off">Off</label><span class="toggle-handle btn btn-default btn-xs"></span></div></div>';
	        		}
		
					$("#tbody"+tagID).append('<tr id="25" role="row" class="odd"><td class="sorting_1">1</td><td>'+e.title+'</td><td>'+e.alias+'</td><td>'+strUser+'</td><td>'+e.int_val+'</td><td>'+btn+'</td>');
				});
	        }
    	});
	}

	function updateStatus(id, status){
		var _token = $('input[name="_token"]').val();
		$.ajax({
  			type: "post",
  			url: "custom_status",
  			data: { id:id, status:status, _token:_token },
  			success: function(data){
  				// console.log(data);
  				setTimeout(function() {
				    location.reload();
				}, 200);
  			}
  		});
	}
</script>