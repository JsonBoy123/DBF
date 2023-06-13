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
	               <h4><u> Sales Report - Monthly format </u></h4>
	            </div>
            </div>
            <div class="row col-md-12" style="padding-top: 20px">
               <div class="col-md-2">
               	  <div class="form-group" align="right">
               	  	<h4><b> Location :</b></h4>
               	  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <select name="location" id="location" class="form-control">
                        <option value="">-- Select Location --</option>
                        @if(!empty($location))
                          @foreach($location as $loc)
                            <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                          @endforeach
                        @endif
                     </select>
                  </div>
               </div>
               <div class="col-md-2">
               	  <div class="form-group" align="right">
               	  	<h4><b> Bill type :</b></h4>
               	  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <select name="bill_type" id="bill_type" class="form-control">
                        <option value="all">All</option>
                        <option value="credit_note"> Credit Note </option>
                        <option value="invoice"> Invoice </option>
                        
                     </select>
                  </div>
               </div>
           </div>
           <div class="row col-md-12" style="padding-top: 20px">
               <div class="col-md-2">
               	  <div class="form-group"  align="right">
               	  	<h4><b> Month :</b></h4>
               	  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <select name="month" id="month" class="form-control">
                        <option value="1">JANUARY</option>
                        <option value="2">FEBRUARY</option>
                        <option value="3">MARCH</option>
                        <option value="4">APRIL</option>
                        <option value="5">MAY</option>
                        <option value="6">JUNE</option>
                        <option value="7">JULY</option>
                        <option value="8">AUGUST</option>
                        <option value="9">SEPTEMBER</option>
                        <option value="10">OCTOBER</option>
                        <option value="11">NOVEMBER</option>
                        <option value="12">DECEMBER</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-2">
               	  <div class="form-group" align="right">
               	  	<h4><b> Year :</b></h4>
               	  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <select name="category" id="category" class="form-control">
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                     </select>
                  </div>
               </div>
           </div>
           <div class="row col-md-12">
           	<div class="col-md-12" align="center">
                 <button class="btn btn-info" id="getSales">Get Sales</button>
           	</div>
           </div>
        </form>
        <hr>
        <div id="table_area"></div>
     </span>
  </div>
</div>


<script type="text/javascript">

$(document).ready(function(){

  /*==========================================================================*/
 /* $('#getSales').click(function(){
    var cat_id = $(this).children("option:selected").val();
    $.ajax({
      type: 'GET',
      url: 'get_bulk_data',
      data: {'cat_id':cat_id},
      success:function(res){
        //alert(res);
        //$('#table_area').html(res);
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
  });
*/
/*===========================================================================*/
 /* $('#category').on('change', function(){
    var cat_id = $(this).children("option:selected").val();
    $.ajax({
      type: 'GET',
      url: 'get_bulk_sub_cat',
      data: {'cat_id':cat_id},
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
  });*/

/*==========================================================================*/
  /*$('#category2').change(function(){
      var cat_id = $(this).children("option:selected").val();
      $.ajax({
        type: 'GET',
        url: 'get_bulk_sub_cat',
        data: {'cat_id':cat_id},
        success: function(res){
        //console.log(res);
          if(res){
            $('#sub_category').empty();
            $("#sub_category").append("<option value=''>-- None --</option>");
            $.each(res,function(key,value){
              $('#sub_category').append('<option value="'+value+'">'+key+'</option>');
            });
          }
        }
     });
  });*/
   
/*==========================================================================*/
  /*$('#form1').on('click', function(e){
     e.preventDefault();
     var category = $("#category1").val();
     var subcategory= $("#sub_cat").val();
    
     var hsn_code = $("#hsn_code").val();     
     var tax = $("#tax").val();
    if(category !='' && hsn_code !='' && tax !=''){
       $.ajax({
          url: 'bulk_hsn_update', 
          type: 'get',
          data: { "category":category, "subcategory":subcategory, "hsn_code":hsn_code, "tax":tax },
          success: function(data){
              //$('#all_items').html(data);
              alert('bulk HSN update successfully');
              $('.close').click();
          }
       });
    }
    else{
      alert('please select Category & Sub Category & Enter HSN code & Tax ');
    }
  });*/

});

   
</script> 
@endsection