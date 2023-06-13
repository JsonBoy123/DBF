<table class="table table-bordered dataTables_wrapper" id="dailyReport">
	<thead class="thead-dark">
		<tr>
		<td class="text-center"><b>POS</b></td>
		<td class="text-center"><b>&nbsp ITEM &nbsp</b></td>
		<td class="text-center"><b>BARCODE</b></td>
		<td class="text-center"><b>PRICE &nbsp</b></td>
		<td class="text-center"><b>QTY</b></td>
		<td class="text-center"><b>Tax</b></td>
		<td class="text-center"><b>DISC %</b></td>
		<td class="text-center"><b>DATE</b></td>

		</tr>
	</thead>
	<tbody>
		@php
			$i			 = 1;
			$total_qty	 = 0;
			$total_price = 0;
		@endphp
		@foreach($items as $item)
			<tr>
				<td class="text-center" class="sale_id" id="sale_id[{{$i}}]">{{$item->sale_id}}</td>
				<td class="text-center" class="desc" id="item[{{$i}}]" style="resize: none; height: 20px;width: 300px;">{{$item->description}}</td>
				<td class="text-center" class="item_number" id="item_number[{{$i}}]">{{$item['item']->item_number}}</td>
				@php $itemPrice = $item->fixed_selling_price == '0.00' ? $item->item_unit_price : $item->fixed_selling_price @endphp
				<td class="text-center" class="item_price" id="item_price[{{$i}}]">{{$itemPrice}}</td>
				<td class="text-center" class="qty" id="item_qty[{{$i}}]">{{$item->quantity_purchased}}</td>
				<td class="text-center" class="gst" id="gst[{{$i}}]">{{$item->taxe_rate}} %</td>
				<td class="text-center" class="disc" id="disc[{{$i}}]">{{$item->discount_percent}}</td>
				<td class="text-center" class="date" id="date[{{$i}}]">{{date('Y-m-d', strtotime($item->created_at))}}</td>
				</td>
			</tr>
			@php
				$i++;
				$total_qty	 += $item->quantity_purchased;
				$total_price += $item->quantity_purchased * $itemPrice;
			@endphp
		@endforeach
	</tbody>
</table><br>
<button class="btn btn-sm btn-success" id="submitBtn" style="float:right">Submit</button>
<table class="table table-bordered">
	<tr class="text-center">
		<th style="text-align:center"></th>
		<th style="text-align:center">Quantity</th>
		<th style="text-align:center">Total</th>
	</tr>
	<tbody>
		<tr>
			<th style="text-align:center">TOTAL</th>
			<th style="text-align:center"id="total_qty">{{$total_qty}}</th>
			<th style="text-align:center" id="total_price">₹ {{$total_price}}</th>
		</tr>
	</tbody>
</table><br>
<script type="text/javascript">

$(document).ready( function(){

	$('#dailyReport').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'pdfHtml5'
          ],
            "searching": true,
            "paging": true,
            "info": true
      } );

	 
	$(document).on('click', '#submitBtn', function(){

		var saleItemsRecord = 	$('#dailyReport').DataTable().rows().data().toArray();
		var total_qty		= 	$('#total_qty').text()
		var total_price		= 	$('#total_price').text().replace('₹ ', '')

		console.log([typeof(saleItemsRecord), typeof(total_price)])

		$.ajax({
			method: 'POST',
			url: "{{route('sale-items-report.generate')}}",
			//data: {'saleItemsRecord': saleItemsRecord, 'total_qty': total_qty, 'total_price': total_price},
			data: {'saleItemsRecord': saleItemsRecord, 'total_qty': total_qty, 'total_price': total_price},
			beforeSend: function() { 
                   $("#submitBtn").text(' Loading ...');
                   $("#submitBtn").attr('disabled',true);
                 },
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(res){
				window.location.href = "/sale-items-report/challan/"+res;
			}
		})
	})

});
</script>
	