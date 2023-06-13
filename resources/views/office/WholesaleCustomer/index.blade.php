@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row">
      <div id="table_holder">
         <div class="bootstrap-table">
            <div class="fixed-table-toolbar">
               <br>
               <div class="col-md-12">
                  <table id="table" class="table table-hover table-striped">
                     <thead id="table-sticky-header">
                        <tr  text-align="center">
                           <th class="" style="" data-field="people.person_id">
                              <div class="th-inner sortable both desc">Id</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="first_name">
                              <div class="th-inner sortable both">Wholesaler Name</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Phone Number</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Tot. Due Amount</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Tot. Paid Amount</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div align="center" class="th-inner sortable both">Pay due Amount</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="print_hide" style="" data-field="edit">
                              <div class="th-inner ">All Invoices</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="print_hide" style="" data-field="edit">
                              <div class="th-inner ">History</div>
                              <div class="fht-cell"></div>
                           </th>
                        </tr>
                     </thead>
                     <tbody>
                     	@if(!empty($customer))
                     		@foreach($customer as $emp)
                          @if($emp['customer'] != null)
		                        <tr data-index="1" align="center" data-uniqueid="{{ $emp['customer']->id }}">
		                           <td class="" style="">{{ $emp['customer']->id }}</td>
                               <td class="" style="">{{ $emp['customer']->first_name.' '.$emp['customer']->last_name }}</td>
		                           <td class="" style="">{{ $emp['customer']->phone_number }}</td>
		                           <td class="" style="">RS. {{ $emp['customer']->due_balance }}</td>
                               <td class="" style="">RS. {{ $emp['customer']->paid_balance }}</td>
		                           <td class="" style="background-color: #e6e6e6">
                                <div class="row form-group">
                                  <form action="{{ route('pay_installment') }}" method="POST">
                                    @csrf()
                                    <div class="col-xs-3">
                                      {{-- ============= Hidden Field ============== --}}
                                      <input type="hidden" name="cust_id" value="{{ $emp['customer']->id }}">
                                      {{-- ============= Hidden Field ============== --}}
                                       <input class="form-control" type="text" id="pay_amt" name="paid_amount" placeholder="Amount...." required="">  
                                    </div>
                                    <div class="col-xs-3">
                                      <select class="form-control" name="payment_type" id="pay_type" required="">
                                        <option value="cash">Cash</option>
                                        <option value="upi">UPI</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="debit_card">Debit Card</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="canceled">Canceled</option>
                                      </select> 
                                    </div>
                                    <div class="col-xs-4">
                                       <input class="form-control" type="text" id="remark" name="remark" placeholder="Remark....." required="">  
                                    </div>
                                    <button type="submit" class="btn btn-success">Pay</button>
                                  </form> 
                                </div>
                               </td>
		                           <td>
                                  <a href="{{ route('wholesale_customer.show',$emp['customer']->id)}}" class="btn btn-warning btn-sm modal-dlg" data-btn-submit="Submit" title="Delete Broker"><span class="glyphicon glyphicon-eye-open"></span></a>
                               </td>
                               <td>
                                  <a href="{{ route('due_history',$emp['customer']->id)}}" class="btn btn-info btn-sm modal-dlg" data-btn-submit="Submit" title="Delete Broker"><span class="glyphicon glyphicon-history"><i class="fa fa-history"></i></span></a>
                               </td>
		                        </tr>
                            @endif
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