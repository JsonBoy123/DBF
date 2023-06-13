@extends('layouts.dbf')

@section('content')

<div class="container">
	<div class="row">
		<script type="text/javascript">
			dialog_support.init("a.modal-dlg");
		</script>

		<h3 class="text-center">Welcome to DBF, click a module below to get started.</h3>

		<div id="office_module_list" class="row">
			<div class="module_item col-md-2" title="Add, Update, Delete, and Search Employees.">
				<a href="{{ route('shop.index') }}"><img src="{{ asset('dbf-style/images/menubar/shop.png') }}" border="0" alt="Menubar Image" width="65"><br>
				Shop</a>
			</div>
			<div class="module_item col-md-2" title="Add, Update, Delete, and Search Employees.">
				<a href="{{ route('employees.index') }}"><img src="{{ asset('dbf-style/images/menubar/employees.png') }}" border="0" alt="Menubar Image"><br>
				Employees</a>
			</div>
			<div class="module_item col-md-2" title="Add, Update, Delete, and Search Employees.">
				<a href="{{ route('configuration.index') }}"><img src="{{ asset('dbf-style/images/menubar/config.png') }}" border="0" alt="Menubar Image"><br>
				Configuration</a>
			</div>
			<div class="module_item col-md-2" title="Add, Update, Delete, and Search Employees.">
				<a href="{{ route('offers.index') }}"><img src="{{ asset('dbf-style/images/menubar/offers.png') }}" border="0" alt="Menubar Image"><br>
				Offers</a>
			</div>
			<div class="module_item col-md-2" title="Add, Update, Delete, and Search Employees.">
				<a href="{{ route('acl.index') }}"><img src="{{ asset('dbf-style/images/menubar/offers.png') }}" border="0" alt="Menubar Image"><br>
				Role & Permissions</a>
			</div>
			<div class="module_item col-md-2" title="List office menu modules.">
				<a href="{{ route('broker.index') }}"><img src="{{ asset('dbf-style/images/menubar/employees.png') }}" border="0" alt="Menubar Image"><br>Reference</a>
			</div> 
		</div>
		<div id="office_module_list" class="row">
			<div class="module_item col-md-2" title="List office menu modules.">
				<a href="{{ route('broker_commisssion.index') }}"><img src="{{ asset('dbf-style/images/menubar/reports.png') }}" border="0" alt="Menubar Image"><br>Reference Commission</a>
			</div> 
			<div class="module_item col-md-2" title="List office menu modules.">
				<a href="{{ route('wholesale_customer.index') }}"><img src="{{ asset('dbf-style/images/menubar/customers.png') }}" border="0" alt="Menubar Image"><br>Wholesale Cusomer</a>
			</div>
			<div class="module_item col-md-2" title="List office menu modules.">
				<a href="{{ route('repair.index') }}"><img style="width:66px;" src="{{ asset('dbf-style/images/menubar/index.png') }}" border="0" alt="Menubar Image"><br>Repair Cost</a>
			</div> 
			
			<!-- <div class="module_item" title="Change OSPOS's Configuration.">
				<a href="http://newpos.dbfindia.com/config"><img src="http://newpos.dbfindia.com/images/menubar/config.png" border="0" alt="Menubar Image"></a>
				<a href="http://newpos.dbfindia.com/config">Configuration</a>
			</div>
			<div class="module_item" title="Implement Offers">
				<a href="http://newpos.dbfindia.com/offers"><img src="http://newpos.dbfindia.com/images/menubar/offers.png" border="0" alt="Menubar Image"></a>
				<a href="http://newpos.dbfindia.com/offers">Offers</a>
			</div>-->
			
		</div>
	</div>
</div>

@endsection
