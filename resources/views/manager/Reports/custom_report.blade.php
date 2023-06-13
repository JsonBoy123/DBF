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
	               <h4><u> Sales Report - Custom format </u></h4>
	            </div>
            </div>
            <div class="row col-md-12" style="padding-top: 20px">
               <div class="col-md-3">
                  <div class="form-group">
                     <select name="location" id="location" class="form-control">
                        <option value="">-- Select Location --</option>
                        @if(!empty($location))
                          @foreach($location as $loc)
                            <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                          @endforeach
                        @endif
                     </select>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <select name="category" id="bill_type" class="form-control">
                        <option value="all">All</option>
                        <option value="credit_note"> Credit Note </option>
                        <option value="invoice"> Invoice </option>
                        
                     </select>
                  </div>
               </div>
               <div class="col-md-2" >
                  <div class="form-group">
                     From <input type="date" name="fromDate" class="form-control">
                  </div>
               </div>
               <div class="col-md-2" >
                  <div class="form-group">
                    To <input type="date" name="toDate" class="form-control">
                  </div>
               </div>	
           </div>
           <div class="row col-md-12" style="padding-top: 30px">
           	<div class="col-md-8">
                 <button class="btn btn-info" id="getSales">Get Sales</button>
           	</div>
           </div>
        </form>
        <hr>
        <div id="table_area"></div>
     </span>
  </div>
</div>

@endsection