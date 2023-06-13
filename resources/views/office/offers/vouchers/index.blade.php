@extends('layouts.dbf')
@section('content')
<div class="container" id="container">
   <div class="row">
      <div id="title_bar" class="btn-toolbar">
         <div class="col-md-10">
            <div class="text-center successMsg" id="successMsg"></div>
         </div>
         <div class="col-md-2">
            <button class="btn btn-info btn-sm pull-right modal-dlg" style="margin-left: 10px" data-toggle="modal" data-target="#AddVoucher" title="New Shop">New Voucher</button>
            <button class="btn btn-info btn-sm pull-right modal-dlg" id="print">Print</button>
         </div>
      </div>
      <table id="table" class="table table-hover table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="table_info">
         <thead id="table-sticky-header">
            <tr>
               <th role="row">S.No.</th>
               <th>Customer Name</th>
               <th>Title</th>
               <th>Amount</th>
               <th>Code</th>
               <th>Expiry Date</th>
               <th>Created At</th>
               <th>Edit Expiry Date</th>
               <th></th>
            </tr>
         </thead>
         <tbody>
            @if(!empty($vouchers))
            @php
             $count = 0;
            @endphp
               @foreach($vouchers as $voucher)
                  <tr role="row" class="odd">
                     <td class="sorting_1">{{++$count}}</td>
                     <td>{{ $voucher['customer']->first_name.' '.$voucher['customer']->last_name }}</td>
                     <td>{{ $voucher->title }}</td>
                     <td>{{ $voucher->amount }}</td>
                     <td>{{ $voucher->code }}</td>
                     <td>{{ $voucher->expiry }}</td>
                     <td>{{ $voucher->created_at }}</td>
                     <td>
                        <a href="#" class="modal-dlg" data-toggle="modal" data-target="#UpdateVoucher{{ $voucher->id }}" title="Update Voucher"><span class="glyphicon glyphicon-edit"></span></a>
                     </td>
                     <td>
                        <input type="checkbox" name="check" value="{{ $voucher->id }}">
                     </td>
                  </tr>

                  <!-- Update Modal -->
                  <div class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" id="UpdateVoucher{{ $voucher->id }}" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">UPDATE Voucher</h4>
                          </div>
                          <div class="modal-body">
                             <form id="EditVoucher{{ $voucher->id }}">
                              @csrf
                              @method('PUT')
                               <div class="form-group">
                                   <label for="expiry">Expiry Date</label>
                                   <input type="date" name="expiry" class="form-control" value="{{ $voucher->expiry }}">
                                   <input type="hidden" name="id" class="form-control" value="{{ $voucher->id }}">
                               </div>
                               <button type="submit" name="submit" class="btn btn-primary" style="float: right">UPDATE</button>
                           </form>
                          </div>
                        </div>   
                      </div>
                  </div>
                  <!-- Modal -->

                  <script type="text/javascript">
                     $("document").ready(function(){
                        $("#EditVoucher{{ $voucher->id }}").on("submit", function(e){
                           e.preventDefault();
                           $.ajax({
                              type: "put",
                              url: "update_voucher",
                              data: $("#EditVoucher{{ $voucher->id }}").serialize(),
                              success: function(data){
                                 // alert(data);
                                 $('#locationAdd').trigger("reset");
                                 $('#UpdateVoucher{{ $voucher->id }}').modal("hide");
                                 $("#successMsg").html(data.successMsg).delay(2000).fadeOut();
                                 setTimeout(function() {
                                     location.reload();
                                 }, 2000);
                              }
                           });
                        })
                     });
                  </script>
               @endforeach
            @endif
         </tbody>
      </table>
   </div>
   <!-- Add Modal -->
   <div class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" id="AddVoucher" role="dialog">
      <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">×</button>
               <h4 class="modal-title">Create Vouchers</h4>
            </div>
            <div class="modal-body">
               <form id="VoucherAdd">
               	@csrf
                  <div class="form-group">
                     <label for="voucher">Voucher Value</label>
                     <select name="voucher" id="voucher" class="form-control">
                        <option value="25000">GC_25K - 25000.00</option>
                        <option value="10000">GC_10K - 10000.00</option>
                        <option value="5000">GC_5K - 5000.00</option>
                        <option value="2000">GC_2K - 2000.00</option>
                        <option value="1000">GC_1K - 1000.00</option>
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="voucher">Voucher Value</label>
                     <select name="customer_id" id="voucher" class="form-control">
                      @foreach($customer_name as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->first_name.' '.$emp->last_name }}</option>
                      @endforeach
                     </select>
                  </div>
                  <button type="submit" name="submit" class="btn btn-primary" style="float: right">ADD</button>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal -->
</div>
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
	
	$("#VoucherAdd").validate({
	  	errorElement: 'p',
    	errorClass: 'help-inline',
		
		rules: {
	      voucher:{
	      	required:true
	      }
	    },
	    
	    messages: {
	    },
  		submitHandler: function(form) {
			$.ajax({
   			type: "post",
   			url: "add_voucher",
   			data: $("#VoucherAdd").serialize(),
   			success: function(data){
   				// alert(data);
   				$('#locationAdd').trigger("reset");
   				$('#AddVoucher').modal("hide");
   				$("#successMsg").html(data.successMsg).delay(200).fadeOut();
					 location.reload();
   				/*setTimeout(function() {
					}, 2000);*/
   			}
   		});
		}
	});

 	$(document).ready(function() {
    	$('#table').DataTable();

      $("#print").click(function(){
         var checked = [];
         $.each($("input[name='check']:checked"), function(){
            checked.push($(this).val());
         });
         var _token = $('input[name="_token"]').val();
         $.ajax({
            type: "post",
            url: "print_voucher",
            data: { "checked":checked, "_token":_token },
            success: function(data){
               //console.log(data);
               if(data == 'Success'){
                  window.location.href = "view_voucher";
               }
            }
         });
      });
  	});
</script>   
@endsection