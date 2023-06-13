@extends('layouts.dbf')
@section('content')

<div class="container">
  <div class="row">
    <div class="col-12">
      <label class="alert alert-success "  id="msg" style="display: none;"></label>
    </div>
    <div class="col-md-12">
      @if($message = Session::get('success'))
        <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <p>{{ $message }}</p>
        </div>
      @endif
    </div>
  </div>
    <div class="row">
        <div id="table_holder">
          <div class="bootstrap-table">
            {{-- <a type="button" href="{{route('items-quantity.index')}}" class="btn btn-primary">Update Items</a> --}}
            {{-- <div class="row col-md-12"> --}}

              <div class="col-6" style="float:left">
                <form action="{{route('search-items')}}" method="get">
                	<div>
                		<input type="radio" id="name" name="type" value="name" >
                		<label for="name" class="mb-10">Name</label>&nbsp
                		<input type="radio" id="item_number" name="type" value="item_number" checked="">
                		<label for="item_number">Barcode</label>
                	</div>
                  <input type="text" placeholder="Search for items or barcode ..." size=50 name="search_items">
                  <button type="submit" class="btn btn-primary btn-sm" name="search">Search</button>
                </form>
              </div>
              <br>

              @if(!empty($employee))
              <div class="col-2" style="float: right">
                <button class="btn btn-sm btn-primary modelRequest" data-shop="{{$employee->shop_id}}" id="stockRequestShow" style="float: right">Request Items</button>
              </div>
              @else
              <div class="col-2" style="float: right;">
                <form action="{{route('all-items-shop.export')}}" method="get">
                  <button class="btn btn-sm btn-primary"> Export Items</button>
                </form>
              </div>
              @endif
              <br><br>
            {{-- </div> --}}
            <div class="fixed-table-container" style="padding-bottom: 0px;">
              <table id="myTable" class="table table-hover table-striped ">
                <thead id="table-sticky-header">
                <tr>
                  {{-- Modal --}}
                  <div class="modal fade" id="reqModal" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Request Details</h4>
                          </div>
                          <div class="modal-body table-responsive" id="reqDetailTable" style="background: #ececec">
                            <p>XYZ</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    {{-- End --}}
                           <th>
                              <div class="th-inner sortable both desc"> &nbsp Item Number</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th>
                              <div class="th-inner sortable both desc">Item Names</div>
                              <!-- <div class="fht-cell"></div> -->
                           </th>
                           {{-- <th>
                              <div class="th-inner sortable both desc">Category</div>
                           </th>
                           <th>
                              <div class="th-inner sortable both desc">SubCategory</div>
                           </th> --}}
                           <th>
                              <div class="th-inner sortable both desc text-center">Price </div>
                              <!-- <div class="fht-cell"></div> -->
                           </th>
                           @foreach($shops as $shop)
                              
                              @if(in_array($shop->id, [1, 2, 5, 6, 7, 12]))
                              {{-- @if(in_array($shop->id, [1, 2, 5, 6, 12])) --}}
	                           <th>
	                                <div class="th-inner sortable both desc">{{$shop->name}}
	                                  <span style="display: none" id="{{$shop->id}}">
	                              </div>
	                           </th>
                              @endif
                           @endforeach
                        </tr>
                      </thead>
                      <tbody>
                      @php 

                        $count =1; 

                      @endphp
                       @foreach($items as $Item)          

                          <tr data-index="0" data-uniqueid="13158">
                            <td>{{$Item->item_number}}</td>
                            <td>{{$Item->name}}</td>
                             @if($Item->unit_price != 0.00)
                            <td>₹ {{ $Item->unit_price }}</td>
                            @else
                            <td>₹ {{ $Item->fixed_sp }}</td>
                            @endif
                            @foreach($Item->item_quantities as $item_quantity)
                              @if(in_array($item_quantity->location_id, [1, 2, 5, 6, 7, 12]))
                              {{-- @if(in_array($item_quantity->location_id, [1, 2, 5, 6, 12])) --}}
                                <td class="text-center">
                                  <table>
                                    <tr>
                                      <td>{{ $item_quantity->quantity }}</td>
                                      @if(!empty($employee))
                                      <td>
                                          @php
                                            $qty = $item_quantity->quantity;
                                          @endphp
<input type="number"  {{$item_quantity->location_id == $employee['shop']->id ? 'disabled' : '' }} {{$qty <= 0 ? 'disabled' : '' }} class="emp checkshop" name="itemcheck" min="0" style="width: 45px;" max="{{$qty}}" data-shop="{{$item_quantity->location_id}}" data-item="{{$Item->id}}" data-currentshop="{{$employee['shop']->id}}" >
                                      </td>
                                      @endif
                                    </tr>
                                  </table>
                                </td>
                              @endif
                            @endforeach
                            
                          </tr>
                          
                        @endforeach
                     
                      </tbody>
                    </table>

                </div>
                   {!! $items->appends(Request::all())->links()!!}
            </div>
          </div>
        </div>
   </div>
</div>

<script type="text/javascript">

   $(document).ready( function () {



    // $(document).on('click', '.pagination a',function(event)
    //   {
    //   event.preventDefault();
    //   alert('tyets');
    //   $('li').removeClass('active');
    //   $(this).parent('li').addClass('active');

    //   var myurl = $(this).attr('href');
    //   var page=$(this).attr('href').split('page=')[1];   

    //   window.location.href = url + '?' 'page='+page;
    //   });

    $('#myTable').DataTable({
        "dom": 'lBfrtip',
        buttons: [ { extend: 'copyHtml5' },
            { extend: 'excelHtml5' },
            { extend: 'print'},
            { extend: 'pdfHtml5'}
            ],
        searching: false,
        paging: false,
        info: false,
        "ordering": false
    });



     /*$("#requestBtn").on('click', function(){

      var shop = $(this).data('shop')

      

    });

   $("#requestBtn").click(function(){

    	var user = $(this).data('user')

    	//Get all seleted shop and item id's & Put it into in array
		var arr = [];

		/*$.each($("input[name='shopcheck']:checked"), function(){
			shop.push($(this).val());
		});

		$.each($(".checkshop:checked"), function(){
			shop.push($(this).data('shop'));
			item.push($(this).data('item'));
		});

		console.log(item)

		$.ajax({
			type:'POST',
			url: '/stock-request',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data:{'user':user, 'shop':shop, 'item':item},
			success:function(res){
			   //window.location.href = $('#exportone').attr('href');

			   console.log(res)

				$('#reqDetailTable').empty().html(res);
        		$('#reqModal').modal('show');
			}
		})
  });*/

    $('#stockRequestShow').click(function(){

      var shop = $(this).data('shop')

      $.ajax({
        type: "POST",
        url: '/stock-request/show',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:{'shop': shop},
        success:function(res){

          $('#reqDetailTable').empty().html(res)
          $('#reqModal').modal('show');

        }
      })
    })

    $('.checkshop').on('change', function(){

      var reqItemVal = $(this).val()
      var itemTotalQty = $(this).attr('max')

      if(parseInt(itemTotalQty) >= parseInt(reqItemVal)){
      	var item = {} ;


      	item['currentshop']	=	$(this).data('currentshop')
    		item['shops']		= $(this).data('shop')
    		item['id']  		= $(this).data('item')
    		item['qty']			= $(this).val()
  			

    		$.ajax({
    			method:'post',
    			url: '/stock-request',
    			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    			data:{'item':item},
    			success:function(data){

    			}
    		})
      }else{

        alert('Requested quantity must be low.')

        $(this).val('0')
      }

    })
});
</script>
<style type="text/css">
	div.dataTables_wrapper div.dataTables_filter input {
    	margin-right: 0.5em;
	}
</style>

@endsection