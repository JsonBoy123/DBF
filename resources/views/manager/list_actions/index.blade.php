@extends('layouts.dbf')
@section('content')

<div class="container">
   <div class="row">
      <div class="row">
         <span class="col-md-12">
            <div class="bg-info" style="color:#fff;padding:10px;margin-bottom:20px;">
               <a style="color:#fff" href="http://newpos.dbfindia.com/manager">
                  <h4 style="display:inline">Manager</h4>
               </a>
               &gt;&gt; List Actions 
            </div>
            <form id="myForm">
                @csrf
                <div class="row">
                   <div class="form-group col-md-6">
                      <label>Locations</label>
                      <select class="form-control" id="location_id">
                         <option value="AllLocations">ALL LOCATIONS</option>
                         @if(!empty($shop))
                            @foreach($shop as $shops)
                                <option value="{{ $shops->id }}">{{ $shops->name }}</option>
                            @endforeach
                         @endif
                      </select>
                   </div>
                   <div class="form-group col-md-3">
                      <label>Report Type</label>
                      <select class="form-control" id="report_type">
                         <option value="">Select</option>
                         <option value="type_1">All Items</option>
                         <option value="type_2">Filter Items</option>
                      </select>
                   </div>
                </div>
                <div class="row" id="extraMci21" style="display:none">
                   <div class="col-md-4">
                      <div class="form-group">
                         <select name="category2" id="category2" class="form-control">
                            <option value="">Select Category</option>
                            @if(!empty($category))
                              @foreach($category as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                              @endforeach
                            @endif
                         </select>
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class="form-group">
                         <select name="subcategory2" id="subcategory2" class="form-control"></select>
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class="form-group">
                         <select name="brand2" id="brand2" class="form-control">
                            <option value="">Select Brand</option>
                            @if(!empty($brand))
                              @foreach($brand as $brands)
                                <option value="{{ $brands->id }}">{{ $brands->brand_name }}</option>
                              @endforeach
                            @endif
                         </select>
                      </div>
                   </div>
                </div>
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
                   <div class="col-md-12 text-center  ">
                      <button class="btn btn-md btn-info" style="width:70px;" id="get_button">Get</button>
                   </div>
                </div>
            </form>
            <div id="table_area"></div>
         </span>
      </div>
   </div>
</div>

<script>
$(document).ready(function(){         
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
</script>
@endsection