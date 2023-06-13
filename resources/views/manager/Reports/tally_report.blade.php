@extends('layouts.dbf')
@section('content')

<div class="container">
  <div class="row">
     <span class="col-md-12">
        <div class="bg-info" style="color:#fff;padding:10px;margin-bottom:20px;">
           <a style="color:#fff" href="#">
              <h4 style="display:inline">Manager</h4>
           </a>
           &gt;&gt; Reports 
        </div>
        <form id="myForm">
            @csrf
            <div class="row" >
            	<div class="col-md-12" style="padding:-10px" align="center">
	               <h4><u> Sales Report - Tally format </u></h4>
	            </div>
            </div>
          {{--   <div class="row col-md-12" style="padding-top: 20px">
               <div class="col-md-3">
                  <div class="form-group">
                     <select name="category" id="category" class="form-control">
                        <option value="">-- Select Category --</option>
                        @if(!empty($get_cat))
                          @foreach($get_cat as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                          @endforeach
                        @endif
                     </select>
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group">
                    <select name="sheet_type" class="form-control" id="sub_cat">
                      <option value="">-- None --</option>
                   	</select>
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group">
                     <select class="form-control"  id="brand">
                      <option value="">-- Select Brand --</option>
                      @if(!empty($brand))
                         @foreach($brand as $brands)
                            <option value="{{ $brands->id }}">{{ $brands->brand_name }}</option>
                         @endforeach
                      @endif
                   </select>
                  </div>
               </div>
           </div> --}}
           <div class="row col-md-12">
           	<div class="col-md-8">
                 <button class="btn btn-info" id="getSales">Get Sales</button>
           	</div>
           		<div class="col-md-2" >
                  <div class="form-group">
                     From <input type="date" id="fromDate" name="fromDate" class="form-control">
                  </div>
               </div>
               <div class="col-md-2" >
                  <div class="form-group">
                    To <input type="date" id="toDate" name="toDate" class="form-control">
                  </div>
               </div>	
           </div>
        </form>
        <hr>
     </span>
  </div>
  <div class="row">
    <div id="table_area"></div>
  </div>
</div>


<script type="text/javascript">

$(document).ready(function(){

/*===========================================================================*/
  $('#category').on('change', function(){
    var cat_id = $(this).children("option:selected").val();
    $.ajax({
      type: 'post',
      url: 'get_bulk_sub_cat',
      data: {'cat_id':cat_id},
      headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function(res){
      //console.log(res);
        if(res){
          $('#sub_cat').empty();
          $("#sub_cat").append("<option value=''>-- None --</option>");
          $.each(res,function(key,value){
            $('#sub_cat').append('<option value="'+value+'">'+key+'</option>');
          });
        }
      }
   });
  });

   
/*==========================================================================*/
  $('#getSales').on('click', function(e){
     e.preventDefault();
     var category    = $("#category").val();
     var subcategory = $("#sub_cat").val();
     var brand       = $("#brand").val();     
     var fromDate    = $("#fromDate").val();
     var toDate      = $("#toDate").val();
     // alert($fromDate);

    if(fromDate !='' && toDate !=''){
       $.ajax({
          url: 'tally_format_report_gen', 
          type: 'post',
          data: { "category":category, "subcategory":subcategory, "brand":brand, "fromDate":fromDate, "toDate":toDate},
          headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          /*success: function(data){
              //$('#all_items').html(data);
              alert('bulk HSN update successfully');
          }*/
          success:function(res){
          $('#table_area').html(res);
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
    else{
      alert('please select From Date & To Date ');
    }
  });

});

   
</script> 
@endsection