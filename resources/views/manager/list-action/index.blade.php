@extends('layouts.dbf')

@section('content')
<body>
	<div class="wrapper">
		<div class="topbar">
			<div class="container">
				<div class="navbar-left">
					<div id="liveclock">111/05/2020 06:22:32 PM</div>
				</div>

				<div class="navbar-right" style="margin:0">
										DBF Main Panel					  |   
					<a href="http://newpos.dbfindia.com/home/logout">Logout</a>					
				</div>

				<div class="navbar-center" style="text-align:center">
					<strong>DBF</strong>
				</div>
			</div>
		</div>

		<div class="navbar navbar-default" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
			
					<a class="navbar-brand hidden-sm" href="http://newpos.dbfindia.com/">
						<img src="http://newpos.dbfindia.com//images/dbflogo.png" width="75" height="45">
					</a>
				</div>

				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li class="active">
						<a href="http://newpos.dbfindia.com/employees" title="Employees" class="menu-icon">
						<img id="menuicon_employees" src="http://newpos.dbfindia.com/images/menubar/employees.png" alt="Module Icon" border="0"><br>Employees</a>
					</li>
					<li class="">
						<a href="http://newpos.dbfindia.com/messages" title="Messages" class="menu-icon">
						<img id="menuicon_messages" src="http://newpos.dbfindia.com/images/menubar/messages.png" alt="Module Icon" border="0"><br>Messages								</a>
					</li>
					<li class="">
						<a href="http://newpos.dbfindia.com/config" title="Configuration" class="menu-icon">
						<img id="menuicon_config" src="http://newpos.dbfindia.com/images/menubar/config.png" alt="Module Icon" border="0"><br>
						Configuration</a>
					</li>
					<li class="">
						<a href="http://newpos.dbfindia.com/offers" title="Offers" class="menu-icon">
						<img id="menuicon_offers" src="http://newpos.dbfindia.com/images/menubar/offers.png" alt="Module Icon" border="0"><br>
						Offers</a>
					</li>
					<li class="">
						<a href="http://newpos.dbfindia.com/office" title="Office" class="menu-icon">
						<img id="menuicon_office" src="http://newpos.dbfindia.com/images/menubar/office.png" alt="Module Icon" border="0"><br>
						Office</a>
					</li>
				
				+</ul>
				</div>
			</div>
		</div>
				<div class="container">
		<div class="row">
  }

<div class="container">
<div class="row">

<div class="row">
  <span class="col-md-12">
  <div class="bg-info" style="color:#fff;padding:10px;margin-bottom:20px;">
      <a style="color:#fff" href="http://newpos.dbfindia.com/manager"><h4 style="display:inline">Manager</h4>  </a>&gt;&gt; List Actions 
  </div>

<div class="row">
  <div class="form-group col-md-6">
    <label>Locations</label>
    <select class="form-control" id="location_id">
	    <option value="all">ALL LOCATIONS</option>
      {{$shop}}
	    @foreach ($shop as $value) 
	 
	    <option value="{{$value->shop_owner_id}}">{{ $value->name }}</option>

	     @endforeach
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
        <?php foreach ($MciCategory as $value) { ?>
	 
	    <option value="{{$value->id}}">{{$value->category_name}}</option>
	    
	    <?php } ?>
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
        <?php foreach ($Brand as $value) { ?>
	 
	    <option value="{{$value->id}}">{{$value->brand_name}}</option>
	    
	    <?php } ?>
       </select>
    </div>
  </div>
</div>

<div class="row" id="extraMci2" style="display:none">
  <div class="col-md-3 col-md-offset-3">
    <div class="form-group">
      <select name="size2" id="size2" class="form-control">
        <option value="">Select Size</option>
         <?php foreach ($Size as $value) { ?>
	 
	    <option value="{{$value->id}}">{{$value->size_name}}</option>
	    
	    <?php } ?>
       </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <select name="color2" id="color2" class="form-control">
        <option value="">Select Color</option>
    	<?php foreach ($Color as $value) { ?>
	 
	    <option value="{{$value->id}}">{{$value->color_name}}</option>
	    
	    <?php } ?>
    </select>
    </div>
  </div>
</div>
<div class="row" style="margin-bottom:20px;">
  <div class="col-md-12 text-center  ">
    <button class="btn btn-md btn-info" style="width:70px;" id="get_button">Get</button>
  </div>
</div>
<div id="table_area"></div>


<script src="jquery-3.5.1.min.js"></script>
<script>
$(document).ready( function () {
  $('#report_type').on('change',function(){
      var level1 =$(this).val();
      if(level1 == "type_1" || level1 == '') {
        $("#table_area").html('');
        $("#category2 option:selected").prop('selected' , false);
        $("#subcategory2 option:selected").prop('selected' , false);
        $('#subcategory2').html('');
      }
  });
 
  $('#category2').on('change',function(){
      var level1 = $(this).val();
      var wearables = ["MEN'S CLOTHING", "WOMEN'S CLOTHING", "KID'S CLOTHING", "MEN'S FOOTWEAR", "WOMEN'S FOOTWEAR", "KID'S FOOTWEAR"];
      $('#extraMci2').toggle(wearables.includes(level1));
     
      if(level1){
      	//alert(level1)
        // $.post('list-action/', {'category': level1}, function(data) {
        //   $('#subcategory2').html(data);
        // }); 

        $.ajax({
               type:'POST',
               url:'get-sub-category/',
               data: {
		        "_token": "{{ csrf_token() }}",
		        "category":level1
		        },
                success:function(data) {
                  $('#subcategory2').html(data);
               }
            });        
      }
      if(level1==""){
         $.ajax({
               type:'POST',
               url:'get-sub-category/',
               data: {
		        "_token": "{{ csrf_token() }}",
		        "category":level1
		        },
                success:function(data) {
                  $('#subcategory2').html(data);
               }
            });   
      }
  });

  $('#report_type').on('change',function(){
      if ( this.value == 'type_2')
      {
        $("#extraMci21").show();
      }
      else
      {
        $("#extraMci21").hide();
        $("#extraMci2").hide();
      }
  });
    
  $('#get_button').on('click',function(){
  	// alert()
      var selected_location = $('#location_id').val(); 
      var report_type = $('#report_type').val();
      var category = $('#category2').val();
      var wearables = ["MEN'S CLOTHING", "WOMEN'S CLOTHING", "KID'S CLOTHING", "MEN'S FOOTWEAR", "WOMEN'S FOOTWEAR", "KID'S FOOTWEAR"];
      if(jQuery.inArray(category, wearables) != -1){
          var mci = {
            'category': $('#category2').val(),
            'subcategory': $('#subcategory2').val(),
            'brand': $('#brand2').val(),
            'size': $('#size2').val(),
            'color': $('#color2').val(),
            };
      }else{
          var mci = {
          'category': $('#category2').val(),
          'subcategory': $('#subcategory2').val(),
          'brand': $('#brand2').val()
          };
      }
      
      if(selected_location == ''){

      }
      else{
          if(report_type =='type_1' ){
            if(selected_location !='all'){
              location.href = 'export-all-items/'+selected_location;
            }
            else {
              location.href = 'export-all-items/'+selected_location;
            }
            }
          else if(category !='' && report_type =='type_2' && mci !=''){

            $('#table_area').html("<p class= 'text-muted' style='text-align:center; font-size:22px;'> Loading... </p>");
                var category = $('#category2').val();
                var subcategory = $('#subcategory2').val();
                var brand = $('#brand2').val();
                // alert(brand);
                
                // if (brand =='') {
                // 	alert('Please select brand');
                // }
                var size = $('#size2').val();
                var color = $('#color2').val();
                var filterData = {
                  'category': category,
                  'subcategory': subcategory,
                  'brand': brand,
                  'custom2': size,
                  'custom3': color
                };

                // alert(brand)
                 $.ajax({
		               type:'POST',
		               url:'get-all-data/',
		               data: {
				        "_token": "{{ csrf_token() }}",
				        "filterData":filterData,
				        "category":category,
				        "subcategory":subcategory,
				        "brand":brand,
				        },
				        
		                success:function(data) {
		                  // $('#subcategory2').html(data);
							$('#table_area').html(data);
		          
		               }
		            }); 
                // $.post('http://newpos.dbfindia.com/manager/list_filtered_items/'+selected_location, {'filter': filterData}, 
                // function(data) {
                // $('#table_area').html(data);
                //     $('#list').DataTable({
                //         "scrollX": true,
                //         dom: 'Bfrtip',
                //         buttons: [
                //           'copy', 'csv', 'excel', 'pdf', 'print'
                //         ]
                //     });
                // });
          }
          else {
            swal({
						title: "",
						text: 'Select Filter',
						icon: "error",
					});
          }
      } 
  });
});
</script>

</span>
</div>
</div>
</div>
</body>
@endsection
