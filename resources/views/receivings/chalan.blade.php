@extends('layouts.dbf')

@section('content')

<div class="container">
	<div class="row">
		<div class="print_hide pull-right">
		  <a href="javascript:void(0);" onclick="window.print()"><div class="btn btn-info btn-sm" ,="" id="show_print_button"><span class="glyphicon glyphicon-print">&nbsp;</span>Print</div></a>
		  <a href="{{route('show_list_of_item')}}" ><div class="btn btn-info btn-sm" id="show_list_button"><span class="glyphicon glyphicon-print">&nbsp;</span>Show Item List</div></a>
		</div>
{{-- @php dd($id); @endphp --}} 
		<div class="container">
			<div class="row">
			    <select class="pull-right">
				    <option value=""></option>
				    <option value="">ACCOUNTS COPY</option>
				    <option value="">PDI(Security) COPY</option>
				    <option value="">STORE COPY</option>
				    <option value="">DRIVER COPY</option>
			    </select>
			</div>
			<div class="row">
			    <span class="col-md-4">
			      <img id="image" src="http://localhost/live_pos/public/images/laxyo.png" alt="company_logo" width="160" height="60">
			    </span>
			    <span class="col-md-8 pull-right">
			      {{-- <p>Laxyo House, Plot No. 2, County park, MR-5, Mahalaxmi Nagar, Indore-10 (MP)</p> --}}
			      <p>{{$shop_address->address}}</p>
			      <p>Phone: +91-731-4043798, Mobile: 8815218210</p>
			    </span>
			</div>
		  	<div class="row">
			    <div class="col-md-12" style="font-size:1.5em; text-align:center">
			      <p>CHALLAN &nbsp;(NOT FOR SALE)</p>
			      <p>LAXYO ENERGY LTD. - GSTIN - 23AABCL3031E1Z9</p>
			    </div>
		  
			    <div class="col-md-12">
			      <table class="table table-bordered table-condensed small">
			        <thead>
			          <tr>
			            <th>CHALLAN NO.</th>
			            <th>STOCK TRANSFER ORDER NO.</th>
			            <th>CONSIGNOR (from)</th>
			            <th>CONSIGNEE (to)</th>
			            <th>PICKED BY</th>
			            <th>DISPATCH THROUGH</th>
			            <th>DATE</th>
			          </tr>
			        </thead>
			        <tbody>
			          <tr>
			            <td>{{$chalan_no}}</td>
			            <td></td>
			            <td><select>
			              <option value=""></option>
			              <option value="">LEL INDORE</option>
			              <option value="">DBF MAHALAXMI</option>
			              <option value="">DBF INDRAPRASTHA</option>
			              <option value="">DBF ANNAPURNA</option>
			              <option value="">DBF BAPAT</option>
			              <option value="">DBF SHOP114</option>
			              <option value="">DBF RS SHOP</option>
			              <option value="">DBF TESTING</option>
			              <option value="">DBF REPAIR</option>
			              <option value="">DBF DAMAGE</option>
			            </select></td>
			            <td><select>
			              <option value=""></option>
			              <option value="">LEL INDORE</option>
			              <option value="">DBF MAHALAXMI</option>
			              <option value="">DBF INDRAPRASTHA</option>
			              <option value="">DBF ANNAPURNA</option>
			              <option value="">DBF BAPAT</option>
			              <option value="">DBF SHOP114</option>
			              <option value="">DBF RS SHOP</option>
			              <option value="">DBF TESTING</option>
			              <option value="">DBF REPAIR</option>
			              <option value="">DBF DAMAGE</option>
			            </select></td>
			            <td><input style="border:none;" value="" type="text"></td>
			            <td><input style="border:none;" value="MP.43.C.1596" type="text"></td>
			            <td>{{$date}}</td>
			          </tr>
			        </tbody>
			      </table>  

			      <table class="table table-bordered table-condensed small">
			        <thead>
			          <tr>
			            <th>Sn.</th>
			            <th>Barcode</th>
			            <th>Name of goods</th>
			            <th>Category</th>
			            <th>Subcategory</th>
			            <th>Quantity</th>
			            <th>Rack Info</th>
			          </tr>
			        </thead>
			        <tbody>
			        	@php $count =1; @endphp
			        	@php $total = 0; @endphp
			           @foreach($receiving_item as $value)
			           <?php
			           		
			           		$total = $total + abs($value->quantity_purchased);
			           ?>
			            <tr>
			              	<td>{{$count++}}</td>
			              	<td>{{$value->item->item_number}}</td>
			              	<td>{{$value->item->name}}</td>
			              	<td>{{ $value->item->categoryName ? $value->item->categoryName->category_name : 'No Record' }}</td>
			              	<td>{{$value->item->subcategoryName ? $value->item->subcategoryName->sub_categories_name : 'No Record'}}</td>
			              	<td>{{abs($value->quantity_purchased)}}</td>
			              	<td>
			              		@php
			              			if($value->racks != null ){
				              			$rack_qtys = json_decode($value->racks);

				              			//dd(gettype($rack_qtys[0]));
				              			foreach($rack_qtys as $index){
				              				echo $index->rack_name.' - '.$index->quantity.'Qty&nbsp | ' ;
				              			}

			              			}
			              		@endphp
			              	</td>
			            </tr>
			            @endforeach
			            <tr>
			              <td><b>Total Quantity</b></td>
			              <td colspan="4"></td>
			              <td>{{$total}}</td>
			              <td></td>
			            </tr>
			            <tr>
			              <td><b>Comment</b></td>
			              <td colspan="6">{{$data->comment}}</td>
			            </tr>
			            <tr>
			              <td colspan="7"><br></td>
			            </tr>
			            <tr>
			              <td colspan="7"><br></td>
			            </tr>
			            <tr>
			              <td colspan="7"><br></td>
			            </tr>
			        </tbody>
			      </table>

			      <table class="table table-bordered">
			        <thead>
			          <tr class="text-center">
			            <th>PREPARED BY- ACCOUNTS</th>
			            <th>CHECKED BY- PDI(Security)</th>
			            <th>VERIFIED BY- STORE</th>
			            <th>TRANSPORTED BY- DRIVER</th>
			          </tr>
			        </thead>
			        <tbody>
			          <tr>
			            <td><br><img id="image" style="position:absolute; bottom:-10px; transform: rotate(-18deg)" src="http://localhost/live_pos/public/images/lel_stamp.png" alt="company_stamp" width="90" height="90"></td>
			            <td></td>
			            <td></td>
			            <td></td>
			          </tr>
			        </tbody>
			      </table>
			    </div>

			    <div class="col-md-12">
			      <p class="text-center small">(BEING THE GOODS TRANSFER FROM WAREHOUSE TO SHOP/SHOP TO WAREHOUSE HENCE NO COMMERCIAL VALUE)</p><br><br> 
			    </div>
		  	</div>
		</div>
	</div>
</div>

<div class="modal fade" id="itemrack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" >
          <h5 class="modal-title" id="exampleModalLabel">New Rack</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="bootstrap-dialog-body">
            <div class="bootstrap-dialog-message" id="item_table">

            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>

<script>
	$(document).on('click','#show_list_button',function(){
		$.ajax({
			method:'post',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url:'',
			success:function(data){
				$('#item_table').html(data)
				$('#itemrack').modal('show');

			}
		})
	})


</script>


@endsection