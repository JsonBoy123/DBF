@extends('layouts.dbf')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="glyphicon glyphicon-stats">&nbsp;</span>Graphical Reports</h3>
					</div>
					<div class="list-group">
						<a class="list-group-item" href="{{route('category-graph')}}">Categories</a>
						<a class="list-group-item" href="{{route('customers-graph')}}">Customers</a>
						<a class="list-group-item" href="{{route('discount-graph')}}">Discounts</a>
						<a class="list-group-item" href="{{route('employee-graph')}}">Employees</a>
						<a class="list-group-item" href="{{route('expense-graph')}}">Expenses</a>
						<a class="list-group-item" href="{{route('ItemGraphReport')}}">Items</a>
						<a class="list-group-item" href="{{route('PaymentGraphReport')}}">Payments</a>
						<a class="list-group-item" href="{{route('transGraphReport')}}">Transactions</a>
						<a class="list-group-item" href="{{route('supplier-graph')}}">Suppliers</a>
						<a class="list-group-item" href="{{route('taxGraphReport')}}">Taxes</a>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="glyphicon glyphicon-list">&nbsp;</span>Summary Reports</h3>
					</div>
					<div class="list-group">
						<a class="list-group-item" href="{{route('categories-report.index')}}">Categories</a>
						<a class="list-group-item" href="{{route('customers-report.index')}}">Customers</a>
						<a class="list-group-item" href="{{route('discount-report.index')}}">Discounts</a>
						<a class="list-group-item" href="{{route('employees-report.index')}}">Employees</a>
						<a class="list-group-item" href="{{route('expanses-report.index')}}">Expenses</a>
						<a class="list-group-item" href="{{route('items-report.index')}}">Items</a>
						<a class="list-group-item" href="{{route('payments-report.index')}}">Payments</a>
						<a class="list-group-item" href="{{route('transactions-report.index')}}">Transactions</a>
						<a class="list-group-item" href="{{route('suppliers-report.index')}}">Suppliers</a>
						<a class="list-group-item" href="{{route('taxes-report.index')}}">Taxes</a>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="glyphicon glyphicon-list-alt">&nbsp;</span>Detailed Reports</h3>
					</div>
					<div class="list-group">
						<a class="list-group-item" href="{{route('detailed-transactions-index')}}">Transactions</a>
						<a class="list-group-item" href="{{route('detailed-receivings-index')}}">Receivings</a>
						<a class="list-group-item" href="{{route('detailed-customers-index')}}">Customers</a>
						<a class="list-group-item" href="{{route('detailed-discounts-index')}}">Discounts</a>
						<a class="list-group-item" href="{{route('detailed-employees-index')}}">Employees</a>
					</div>
				</div>

				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="glyphicon glyphicon-book">&nbsp;</span>Inventory Reports</h3>
					</div>
					<div class="list-group">
								<a class="list-group-item" href="{{route('inventory-low-index')}}">Low Inventory</a>
						<a class="list-group-item" href="{{route('inventory-summery-index')}}">Inventory Summary</a>
						<a class="list-group-item" href="{{route('inventory-age-index')}}">Inventory Age</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
