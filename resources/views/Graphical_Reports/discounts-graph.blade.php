	@extends('layouts.dbf')

@section('content')

<div class="container">
	<div class="row">
		<canvas id="myChart" width="500" height="200"></canvas>
	</div>
</div>

	@php 
	    $discount_total = [];

	    //dd($disc_name);
  	@endphp
  	@foreach($disc_name as $discount)

		<?php $discount_total[] = total($daterange, $location, $discount, 'discount'); ?>
  	@endforeach

  		
<script>



var discount_name = <?php echo json_encode($disc_name) ; ?>;
var discount_total = <?php echo json_encode($discount_total) ; ?>

var ctx = document.getElementById('myChart').getContext('2d');

var chart = new Chart(ctx, {

    type: 'bar',

    data: {
        //labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        labels: discount_name,
        datasets: [{
            label: 'My First dataset',
            backgroundColor:["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3cba9f","#3e95cd"],
            borderColor: "rgba(117,61,41,1)",
            //data: [0.5, 10, 5, 2, 20, 30, 45]
            data: discount_total
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
