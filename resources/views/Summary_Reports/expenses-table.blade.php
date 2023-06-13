@extends('layouts.dbf')

@section('content')

<div class="container">
    <div id="page_title">Expense Categories Summary Report</div><br>
    <div style="font-size: 20px"><b>Time Duration - </b> {{$date['to']}} To {{$date['from']}}</div>
        <div class="row" id="catsTable">
        <div class="col-md-12 col-xl-12">
          <div class="card shadow-xs">
            <div class="card-body table-responsive">
              <table class="table table-striped table-hover" id="LocationTable">
                <thead>
                  <tr class="text-center">
                    <th style="text-align:center">Category</th>
                    <th style="text-align:center">Count</th>
                    <th style="text-align:center">Amount</th>
                    <th style="text-align:center">Tax</th>
                  </tr>
                </thead>
                <tbody>
                <tr class="text-center">
                    <td></td>
                    <td></td>
                    <td>₹ {{-- {{number_format(discountShow($discount->discount_percent, $location_id, 'subtotal')['amount'], 2)}} --}}{{-- {{number_format($total - $tax, 2)}} --}}</td>               
                    <td>₹ {{-- {{number_format(discountShow($discount->discount_percent, $location_id, 'subtotal')['tax'], 2)}} --}}</td>
                  </tr>
                </tbody>
                </table>

                <table class="table table-bordered">
                <tr class="text-center">
                    <th style="text-align:center"></th>
                    <th style="text-align:center">Quantity</th>
                    <th style="text-align:center">Subtotal</th>
                    <th style="text-align:center">Tax</th>
                    <th style="text-align:center">Total</th>
                </tr>
                <tbody>
                    <tr>
                        <th style="text-align:center">TOTAL</th>
                        <th style="text-align:center">{{-- {{number_format($sum_quantity, 2)}} --}}</th>
                        <th style="text-align:center">₹ {{-- {{number_format($sum_subtotal, 2)}} --}}</th>
                        <th style="text-align:center">₹ {{-- {{number_format($sum_tax, 2)}} --}}</th>
                        <th style="text-align:center">₹ {{-- {{number_format($sum_total, 2)}} --}}</th>
                    </tr>
                </tbody>
            </table>
            </div>
          </div>
        </div>
    </div>
</div>
<script>
    $(document).ready( function () {
        
        $('#LocationTable').dataTable({
            order: [[1, 'asc']],
            "columnDefs": [
            {'orderable': false, "target": 0}
            ]
        });

    });


</script>
@endsection
