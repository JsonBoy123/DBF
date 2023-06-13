<?php //dd(session()->get('available_bal'));  ?>
@if(session('cartCustomer'))
	@foreach(session('cartCustomer') as $id => $sales)

	      <td><b>Total Spent:</b></td><br><br>
		  <td><b> Name:-</b><span id="customer_name">{{ $sales['customer_name'] }}</span></td>
		  <td><input type="hidden" id="customer_id" name="customer_id" value="{{ $id }}"></td>
		<form action="{{ route('customer-cert-destroy',$id) }}" method="POST">
	        @csrf
	        {{-- @method('DELETE') --}}
	        <button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
	    </form>

	    @if(session('available_bal') != null)
	    <?php $available_bal = session()->get('available_bal') ; ?>
	    <div class="row col-12">
	    	<div class="col-md-8" style="margin-top: 12px;">
	    		<label for="paynote" style="float: left" >CREDIT BALANCE </label> 
	    	</div>
	    	<div class="col-md-4" >
	    	<buton class="btn btn-danger btn-sm" id="balanceBtn" data-balance={{$available_bal}}><b style="float: right;">	₹ {{$available_bal}} </b></button>
	    	</div>
	    	<input type="checkbox" name="check_balance" value="" id="check_balance" style="display: none">
	    	<div id="balance_msg" style="display: none; font-size: 18px;margin-top: 7px"><b> ₹ 0</b></div>
	    </div>
	    @endif
	    {{-- @if(!empty(session('paynote_total')))
	    <div class="row col-12">
	    	<div class="col-md-6">
	    		<label for="paynote">PAYNOTE -</label> 
	    	</div>
	    	<div class="col-md-6">
	    		<input class="mt-2" id="paynote" type="checkbox" name="paynote" value="1">
	    	</div>
	    </div>
	    <div class="row col-12">
	    	<div class="col-md-7">
	    		<label for="">PREVIOUS BALANCE - </label>
	    	</div>
	    	<div class="col-md-5">
	    		<label> ₹ {{session('paynote_total')}}</label>
	    		<input type="hidden" name="previous_bal" value="{{session('paynote_total')}}" id="previous_bal">
	    	</div>
	    
	    </div>
	    @endif --}}
	@endforeach
@endif