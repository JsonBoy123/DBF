
@extends('layouts.dbf')

@section('content')
<div class="container">
   <div class="row">

<script type="text/javascript">
	dialog_support.init("a.modal-dlg");
</script>


<div class="row">
	<div class="bg-info" style="color:#fff;padding:10px;margin-bottom:20px;">
               <a style="color:#fff" href="http://newpos.dbfindia.com/manager">
                  <h4 style="display:inline">Manager</h4>
               </a>
               &gt;&gt; Reports 
            </div>
	<div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="glyphicon glyphicon-stats">&nbsp;</span>Sales Reports</h3>
			</div>
			<div class="list-group">
				<a class="list-group-item" href="{{ route('tally_format') }}">Tally Format</a>
				<a class="list-group-item" href="{{ route('sale-items-report') }}">Sale Items Report</a>
				<!-- <a class="list-group-item" href="{{ route('custom_format') }}">Custom Format</a>
				<a class="list-group-item" href="{{ route('email_format') }}">Email Reports</a> -->
			</div>
		</div>
	</div>

	
</div>

		</div>
	</div>

	<div id="footer">
		<!-- <div class="jumbotron push-spaces"> -->
			<!-- <strong>  			 - </strong>.
						<a href="https://github.com/jekkos/opensourcepos" target="_blank"></a>
			 -->
		<!-- </div> -->
	</div>


</div></body></html>

@endsection
