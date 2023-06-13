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
                         <option value="0">ALL LOCATIONS</option>
                         @if(!empty($shop))
                            @foreach($shop as $shops)
                                <option value="{{ $shops->id }}">{{ $shops->name }}</option>
                            @endforeach
                         @endif
                      </select>
                   </div>
                   <div class="form-group col-md-6">
	                 	<div class="form-group col-md-3 text-right" >
	                 		<br><h4> Items : </h4>
	                 	</div>
	                 	<div class="form-group col-md-3 text-left">
	                 		<br><h4 id="all_items"> 00 </h4>
	                   		<a href="{{ route('home') }}"> More details...</a>
	                   	</div>
                   </div>
                </div>
                <div class="row" style="margin-bottom:20px;">
                   <div class="col-md-12">
                     {{-- <a class="btn btn-md btn-info" id="get_all_items" href="#"> All Items</a> --}}
                      <button class="btn btn-md btn-info" style="width:90px;" id="get_all_items">All Items</button>
                      

                      <button class="btn btn-md btn-success" style="width:100px;" id="get_count">Get Count</button>
                   </div>
                </div>

                <div class="row" id="">
                   <div class="col-md-4">
                      <div class="form-group">
                         <select name="category" id="category" class="form-control">
                            <option value="">Select Category</option>
                            @if(!empty($get_cat))
                              @foreach($get_cat as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                              @endforeach
                            @endif
                         </select>
                      </div>
                   </div>
                   
                   <div class="col-md-4">
                      <div class="form-group">
                         <select name="category" id="sub_category1" class="form-control">
                         <select name="category" id="sub_category" class="form-control">
                            @if(!empty($sub_category))
                              @foreach($sub_category as $sub_cat)
                                <option value="{{ $sub_cat->id }}">{{ $sub_cat->category_name }}</option>
                              @endforeach
                            @endif
                         </select>
                      </div>
                   </div>


                   <div class="col-md-4">
                      <div class="form-group">
                         <select name="brand2" id="brand" class="form-control">
                            <option value="">Select Brand</option>
                            @if(!empty($get_brand))
                              @foreach($get_brand as $brands)
                                <option value="{{ $brands->id }}">{{ $brands->brand_name }}</option>
                              @endforeach
                            @endif
                         </select>
                      </div>
                   </div>
               </div>
                   
                <div class="row" id="extraMci" style="display:none">
                   <div class="col-md-3 col-md-offset-3">
                      <div class="form-group">
                         <select name="size2" id="size" class="form-control">
                            <option></option>
                <div class="row" id="extraMci2" style="display:none">
                   <div class="col-md-3 col-md-offset-3">
                      <div class="form-group">
                         <select name="size2" id="size2" class="form-control">
                            <option value="0">Select Size</option>
                         </select>
                      </div>
                   </div>
                   <div class="col-md-3">
                      <div class="form-group">
                         <select name="color2" id="color" class="form-control">
                            <option></option>
                         <select name="color2" id="color2" class="form-control">
                            <option value="0">Select Color</option>
                         </select>
                      </div>
                   </div>
                </div> 
                
            </form>
            <div id="table_area"></div>
         </span>
      </div>
   </div>
</div>


<script type="text/javascript">

$(document).ready(function(){         
   $('#get_all_items').on('click', function(e){
     e.preventDefault();
     var location_id = $('#location_id').val();
       $.ajax({
          url: '/get_all_items/'+location_id, 
          type: 'get',         
          success: function(data){
              //alert(data);
              $('#all_items').html(data);
          }
       });
   });
});

/*  category and subcategory select  */

$('#category').change(function(){
	var cat_id = $(this).children("option:selected").val();
	$.ajax({
		type: 'post',
		url: 'get_sub_cat',
		data: {'cat_id':cat_id},
    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success:function(res){
			if(res){
				$('#sub_category1').empty();
				$("#sub_category1").append('<option>Select sub category</option>');
				$.each(res,function(key,value){
					$('#sub_category1').append('<option value="'+value+'">'+key+'</option>');
				});
				if(cat_id == 2 || cat_id == 3 || cat_id == 4 || cat_id == 5 || cat_id == 6 ||cat_id == 7){
					$.ajax({
						type: 'get',
						url: 'get_size',
						data: {'cat_id':cat_id},
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						success:function(res){
							//console.log(res);
							if(res){
								$('#size').empty();
								$("#size").append('<option value="">Select size</option>');
								$.each(res,function(key,value){
									$('#size').append('<option value="'+value+'">'+key+'</option>');
								});
							}
						}
					});
					$.ajax({
						type: 'get',
						url: 'get_color',
						data: {'cat_id':cat_id},
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						success:function(res){
							//console.log(res);
							if(res){
								$('#color').empty();
								$("#color").append('<option value="">Select color</option>');
								$.each(res,function(key,value){
									$('#color').append('<option value="'+value+'">'+key+'</option>');
								});
							}
						}
					});

					$('#extraMci').show();
				}
				else
				{
					$('#extraMci').hide();
				}
			}
			else{
				$('#sub_category').empty();
			}
		}
	});
});

/*  category and subcategory select  */


$(document).ready(function(){         
   $('#get_count').on('click', function(e){
     e.preventDefault();
     //var location_id = $("#location_id").val();
     var category = $("#category").val();
     var sub_category1= $("#sub_category1").val();
     var brand = $("#brand").val();     
     var size = $("#size").val();
     var color = $("#color").val();

    if(category !='' && sub_category1 !='' && brand !=''){
     
       $.ajax({
          url: 'get_all_items_count', 
          type: 'post',
          data: { "category":category, "sub_category1":sub_category1, "brand":brand, "size":size, "color":color },
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function(data){
              $('#all_items').html(data);
          }
       });
   	}
   	else{
   		alert('please select Category , Sub Category & Brand at least')
   	}
   });
});


</script>


@endsection