

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
            {{-- <div class="fixed-table-container" style="padding-bottom: 0px;"> --}}
               <div class="fixed-table-header">
                @if($sheet->sheet_status == 0)
                  <div class="col-md-1 pull-right">                    
                    <a id="Decline" class="btn btn-danger pull-right">Decline</a>
                  </div>
                  <div class="col-md-1 pull-right">                    
                    <a id="Approve" class="btn btn-success pull-right">Approve</a>
                  </div>
                 @endif 
               </div>
                <div class="table-body" style="padding-top: 20px">
                 <table id="myTable" class="table table-hover table-striped" style="padding-top: 10px">
                      <thead >
                        <tr style="padding-top: 20px">
                           <th class="" style="" data-field="people.person_id">
                              <div class="th-inner sortable both desc">No</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="last_name">
                              <div class="th-inner sortable both">Name</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="first_name">
                              <div class="th-inner sortable both">Category</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Subcatagory</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">brand</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Color</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Size</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Model</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">HSN</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Unit Price</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">IGST</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Retail Discount</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Location</div>
                              <div class="fht-cell"></div>
                           </th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $count =1; @endphp
                        @foreach ($data as $datas)
                        @if($datas->error_status == 1)
                          <tr data-index="0" data-uniqueid="13158">
                        @elseif($datas->error_status == 0)
                          <tr data-index="0" data-uniqueid="13158" style="color: #ff0000">
                        @endif
                             <td class="" style="">{{$count++}}</td>
                             <td class="" style="">{{$datas->name}}</td>
                             <td class="" style="">{{$datas->category}}</td>
                             <td class="" style="">{{$datas->subcategory}}</td>
                             <td class="" style="">{{$datas->brand}}</td>
                             <td class="" style="">{{$datas->color}}</td>
                             <td class="" style="">{{$datas->size}}</td>
                             <td class="" style="">{{$datas->model}}</td>
                             <td class="" style="">{{$datas->hsn_no}}</td>
                             <td class="" style="">{{$datas->unit_price}}</td>
                             <td class="" style="">{{$datas->igst}}</td>
                             <td class="" style="">{{$datas->retail_discount}}</td>
                             <td class="" style="">{{$datas->location_id}}</td>
                          </tr>
                        @endforeach
                      </tbody> 
                    </table>
                </div>

            {{-- </div> --}}

          </div>
        </div>
   </div>
</div>

<script type="text/javascript">
   
   $(document).ready(function(){

    /*======================================*/
 
    $('#myTable').DataTable({
      dom: 'Bfrtip',
       buttons: [ { extend: 'copyHtml5' },
            { extend: 'excelHtml5' },
            { extend: 'print'},
            { extend: 'pdfHtml5'}
            ]
      });

    /*=======================================*/

    $('#Approve').on('click', function(e){
      var parent_id = '{{$sheet_id}}';
       $.ajax({
          url: '/sheet_approval', 
          type: 'post',
          data: { "parent_id":parent_id},
          headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function(data){
            console.log(data);
              // $('#MyPopup').modal('hide');
              alert("success");
             location.reload(true);
          }
        });
    });

    /*=======================================*/

    $('#Decline').on('click', function(e){
      var parent_id = '{{$sheet_id}}';

       $.ajax({
          url: '/sheet_decline', 
          type: 'post',
          data: { "parent_id":parent_id},
          headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function(data){
              // $('#MyPopup').modal('hide');
              alert("success");
              location.reload(true);
          }
        });
    });

    /*=======================================*/
});
</script>

@endsection