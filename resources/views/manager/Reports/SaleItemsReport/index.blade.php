@extends('layouts.dbf')

@section('content')

<div class="container">
	<div class="row">
    <form >
  		<div class="col-md-3">
          <input id="datePicker" class="form-control" placeholder="Select Date" /><span id="inlineDate"></span>
  		</div>
      <div class="col-md-3">
          <select id="categoryOption" name="category" class="form-control">
            <option value="">Select Category</option>
        </select>
      </div>
      <div class="col-md-3">
          <select id="taxRatesOption" name="taxRate" class="form-control">
            <option value="">Select GST Rate</option>
            <option value="5">5 %</option>
            <option value="8">8 %</option>
            <option value="9">9 %</option>
            <option value="12">12 %</option>
            <option value="18">18 %</option>
            <option value="28">28 %</option>
        </select>
      </div>
  		<div class="col-md-2">
  			<button type="button" id="searchItemsBtn" class="btn btn-primary btn-sm">Search</button>
  		</div>
    </form>
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
        <div class="fixed-table-toolbar" id="daily_sales">
          <table class="table table-bordered dataTables_wrapper" id="dailyReport">
            <thead class="thead-dark">
              <tr>
                <td class="text-center"><b>POS</b></td>
                <td class="text-center"><b>CUSTOMER</b></td>
                <td class="text-center" style="display: none;" ><b>Contact No.</b></td>
                <td class="text-center"><b>&nbsp TYPE &nbsp</b></td>
                <td class="text-center"><b>TENDERED AMT.</b></td>
                <td class="text-center"><b>DISCOUNT</b></td>
                <td class="text-center"><b>PAID &nbsp</b></td>
                <td class="text-center"><b>DUE &nbsp</b></td>
                <td class="text-center"><b>REF. NO</b></td>
                <td class="text-center"><b>INVOICE NO.</b></td>
                <td class="text-center"><b>DATE</b></td>
               
              </tr>
            </thead>
            <tbody>
              
              {{-- <tr>
                <td class="text-center"></td> 
              <td ></td>
              <td style="display: none;">  </td>
              <td class="text-center"><br></td>  
              <td class="text-center">₹&nbsp;</td>

              <td class="text-center"></td>

             
              <td class="text-center"></td> 
              <td class="text-center"></td>
              
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
            </tr> --}}
           
            </tbody>
          </table><br>

        </div>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<script type="text/javascript">   
  $(document).ready( function () {

 
    $('#dailyReport').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'pdfHtml5'
          ],
          //order:[[0, 'desc']]
      } );

  });

  $('#datePicker').datepicker();

  $(document).on('change', '#datePicker', function(){

    var date = $(this).val()
    $('#categoryOption').empty();
    $('#categoryOption').append($('<option value="">Select Category</option>'));

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      method: 'POST',
      url: '{{route('get-categories')}}',
      data: {date:date},
      success:function(data){
        $.each(data, function (key, value) {

          $('#categoryOption').append(
            $('<option></option>').val(key).html(value));
        });

      }
    })
  });
  
  $(document).on('click','#searchItemsBtn',function(){
  
    var date    = $('#datePicker').val()
    var categ   = $('#categoryOption').val()
    var tax     = $('#taxRatesOption').val()

    $.ajax({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      method:'POST',
      url:'{{route('sale-items-report.search')}}',
      data:{date:date, categ:categ, tax:tax},
      success:function(data){
        $('#daily_sales').html(data)
      }
    })
  })
</script>

@endsection