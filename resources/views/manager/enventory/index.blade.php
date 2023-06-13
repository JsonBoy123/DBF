@extends('layouts.dbf')

@section('content')

<div class="container">
<div class="row">

<div class="row">
	<div class="col-xs-3 mb-2" align="center">
	    <p>
	      @if($message = Session::get('success'))
	        <div class="alert alert-success">
	          <p>{{ $message }}</p>
	        </div>
	      @endif
	    </p>
   </div>
	<div class="bg-info" style="color:#fff;padding:10px;margin-bottom:20px;">
      <a style="color:#fff" href="http://newpos.dbfindia.com/manager"><h4 style="display:inline">Manager</h4>  </a>&gt;&gt; Inventory 
  </div>
	
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js">
  </script>
  
	<div class="container">
	  <ul class="nav nav-tabs" id="feedtab">
	    <li class="active"><a data-toggle="tab" href="#Category">Sheet Uploads</a></li>
	    <li><a data-toggle="tab" href="#Subcategory">Sheet Processed</a></li>
	  </ul>
	<div class="tab-content">

    {{-- =========================++++++++++++++++++=============================== --}}

	 <div id="Category" class="tab-pane fade in active">
      <div class="container" style="margin-bottom: 20px;">
      </div>

		  <div class="container">
			  <table id="myTable" class="table table-hover table-striped ">
            <thead id="table-sticky-header">
              <tr>
                 
                 <th class="" style="text-align: center;" data-field="people.person_id">
                    <div class="th-inner sortable both desc">Id</div>
                    
                 </th>
                 <th class="" style="text-align: center;" data-field="last_name">
                    <div class="th-inner sortable both">Sheet Name</div>
                    
                 </th>
                 <th class="" style="text-align: center;" data-field="first_name">
                    <div class="th-inner sortable both">Sheet Uploader</div>
                   
                 </th>
                 <th class="" style="text-align: center;" data-field="first_name">
                    <div class="th-inner sortable both">Sheet Status</div>
                   
                 </th>
                 <th class="" style="text-align: center;" data-field="phone_number">
                    <div class="th-inner sortable both">Created Date</div>
                   
                 </th>
                 <th class="" style="text-align: center;" data-field="phone_number">
                    <div class="th-inner sortable both">View	</div>
                    
                 </th>
              </tr>
            </thead>
            <tbody>
              @php $count =1; @endphp
             @foreach ($sheet as $value)
             @if($value->sheet_status == 0)
              <tr data-index="0" data-uniqueid="13158" style="color: blue">
             @elseif($value->sheet_status == 1)
              <tr data-index="0" data-uniqueid="13158" style="color: green">
             @elseif($value->sheet_status == 2)
              <tr data-index="0" data-uniqueid="13158" style="color: red">
             @endif
                  <td align="center">{{$value->id}}</td>
                  <td align="center">{{$value->name}}</td>
                  <td align="center">{{$value['uploader_name']->title}}</td>
                @if($value->sheet_status == 0)
                  <td align="center" style="font-size: 15px"><b> Pending </b></td>
                @elseif($value->sheet_status == 1)
             	    <td align="center" style="font-size: 15px"><b> Approved </b></td>
                @elseif($value->sheet_status == 2)
                  <td align="center" style="font-size: 15px"><b> Decline </b></td>
                @endif     
                <td align="center">{{$value->created_at}}</td>
                <td align="center" ><a href="{{ route('enventory.show',$value->id) }}" target="blank"><span class="fa fa-file-text"></span></a>
                </td>
                </tr>
              @endforeach
            </tbody> 
        </table>
	    </div>
    </div>


    {{-- ============================================================ --}}


    <div id="Subcategory" class="tab-pane fade" style="margin-bottom: 20px;">
        <div class="container" style="margin-bottom: 20px;">
      </div>

		  <div class="container">
        <table id="myTable" class="table table-hover table-striped ">
            <thead id="table-sticky-header">
              <tr>
                 
                 <th class="" style="text-align: center;" data-field="people.person_id">
                    <div class="th-inner sortable both desc">Id</div>
                    
                 </th>
                 <th class="" style="text-align: center;" data-field="last_name">
                    <div class="th-inner sortable both">Sheet Name</div>
                    
                 </th>
                 <th class="" style="text-align: center;" data-field="first_name">
                    <div class="th-inner sortable both">Sheet Uploader</div>
                   
                 </th>
                 <th class="" style="text-align: center;" data-field="first_name">
                    <div class="th-inner sortable both">Sheet Status</div>
                   
                 </th>
                 <th class="" style="text-align: center;" data-field="phone_number">
                    <div class="th-inner sortable both">Created Date</div>
                   
                 </th>
                 <th class="" style="text-align: center;" data-field="phone_number">
                    <div class="th-inner sortable both">View  </div>
                    
                 </th>
              </tr>
            </thead>
            <tbody>
              @php $count =1; @endphp
             @foreach ($app_sheet as $value)
              <tr data-index="0" data-uniqueid="13158" style="color: green">
                  <td align="center">{{$value->id}}</td>
                  <td align="center">{{$value->name}}</td>
                  <td align="center">{{$value['uploader_name']->title}}</td>
                  <td align="center" style="font-size: 15px"><b> Approved </b></td>
                <td align="center">{{$value->created_at}}</td>
                <td align="center" ><b><a href="{{ route('get_barcode',$value->id) }}" target="blank"><span class="fa fa-file-text"></span></a></b></td>
                </tr>
              @endforeach
            </tbody> 
        </table>
      </div>
    </div>

    
    {{-- ========================================================================= --}}


  </div>
</div>
	
</div>
<hr>
<div class="row">
	<div id="suggestion" class="text-center"></div>
	<div class="col-md-6 col-md-offset-3" id="mci_sublist">
		
	</div>
	<div class="col-md-3">
		<select id="cSwitch" class="form-control" style="display:none">
				<option value="26">ACCESSORIES</option>
				
		</select>
	</div>
</div>

<style type="text/css">
	.myImp{
		width: 100% !important;
    border: none !important;
    background: none !important;
  }
</style>

</div>
</div>


{{-- Datatable for export files.............. --}}
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
    $('#example1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );

} );
</script>

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<script>

 $(document).ready(function(){
    $(".reason-approve").click(function(){
    	
	    var id = this.id;
	    var text = $(this).data("value");
	    var name = $('.category_name1').val();
	    // var category_name = $(category_names1).val('.category_name');
	  	alert(name);
        //var reason;
  		var text = prompt("Please enter the value","");
	    if (!text){
	        return false;
	    }else {
			reason =  text;
			$('input[name="category_name"]').val(name);
		}
		
	});
	$("#approved").click(function(){
	    if (!confirm("Do you want to approve")){
	      return false;
	    }
	  });
});

   
$(document).ready( function () {
 
    $('#myTable').DataTable({
      dom: 'Bfrtip',
       buttons: [ { extend: 'copyHtml5' },
            { extend: 'excelHtml5' },
            { extend: 'print'},
            { extend: 'pdfHtml5'}
            ]
    });
});
</script>

@endsection
