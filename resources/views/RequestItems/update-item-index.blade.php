@extends('layouts.dbf')
@section('content')

<div class="container">
  <div class="row">
    <div class="col-12">
      <label class="alert alert-success "  id="msg" style="display: none;"></label>
    </div>
    @if(\Request::path() != 'items-quantity/index')
      <div class=" col-xl-12" style="float: right;">
        <a class="btn btn-sm btn-default" href="{{route('items-quantity.index')}}">↵ Back</a>
      </div>
    @endif
    <div class=" col-xl-12">
    @if($message = Session::get('failure'))
        <div class="alert alert-danger alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
              {{$message}}
            </div>
      @endif
  </div>
  </div>
    <div class="row">
        <div id="table_holder">
          <div class="bootstrap-table">
            {{-- <div class="row col-md-12"> --}}

              <div class="col-6" style="float:left">
                <form action="{{route('items-detail.search')}}" method="get">
                  <div>
                    {{-- <input type="radio" id="name" name="type" value="name" checked="">
                    <label for="name" class="mb-10">Name</label>&nbsp 
                    <input type="radio" id="" name="type" value="item_number" >--}}
                    <label for="item_number">Search Items</label>
                  </div>
                  <input type="text" id="searchItem" placeholder="Search barcode ..." size=50 name="item_barcode" autocomplete="off">
                  <button type="submit" class="btn btn-primary btn-sm" >Search</button>
                </form>
              </div>
              <div class="col-6" style="float:right;">
                  
                  <button type="button" class="btn btn-primary btn-sm" id="update_item_racks">Update Items & Racks</button>
              </div>

              <br>

              {{-- <div class="col-2" style="float: right">
                <button class="btn btn-sm btn-primary modelRequest" data-shop="" style="float: right">Submit</button>
              </div>
              <br><br> --}}
            
            <div class="fixed-table-container" style="padding-bottom: 0px;">
              <table id="myTable" class="table table-hover table-striped ">
                <thead id="table-sticky-header">
                <tr>
                           <th>
                              <div class="th-inner sortable both desc">  Item Number</div>

                           </th>
                           <th>
                              <div class="th-inner sortable both desc">Name</div>

                           </th>
                           <th>
                              <div class="th-inner sortable both desc">Quantity</div>

                           </th>
                           <th>
                              <div class="th-inner sortable both desc">Rack Location</div>

                           </th>
                           <th>
                              <div class="th-inner sortable both desc">Action</div>

                           </th>
                         
                           
                        </tr>
                      </thead>
                      <tbody>
                      {{-- @foreach($items as $data)
                        
                        <tr><td>{{$data->item ?$data->item->item_number : ''}}</td>
                          <td>{{$data->item ? $data->item->name : ''}}</td>
                          <td>
                            <input type="number"  class="emp checkshop"  min="0" style="width: 45px; " value="{{$data->quantity}}" id="quantity_{{$data->item_id}}">

                          </td>
                          <td>
                            
                            <div class="col-md-2">
                              <select id="rack_{{$data->item_id}}" class="form-control" style="width: 190px;" >
                                  <option value="0" select="selected">Select Rack</option>
                                @foreach($racks as $rack)
                                  <option value="{{$rack->id}}">{{$rack->rack_number }}</option>
                                @endforeach

                              </select>
                            </div>

                          </td>
                          <td><button type="submit" data-item="{{$data->item_id}}" class="btn btn-primary update-item">Submit</button></td>
                        </tr>
                        
                      @endforeach --}}
                      @if(!empty($items))
                      <tr><td>{{$items->item_number}}</td>
                          <td>{{$items->name}}</td>
                          <td>
                            <input type="number"  class="emp checkshop"  min="0" style="width: 45px; " value="0" id="quantity_{{$items->id}}">

                          </td>
                          <td>
                            
                            <div class="col-md-2">
                              <select id="rack_{{$items->id}}" class="form-control" style="width: 190px;" >
                                  <option value="0" select="selected">Select Rack</option>
                                @foreach($racks as $rack)
                                  <option value="{{$rack->id}}">{{$rack->rack_number }}</option>
                                @endforeach

                              </select>
                            </div>

                          </td>
                          <td><button type="submit" data-item="{{$items->id}}" class="btn btn-primary update-item">Submit</button></td>
                        </tr>
                       @endif
                     
                      </tbody>
                    </table>

                </div>
                   
            </div>
          </div>
        </div>
   </div>
</div>
<!-- Update PP Modal --> 
<div id="updateItemsRacks" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;"><button class="close" data-dismiss="modal">×</button></div>
               <div class="bootstrap-dialog-title" >Update Items & Racks</div>
            </div>
         </div>
         <form enctype="multipart/form-data" action="{{ route('update.items-racks') }}" method="post">
            @csrf
            <div class="modal-body">
               <div class="bootstrap-dialog-body">
                  <div class="bootstrap-dialog-message">
                     <label>Select Sheet</label>
                     <div class="form-group">
                        <input type="file" name="file_path" accept=".xlsx" class="form-control input-sm">
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer" style="display: block;">
               <div class="bootstrap-dialog-footer">
                  <div class="bootstrap-dialog-footer-buttons">
                         <input type="hidden" name="location_upload" >
                     <button class="btn btn-primary" type="submit">Submit</button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<script type="text/javascript">

  $(document).ready( function () {


    $(document).on('click','.update-item', function(){
  
    var item_id = $(this).data('item')
    var rack    = $('#rack_'+item_id).val()
    var quantity = $('#quantity_'+item_id).val()

      if(rack != 0 && quantity != 0){

        $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          method:'POST',
          url:'{{route('items-detail.update')}}',
          data:{item_id:item_id, rack:rack, quantity:quantity},
          success:function(data){
            alert('Items\'s Rack & Quantity has been updated.')
            $('#quantity_'+item_id).val(0)
            $('#rack_'+item_id+' option:eq(0)').prop("selected", true)
          }
        })
      }else{
        alert('Empty values are not accepted.')
      }
  })

  $(document).on('keyup','#searchItem',function(){
  if($(this).val().length >= 10){
    $('#searchItem tr td input').attr('checked','checked')

    setTimeout(function(){
           $('#ItemsTable_filter label input').val('')            
        }, 1000);
  }
  
})

    $('#myTable').DataTable({
        "dom": 'lBfrtip',
        buttons: [ { extend: 'copyHtml5' },
            { extend: 'excelHtml5' },
            { extend: 'print'},
            { extend: 'pdfHtml5'}
            ],
        searching: false,
        paging: false,
        info: false,
        "ordering": false
    });


    /**update items & racks***/

   $('#update_item_racks').on('click', function(){

      $('#updateItemsRacks').modal('show');
     
   });
});
</script>
<style type="text/css">
  div.dataTables_wrapper div.dataTables_filter input {
      margin-right: 0.5em;
  }
</style>

@endsection