

 @extends('layouts.dbf')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <label class="alert alert-success "  id="msg" style="display: none;"></label>
    </div>
    <div class="col-md-12">
      @if($message = Session::get('success'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
      @endif
    </div>
  </div>
    <div class="row">
      
        <div id="table_holder">
          <div class="bootstrap-table">
            <div class="fixed-table-toolbar">
               <div class="bs-bars pull-left">
                  <div id="toolbar">
                     <div class="pull-left btn-toolbar">
                        
                     </div>
                  </div>
               </div>
            </div>

{{-- Record Table Start --}}
            <div class="fixed-table-container" style="padding-bottom: 0px;">
               <div class="fixed-table-header" style="display: none;">
                
               </div>
                <div class="table-body">
                  <div class="fixed-table-loading" style="top: 41px; display: none;">Loading, please wait...</div>
                  
                    <table id="myTable" class="table table-hover table-striped ">
                      <thead id="table-sticky-header">
                        <tr>
                           <th class="bs-checkbox print_hide checkall" style="width: 36px; " data-field="checkbox" >
                              <div class="th-inner "><input name="btSelectAll" type="checkbox" ></div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="people.person_id">
                              <div class="th-inner sortable both desc">Id</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="last_name">
                              <div class="th-inner sortable both">Login Time</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="first_name">
                              <div class="th-inner sortable both">Logout Time</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Date</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Reason</div>
                              <div class="fht-cell"></div>
                           </th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $count =1; @endphp
                       @foreach ($open_close as $datas)
                          <tr data-index="0" data-uniqueid="13158">
                             <td class="bs-checkbox print_hide"><input data-index="0" name="btSelectItem" value="{{$datas->id}}" type="checkbox" class="checkhour"></td>
                             <td class="" style="">{{$count++}}</td>
                             <td class="" style="">{{$datas->logintime}}</td>
                             <td class="" style="">{{$datas->logouttime}}</td>
                             <td class="" style="">{{$datas->date}}</td>
                             <td class="" style="">{{$datas->reason}}</td>
                           
                          </tr>
                        @endforeach
                      </tbody> 
                    </table>
                </div>
            </div>
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
});
</script>

@endsection