@extends('layouts.dbf')

@section('content')

<div class="container">
    <div id="page_title">Items Summery Report</div><br>
    <div style="font-size: 20px"><b>Time Duration - </b> {{$to}} To {{$from}}</div>
    @if(isset($items) == true)
        <div class="row" id="catsTable">
        <div class="col-md-12 col-xl-12">
          <div class="card shadow-xs">
            <div class="card-body table-responsive">
              <table class="table table-striped table-hover" id="LocationTable">
                <thead>
                  <tr class="text-center">
                    <th style="text-align:center">Items</th>
                    <th style="text-align:center">Category</th>
                    <th style="text-align:center">SubCategory </th>
                    <th style="text-align:center">Quantity</th>
                    <th style="text-align:center">Subtotal</th>
                    <th style="text-align:center">Tax</th>
                    <th style="text-align:center">Total</th>
                    <th style="text-align:center">Wholesale</th>
                    <th style="text-align:center">Profit</th>
                  </tr>
                </thead>
                <tbody>
                @php
                    $sum_tax = $sum_total = $sum_subtotal = $sum_quantity = 0;
                    $quantityTotal= 0;

                    foreach($items as $item){
                        $subtotal = $tax = $total = 0;
                @endphp
                <tr class="text-center">
                    <?php
                        $tax = floatval(tax($date, $location_id,$item->item_id,'item'));
                        $total = floatval(total($date, $location_id,$item->item_id,'item')); 
                     ?>
                    <td>{{$item->item->name}}</td>
                    <td>{{$item['item']['categoryName']->category_name}}</td>
                    <td>{{$item['item']['subcategoryName']->sub_categories_name}}</td>
                    <td> {{ $item->quantity }}</td>
                    <td>₹ {{number_format($total - $tax, 2)}}</td>
                    <td>₹ {{number_format($tax, 2)}}</td>
                    <td>₹ {{number_format($total, 2)}}</td>
                    <td>₹ 0</td>
                    <td>₹ {{number_format($total - $tax, 2)}}</td>
                    @php                  
                        $sum_quantity += $item->quantity;
                        $sum_subtotal += $total - $tax ;
                        $sum_tax      += $tax;
                        $sum_total    += $total;
                    @endphp
                  </tr>
                @php } @endphp
                </tbody>
                </table>

                <table class="table table-bordered">
                <tr class="text-center">
                    <th style="text-align:center"></th>
                    <th style="text-align:center">Quantity</th>
                    <th style="text-align:center">Subtotal</th>
                    <th style="text-align:center">Tax</th>
                    <th style="text-align:center">Total</th>
                    <th style="text-align:center">Wholesale</th>
                    <th style="text-align:center">Profit</th>
                </tr>
                <tbody>
                    <tr>
                        <th style="text-align:center">TOTAL</th>
                        <th style="text-align:center">{{$sum_quantity}}</th>
                        <th style="text-align:center">₹ {{number_format($sum_subtotal, 2)}}</th>
                        <th style="text-align:center">₹ {{number_format($sum_tax, 2)}}</th>
                        <th style="text-align:center">₹ {{number_format($sum_total, 2)}}</th>
                        <th style="text-align:center">0</th>
                        <th style="text-align:center">₹ {{number_format($sum_subtotal, 2)}}</th>
                    </tr>
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
        
        $('#LocationTable').dataTable({
            order: [[1, 'asc']],
            "columnDefs": [
            {'orderable': false, "target": 0}
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });


</script>
@endsection
