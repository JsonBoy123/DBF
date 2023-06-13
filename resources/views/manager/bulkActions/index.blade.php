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
               &gt;&gt; Bulk Actions 
            </div>
            <form id="myForm">
                @csrf
                <div class="row" id="">
                   <div class="col-md-4">
                      <div class="form-group">
                         <select name="category" id="category" class="form-control">
                            <option value="">-- Select Report --</option>
                              <option value="Offer"> Bulk Offer </option>
                              <option value="Bulk_HSN"> Bulk HSN </option>
                              <option value="Bulk_Discount"> Bulk Discount </option>
                            {{-- @if(!empty($get_cat))
                              @foreach($get_cat as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                              @endforeach
                            @endif --}}
                         </select>
                      </div>
                   </div>
                   <div class="col-md-7 text-right">
                     <a class="btn btn-md btn-info" data-toggle="modal" id="#myModal" data-target="#myModal" title="New Item">Bulk HSN</a>
                     <a class="btn btn-md btn-info" data-toggle="modal" id="#myModal-2" data-target="#myModal-2" title="New Item">Bulk Discounts</a>
                     <a class="btn btn-md btn-info" data-toggle="modal" id="#myModal-4" data-target="#myModal-4" title="New Item">Create Offer</a>
                     <a class="btn btn-md btn-info" data-toggle="modal" id="#myModal-3" data-target="#myModal-3" title="New Item">Quick Discount</a>
                   		
                      {{-- <button class="btn btn-md btn-info" id="get_button">Bulk HSN</button>
                   		<button class="btn btn-md btn-info" id="get_button">Bulk Dicscounts</button>
                   		<button class="btn btn-md btn-info" id="get_button">Quick Discount</button> --}}
                   </div>
               </div>
            </form>
            <hr>
            <div id="table_area"></div>
         </span>
      </div>
   </div>
</div>

{{-- Model of Bulk HSN start --}}

<div id="myModal" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;">
                     <button class="close" data-dismiss="modal">×</button>
               </div>
               <div class="bootstrap-dialog-title" id="c0535119-0563-480e-a1ee-c9f1f55db5f3_title">Bulk HSN Update</div>
            </div>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
              <div class="bootstrap-dialog-message">
                <form id="excel_form" enctype="multipart/form-data" >
                  @csrf
                  <div class="modal-body">
                     <div class="bootstrap-dialog-body">
                        <div class="bootstrap-dialog-message">
                           <div>
                              <div class="errMsg alert-danger"></div>
                              <fieldset id="item_basic_info1">
                                 <div class="form-group col-md-12">
                                    <div class="col-md-8" style="margin-left: 70px">
                                       <select class="form-control input-sm" id="category1">
                                          <option value="">-- None --</option>
                                          @if(!empty($category))
                                             @foreach($category as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                             @endforeach
                                          @endif
                                       </select>
                                    </div>
                                 </div>

                                 <div class="form-group col-md-12">
                                    <div class="col-md-8" style="margin-left: 70px">
                                       <select class="form-control input-sm" id="sub_cat">
                                          <option value=''>-- None --</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="form-group col-md-12">     
                                    <div class="col-md-6">
                                       <input type="number" name="hsn_code" id="hsn_code" class="form-control input-sm" placeholder="HSN Code">
                                    </div>
                                    <div class="col-md-6">
                                       <input type="number" name="tax" id="tax" class="form-control input-sm" placeholder="TAX">
                                    </div>
                                 </div>
                              </fieldset>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer" style="display: block;">
                     <div class="bootstrap-dialog-footer">
                        <div class="bootstrap-dialog-footer-buttons" style="text-align: center;">
                           <button class="btn btn-success" id="form1">Proceed</button>
                        </div>
                     </div>
                  </div>
               </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

{{-- Model of Bulk HSN  end --}}

{{-- Model of Bulk HSN discount start --}}


<div id="myModal-2" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;">
                     <button class="close" data-dismiss="modal">×</button>
               </div>
               <div class="bootstrap-dialog-title" id="c0535119-0563-480e-a1ee-c9f1f55db5f3_title">Bulk Discount Update</div>
            </div>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
              <div class="bootstrap-dialog-message">
                <form id="excel_form" enctype="multipart/form-data" >
                  @csrf
                  <div class="modal-body">
                     <div class="bootstrap-dialog-body">
                        <div class="bootstrap-dialog-message">
                           <div>
                              <div class="errMsg alert-danger"></div>
                              <fieldset id="item_basic_info1">
                              <div class="form-group col-md-12"> 
                                  <div class="col-md-6">
                                    <input type="radio" name="radio" value="1" id="radio_cat"> On Category<br>    
                                     <select class="form-control input-sm" name="sheet_uploader" id="bdu_cat">
                                          <option value="">-- None --</option>
                                          @if(!empty($category))
                                             @foreach($category as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                             @endforeach
                                          @endif
                                       </select>
                                  </div>
                                  <div class="col-md-6">
                                     <input type="radio" name="radio" value="2" id="radio_cat"> On Brand<br>
                                     <select class="form-control input-sm" name="sheet_uploader" id="bdu_brand">
                                          <option value="">-- None --</option>
                                          @if(!empty($brand))
                                             @foreach($brand as $brands)
                                                <option value="{{ $brands->id }}">{{ $brands->brand_name }}</option>
                                             @endforeach
                                          @endif
                                       </select>
                                  </div>
                               </div> 

                               <div class="form-group col-md-12">
                                  <div class="col-md-8" style="margin-left: 70px; padding-top: 20px">
                                     <input type="radio" name="radio" value="3" id="radio_cat"> On Sub Category<br>
                                     <select class="form-control input-sm" name="sheet_uploader" id="category2">
                                          <option value="">-- None --</option>
                                          @if(!empty($category))
                                             @foreach($category as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                             @endforeach
                                          @endif
                                       </select>
                                  </div>
                               </div>
                               <div class="form-group col-md-12">
                                <div class="col-md-8" style="margin-left: 70px">
                                     <select name="sheet_type" class="form-control input-sm" id="sub_category">
                                          <option value="">-- None --</option>
                                       </select>
                                  </div>
                               </div>
                               <div class="form-group col-md-12">     
                                  <div class="col-md-6">
                                    <label> Type </label>
                                     <select class="form-control input-sm" id="bdu_type">
                                          <option selected="">-- None --</option>
                                          <option value="retail">Retails</option>
                                          <option value="wholesale">Wholesale</option>
                                          <option value="franchise">Franchise</option>
                                          <option value="special">Special Approval</option>
                                       </select>
                                  </div>
                                  <div class="col-md-6">
                                    <label>Discount Value </label>
                                     <input type="number" id="bdu_value" class="form-control input-sm" placeholder="Value">
                                  </div>
                               </div>
                              </fieldset>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer" style="display: block;">
                     <div class="bootstrap-dialog-footer">
                        <div class="bootstrap-dialog-footer-buttons" style="text-align: center;">
                           <button class="btn btn-success" id="form2">Proceed</button>
                        </div>
                     </div>
                  </div>
               </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


{{-- Model of Bulk HSN discount end --}}

{{-- Model of Bulk HSN Quick discount start --}}


<div id="myModal-3" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;">
                     <button class="close" data-dismiss="modal">×</button>
               </div>
               <div class="bootstrap-dialog-title" id="c0535119-0563-480e-a1ee-c9f1f55db5f3_title">Bulk HSN Update</div>
            </div>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
              <div class="bootstrap-dialog-message">
                <form id="excel_form" enctype="multipart/form-data" >
                  @csrf
                  <div class="modal-body">
                     <div class="bootstrap-dialog-body">
                        <div class="bootstrap-dialog-message">
                           <div>
                              <!-- <ul id="error_message_box" class="error_message_box">dddd</ul> -->
                              <div class="errMsg alert-danger"></div>
                              <fieldset id="item_basic_info1">
                                 <div class="form-group col-md-12"> 
                                    <div class="col-md-12">
                                       <input type="file" name="tax" class="form-control input-sm">
                                    </div>
                                 </div>
                              </fieldset>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer" style="display: block;">
                     <div class="bootstrap-dialog-footer">
                        <div class="bootstrap-dialog-footer-buttons" style="text-align: center;">
                           <button class="btn btn-success" type="submit">Proceed</button>
                        </div>
                     </div>
                  </div>
               </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


{{-- Model of Bulk HSN Quick discount end --}}


{{-- Model of Bulk Offer create start --}}


<div id="myModal-4" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;">
                     <button class="close" data-dismiss="modal">×</button>
               </div>
               <div class="bootstrap-dialog-title" id="c0535119-0563-480e-a1ee-c9f1f55db5f3_title">Bulk Offer Create</div>
            </div>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
              <div class="bootstrap-dialog-message">
                <form id="excel_form" enctype="multipart/form-data" >
                  @csrf
                  <div class="modal-body">
                     <div class="bootstrap-dialog-body">
                        <div class="bootstrap-dialog-message">
                           <div>
                              <div class="errMsg alert-danger"></div>
                              <fieldset id="item_basic_info1">
                              <div class="form-group col-md-12"> 
                                  <div class="col-md-12">
                                    <div class="col-md-12">
                                      <label>Select Offer</label>
                                      <select class="form-control input-sm" name="offer_type" id="offer_type">
                                          <option selected="" value=0>-- None --</option>
                                          <option value="1">Buy 1 Get 1 Free</option>
                                          <option value="2">Buy 1 Get 2 Free</option>
                                          <option value="3">Buy 1 Get 3 Free</option>
                                          <option value="4">Buy 1 Get 4 Free</option>
                                          <option value="5">Buy 1 Get 5 Free</option>
                                          <option value="6">Buy 1 Get 6 Free</option>
                                          <option value="7">Buy 1 Get 7 Free</option>
                                          <option value="8">Buy 1 Get 8 Free</option>
                                          <option value="9">Buy 1 Get 9 Free</option>
                                      </select>
                                       <br>
                                       <label>Select Category</label> 
                                      <select class="form-control input-sm" name="sheet_uploader" id="category3">
                                           <option value="">-- None --</option>
                                           @if(!empty($category))
                                              @foreach($category as $cat)
                                                 <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                              @endforeach
                                           @endif
                                      </select>
                                    </div>                                    
                                    <div class="col-md-12 mt-3">
                                        <label>Select Sub Category</label>
                                       <select name="sheet_type" class="form-control input-sm" id="s_cat">
                                          <option value="">-- None --</option>
                                       </select>
                                    </div> 
                                  </div>                         
                                  
                               </div> 
                              </fieldset>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer" style="display: block;">
                     <div class="bootstrap-dialog-footer">
                        <div class="bootstrap-dialog-footer-buttons" style="text-align: center;">
                           <button class="btn btn-success" id="form3">Proceed</button>
                        </div>
                     </div>
                  </div>
               </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div id="show">
  
</div>
{{-- Model of Bulk offer create end --}}


<script type="text/javascript">

function offerDelete(id)
{
  $(document).ready(function(){
     var offer_id = id;
      alert(offer_id);
      $.ajax({
        url: 'bulk_offer_delete', 
        type: 'post',
        data: { "offer_id":offer_id },
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(data){
            alert('Offer deleted successfully');
            //$('.close').click();
            location.reload()
        }
      });
  });
}

$(document).ready(function(){

  /*==========================================================================*/
  $('#category').change(function(){
    var cat_id = $(this).children("option:selected").val();
    $.ajax({
      type: 'post',
      url: 'get_bulk_data',
      data: {'cat_id':cat_id},
      headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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

/*===========================================================================*/
  $('#category1').on('change', function(){
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
  $('#category2').change(function(){
      var cat_id = $(this).children("option:selected").val();
      $.ajax({
        type: 'post',
        url: 'get_bulk_sub_cat',
        data: {'cat_id':cat_id},
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
  });
   
/*==========================================================================*/

$('#category3').change(function(){
      var cat_id = $(this).children("option:selected").val();
      $.ajax({
        type: 'post',
        url: 'get_bulk_sub_cat',
        data: {'cat_id':cat_id},
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(res){
        //console.log(res);
          if(res){
            $('#s_cat').empty();
            $("#s_cat").append("<option value=''>-- None --</option>");
            $.each(res,function(key,value){
              $('#s_cat').append('<option value="'+value+'">'+key+'</option>');
            });
          }
        }
     });
  });

/*==========================================================================*/

$('#category4').change(function(){
      var cat_id = $(this).children("option:selected").val();
      $.ajax({
        type: 'post',
        url: 'get_bulk_sub_cat',
        data: {'cat_id':cat_id},
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(res){
        //console.log(res);
          if(res){
            $('#s_category').empty();
            $("#s_category").append("<option value=''>-- None --</option>");
            $.each(res,function(key,value){
              $('#s_category').append('<option value="'+value+'">'+key+'</option>');
            });
          }
        }
     });
  });
   
/*==========================================================================*/
  $('#form1').on('click', function(e){
     e.preventDefault();
     var category = $("#category1").val();
     var subcategory= $("#sub_cat").val();
    
     var hsn_code = $("#hsn_code").val();     
     var tax = $("#tax").val();
    if(category !='' && hsn_code !='' && tax !=''){
       $.ajax({
          url: 'bulk_hsn_update', 
          type: 'post',
          data: { "category":category, "subcategory":subcategory, "hsn_code":hsn_code, "tax":tax },
          headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
  });
/*==========================================================================*/

$('#form2').on('click', function(e){
     e.preventDefault();
     var radio_btn_id = $('input[name="radio"]:checked').val();
     //alert(radio_btn_id);
     if(radio_btn_id == 1){
        var radio_btn_id = '1';     
        var bdu_cat  = $("#bdu_cat").val();
        var bdu_type = $("#bdu_type").val();
        var bdu_value = $("#bdu_value").val();
         $.ajax({
            url: 'bulk_discount_update', 
            type: 'post',
            data: { "radio_btn_id":radio_btn_id, "bdu_cat":bdu_cat, "bdu_type":bdu_type, "bdu_value":bdu_value },
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data){
                //$('#all_items').html(data);
                alert('bulk discount update successfully');
                $('.close').click();
            }
         });
     }
     else if(radio_btn_id == 2){
      //alert(radio_btn_id);
        var radio_btn_id = '2';      
        var bdu_brand = $("#bdu_brand").val();
        var bdu_type = $("#bdu_type").val();
        var bdu_value = $("#bdu_value").val();
         $.ajax({
            url: 'bulk_discount_update', 
            type: 'post',
            data: { "radio_btn_id":radio_btn_id, "bdu_brand":bdu_brand, "bdu_type":bdu_type, "bdu_value":bdu_value },
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data){
                //$('#all_items').html(data);
                alert('bulk discount update successfully');
                $('.close').click();
            }
         });
     }
     else if(radio_btn_id == 3){
      //alert(radio_btn_id);
        var radio_btn_id = '3';  
        var bdu_cat  = $("#category2").val();
        var bdu_sub_cat = $("#sub_category").val();     
        var bdu_type = $("#bdu_type").val();
        var bdu_value = $("#bdu_value").val();
         $.ajax({
            url: 'bulk_discount_update', 
            type: 'post',
            data: { "radio_btn_id":radio_btn_id, "bdu_cat":bdu_cat, "bdu_sub_cat":bdu_sub_cat, "bdu_type":bdu_type, "bdu_value":bdu_value },
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data){
                //$('#all_items').html(data);
                alert('bulk discount update successfully');
                $('.close').click();
            }
         });
     }
     else{
        alert('please select any one of Category, Sub Category Or Brand');
     }
  });
   
/*================================================================================*/

   $('#form3').on('click', function(e){
     e.preventDefault();
     //var radio_btn_id = $('input[name="radio"]:checked').val();
     var offer_sub_cat  = $("#s_cat").val();
     var offer_cat  = $("#category3").val();
     var offer_type = $("#offer_type").val();
     console.log(offer_type, offer_cat)
      if(offer_type !=0)
      { 

         if(offer_cat !='')
         {
            //alert("okay");
            $.ajax({
               url: 'bulk_offer_create', 
               type: 'post',
               data: { "offer_type":offer_type, "offer_sub_cat":offer_sub_cat,"offer_cat":offer_cat},
               headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               success: function(data){
                //$('#show').html(data)
                   //$('#all_items').html(data);
                   alert('bulk Offer created successfully');
                   $('.close').click();
               }
            });
         }else{
            alert('please select Category.......');
         }
         
      }
      else{
        alert('please select any one offer at least');
      }
  });



});

   
</script> 
@endsection