@extends('layouts.dbf')

@section('content')

<div class="container">
	<div class="row">
		<canvas id="myChart" width="500" height="200"></canvas>
	</div>
</div>
<script>
	
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {

    type: 'horizontalBar',

    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'My First dataset',
            backgroundColor:["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3cba9f","#3e95cd"],
            borderColor: "rgba(117,61,41,1)",
            data: [0.5, 10, 5, 2, 20, 30, 45]
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
