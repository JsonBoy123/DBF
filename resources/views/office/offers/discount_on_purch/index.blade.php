@extends('layouts.dbf')
@section('content')
<div class="container" id="container">
   <div class="row">
      <div id="title_bar" class="btn-toolbar">
         <div class="col-md-10">
            <div class="text-center successMsg" id="successMsg"></div>
         </div>
         <div class="col-md-2">
            <button class="btn btn-info btn-sm pull-right modal-dlg" id="create_discount" data-toggle="modal" data-target="#AddPricing" title="New Shop"><span class="glyphicon glyphicon-user">&nbsp;</span>New Discount</button>
         </div>
      </div>
      <table id="table" class="table table-hover table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="table_info">
         <thead id="table-sticky-header">
            <tr>
               <th role="row">S.No.</th>               
               <th>Title</th>
               <th>Discount</th>
               <th>Start Time</th>
               <th>End Time</th>
               <th>Status</th>
            </tr>
         </thead>
         <tbody>
            @if(!empty($data))
               @foreach($data as $Data)
                  <tr role="row" class="odd">
                     <td class="sorting_1">{{ $Data->id }}</td>                    
                     <td>{{ $Data->category->category_name }}</td>
                     <td>{{ $Data->amount }}</td>
                     <td>{{ $Data->from_date }}</td>
                     <td>{{ $Data->to_date }}</td>
                     <td>
                        <a onclick="edit( {{$Data->id}})" class="fa fa-pencil" ></a>
                        <a onclick="del( {{$Data->id}})" class="fa fa-trash" ></a>
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
            <div class="modal-body" id="model_id">
               
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

   $(document).on('click','#create_discount',function(){

      $.ajax({
         method:'get',
         url:'{{route('dicount_on_purchase.create')}}',
         success:function(data){
              $('#model_id').html(data) 
              $('#AddPricing').modal('show')
         }
      })
   })

 	$(document).ready(function() {
    	$('#table').DataTable();
  	  	$('.datepicker').datepicker({
  	  		autoclose: true,
  	  		orientation: "bottom"
  	  	});
  	});

function edit(id){
   $.ajax({
         method:'get',
         url:'/Office/dicount_on_purchase/edit/'+id,
         success:function(data){
              $('#model_id').html(data) 
              $('#AddPricing').modal('show')
         }
      })
}

function del(id){
   $.ajax({
         method:'get',
         url:'/Office/dicount_on_purchase/delete/'+id,
         success:function(data){
              $('#table').html(data) 
              // $('#AddPricing').modal('show')
         }
      })
}

  

</script>   
@endsection