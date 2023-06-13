@extends('layouts.dbf')

@section('content')
<div class="wrapper">
		<div class="topbar">
			<div class="container">
				<div class="navbar-left">
					<div id="liveclock">13/05/2020 04:44:45 PM</div>
				</div>

				<div class="navbar-right" style="margin:0">
										DBF Main Panel					  |   
					<a href="http://newpos.dbfindia.com/home/logout">Logout</a>					
				</div>

				<div class="navbar-center" style="text-align:center">
					<strong>DBF</strong>
				</div>
			</div>
		</div>

		<div class="navbar navbar-default" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
			
					<a class="navbar-brand hidden-sm" href="http://newpos.dbfindia.com/">
						<img src="http://newpos.dbfindia.com//images/dbflogo.png" width="75" height="45">
					</a>
				</div>

				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
							<li class="active">
								<a href="{{ route('employees.index') }}" title="Employees" class="menu-icon">
								<img id="menuicon_employees" src="http://newpos.dbfindia.com/images/menubar/employees.png" alt="Module Icon" border="0"><br>Employee</a>
							</li>
							<li class="active">
								<a href="{{ route('message.index') }}" title="Messages" class="menu-icon">
								<img id="menuicon_messages" src="http://newpos.dbfindia.com/images/menubar/messages.png" alt="Module Icon" border="0"><br>
									Messages</a>
							</li>
							<li class="">
								<a href="" title="Configuration" class="menu-icon">
								<img id="menuicon_config" src="http://newpos.dbfindia.com/images/menubar/config.png" alt="Module Icon" border="0"><br>Configuration	</a>
							</li>
							<li class="">
								<a href="" title="Offers" class="menu-icon">
								<img id="menuicon_offers" src="http://newpos.dbfindia.com/images/menubar/offers.png" alt="Module Icon" border="0"><br>Offers</a>
							</li>
							<li class="">
								<a href="{{ route('office.index') }}" title="Office" class="menu-icon">
								<img id="menuicon_office" src="http://newpos.dbfindia.com/images/menubar/office.png" alt="Module Icon" border="0"><br>Office</a>
							</li>
						</ul>
				</div>
			</div>
		</div>
 <div class="col-xs-3 mb-2" align="center">
    <p align="center">
      @if($message = Session::get('success'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
      @endif
    </p>
</div>
<div class="container">
<div class="row">
	     
<div class="jumbotron" style="max-width: 60%; margin:auto">

	<form action="{{ route('message') }}" id="send_sms_form" enctype="multipart/form-data" method="post" class="form-horizontal" accept-charset="utf-8" novalidate="novalidate">
    @csrf          
		                                                                             
		<fieldset>
			<legend style="text-align: center;">Send SMS</legend>

			<div class="form-group form-group-sm">
				<label for="phone" class="col-xs-3 control-label">Phone number</label>
				<div class="col-xs-9">
					<input class="form-control input-sm" ,="" type="text" name="phone" placeholder="Mobile Number(s) here...">
					<span class="help-block" style="text-align:center;">(In case of multiple recipients, enter mobile numbers separated by commas)</span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label for="message" class="col-xs-3 control-label">Message</label>
				<div class="col-xs-9">
					<textarea class="form-control input-sm" rows="3" id="message" name="message" placeholder="Your Message here..."></textarea>
				</div>
			</div>

			<input type="submit" name="submit_form" value="Submit" id="submit_form" class="btn btn-primary btn-sm pull-right">
		</fieldset>
	</form></div>

		</div>
	</div>

	<div id="footer">
		<!-- <div class="jumbotron push-spaces"> -->
			<!-- <strong>  			 - </strong>.
						<a href="https://github.com/jekkos/opensourcepos" target="_blank"></a>
			 -->
		<!-- </div> -->
	</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="https://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

<script type="text/javascript">
//validation and submit handling

		
		$("#send_sms_form").validate({
		  errorElement: 'p',
        	errorClass: 'help-inline',
			
    	rules: {

	      
	      	phone:{
		      	required:true,
		      	mobile:true
	      	},
	      	message:{
		      	required:true,
		      	message:true
	      	},
	      
		},
		messages: 
		{
			phone: "Phone Number is a required field.",
			message: "Message is a required field.",
			
			// email: "The email address is not in the correct format."
		},
    
	    
      submitHandler: function(form) {
    	form.submit();
    	}
 });
</script> 
@endsection

</div>