@extends('layouts.dbf')
@section('content')
<div class="container">
   {{-- <div class="row col-md-12">
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
    </div> --}}
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
                              <div class="th-inner sortable both">Against Bill Number</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Adjusted Amount</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Transaction Date/Time</div>
                              <div class="fht-cell"></div>
                           </th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($adjust_history))
                           @foreach($adjust_history as $history)
                              <tr data-index="1" data-uniqueid="{{ $history->id }}">
                                 <td class="" style="">{{ $history->sale_id }}</td>
                                 <td class="" style="">RS. {{ $history->adjusted_amt }}</td>
                                 <td class="" style="">{{ $history->created_at }}</td>
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
   
   
   $("document").ready(function(){
      $("#table").DataTable({
         dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
      });
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