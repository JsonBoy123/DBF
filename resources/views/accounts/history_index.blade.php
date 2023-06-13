@extends('layouts.dbf')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-4">
      <a href="{{route('account.repair-items')}}" class="btn btn-primary">Back</a><br>
    </div>
    <div class="col-md-8">
      <h4>All Completed bills against Repairing panel.....!</h4>
    </div>
  </div>
  <hr>
    <div class="row">
        <div id="table_holder">
          <div class="bootstrap-table">
            <div class="fixed-table-container" style="padding-bottom: 0px;">
               <div class="fixed-table-header" style="display: none;">
                
               </div>
                <div class="table-body">
                  {{-- <div class="fixed-table-loading" style="top: 41px; display: none;">Loading, please wait...</div>
                  <div id="table-sticky-header-sticky-header-container" class="hidden"></div>
                  <div id="table-sticky-header_sticky_anchor_begin"></div> --}}
                    <table id="myTable" class="table table-hover table-striped ">
                      <thead id="table-sticky-header">
                        <tr>
                           <th class="text-center" style="" data-field="people.person_id">
                              <div class="th-inner sortable both desc"> No.</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="text-center" style="" data-field="last_name">
                              <div class="th-inner sortable both">Bill Number</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="text-center" style="" data-field="first_name">
                              <div class="th-inner sortable both">Date</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="text-center" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Repaired Qty</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="text-center" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Bill Amount</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="text-center" style="" data-field="total">
                              <div class="th-inner ">View / Action</div>
                              <div class="fht-cell"></div>
                           </th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $count =1; @endphp
                          @foreach ($bills as $data)
                            <tr>
                              <td class="text-center" style="">{{$count++}}</td>
                              <td class="text-center" style="">{{$data->id}}</td>
                              <td class="text-center" style="">{{$data->bill_date}}</td>
                              <td class="text-center" style="">{{$data->quantity}}</td>
                              <td class="text-center" style="">{{$data->bill_amount}}</td>
                              <td class="text-center" style="">
                                <div class="row col-md-12">
                                  <div class="col-md-6">
                                    <a href="{{route('account.repair-challan', [$data->id])}}"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></a> 
                                  </div>
                                  <div class="col-md-6">
                                    <a href=""><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
                                 </div>
                                </div>
                              </td>
                            </tr>
                          @endforeach
                      </tbody>
                    </table>
              </div>
            </div>
{{-- Record Table End --}}


          </div>
        </div>
   </div>
</div>



<script type="text/javascript">
   
   $(document).ready( function () {
 
    $('#myTable').DataTable({
      dom: 'Bfrtip',
       buttons: [ { extend: 'copyHtml5' },
            { extend: 'excelHtml5' },
            { extend: 'print'},
            { extend: 'pdfHtml5'}
            ]
    });
} );


</script>

@endsection