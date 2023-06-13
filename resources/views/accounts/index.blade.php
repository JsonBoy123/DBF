@extends('layouts.dbf')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-3">
			<input type="text" name="daterangepicker" value="" id="daterangepicker" class="form-control input-sm" style="width: 180px;">
		</div>
		<div class="col-md-2">
			<button type="button" id="filters" class="btn btn-primary btn-sm">Search</button>
		</div>
		<div class="col-md-7 " align="right" >
      <a href="{{route('account.repair-history')}}" class="btn btn-primary btn-sm">Monthly History</a>
    </div>
	</div>
	<hr>
  <div class="row">
    <div class="col-md-12">
      <label class="alert alert-success "  id="msg" style="display: none;"></label>
    </div>
    <div class="col-md-12">
      @if($message = Session::get('success'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
      @endif
    </div>
  </div>
    <div class="row">
        <div id="table_holder">
          <div class="bootstrap-table">
            <div class="fixed-table-container" style="padding-bottom: 0px;">
               <div class="fixed-table-header" style="display: none;">
                
               </div>
                <div class="table-body">
                  <div id="daily_table">
                  	<!-- <table id="myTable" class="table table-hover table-striped "> -->
                    <table>
                      <thead id="table-sticky-header">
                        <tr>
                           <th class="text-center" align="center" style="" >
                              <div class="th-inner sortable ">No</div>
                           </th>
                           <th class="text-center" style="" >
                              <div class="th-inner sortable">Barcode</div>
                           </th>
                           <th class="text-center" style="">
                              <div class="th-inner sortable">Item Name</div>
                           </th>
                           <th class="text-center" style="">
                              <div class="th-inner ">Model Number</div>
                           </th>
                           <th class="text-center" style="">
                              <div class="th-inner sortable">Quantity</div>
                           </th>
                           <th class="text-center" style="">
                              <div class="th-inner ">Repair Cost</div>
                           </th>
                           <th class="text-center" style="">
                              <div class="th-inner sortable ">Check</div>
                           </th>
                        </tr>
                      </thead>
                      <tbody>
                       @php $count =1; @endphp
                        @foreach ($items as $data)
                          <tr>
                            <td class="text-center" style="">{{$count++}}</td>
                            <td class="text-center" style="">{{$data->item->item_number}}</td>
                            <td class="text-center" style="">{{$data->item->name}}</td>
                            <td class="text-center" style="">{{$data->item->model}}</td>
                            <td class="text-center" style="">{{$data->qty}}</td>
                            <td class="text-center" style="">
                              {{$data->item->repair_cost}}</td>
                            <td class="text-center" style="">
                              @if($data->status == 0)
                              <input  class="bs-checkbox" type="checkbox" name="items" value="{{$data->id}}">
                              @else
                                <span style="color: green">Done</span>
                              @endif
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>  	
                  </div>
                    <br>
                    <button type="button" id="submit" class="btn btn-sm btn-primary" style="float: right;">Submit</button>
                    
              </div>
            </div>
{{-- Record Table End --}}


          </div>
        </div>
   </div>
</div>



<script type="text/javascript">
   
   $(document).ready( function () {
 
    $('#myTable').DataTable({
      dom: 'Bfrtip',
       buttons: [ { extend: 'copyHtml5' },
            { extend: 'excelHtml5' },
            { extend: 'print'},
            { extend: 'pdfHtml5'}
            ]
    });

    /*==================Form Submit=======================*/

    $('#submit').on('click', function(){
       //var checkBtn = $('#checkBtn').val();
       var checkBtn = [];
              $.each($("input[name='items']:checked"), function(){
                  checkBtn.push($(this).val());
              });
      if (checkBtn != '') {
      	$.ajax({
	         type: 'post',
	         url: "{{ route('account.repair-store') }}",
	         data: {'checkBtn':checkBtn},
	         headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	         success: function(data) {
	          var lastId = data;
	            window.location.href = "/account/repair-items/challan/"+lastId;
	        }
	      });
      }else{
      	alert("Item not checked............!!!")
      }
     });

    /*==================Form Submit=======================*/

    /*==========================Get Repaired Item=========================*/

	$('#filters').on('click', function(){
		var date = $('#daterangepicker').val()
		var fromDate = date.split('-')[0];
		var toDate = date.split('-')[1];
		alert(fromDate)

		//alert(type)
		$.ajax({
			headers: {
	        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    	},
			method:'POST',
			url:"{{ route('account.repaied-item-histoty') }}",
			data:{fromDate:fromDate,toDate:toDate},
			success:function(data){
				//console.log(data)
				$('#daily_table').html(data)
			}
		})
	})


	/*==========================Get Repaired Item=========================*/

});




$(document).ready( function () {
		var start = moment().subtract(29, 'days');
    	var end = moment();

    function cb(start, end) {
			        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			}
			$('#daterangepicker').daterangepicker(
				{
		        startDate: start,
		        endDate: end,
		        ranges: {
		           'Today': [moment(), moment()],
		           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		           'This Month': [moment().startOf('month'), moment().endOf('month')],
		           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		        },
		        
		}, cb);

 cb(start, end);
	});



</script>

@endsection