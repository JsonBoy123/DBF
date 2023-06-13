@extends('layouts.dbf')

@section('content')

	
	<script type="text/javascript">
	// live clock
	var clock_tick = function clock_tick() {
		setInterval('update_clock();', 1000);
	}

	// start the clock immediatly
	clock_tick();

	var update_clock = function update_clock() {
		document.getElementById('liveclock').innerHTML = moment().format("DD/MM/YYYY hh:mm:ss A");
	}

	$.notifyDefaults({ placement: {
		align: 'center',
		from: 'bottom'
	}});

	var post = $.post;

	var csrf_token = function() {
		return Cookies.get('csrf_cookie_ospos_v3');
	};

	var csrf_form_base = function() {
		return { csrf_ospos_v3 : function () { return csrf_token();  } };
	};

	$.post = function() {
		arguments[1] = csrf_token() ? $.extend(arguments[1], csrf_form_base()) : arguments[1];
		post.apply(this, arguments);
	};

	var setup_csrf_token = function() {
		$('input[name="csrf_ospos_v3"]').val(csrf_token());
	};

	setup_csrf_token();

	$.ajaxSetup({
		dataFilter: function(data) {
			setup_csrf_token();
			return data;
		}
	});

	var submit = $.fn.submit;

	$.fn.submit = function() {
		setup_csrf_token();
		submit.apply(this, arguments);
	};

</script>
	<script type="text/javascript">
(function(lang, $) {

    var lines = {
        'common_submit' : "Submit",
        'common_close' : "Close"
    };

    $.extend(lang, {
        line: function(key) {
            return lines[key];
        }
    });


})(window.lang = window.lang || {}, jQuery);
</script>
	<style type="text/css">
		html {
			overflow: auto;
		}
	</style>

	<!-- DATATABLE CDN -->
	<!-- 
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.8.2/css/demo_table_jui.css">
	<link rel="stylesheet" type="text/css" href=" https://cdn.datatables.net/1.8.2/css/demo_table.css"> -->
	<!-- <script src="https://cdn.datatables.net/1.8.2/js/jquery.dataTables.js"></script> -->
	

	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

	
	<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script> -->
	<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script> -->
	<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script> -->
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
	<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script> -->
	<!-- DATATABLE CDN -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<!----Sweet alert---->
	 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
	<!----Editer for control pannel---->
	<script src="https://cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script><style>.cke{visibility:hidden;}</style>

	<!-- Jquery Model -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
	
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" /> --> 

	<!-- jQuery Modal -->

	
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>

	<!-- <link rel="stylesheet" href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/css/bootstrap.min.css'
    media="screen" /> -->

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<!-- <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css" />
<link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script> -->

<!--  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
 <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> -->


<!-- <script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script> -->

</head>


				<div class="container">
		<div class="row">

<script type="text/javascript">
	dialog_support.init("a.modal-dlg");
</script>
<div class="tab-content">
<div class="tab-pane fade in active" id="mh_count">
<div class="row">
	<div class="col-sm-3">
		<div class="column">
			<center>
			<div class="card" style="background-image: linear-gradient(to bottom,#01e6e647, #00c3cc); min-height:200px;">
				<br>
				<h3>Count Actions</h3>
				<h1><a href="{{ route('count_action.index') }}" title="Count Actions"><span class="fa fa-tags" style="color: white;"></span></a></h1>
				<br>
			</div>
			</center>
		</div>
	</div>
	<div class="col-sm-3 min_height">
		<div class="column">
			<center>       
			<div class="card" style="background: linear-gradient(to bottom,#ccb3006e, #ffcc66);min-height:200px;">
				<br>
				<h3>List Actions</h3>
				<h1><a href="{{ route('list_actions.index') }}" title="List Actions"><span class="fa fa-briefcase" style="color: white;"></span></a></h1>
				<br>
			</div>
			</center>
		</div>
	</div>
	<div class="col-sm-3 min_height">
		<div class="column">
			<center>       
			<div class="card" style="background-image: linear-gradient(to bottom,#efb1ab, #f77b7b);background-color: #f77b7b;min-height:200px;">
				<br>
				<h3>MCI</h3>
				<h1><a href="{{route('mci.index')}}" title="MCI"><span class="fa fa-qrcode" style="color: white;"></span></a></h1>
				<br>
			</div>
			</center>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="column">
			<center>       
			<div class="card" style="background-image: linear-gradient(to bottom, #c7a9ef , #bf38d8);min-height:200px;">
				<br>
				<h3>Bulk Actions</h3>
				<h1><a href="{{ route('bulk_action.index') }}" title="Bulk Actions"><span class="fa fa-tasks" style="color: white;"></span></a></h1>
				<br>
			</div>
			</center>
		</div>
	</div>
	<div class="clearfix" style="margin-top:20px;margin-bottom:30px;"></div>
	<div class="col-sm-3">
		<div class="column">
			<center>       
			<div class="card" style="background-image: linear-gradient(to bottom, #c7a9ef , #bf38d8); min-height:200px;">
				<br>
				<h3>Reports</h3>
				<h1><a href="{{ route('manager_reports.index') }}" title="Reports"><span class="fa fa-align-justify" style="color: white;"></span></a></h1>
				<br>
			</div>
			</center>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="column">
			<center>       
			<div class="card" style="background: linear-gradient(to bottom,#01e6e647, #00c3cc);min-height:200px;">
				<br>
				<h3>Extras</h3>
				<h1><a href="{{ route('extras.index') }}" title="Cashiers"><span class="fa fa-cog" style="color: white;"></span></a></h1>
				<br>
			</div>
			</center>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="column">
			<center>       
			<div class="card" style="background-image: linear-gradient(to bottom,#fbefd6, #ffcc66);background-color: #f77b7b;min-height:200px;">
				<br>
				<h3>Inventory</h3>
				<h1><a href="{{ route('enventory.index') }}" title="Inventory"><span class="fa fa-folder-open" style="color: white;"></span></a></h1>
				<br>
			</div>
			</center>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="column">
			<center>       
			<div class="card" style="background-image: linear-gradient(to bottom,#efb1ab, #f77b7b);background-color: #f77b7b;min-height:200px;">
				<br>
				<h3>Control Panel</h3>
				<h1><a href="{{ route('control_panel.index') }}" title="Inventory"><span class="fa fa-cog" style="color: white;"></span></a></h1>
				<br>
			</div>
			</center>
		</div>
	</div>
	<div class="clearfix" style="margin-top:20px;margin-bottom:30px;"></div>
	<div class="col-sm-3">
		<div class="column">
			<center>       
			<div class="card" style="background-image: linear-gradient(to bottom,#efb1ab, #a4cb2b);background-color: #f77b7b;min-height:200px;">
				<br>
				<h3>Manage Item By Rack</h3>
				<h1><a href="{{ route('item_manage_rack.index') }}" title="Manage Item By Rack"><span class="fa fa-list-alt " style="color: white;"></span></a></h1>
				<br>
			</div>
			</center>
		</div>
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
