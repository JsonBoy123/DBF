@extends('layouts.dbf')

@section('content')

<div class="container">
	<div class="row">
		<canvas id="myChart" width="500" height="200"></canvas>
	</div>
</div>
@php 
    $total_arr = [];
  @endphp
  @foreach($customers_id as $custId)

      <?php $total_arr[] = total($daterange, $location, $custId,'customer'); ?>
  @endforeach
    
<script>

   var emp_val = <?php echo json_encode($total_arr); ?>;
   var customers_name = <?php echo json_encode($customers_name); ?>;

	
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {

    type: 'horizontalBar',

    data: {
        labels:customers_name,
        datasets: [{
            label: 'My First dataset',
            backgroundColor:["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3cba9f","#3e95cd"],
            borderColor: "rgba(117,61,41,1)",
            data: emp_val
        }]
    },
    options: {
	    responsive: true,
	    maintainAspectRatio: true,
	    scales: {
	        xAxes: [{
	            gridLines: {
	                offsetGridLines: true
	            }
	        }]
	    }
	}
});
</script>
@endsection
