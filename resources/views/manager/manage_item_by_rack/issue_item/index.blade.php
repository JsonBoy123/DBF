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
                <div class="row" id="extraMci21" >
                  <div class="col-md-12 float-left">
                    <a href="{{route('issue_items.create')}}" class="btn btn-md btn-info pull-right"  id="get_button">Issue Item </a>
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
                   
                </div>
            </form>
            <div id="table_area">
              <table id="myTable1" class="table table-hover table-striped ">
                  <thead id="table-sticky-header">
                    <tr>      
                      <th>Item Name</th>                    
                       
                       <th class="print_hide" style="" data-field="edit">
                          <div class="th-inner "> Action</div>
                          <div class="fht-cell"></div>
                       </th>
                    </tr>
                  </thead>
                  <tbody>
                   
                  </tbody>
                </table>

            </div>
         </span>
      </div>
   </div>
</div>

<div class="modal fade" id="itemrack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" >
          <h5 class="modal-title" id="exampleModalLabel">New Rack</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="bootstrap-dialog-body">
            <div class="bootstrap-dialog-message" id="creat_form">

            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>

<script>
$(document).ready(function(){  

  $('#myTable1').DataTable();


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
        }
      })
    })
</script>
@endsection