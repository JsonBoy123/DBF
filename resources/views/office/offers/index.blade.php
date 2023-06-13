@extends('layouts.dbf')

@section('content')

<div class="container">
   <div class="row">
      <div class="tab-content">
         <div class="tab-pane fade in active" id="mh_count">
            <div class="row">
               <div class="col-sm-4">
                  <div class="column">
                     <center>
                        <div class="card" style="background-image: linear-gradient(to bottom,#01e6e647, #00c3cc); min-height:200px;">
                           <br>
                           <h3>Dynamic Pricing</h3>
                           <h1><a href="{{ route('view_dynamic_pricing') }}" target="_blank" title="Dynamic Pricing"><span class="fa fa-tags" style="color: white;"></span></a></h1>
                           <br>
                        </div>
                     </center>
                  </div>
               </div>
               <div class="col-sm-4 min_height">
                  <div class="column">
                     <center>
                        <div class="card" style="background: linear-gradient(to bottom,#ccb3006e, #ffcc66);min-height:200px;">
                           <br>
                           <h3>Vouchers</h3>
                           <h1><a href="{{ route('view_vouchers') }}" target="_blank" title="Vouchers"><span class="fa fa-briefcase" style="color: white;"></span></a></h1>
                           <br>
                        </div>
                     </center>
                  </div>
               </div>
               <div class="col-sm-4 min_height">
                  <div class="column">
                     <center>
                        <div class="card" style="background-image: linear-gradient(to bottom,#efb1ab, #f77b7b);background-color: #f77b7b;min-height:200px;">
                           <br>
                           <h3>Purchase Limits</h3>
                           <h1><a href="{{ route('view_purchase_limits') }}" target="_blank" title="Purchase Limits"><span class="fa fa-qrcode" style="color: white;"></span></a></h1>
                           <br>
                        </div>
                     </center>
                  </div>
               </div>

               <div class="col-sm-4 min_height">
                  <div class="column">
                     <center>
                        <div class="card" style="background-image: linear-gradient(to bottom,#efb1ab, #76c2af);background-color: #76c2af;min-height:200px; margin-top: 18px !important;">
                           <br>
                           <h3>Discount On Purchase</h3>
                           <h1><a href="{{route( 'dicount_on_purchase.index' )}}" title="Discount On Purchase"><span class="fa fa-qrcode" style="color: white;"></span></a></h1>
                           <br>
                        </div>
                     </center>
                  </div>
               </div>
               <div class="clearfix" style="margin-top:20px;"></div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection
