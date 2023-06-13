@extends('layouts.dbf')
@section('content')

<div class="container">
  <div class="row">
     <span class="col-md-12">
        <div class="bg-info" style="color:#fff;padding:10px;margin-bottom:20px;">
           <a style="color:#fff" href="#">
              <h4 style="display:inline">Manager</h4>
           </a>
           &gt;&gt; Reports 
        </div>
        <form id="myForm">
            @csrf
            <div class="row" >
            	<div class="col-md-12" style="padding:-10px" align="center">
	               <h4><u> Sales Report - Email format </u></h4>
	            </div>
            </div>
            <div class="row col-md-12" style="padding-top: 20px">
               <div class="col-md-5">
                  <div class="form-group">
                     <input type="email" name="email" class="form-control" placeholder="Enter your email address">
                  </div>
               </div>
               <div class="col-md-5">
                  <div class="form-group">
                     <select name="category" id="bill_type" class="form-control">
                        <option value="">--  select type --</option>
                        <option value="monthly_sales_report"> Monthly sales report </option>
                        <option value="monthly_deleted_report"> Monthly deleted report </option>
                        
                     </select>
                  </div>
               </div>
           </div>
           <div class="row col-md-12" style="padding-top: 30px">
           	<div class="col-md-8">
                 <button class="btn btn-info" id="getSales">Send Email</button>
           	</div>
           </div>
        </form>
        <hr>
        <div id="table_area"></div>
     </span>
  </div>
</div>


@endsection