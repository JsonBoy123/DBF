@extends('layouts.dbf')

@section('content')
<div class="container">
	<div class="row">
		<div id="register_wrapper">	

			<form action="http://newpos.dbfindia.com/receivings/change_mode" id="mode_form" class="form-horizontal panel panel-default" method="post" accept-charset="utf-8">
		        <input type="hidden" name="csrf_ospos_v3" value="c53c8c62784376573ff6285fc2162f18">
				
				<div class="panel-body form-group">
					<ul>
						<li class="pull-left first_li">
							<label for="item" ,="" class="control-label">
															Find or Scan Item									
							</label>
						</li>
						<li class="pull-left">
						
						<input type="text" name="item" value="" placeholder="Start typing Item Name or scan Barcode..." id="item" class="form-control input-sm ui-autocomplete-input" size="50" tabindex="1" autocomplete="off">
						 <span class="ui-helper-hidden-accessible" role="status"></span>
                            <div id="itemList"></div>
						</li>
						<li class="pull-right" style="font-weight:bold; font-size:1.2em">
                            <a href="{{route('issue_items.store')}}" class="btn btn-primary">Generate List</a>
						</li>
					</ul>
				</div>
			</form>
			<table class="sales_table_100" id="register">
				<thead>
					<tr>						
						<th >Delete</th>
                        <th >Barcode</th>
						<th >Item Name</th>						
						<th >Qty.</th>					
					</tr>
				</thead>
				<tbody>
                    <?php $data = session('item_list') != null ? session('item_list') :array();  ?>
                    @if($data !=null)
                    @foreach($data as $key => $Data)
                       <tr>
                          <td><a href="{{route('issue_items.destroy',$key)}}" class="fa fa-trash text-danger"></a></td>
                          <td >{{$Data['item_nummber']}}</td>
                          <td >{{$Data['item_name']}}</td>
                          <td ><input id="add_quantity" data-id='{{$Data['item_id']}}' type="number" value="{{$Data['quantity']}}" ></td>
                       </tr>
                    @endforeach                       
                    @endif    
                </tbody>
			</table>
		</div>
	</div>
	
</div>
<script>
   $(document).ready(function() {

    var item_qty = 0;

    $('input[name^="qty"]').each(function() {
                    item_qty = item_qty + parseInt(($(this).val()));
                });

        $('.total_qty').text(item_qty)

	  $('#item').keyup(function() {
        var query = $(this).val();
        if (query != '') {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('get-receiving-item') }}",
                method: "POST",
                data: {
                    query: query,
                    _token: _token
                },
                success: function(data) {
                    $('#itemList').fadeIn();
                    $('#itemList').html(data);
                }
            });
        } else {
            $('#itemList').fadeOut();
        }
    });

	  $(document).on('click', '#selectLI', function() {
        // alert('gdfgdfgdfgfdfdgdfgd');
        $('#item').val($(this).text());
        $('#itemList').fadeOut();
        var value   = $('#item').val();
        var res     = value.split("|");
        var final   = res[1];
        var item    = 'item';
        if (final != '') {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('issue_items.itemInSession') }}",
                method: "POST",
                data: {
                    item_name: final,
                    item: item,
                    _token: _token
                },
                success: function(data) {
                	console.log(data)
                    // window.location.reload();
                }
            });
        }
    });
    $('#item').focus();


   $(document).on('change','#add_quantity',function(){
    var id = $(this).attr('data-id')
    var qty = $(this).val()
    alert(qty)

    $.ajax({
        method:'get',
        url:'/issue_items/add_qty/'+id+'/'+qty,
        success:function(data){
            //window.location.reload();
        }

    })

   })


});
</script>
@endsection('content')