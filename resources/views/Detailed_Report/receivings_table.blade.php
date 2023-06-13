@extends('layouts.dbf')

@section('content')
<script src="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.js"></script>

<div class="container">
	<div id="page_title">Receivings Report</div><br>
	<div id="table_holder">

		{{-- @php echo json_encode($receiving_data); @endphp --}}

	<table id="table"></table>
	</div>

	<div id="report_summary">
		<div class="summary_row">Total: ₹ 0</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function()
	{
	 	(jQuery);
		var details_data = @php echo json_encode($receiving_items); @endphp;
				var init_dialog = function() {
							// table_support.submit_handler('http://newpos.dbfindia.com/reports/get_detailed_receivings_row');
				// dialog_support.init("a.modal-dlg");
					};

		$('#table').bootstrapTable({
			columns: [{"field":"id","title":"Receiving ID","switchable":true,"sortable":true,"checkbox":false,"class":"","sorter":""},{"field":"receiving_date","title":"Date","switchable":true,"sortable":"","checkbox":false,"class":"","sorter":""},{"field":"quantity","title":"Quantity","switchable":true,"sortable":true,"checkbox":false,"class":"","sorter":""},{"field":"employee_name","title":"Origin","switchable":true,"sortable":true,"checkbox":false,"class":"","sorter":""},{"field":"comment","title":"Comments","switchable":true,"sortable":true,"checkbox":false,"class":"","sorter":""}],
			stickyHeader: true,
			pageSize: 20,
			striped: true,
			pagination: true,
			sortable: true,
			showColumns: true,
			uniqueId: 'id',
			showExport: true,
			exportDataType: 'all',
			exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
			data: @php echo json_encode($receiving_data); @endphp,
			iconSize: 'sm',
			paginationVAlign: 'bottom',
			detailView: true,
			escape: false,
			onPageChange: init_dialog,
			onPostBody: function() {
				// dialog_support.init("a.modal-dlg");
			},
			onExpandRow: function (index, row, $detail) {
				$detail.html('<table></table>').find("table").bootstrapTable({
					columns: [{"field":0,"title":"Barcode","sortable":true,"switchable":true},{"field":1,"title":"Name","sortable":true,"switchable":true},{"field":2,"title":"Category","sortable":true,"switchable":true},{"field":3,"title":"Quantity","sortable":true,"switchable":true},{"field":4,"title":"Total","sortable":true,"switchable":true},{"field":5,"title":"Discount","sortable":true,"switchable":true}],
					data: details_data[(!isNaN(row.id) && row.id) || $(row[0] || row.id).text().replace(/(POS|RECV)\s*/g, '')]
				});

							}
		});

		init_dialog();
	});
</script>



	{{-- @if(isset($items) == true) --}}
	{{-- 	<div class="row" id="catsTable">
	    <div class="col-md-12 col-xl-12">
	      <div class="card shadow-xs">
	        <div class="card-body table-responsive">
	          <table class="table table-striped table-hover" id="CategoryTable">
	            <thead>
	              <tr class="text-center">
	                <th style="text-align:center">Ieceiving ID</th>
	                <th style="text-align:center">Date</th>
	                <th style="text-align:center">Quantity</th>
	                <th style="text-align:center">Origin</th>
	                <th style="text-align:center">Comments</th>
	              </tr>
	            </thead>
	           
	          </table>
	        </div>
	      </div>
	    </div>
  	</div> --}}
  	{{-- @endif --}}
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
