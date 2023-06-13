<table id="table" class="table table-hover table-bordered table-striped">
    <thead id="table-sticky-header">
        <tr>
            <th>S.No.</th>
            <th>Shop Name</th>
            <th>Owner</th>
            <th>Alias</th>
            <th>Shop sort name</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
		@if(!empty($shop))
			@foreach($shop as $index => $shops)
		    <tr>
		        <td>{{ ++$index }}</td>
		        <td>{{ $shops->name }}</td>
		        <td>{{ $shops['employee']->first_name }} {{$shops['employee']->last_name}}</td>
		        <td>{{ $shops->alias }}</td>
		        <td>{{ $shops->inv_prefix }}</td>
		        <td>{{ $shops->address }}</td>
		        <td>
		        	<a href="#" class="modal-dlg" data-toggle="modal" data-target="#UpdateShop{{ $shops->id }}" title="Update Customer"><span class="glyphicon glyphicon-edit"></span></a>
		        </td>
		    </tr>

		    <!-- Update Modal -->
				<div class="modal fade" id="UpdateShop{{ $shops->id }}" role="dialog">
				    <div class="modal-dialog">
				      <!-- Modal content-->
				      <div class="modal-content">
				        <div class="modal-header">
				          <button type="button" class="close" data-dismiss="modal">&times;</button>
				          <h4 class="modal-title">UPDATE SHOP</h4>
				        </div>
				        <div class="modal-body">
					        <form id="EditShop{{ $shops->id }}">
					        	@csrf
					        	@method('PUT')
							    <div class="form-group">
							        <label for="shop_name">Shop Name</label>
							        <input type="text" class="form-control" name="name" value="{{ $shops->name }}" placeholder="SHOP NAME">
							    </div>

							    <div class="form-group">
							        <label for="shop_owner_name">Shop Owner Name</label>
							        <input type="text" class="form-control" value="{{$shops['employee']->first_name }} {{$shops['employee']->last_name }}" placeholder="OWNER NAME" disabled="">
							        <input type="hidden" name="shop_owner_id" value="{{$shops['employee']->id }} ">
							    </div>

							    <div class="row">
							    	<div class="col-md-6">
							    		<div class="form-group">
									        <label for="contact_no">Alias.</label>
									        <input type="text" name="alias" class="form-control" value="{{ $shops->alias }}" placeholder="CONTACT NUMBER">
									        <div id="contactErr1" class="registeredMsg"></div>
									    </div>
									</div>
									<div class="col-md-6">
									    <div class="form-group">
									        <label for="email">Shop sort Address</label>
									        <input type="text" name="inv_prefix" value="{{ $shops->inv_prefix }}" class="form-control" placeholder="EMAIL ADDRESS">
									        <div id="emailErr1" class="registeredMsg"></div>
									    </div>
							    	</div>
							    </div>

							    <div class="form-group">
							        <label for="shop_address">Shop Address</label>
							        <textarea name="address" class="form-control"  placeholder="SHOP ADDRESS">{{ $shops->address }}</textarea>
							    </div>

							    <button type="submit" name="submit" class="btn btn-primary" style="float: right">UPDATE</button>
							</form>
				        </div>
				      </div>   
				    </div>
				</div>
			<!-- Modal -->
			@endforeach
		@endif
	</tbody>
</table>

<script type="text/javascript">
  	$(document).ready(function() {
      	$('#table').DataTable();
    });
</script>