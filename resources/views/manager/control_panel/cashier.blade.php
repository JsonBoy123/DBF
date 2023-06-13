<div >
 	<div class="row">
	    <div class="col-md-12">
	          <div class="row">
	             <div class="col-sm-4 col-md-4">
	                <label>Shop Open Time</label>
	                <input type="hidden" name="type" value="timing">
	                <input type="hidden" name="shop_id" value="{{$shops->id}}" id="shop_id">
	                <input type="text" name="login" class="form-control timepicker" id="login" value="{{$shop_data == null ?  'No Record': $shop_data->login }}"> 
	             </div>
	          </div>
	          <div class="row">
	             <div class="col-sm-4 col-md-4">
	                <label>Shop Close Time</label>
	                <input type="text" name="logout" class="form-control timepicker" id="logout" value="{{$shop_data == null ?  'No Record': $shop_data->logout }}">        
	             </div>
	          </div>
	          
	          <div class="row" style="margin-top: 10px;">
	          	<div class="col-sm-4 pull-right">
			       <div class="list-group-item disabled" style="background-color: #132639;color:#fff;font-size:15px;">
			          <span class="glyphicon glyphicon-user" style="color: white;margin-right:10px;"></span>
			          Cashiers
			          <button type="button" class="btn btn-xs btn-info col-sm-3  pull-right cashier">Add Cashier</button>
			       </div>
			       <br>
			       <div id="CashierDetails" class="list-group-item">
			       	@if(! empty($CashierShop) )
			       		@foreach($CashierShop as $cashier_data)
				       		<div class="panel-group">
						        <div class="panel panel-default">
						            <div class="panel-heading">
						            <h4 class="panel-title">
						                <span id="cashier_title{{$cashier_data->id}}" class="">
						                     {{$cashier_data ? $cashier_data->cashier->name : "No Record"}}                </span>
						                <a data-toggle="collapse" href="#collapse{{$cashier_data->id}}" class="fa fa-arrow-down pull-right arrow" aria-expanded="true"></a> 
						            </h4>
						            </div>
						         <div id="collapse{{$cashier_data->id}}" class="panel-collapse collapse in" aria-expanded="true" style="">
						            <ul class="list-group">
						                <li class="list-group-item col-sm-8">
						                <div class="form-group">
						                    <label for="name">Name : </label>
						                   
						                    {{$cashier_data ? $cashier_data->cashier->name : "No Record"}}               </div>
						                </li>
						                <div class="clearfix"></div>
						                <li class="list-group-item">
						                    <div class="form-group">
						                    <label for="pwd">Password:</label>
						                    
						                   {{$cashier_data ? $cashier_data->cashier->webkey : "No Record"}}                </div>
						                </li>
						                <li class="list-group-item">
						                    <div class="form-group">
						                    <label for="phone">Contact Number:</label>
						                 
						                    {{$cashier_data ? $cashier_data->cashier->contact_no : "No Record"}}       </div>
						                </li>
						            </ul>
						        </div>
						        <div class="clearfix"></div>
						        </div>
					        </div>
				        @endforeach
			       	@endif
			       		
			       </div>
				</div>
          	  	<div class="col-sm-7 ">
			       <div style="background: #2c3e50; padding: 10px 15px;" class="col-sm-12">
			          <span style="color:#fff;font-size: 15px;padding-left:0" class="col-sm-3 ">Shop Incharge
			          </span>
			          <span>

			          <input type="text" name="shop_incharge" id="shop_incharge" value="{{$shop_data == null ?  '': $shop_data->shop_incharge }}" class="form-control" placeholder="Write The Shop Incharge Name Here..">

			       </div>
			       <div>
			          <textarea name="address" id="address" >{{$shop_data == null ?  '': $shop_data->address }}</textarea>
			       </div>
			       {{-- <div><br>
			          <span class="btn btn-md btn-info col-sm-2 col-sm-offset-10">Save Address</span>
			       </div> --}}
			       <br>
			       <div class="clearfix"></div>
			       <br>
			       <div>
			          <textarea name="tnc" id="tnc" >{{$shop_data == null ?  '': $shop_data->tnc }}</textarea>
			       </div>
			      {{--  <div class="col-sm-12"> <br>
			          <span class="btn btn-md btn-info col-sm-2 col-sm-offset-10">Save T&amp;C</span>
			       </div> --}}
			       <br>
			    </div>
	          </div>
	          <div class="row">
	             <div class="col-sm-2 col-md-2" style="padding-top: 10px;padding-bottom: 10px;">
	                <button type="button" class="btn btn-info" id="form_submit">Submit</button>
	             </div>
	          </div>
	    </div>
 	</div>
 	<div class="row">
	    
	  
 	</div>
</div>
<!-- Add Modal -->
  <div class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" id="add_cashier" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ADD Cashier</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label>Location</label>
                <input type="text" class="form-control" readonly="true" data-id="{{ $shops->id }}" value="{{ $shops->name }}" id="modal_shop_id" name="modal_shop_id">
            </div>

            <div class="form-group">
                <label>Cashier</label>
                <select class="form-control" name="cashier_id" id="cashier_id">
                  @if(!empty($cashier))
                          @foreach($cashier as $cashiers)
                            <option value="{{ $cashiers->id }}">{{ $cashiers->name }}</option>
                          @endforeach
                        @endif
                </select>
            </div>

            <button type="button" class="btn btn-primary" id="Addcashier" style="float: right" >ADD</button>
          </div>
        </div>   
      </div>
  </div>
  <!-- Modal -->
<script>

	$(document).on('click','.cashier',function(){
      	$('#add_cashier').modal('show');
    })
  $(document).ready( function () {

      CKEDITOR.replace( 'tnc' );
      CKEDITOR.replace( 'address' );

      $('.timepicker').datetimepicker({
  			format:'H:m:s'
      });

         
    });

	$(document).on('click','#Addcashier',function(){
	  var shop_id 		=	$('#modal_shop_id').attr('data-id');
	  var cashier_id 	=	$('#cashier_id').val();

	  	var _token = $('input[name="_token"]').val();
	        $.ajax({
	            url: "{{ route('AddCashier') }}",
	            method: "POST",
	            data: {
	                shop_id: shop_id,
	                cashier_id: cashier_id,
	                _token: _token
	            },
	            success: function(data) {
	              console.log(data)
	  				$('.close').click();
	              	$('#data').html(data);
	            }
	        });

	  })

  $(document).on('click','#form_submit',function(){
      
      	var login  			= $('#login').val();
      	var logout 			= $('#logout').val();
      	var shop_incharge 	= $('#shop_incharge').val();

      	var address 		=  CKEDITOR.instances['address'].getData() ;
      	var tnc 		    =  CKEDITOR.instances['tnc'].getData() ;

      	var shop_id 		= $('#shop_id').val();
      		var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('update_cashier') }}",
                method: "POST",
                data: {
                    login: login,
                    logout: logout,
                    shop_incharge: shop_incharge,
                    address: address,
                    tnc: tnc,
                    shop_id: shop_id,
                    _token: _token
                },
                success: function(data) {
                  console.log(data)
                  $('#data').html(data);
                }
            });
      	})
</script>