@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row col-md-12">
      <div class="col-md-2">
        <a href="{{ route('wholesale_customer.index') }}" class="btn btn-primary"><span class="glyphicon glyphicon-user">&nbsp;</span>Back</a>
      </div>
    </div>
   <br><hr>
   <div class="row col-md-12">
      <div class="col-md-2">
        <label> Customer name : </label> 
      </div>
      <div class="col-md-2">
        <input type="text" class="form-control col-md-2" name="customer_name" value="{{ $name }}" readonly="">
      </div>
    </div>
    <br><br>
    <div class="row col-md-12">
      <div class="col-md-2">
        <label> Adjustable Amount : </label> 
      </div>
      <div class="col-md-2">
        <input type="text" class="form-control col-md-2" id="adjustable_amt" name="adjustable_amt" value="{{ $paid_amt }}" readonly="">
      </div>
    </div>
    <br><hr>
   <div class="row">
      <div id="table_holder">
         <div class="bootstrap-table">
            <div class="fixed-table-toolbar">
               <div class="col-md-12">
                  <table id="table" class="table table-hover table-striped">
                     <thead id="table-sticky-header">
                        <tr>
                           <th class="" style="" data-field="first_name">
                              <div class="th-inner sortable both">Id</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="first_name">
                              <div class="th-inner sortable both">Bill Number</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="first_name">
                              <div class="th-inner sortable both">Date</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Pending Amount</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Paid Amount</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Total Bill Amount</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both" align="center">Adjust Amount</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="print_hide" style="" data-field="edit">
                              <div class="th-inner ">Status</div>
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
                              <tr data-index="1" data-uniqueid="{{ $emp->id }}">
                                 <td class="" style="">{{ $emp->id }}</td>
                                 <td class="" style="">{{ $emp->sale_id }}</td>
                                 <td class="" style="">{{ $emp->date }}</td>
                                 <td class="" style="">RS. {{ $emp->pending_amount }}</td>
                                 <td class="" style="">RS. {{ $emp->paid_amount }}</td>
                                 <td class="" style="">RS. {{ $emp->total_amount }}</td>
                                 <td class="" style="background-color: #e6e6e6">
                                   <div class="row col-md-12 form-group">
                                    <form action="{{ route('adjust_amt') }}" method="POST">
                                      @csrf()

                                      {{-- ============= Hidden Field ============== --}}
                                      <input type="hidden" name="cust_id" value="{{ $emp->customer_id }}">
                                      <input type="hidden" name="sale_id" value="{{ $emp->sale_id }}">
                                      {{-- ============= Hidden Field ============== --}}

                                      <div class="col-xs-10">
                                         <input class="form-control" type="text" id="adjust_amt" name="adjust_amt" placeholder="Amount...." required="">  
                                      </div>
                                      <div class="col-xs-2">
                                        @if($emp->pending_amount != 0)
                                          <button type="submit" class="btn btn-success">Adjust</button>
                                        @else
                                          <button type="submit" disabled="" class="btn btn-success">Adjust</button>
                                        @endif
                                      </div>
                                    </form> 
                                  </div>
                                 </td>
                                 <td>
                                    @if($emp->pending_amount != 0)
                                      <span style="color: orange">Pending</span>
                                    @else
                                      <span style="color: green">Paid</span>
                                    @endif
                                 </td>
                                 <td>
                                  <a href="{{ route('adjusted_history',$emp->sale_id) }}" class="btn btn-info btn-sm modal-dlg" data-btn-submit="Submit" target="blank"><span class="glyphicon glyphicon-history"><i class="fa fa-history"></i></span></a>
                                 </td>
                              </tr>
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
   
   $('input#adjust_amt').on('keyup mouseup', function(){
      var aval_bal = {{ $paid_amt }};
      var value = $(this).val();
      //alert(aval_bal)
      if(value > aval_bal)
      {
         alert("You have not enough balance");
         location.reload(true);
      }
   });

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