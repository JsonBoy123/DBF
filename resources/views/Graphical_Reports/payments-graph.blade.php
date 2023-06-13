@extends('layouts.dbf')

@section('content')

<div class="container">
	<div id="page_title">Payment Graph</div><br>
  <div style="font-size: 20px"><b>Time Duration - </b> {{$date['to']}} To {{$date['from']}}</div>
	<div class="row">
		<canvas id="myChart" width="500" height="200"></canvas>
	</div>
</div>

  @php 
    $paytm_type = [];
    $paytm_amt = [];
  @endphp
  @foreach($payments as $Payments)
      <?php 
      		$paytm_type[] = $Payments->payment_type;
      		$paytm_amt[] = $Payments->total_amount;

       ?>
  @endforeach 
<script>

	var pay_lable = <?php echo json_encode($paytm_type); ?>;
    var pay_val = <?php echo json_encode($paytm_amt); ?>;
	
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {

    type: 'doughnut',

    data: {
        labels: pay_lable,//['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            
            backgroundColor:["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3cba9f","#3e95cd"],
            borderColor: "rgba(117,61,41,1)",
            data: pay_val//[0.5, 10, 5, 2, 20, 30, 45]
        }]
    },
    /*options: {
	    responsive: true,
	    maintainAspectRatio: true,
	    scales: {
	        xAxes: [{
	            gridLines: {
	                offsetGridLines: true
	            }
	        }]
	    }
	}*/
});
</script>
@endsection
