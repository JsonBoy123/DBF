@extends('layouts.dbf')
@section('content')

<div class="container">
   <div class="row">
      <div class="row">
         <span class="col-md-12">

            <div class="bg-info" style="color:#fff;padding:10px;margin-bottom:20px;">
               <a style="color:#000" href="http://newpos.dbfindia.com/manager">
                  <h4 style="display:inline;">Manager ></h4>
               </a>
               <h4 style="display:inline;color:#000;">Racks > Items</h4>
            </div>
             {{--
            @if(\Request::path() != 'item_manage_rack')
              <div class="col-md-12">
                <div class="text-right">
                  <a class="btn btn-sm btn-default" href="{{route('item_manage_rack.index')}}">↵ Back</a>
                </div>
              </div><br><br>
            @endif
            <div class="row" id="extraMci21" >
              <form action="{{route('rack-items.search')}}" method="get">
                  <div class="col-md-3">
                    <select name="category2" id="category2" class="form-control text-left">
                      <option value="">Select Category</option>                           
                        @foreach($rack as $Rack)
                          <option value="{{$Rack->id}}" >{{$Rack->rack_number}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm" >Search</button>
                  </div>
                </form>

             
              <div class="col-md-7 text-right">
                <button class="btn btn-md btn-info" style="width:70px;" id="get_button">Get</button>
                <a href="{{route('rack-items.index')}}" class="btn btn-md btn-info" id="get_button">Find Items</a>
                <a href="{{route('item_manage_rack.create_rack')}}" class="btn btn-md btn-info" id="get_button">Create Rack</a>
                <a class="btn btn-md btn-info" id="item_model">Add Item Quantity On Rack</a>
                <a class="btn btn-md btn-info" href="{{route('issue_items.index')}}"  id="get_button">Issue Item List</a>
              </div>
            </div> --}}
                <!-- <div class="row" id="extraMci2" style="display:none">
                   <div class="col-md-3 col-md-offset-3">
                      <div class="form-group">
                         <select name="size2" id="size2" class="form-control">
                            <option value="">Select Size</option>
                         </select>
                      </div>
                   </div>
                   <div class="col-md-3">
                      <div class="form-group">
                         <select name="color2" id="color2" class="form-control">
                            <option value="">Select Color</option>
                         </select>
                      </div>
                   </div>
                </div> -->
                <div class="row" style="margin-bottom:20px;">

                </div>
            <div id="table_area">
              <table id="myTable1" class="table table-hover table-striped ">
                  <thead id="table-sticky-header">
                    <tr> 
                      <th class="text-center">ID</th>
                      <th class="text-center">Name</th>
                      <th class="text-center">Barcode</th>
                      <th class="text-center">Quantity</th>
                      <th class="text-center">Rack</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @php $count =1;  @endphp
                      {{-- @if(!empty($items)) --}}
                        @foreach($items as $data)
                          <tr>
                            <td class="text-center">{{$count++}}</td>
                            <td class="text-center" width="40%">{{$data['items']->name}}</td>
                            <td class="text-center">{{$data['items']->item_number}}</td>
                            <td class="text-center">{{$data->quantity}}</td>
                            <td class="text-center">{{$data['rack_name']->rack_number}}</td>
                          </tr>
                        @endforeach
                      {{-- @endif --}}
                  </tbody>
                </table>

            </div>
         </span>
      </div>
   </div>
</div>

<script>
$(document).ready(function(){  

  $('#myTable1').DataTable({
    order:[[0, 'asc']],
    dom: 'Bfrtip',
          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'pdfHtml5'
          ],
  });


   $('#myForm').on('submit', function(e){
     e.preventDefault();
     var location_id = $("#location_id").val();
     var report_type = $("#report_type").val();
     var category = $("#category2").val();
     var subcategory = $("#subcategory2").val();
     var brand = $("#brand2").val();
     var _token = $('input[name="_token"]').val();
     if(report_type == "type_1"){
       window.location.href = "download/"+location_id;
     }

     if(report_type == "type_2"){
        $.ajax({
          url: 'get_listaction_data', 
          type: 'post',
          data: { "location_id":location_id, "report_type":report_type, "category":category, "subcategory":subcategory, "brand":brand, "_token":_token },
          headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function(data){
            $('#table_area').html(data);
            $('#extras_sublist').DataTable({
              "scrollX": true,
               dom: 'Bfrtip',
               buttons: [
                  'copy', 'csv', 'excel', 'pdf', 'print'
               ]
            });
          }
        });
     }
   });

    $('#report_type').on('change',function(){
        if ( this.value == 'type_2'){
            $("#extraMci21").show();
        } else {
            $("#extraMci21").hide();
            $("#extraMci2").hide();
        }
    });

    $('#category2').change(function(){
      var cat_id = $(this).children("option:selected").val();
      $.ajax({
        type: 'POST',
        url: 'getListActionMCI',
        data: {'cat_id':cat_id},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(res){
          if(res){
            $('#subcategory2').empty();
            $("#subcategory2").append('<option value="">Select</option>');
            $.each(res,function(key,value){
              $('#subcategory2').append('<option value="'+value.id+'">'+value.sub_categories_name+'</option>');
            });
          }else{
            $('#subcategory2').empty();
          }
        }
      });
    });
});

    $(document).on('click','#item_model',function(){

      $.ajax({
        method:'get',
        url:'{{route('item_manage_rack.create')}}',
        success:function(data){
          $('#creat_form').html(data);
          $('#itemrack').modal('show');
          // location.reload()
        }
      })
    })

    $(document).on('click','#delete_rack_item',function(){
      var id = $(this).attr('data-id')
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method:'post',
        url:'{{route('item_manage_rack.delete')}}',
        data:{id:id},
        success:function(data){
          location.reload()
        }
      })
    })
</script>
@endsection