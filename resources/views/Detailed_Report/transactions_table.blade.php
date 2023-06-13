@extends('layouts.dbf')

@section('content')

<div class="container">
	<div id="page_title">Detailed Transactions Report</div><br>

	@if(isset($sales) == true)
		<div class="row" id="catsTable">
	    <div class="col-md-12 col-xl-12">
	      <div class="card shadow-xs">
	        <div class="card-body table-responsive">
	          <table class="table table-striped table-hover" id="CategoryTable">
	            <thead>
	              <tr class="text-center">
	                <th style="text-align:center">Trans. Id</th>
	                <th style="text-align:center">Type</th>
	                <th style="text-align:center">Date</th>
	                <th style="text-align:center">Quantity</th>
	                <th style="text-align:center">Sold By</th>
	                <th style="text-align:center">Sold to</th>
	                <th style="text-align:center">Subtotal</th>
	                <th style="text-align:center">Tax </th>
	                <th style="text-align:center">Total</th>
	                <th style="text-align:center">Wholesale</th>
	                <th style="text-align:center">Profit</th>
	                <th style="text-align:center">Payment type</th>
	                <th style="text-align:center">Comments</th>
	              </tr>
	            </thead>
	            <tbody>
	          @php $count = 0;
	          //dd($items);
	           	foreach($sales as $val){ 
	           		$q = 0;
	           		$total_tax_amount = 0;
	           		$total_gross_value = 0;
	           		foreach($val['sale_items'] as $index)
	           		{
	           			$q += $index['quantity_purchased'];

	           			if($index['item_unit_price'] != 0.00)
                        {
                            $mrp_prise = $index['item_unit_price'];
                            $discount = $index['discount_percent'];
                            $q_p = $index['quantity_purchased'];
                            $tax_rate = (float)$index['taxe_rate'];

                            $dis_value = ($mrp_prise*$discount)/100;
                            $g_v = $mrp_prise-$dis_value;
                            $tax_amt = ($g_v*$tax_rate)/(100+$tax_rate);

                            $gross_value = $g_v*$q_p; 
                            $tax_amount = $tax_amt*$q_p; 
                        }
                        else
                        {
                            $mrp_prise = $index['discount_percent'];
                            $q_p = $index['quantity_purchased'];
                            $tax_rate = (float)$index['taxe_rate'];

                            $dis_value = "0";

                            $g_v = $mrp_prise-$dis_value;
                            $tax_amt = ($g_v*$tax_rate)/(100+$tax_rate);

                            $gross_value = $g_v*$q_p; 
                            $tax_amount = $tax_amt*$q_p; 
                        }

                        $total_gross_value += $gross_value;
                        $total_tax_amount += $tax_amount;
                        $Subtotal = $total_gross_value - $total_tax_amount;
	           		}

	          @endphp
	              <tr class="text-center">
	                <td>{{ $val->id }}</td>
	                <td>INV</td>
	                <td>{{ $val->sale_time }}</td>
	                <td>{{ $q }} </td>
	                <td>{{ $val['shop']->name }} </td>
	                <td>{{ $val['customer']->first_name.' '.$val['customer']->last_name }} </td>
	                <td>₹ {{number_format($Subtotal, 2)}}</td>
	                <td>₹ {{number_format($total_tax_amount, 2)}}</td>
	                <td>₹ {{number_format($total_gross_value, 2)}}</td>
	                <td> ₹ 0</td>
	                <td>₹ {{number_format($Subtotal, 2)}}</td>
	                <td>{{-- {{ $val['sale_payment']->payment_type}} - {{ $val['sale_payment']->payment_amount}} --}}</td>
	                <td>....</td>
	              </tr>

	            @php } @endphp
	            </tbody>
	          </table>
	        </div>
	      </div>
	    </div>
  	</div>
  	@endif
</div>
<script>
	$(document).ready( function () {
		
		$('#CategoryTable').dataTable({
			order: [[1, 'asc']],
			"columnDefs": [
			{'orderable': false, "target": 0}
			],
			dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
		});
	});


</script>
@endsection
