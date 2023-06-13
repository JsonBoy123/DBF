@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row">
      <input type="hidden" id="sale_mode" value="sale">
      <div id="register_wrapper">
         <!-- Top register controls -->
          <marquee style="color:blue;"><b>To generat Bill Now Amount Due should be equal to 0</b></marquee>
         <form id="mode_form" class="form-horizontal panel panel-default sPanel1" method="post" accept-charset="utf-8">
            <div class="col-md-10">
               <span class="successMsg" id="successMsg"></span>
            </div>

            <div class="panel-body form-group sPanel1">
                  <select name="billtype" class="show-menu-arrow" data-style="btn-default btn-sm" data-width="fit" id="billType" >
                     @if(auth()->user()->can('wholesale'))
                     <option value="">Select.. </option>
                     <option {{session('billType') == 'retail' ? 'selected':''}} value="retail">RETAIL</option> 
                     <option {{ session('billType') == 'wholesale' ? 'selected':''}} value="wholesale">WHOLESALE</option> 
                     <option {{session('billType') == 'franchise' ? 'selected':''}} value="franchise">FRANCHISE</option>
                     <option {{session('billType') == 'special' ? 'selected':''}} value="special">SPECIAL APPROVAL</option>
                     <option {{session('billType') == '1rupee' ? 'selected':''}} value="1rupee">1RUPEE</option>
                     @else
                     <option {{session('billType') == 'retail' ? 'selected':''}} value="retail">RETAIL</option> 
                     @endif
                  </select>               
                  <input type="text" value="" id="voucherValue"><button id="voucherBtn">Apply Voucher </button>
               </div>
            <div class="panel-body form-group sPanel1">
               <ul>
                  <li class="pull-right">
                     <div>
                        <select id="selectCashier">
                           <option value="0" >Select Cashier</option>
                           @foreach($cashier as $value)
                           <option value="{{$value->cashier->id}}" {{session('cashier_id') == $value->cashier->id ? 'selected':''}}>{{$value->cashier->name}}</option>

                           @endforeach
                        </select>
                     </div>
                  </li>
               </ul>
            </div>
              
            <div class="panel-body form-group">

               <ul>                  
                  <li class="pull-left first_li">
                     <label class="control-label">Register Mode </label>
                  </li>
                  <li class="pull-left">                       
                        <select name="mode" id="changemode">
                           <option value="sale" selected="selected">Sales Receipt</option>
                           <option value="return" >Return</option>
                        </select>
                  </li>
                  
                  <li class="pull-left">
                     <label class="control-label">Stock Location</label>
                  </li>
                  <li class="pull-left">
                     <div>
                        <select name="stock_location"{{--  onchange="$('#mode_form').submit();" class="selectpicker show-menu-arrow" data-style="btn-default btn-sm" data-width="fit" tabindex="-98" --}} id="stock_location">
                        <option value="">...Select...</option>
                        <?php foreach ($shop as  $value) { ?>
                        <option value="{{$value->shop->id}}" {{get_shop_id_name()->id == $value->shop->id ? 'selected':''}} >{{$value->shop->name}}</option>
                        <?php } ?>
                        </select>
                     </div>
                  </li>             
                  <!-- <li class="pull-right">
                     <a class="btn btn-primary btn-sm" id="add_person" title="Daily Sales"><span class="glyphicon glyphicon-list-alt">&nbsp;</span>Add Person</a>       
                  </li> -->
                     
                  <li class="pull-right">
                     <a href="{{route('daily-sales.index')}}" class="btn btn-primary btn-sm" id="sales_takings_button" title="Daily Sales" target="blank"><span class="glyphicon glyphicon-list-alt">&nbsp;</span>Daily Sales</a>              
                  </li>
               </ul>
            </div>
         </form>
         <form id="add_item_form" class="form-horizontal panel panel-default sPanel2" method="post" accept-charset="utf-8">
            <div class="panel-body form-group">
               <ul>
                  <li class="pull-left first_li">
                     <label for="item" ,="" class="control-label">Find or Scan Item...</label>
                  </li>
                  <li class="pull-left">
                  
                  <input type="text" name="barcode" value="" placeholder="Start typing Item Name or scan Barcode..." id="item" class="form-control input-sm ui-autocomplete-input" size="50" tabindex="1" autocomplete="off" {{session()->has('paynote') == true ? 'disabled' : ''}}>

                        <input type="hidden" name="status" value="1">
                   <span class="ui-helper-hidden-accessible" role="status"></span>
                            <div id="itemList"></div>
                  </li>
                  <li class="pull-right" style="font-weight:bold; font-size:1.2em">
                            <label class="total_qty" value=""></label></li>
               </ul>
            </div>
         </form>
         <!-- Sale Items List -->
         <table class="sales_table_100" id="register">
            <thead>
               <tr>
                  <th style="width: 5%;">Delete</th>
                  <th style="width: 15%;">Item #</th>
                  <th style="width: 35%;">Item Name</th>
                  <th style="width: 10%;">Price</th>
                  <th style="width: 10%;">Quantity</th>
                  <th style="width: 10%;">Disc %</th>
                  <th style="width: 10%;">Total</th>
                  <!-- <th style="width: 5%;"></th> -->
               </tr>
            </thead>
            <tbody id="cart_contents">
               <tr>
                  <td colspan="8">
                     @include('sales.sales-items-display')
                  </td>
               </tr>
            </tbody>
         </table>
         <div style="display: none" id="special_discount" class="mt-3"> 
         <br>          
            <div class="row" >
               <div class="col-sm-3">
                  
               </div>
               <div class="col-sm-3">
                  
               </div>
               <div class="col-sm-1">    
               </div>
               <div class="col-sm-5">
                  <table>
                     <tr>
                        <th> 
                           <select class="discount_type" name="discount_type" id="discount_type">
                              <option value="0">Select Discount Type</option>
                              <option value="damage">Damage</option>
                              <option value="special">Small Issue</option>
                              <option value="refrence">In Complete</option>
                              <option value="other">Other</option>
                           </select>
                        </th>
                        <th>
                           <input type="number" class="input-sm form-control half_tot" disabled="true" name="amount" id="amount">
                        </th>
                     </tr>                    
                     <tr>
                        <th>  <label>Remark </label></th>
                        <th>
                           <textarea type="" disabled="true" class="input-sm form-control" name="remark" id="remark" required></textarea>
                          <p>This Field is mandatory</p>
                        </th>
                     </tr>

                  </table>                
               </div>
              
            </div>
         </div> 

{{--  broker adding tab  --}}
         
         <div style="display: none" id="adding_broker" class="mt-3">
         <br>           
            <div class="row" >
               <div class="col-sm-8"></div>
               <div class="col-sm-4">
                  <table>
                     <tr>                        
                        <th>
                           <select name="person_id" id="broker_id" class="form-control">
                              <option value="">Select Person...</option>
                              @foreach($data as $Data)
                                 <option value="{{$Data->id}}">{{$Data->name}}</option>
                              @endforeach 
                           </select>
                        </th>
                     </tr>                    
                     <tr>
                        <th>
                           <a class="fa fa-plus text-success" id="addmore"></a>
                           <div id="total_div">
                               <input type="text" class="input-sm form-control" placeholder="Enter Barcode" name="barcode[]" id="commission_barcode">
                           </div>
                        </th>
                     </tr>

                  </table>                
               </div>
              
            </div>
         </div>   
      </div>
      <!-- Overall Sale -->
      <div id="overall_sale" class="panel panel-default">
         <div class="panel-body">
            <section></section>
            @if(session('cartCustomer'))
            @else
            <div class="form-group" id="select_customer">
               <label id="customer_label" for="customer" class="control-label" style="margin-bottom: 1em; margin-top: -1em;">Select Customer</label>
               <input type="text" name="customer" value="Start typing customer details..." id="customer" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
               <div id="customerList"></div>
               <div class="hide_button">
                  <button class="btn btn-info btn-sm modal-dlg" title="New Customer" data-toggle="modal" data-target="#addCustomer">
                  <span class="glyphicon glyphicon-user">&nbsp;</span>New Customer</button>
               </div>
            </div>
            @endif    
            @include('sales.customer-display')
            
            <p id="customer_cert"></p>

            @if(session('item'))
            <?php 
                  $sum = 0;
                  $itemId = '';
                  $IGST = 0;
                  $CGST = 0;
                  $SGST = 0;
                  $CGSTAMT = 0;
                  $SGSTAMT = 0;
                  $CGSTAMT18 = 0;
                  $SGSTAMT18 = 0;
                  $CGSTAMT12 = 0;
                  $SGSTAMT12 = 0;
                  $CGSTAMT28 = 0;
                  $SGSTAMT28 = 0;

                  foreach(session('item') as $id => $value){                     
                     
                     $dic=$value['unit_price'] - ((float)$value['unit_price']/100)*(float)$value['discounts'];
                   
                     if($value['unit_price'] ==00){
                        $dic = $value['discounts'];
                     }                 
                     $total = $sum * ($value['quantity']);
                     $total1 = $sum * $value['quantity'];
                       '<span id="items_id" >'.$id.'</span>';  

                     $CGST = $value['ItemTax']->CGST ;  
                     $SGST = $value['ItemTax']->SGST ;  

                     if($SGST==9){
                        $SGSTAMT18 +=  (( $dic/ (100+((float)$value['ItemTax']->SGST*2) ))* (float)$value['ItemTax']->SGST) * $value['quantity'] ; 


                        $CGSTAMT18 += ( ($dic / (100 +((float)$value['ItemTax']->CGST*2) ))*(float)$value['ItemTax']->CGST ) * $value['quantity'];  
                     }
                     if($SGST== 2.5){
                        $SGSTAMT +=  ( ($dic / (100 + ((float)$value['ItemTax']->SGST*2)))*(float)$value['ItemTax']->SGST) * $value['quantity'] ;                 
                        $CGSTAMT += ( ($dic/(100+ ((float)$value['ItemTax']->CGST*2)))*(float)$value['ItemTax']->CGST ) * $value['quantity'];                 
                     }

                     if($SGST==14){
                        $SGSTAMT28 +=  ( ($dic/(100+((float)$value['ItemTax']->SGST*2)))*(float)$value['ItemTax']->SGST) * $value['quantity'] ;                 
                        $CGSTAMT28 += ( ($dic/(100+((float)$value['ItemTax']->CGST*2)))*(float)$value['ItemTax']->CGST ) * $value['quantity'];                 
                     }

                     if($SGST==6){
                        $SGSTAMT12 +=  ( ($dic/(100+((float)$value['ItemTax']->SGST*2)))*(float)$value['ItemTax']->SGST) * $value['quantity'] ;                 
                        $CGSTAMT12 += ( ($dic/(100+((float)$value['ItemTax']->CGST*2)))*(float)$value['ItemTax']->CGST ) * $value['quantity'];                 
                     }
                  }
               ?>
            <table class="sales_table_100" id="sale_totals">
               <tbody>
                  <!-- <tr>
                     <th style="width: 55%;" >Avalable Balance </th>
                     <th style="width: 45%; text-align: right;" >₹&nbsp;

                        @if(session('available_bal')) 
                           {{session('available_bal')}}
                        @endif
                     </th>
                  </tr> -->
                  <tr>
                     <th style="width: 55%;">Quantity of <?php $itemsum = 0; foreach(session('item') as $id => $sales){ $itemsum++; }?>{{ $itemsum}} Items</th>
                     <th style="width: 45%; text-align: right;"><?php $itemsum = 0; foreach(session('item') as $id => $sales){ $itemsum += $sales['quantity']; }?>{{$itemsum}} </th>
                  </tr>
                  <tr>
                     <th style="width: 55%;" >Subtotal</th>
                     <th style="width: 45%; text-align: right;" >₹&nbsp;<?php $totalAmount = session()->get('totalAmount'); 
                        echo number_format($totalAmount-($SGSTAMT+$CGSTAMT+$SGSTAMT18+$CGSTAMT18+$SGSTAMT12+$CGSTAMT12+$SGSTAMT28+$CGSTAMT28 ),2);
                     ?></th>
                  </tr>
                  
                  <!-- <tr class="igst_taxes">
                     <th style="width: 55%;">{{ $IGST }}% IGST</th>
                     <th style="width: 45%; text-align: right;">₹&nbsp; <?php echo $IGST = $totalAmount/100*$IGST; ?></th>
                  </tr> -->
                  <div >
                  <?php if($SGSTAMT !=0){ ?>
                     <tr class="gst_taxess">
                        <th style="width: 55%;">2.5% SGST</th>
                        <th style="width: 45%; text-align: right;">₹&nbsp; <?php echo number_format($CGSTAMT,2); ?></th>
                     </tr>

                     <?php } if($SGSTAMT !=0){ ?>
                     <tr class="gst_taxess">
                        <th style="width: 55%;">2.5% CGST</th>
                        <th style="width: 45%; text-align: right;">₹&nbsp; <?php echo number_format($CGSTAMT,2); ?></th>
                     </tr>
                     <?php } 

                     if($SGSTAMT12 !=0){ ?>
                     <tr class="gst_taxes1s">
                        <th style="width: 55%;">6% SGST </th>
                        <th style="width: 45%; text-align: right;">₹&nbsp;<?php echo number_format($SGSTAMT12,2);?></th>
                     </tr>
                     <?php } if($CGSTAMT12 !=0){ ?>
                     <tr class="gst_taxes1s">
                        <th style="width: 55%;">6% CGST </th>
                        <th style="width: 45%; text-align: right;">₹&nbsp;<?php echo number_format($SGSTAMT12,2);?></th>
                     </tr>
                     <?php } ?>

                <?php  if($SGSTAMT18 !=0){ ?>
                     <tr class="gst_taxes1s">
                        <th style="width: 55%;">9% SGST </th>
                        <th style="width: 45%; text-align: right;">₹&nbsp;<?php echo number_format($SGSTAMT18,2);?></th>
                     </tr>
                     <?php } if($CGSTAMT18 !=0){ ?>
                     <tr class="gst_taxes1s">
                        <th style="width: 55%;">9% CGST </th>
                        <th style="width: 45%; text-align: right;">₹&nbsp;<?php echo number_format($SGSTAMT18,2);?></th>
                     </tr>
                     <?php } ?>

                      <?php  if($SGSTAMT28 !=0){ ?>
                     <tr class="gst_taxes1s">
                        <th style="width: 55%;">14% SGST </th>
                        <th style="width: 45%; text-align: right;">₹&nbsp;<?php echo number_format($SGSTAMT28,2);?></th>
                     </tr>
                     <?php } if($CGSTAMT28 !=0){ ?>
                     <tr class="gst_taxes1s">
                        <th style="width: 55%;">14% CGST </th>
                        <th style="width: 45%; text-align: right;">₹&nbsp;<?php echo number_format($SGSTAMT28,2);?></th>
                     </tr>
                     <?php } ?>
                  </div>
                  <tr>
                     <th style="width: 55%;">Total </th>
                     <th style="width: 45%; text-align: right;"><span>₹&nbsp;{{ number_format($totalAmount,2) }}</span></th>
                  </tr>
               </tbody>
            </table>
            <table class="sales_table_100" id="payment_totals">
               <tbody>
                  <tr>
                     <th style="width: 55%;">Payments Total</th>
                     <th style="width: 45%; text-align: right;" id="payment_total">₹&nbsp;0</th>
                     <input type="hidden" id="payment_total_credit" value="0" >
                  </tr>
                  <tr>
                     <th style="width: 55%;">Amount Due</th>
                     <th style="width: 45%; text-align: right;">₹&nbsp;<span id="sale_amount_due1">{{ number_format($totalAmount,2) }}</span></th>
                  </tr>
               </tbody>
            </table>
            <div id="payment_details">
               <form id="add_payment_form" class="form-horizontal" method="post" accept-charset="utf-8">
                  <input type="hidden" name="csrf_ospos_v3" value="14516c71ad8d9820b0440dbc36bf405d">                 
                  <table class="sales_table_100">
                     <tbody>
                        {{-- <tr>
                           <td>Half Payment</td>
                           <td><input type="checkbox" id="check_half" value="0" name="check_half"></td>
                        </tr> --}}
                       
                        {{-- <tr class="default_pay">
                           <td>Payment Type</td>
                           <td>
                              <div class="">
                                 <select name="payment_type" id="payment_types">
                                 <option value="Cash">Cash</option>
                                 <option value="Debit Card">Debit Card</option>
                                 <option value="Credit Card">Credit Card</option>
                                 <option value="PayTM">Paytm/UPI</option>
                                 @if(session()->has('paynote'))
                                    <option value="Credit Note" selected="">Credit Note</option>
                                 @endif
                                 </select>
                              </div>
                           </td>
                        </tr> --}}
                        <tr>
                           <td>Add Reference</td>
                           <td><input type="checkbox" id="add_broker" value="1" name="check_half"></td>
                        </tr>
                         <tr>
                           <td>Other Discounts</td>
                           <td><input type="checkbox" id="other_discounts" value="0" name="check_half"></td>
                        </tr>
                        <tr class="half">
                           <td> 
                              <div><span>Cash</span></div>   
                           </td>
                           <td><input type="number" style="width: 80px" class="half_tot"  id="half_case" ></td>
                        </tr>   
                         <tr class="half">
                           <td><span>Credit Card</span></td>
                           <td><input class="half_tot" style="width: 80px" type="number" id="half_credit" ></td>
                           <td><input style="width: 80px" type="text" id="half_credit_number" placeholder="Card number"></td>
                        </tr> 
                         <tr class="half" >
                           <td><span>Debit Card</span></td>
                           <td><input class="half_tot" style="width: 80px" type="number" id="half_debit"></td>
                           <td><input style="width: 80px" type="text" id="half_debit_number" placeholder="Card number"></td>
                        </tr> 
                        <tr class="half">
                           <td><span>Paytm/UPI</span></td>
                           <td><input class="half_tot" style="width: 80px" type="number" id="half_paytm"></td>
                           <td><input style="width: 80px" type="text" id="half_paytm_number" placeholder="UPI number"></td>
                        </tr>
                        <tr class="half">
                           <td><span>Cheque</span></td>
                           <td><input class="half_tot" style="width: 80px" type="number" id="cheque"></td>
                           <td><input style="width: 80px" type="text" id="cheque_number" placeholder="cheque number"></td>
                        </tr>
                           @php  
                              $amount = round((float)$totalAmount - (session('voucher_amount') != null ? (float)session('voucher_amount'):0));
                           @endphp  
                        <tr>
                        @php $last_pay = session('last_payment') == true ? $amount : 0; 
                           $due_amount =  $amount - round($last_pay);
                        @endphp
                           <td><span>Amount Due</span></td>
                           <td colspan="2">
                              <input type="" readonly="true" class="form-control input-sm non-giftcard-input" name="remaning_amount" id='remaning_amount' value="{{session('billType') != '1rupee' ? $due_amount :1}}">
                           </td>
                        </tr>

                        <tr>
                           <td><span id="amount_tendered_label">Amount Tendered </span></td>                     
                           <td colspan="2">  
                           
                              <input type="text" readonly="" name="amount_tendered" value="{{session('billType') != '1rupee' ? $amount :1}}" id="amount_tendered1" class="form-control input-sm non-giftcard-input" size="5" tabindex="5" onclick="this.select();">

                              {{-- used for salePayment --}}
                              <input type="text" name="amount_tendered" value="{{number_format($totalAmount,2)}}" id="amount_tendered" class="form-control input-sm giftcard-input ui-autocomplete-input" disabled="disabled" size="5" tabindex="6" autocomplete="off">
                              {{-- used for salePayment --}}
                           </td>
                           
                        </tr>
                        
                        <tr>
                           <td>Comment/Remark</td>
                           <td colspan="2"><textarea rows="2" id="sale_comment" class="form-control" placeholder="Regarding comment..."></textarea>
                           </td>
                        </tr>
                        @permission('wholesale')
                        {{-- <tr>
                           <td>Add Account</td>
                           <td><input type="checkbox" id="account_check" value="1" name="account_check"></td>
                           
                        </tr> --}}
                        
                        @endpermission
                     </tbody>
                  </table>
               </form>
               <button class="btn btn-sm btn-success pull-right" id="add_payment_button" onclick="add_payment_button();" tabindex="7" disabled=""><span class="glyphicon glyphicon-credit-card" disabled>&nbsp;</span>Add Payment</button>
               
               </div>
               <form action="" id="buttons_form" method="post" accept-charset="utf-8">
                  <div class="form-group" id="buttons_sale">
                     <a href="{{route('remove_session')}}" class="btn btn-sm btn-danger pull-right" id="cancel_sale_button"><span class="glyphicon glyphicon-remove">&nbsp;</span>Cancel</a>
                  </div>
               </form>
         </div>
      </div>
      @else
      <table class="sales_table_100" id="sale_totals">
         <tbody>
            <tr>
               <th style="width: 55%;">Quantity of 0 Items</th>
               <th style="width: 45%; text-align: right;">0</th>
            </tr>
            <tr>
               <th style="width: 55%;">Subtotal</th>
               <th style="width: 45%; text-align: right;">₹&nbsp;0</th>
            </tr>
            <tr>
               <th style="width: 55%;">Total</th>
               <th style="width: 45%; text-align: right;"><span id="sale_total">₹&nbsp;0</span></th>
            </tr>
         </tbody>
      </table>
      @endif
   </div>
</div>


<div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header" >
            <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
               <div class="bootstrap-dialog-message">
                  <div>
                     <div id="required_fields_message">Fields in red are required</div>
                     <ul id="error_message_box" class="error_message_box"></ul>
                     <form id="customer_form" class="form-horizontal" method="post" accept-charset="utf-8" novalidate="novalidate" action="{{ route('add-customer') }}" >
                        @csrf
                        <ul class="nav nav-tabs nav-justified" data-tabs="tabs">
                           <li class="active" role="presentation">
                              <a data-toggle="tab" href="#customer_basic_info">Information</a>
                           </li>
                        </ul>
                        <div class="tab-content">
                           <div class="tab-pane fade in active" id="customer_basic_info">
                              <fieldset>
                                 <div class="form-group form-group-sm">
                                    <label for="first_name" class="required control-label col-xs-3" aria-required="true">First Name</label>  
                                    <div class="col-xs-8">
                                       <input type="text" name="first_name" value="" id="first_name" class="form-control input-sm">
                                    </div>
                                 </div>
                                 @error('first_name')
                                 <span class="text-danger" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                                 <div class="form-group form-group-sm">
                                    <label for="last_name" class="required control-label col-xs-3" aria-required="true">Last Name</label> 
                                    <div class="col-xs-8">
                                       <input type="text" name="last_name" value="" id="last_name" class="form-control input-sm">
                                    </div>
                                 </div>
                                 @error('last_name')
                                 <span class="text-danger" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                                 <div class="form-group form-group-sm">
                                    <label for="gender" class="control-label col-xs-3">Gender</label> 
                                    <div class="col-xs-4">
                                       <label class="radio-inline">
                                       <input type="radio" name="gender" value="1" id="gender">
                                       M    </label>
                                       <label class="radio-inline">
                                       <input type="radio" name="gender" value="0" id="gender">
                                       F    </label>
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="email" class="control-label col-xs-3">Email</label>   
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-envelope"></span></span>
                                          <input type="text" name="email" value="" id="email" class="form-control input-sm">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="phone_number" class="required control-label col-xs-3" aria-required="true">Phone Number</label> 
                                    <div class="col-xs-8">
                                       <div class="input-group">
                                          <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-phone-alt"></span></span>
                                          <input type="text" name="phone_number" value="" id="phone_number" class="form-control input-sm">
                                       </div>
                                    </div>
                                 </div>
                                 @error('phone_number')
                                 <span class="text-danger" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                                 <div class="form-group form-group-sm">
                                    <label for="address_1" class="control-label col-xs-3">Address 1</label> 
                                    <div class="col-xs-8">
                                       <input type="text" name="address_1" value="" id="address_1" class="form-control input-sm">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="address_2" class="control-label col-xs-3">Address 2</label> 
                                    <div class="col-xs-8">
                                       <input type="text" name="address_2" value="" id="address_2" class="form-control input-sm">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="city" class="control-label col-xs-3">City</label>  
                                    <div class="col-xs-8">
                                       <input type="text" name="city" value="" id="city" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="state" class="control-label col-xs-3">State</label>   
                                    <div class="col-xs-8">
                                       <input type="text" name="state" value="" id="state" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="zip" class="control-label col-xs-3">Postal Code</label>  
                                    <div class="col-xs-8">
                                       <input type="text" name="zip" value="" id="postcode" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="country" class="control-label col-xs-3">Country</label>  
                                    <div class="col-xs-8">
                                       <input type="text" name="country" value="" id="country" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="comments" class="control-label col-xs-3">Comments</label>   
                                    <div class="col-xs-8">
                                       <textarea name="comments" cols="40" rows="10" id="comments" class="form-control input-sm"></textarea>
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="company_name" class="control-label col-xs-3">Company</label>               
                                    <div class="col-xs-8">
                                       <input type="text" name="company_name" value="" id="company_name" class="form-control input-sm">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                    <label for="gstin" class="control-label col-xs-3">GSTIN</label>               
                                    <div class="col-xs-8">
                                       <input type="text" name="gstin" value="" id="gstin" class="form-control input-sm">
                                    </div>
                                 </div>
                                 <div class="form-group form-group-sm">
                                <label for="ifsc_code" class="control-label col-xs-3">IFSC Code</label><div class="col-xs-8">
                                   <input type="text" name="ifsc_code" value="" id="ifsc_code" class="form-control input-sm">
                                </div>
                              </div>
                              <div class="form-group form-group-sm">
                                <label for="customer_type" class="control-label col-xs-3">Type </label><div class="col-xs-4">
                                  <select name="customer_type" class="show-menu-arrow" id="customer_type">
                                    <option value="">Select Type</option>
                                    <option value="employee">EMPLOYEE</option>
                                    <option value="wholesale">WHOLESALE</option> 
                                    <option value="franchise">FRANCHISE</option>
                                    <option value="retail">RETAIL</option>
                                  </select>
                                </div>
                            </div>
                                 <div class="form-group form-group-sm">
                                    <label for="account_number" class="control-label col-xs-3">Account #</label>              
                                    <div class="col-xs-4">
                                       <input type="text" name="account_number" value="" id="account_number" class="form-control input-sm">
                                    </div>
                                 </div>
                                 <input type="hidden" name="taxable" value="1">
                              </fieldset>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-primary" id="submit">Add Customer</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="showInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header" >
            <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
            <button type="button" class="close" id="close_invoice" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
               <div class="bootstrap-dialog-message">                                
                     <div id="invoice">
                        
                     </div>   
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="showBrok" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header" >
            <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
            <button type="button" class="close" id="close_invoice" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
               <div class="bootstrap-dialog-message">                                
                     <div id="brocker">
                        
                     </div>   
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $item = session('item');
   $var = array(
       'qwe' => 'asd',
       'asd' => array(
           1 => 2,
           3 => 4,
       ),
       'zxc' => 0,
   );
?>

{{-- End Code for add customers ......................... --}}
<!-- <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link> -->
<!-- <script src="jquery-3.5.1.min.js"></script> -->
<!-- <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script> -->
<script type="text/javascript">
  
 //Credit Note  Balance

 var glob_credit = 0;


 var glob = "{{session('mytest') == null ? 0 :session('mytest') }}"; 
 
 $(document).on('click', '#balanceBtn', function(e){    

   var creditBal = $(this).data('balance').toString().replace(new RegExp(',', 'g'), '')
   var amounTendered1 = $('#amount_tendered1').val().toString().replace(new RegExp(',', 'g'), '')


   if(parseFloat(amounTendered1) >= parseFloat(creditBal) ){

       var finalAmount = amounTendered1 - creditBal

      //$('#amount_tendered1').val(finalAmount)
      $('#remaning_amount').val(finalAmount)
      $('#balanceBtn').hide()
      $('#balance_msg').show()
      $('#payment_total').text('- ₹ '+creditBal)
      $('#payment_total_credit').val(creditBal)
      $('#check_balance').attr('checked', true)
      $('#check_balance').val(1)

      glob_credit = '{{session('available_bal') == true ? session('available_bal') : 0 }}'

   }else{

      alert('Amount due must be greater than Credit Balance.')
      $('#amount_tendered1').val(amounTendered1)
     
   }
 })

 // Add Vouchers

   $(document).on('click', '#voucherBtn', function(e){
      event.preventDefault()
      var voucher_code = $('#voucherValue').val()

      $.ajax({
         url: "{{route('apply.voucher')}}",
         method: "post",
         data: {'voucher_code': voucher_code},
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         success: function(res){
            location.reload()
         },
         error: function(jqXHR, textStatus, errorThrown) {
            alert('Voucher Already Used');
         }
      })

   })

   $(document).ready(function() {

    $('#selectCashier').on('change', function() {
        var cashier_id = $(this).val();
        var stock_location = $('#stock_location').val();       
        alert(stock_location)
        var _token = $('input[name="_token"]').val();
        if(cashier_id !=0){
         var webkey = prompt("Enter your secure webkey:");

           $.ajax({
               url: "{{ route('cashier_auth') }}",
               method: "POST",
               data: {
                   'cashier_id': cashier_id,
                   'webkey': webkey,
                   'stock_location': stock_location,
                   _token: _token
               },
               success: function(data) {
                   if (data == "success") {                       
                       window.location.href = "sales";
                   } else {
                     alert("Incorrect Webkey");
                     window.location.href = "sales";
                   }
               }
        });
        }
    });

   

    $('#lock_bill').on('click', function() {
        var lock_bill1 = $('#lock_bill1').val();
        $("#register_wrapper *").prop('disabled', true);
        $("#overall_sale *").prop('disabled', true);
    });

     var counter = 0;

    $(document).on('keyup ,click','#item',function(e) {
        var query = $(this).val();        
        var mode = $('#changemode').val();        
        var _token = $('input[name="_token"]').val();
        if (e.keyCode == 13 || e.keyCode == 8 && query !='') {
        
         // setInterval(function () {         
        // clearTimeout(500);
         if(mode != 'return'){
           if (query != '') {
               $.ajax({
                   url: "{{ route('get-sale-item') }}",
                   method: "POST",
                   data: {
                       query: query,
                       _token: _token
                   },
                   success: function(data) {
                     console.log(data);
                       $('#itemList').fadeIn();
                       $('#itemList').html(data);
                   }
               });
           } else {
               $('#itemList').fadeOut();
           }
        }
        else{
            $.ajax({
                   url: 'return_item/'+query,
                   method: "get",                   
                   success: function(data) {
                      location.reload()
                     // alert(data)
                   },error: function(jqXHR, textStatus, errorThrown) {
                        alert('Credit note can not be generated on this bill.')
                  }
               });
        }
     }
        // }, 2000);
    });

    // $('#item').keyup(function() {
    //     var query = $(this).val();
    //     // alert('query');
    //     if (query != '') {
    //         var _token = $('input[name="_token"]').val();
    //         $.ajax({
    //             url: "{{ route('get-receiving-item') }}",
    //             method: "POST",
    //             data: {
    //                 query: query,
    //                 _token: _token
    //             },
    //             success: function(data) {
    //                 $('#itemList').fadeIn();
    //                 $('#itemList').html(data);
    //             }
    //         });
    //     } else {
    //         $('#itemList').fadeOut();
    //     }
    // });
    $(document).on('click', '#selectLI', function() {
        $('#item').val($(this).text());
        $('#itemList').fadeOut();
        var value = $('#item').val();
        var res = value.split("|");
        var final = res[1];
        var item = 'item';
        var billType = $('#billType').val();
        if (final != '') {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('sales.store') }}",
                method: "POST",
                data: {
                    item_name: final,
                    billType: billType,
                    item: item,
                    _token: _token
                },
                success: function(data) {
                    $('#item').val('');
                    $('#cart_contents').empty().html(data);
                    $('.load-cls').hide();
                    $('#finish_sale').show();
                   // if(glob != 'true'){
                  
                     window.location.reload();
                    // }
                }
            });
        }
    });
    $('#item').focus();
    $('#item').keypress(function(e) {
        if (e.which == 13) {
            // $('#add_item_form').submit();
            return false;
        }
    });
    $('#item').blur(function() {
        $(this).val("Start typing Item Name or scan Barcode...");
    });
    var clear_fields = function() {
        if ($(this).val().match("Start typing Item Name or scan Barcode...|Start typing customer details...")) {
            $(this).val('');
        }
    };

    $('#customer').keyup(function() {
      // alert("ewyt");
        var query = $(this).val();
        var mybill = $('#billType').val();

        if (query != '') {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('get-customer') }}",
                method: "POST",
                data: {
                    customer_name: query,
                    billtype: mybill,
                    _token: _token
                },
                success: function(data) {
                    $('#customerList').fadeIn();
                    $('#customerList').html(data);
                }
            });
        } else {
            $('#customerList').fadeOut();
        }
    });
    $(document).on('click', '#selectCustomerLi', function() {
        $('#customer').val($(this).text());
        $('#customerList').fadeOut();
        var value = $(this).attr('data-id');
        var customer = 'customer';
        if (value != '') {
            var _token = $('input[name="_token"]').val(); 
            $.ajax({
                url: "{{ route('store-customer') }}",
                method: "POST",
                data: {
                    query_string: value,
                    customer: customer,
                    _token: _token
                },
                success: function(data) {
                    $('#customer').val('');
                    $('#customer_cert').empty().html(data);
                    $('.load-cls').hide();
                    $('#finish_sale').show();
                    window.location.reload();
                    $('#select_customer').css('display', 'none');
                }
            });
        }
    });
    $('#item, #customer').click(clear_fields).dblclick(function(event) {
        $(this).autocomplete("search");
    });
    $('#customer').blur(function() {
        $(this).val("Start typing customer details...");
    });
      

    $("#payment_types").change(check_payment_type).ready(check_payment_type);
    $("#cart_contents input").keypress(function(event) {
        if (event.which == 13) {
            $(this).parents("tr").prevAll("form:first").submit();
        }
    });
});

function check_payment_type() {
    var cash_rounding = "0";
    if ($("#payment_types").val() == "Gift Card") {
        $("#sale_total").html("₹ 0");
        $("#sale_amount_due").html("₹ 0");
        $("#amount_tendered_label").html("Gift Card Number");
        $("#amount_tendered:enabled").val('').focus();
        $(".giftcard-input").attr('disabled', false);
        $(".non-giftcard-input").attr('disabled', true);
        $(".giftcard-input:enabled").val('').focus();
    } else if ($("#payment_types").val() == "Cash" && cash_rounding) {
        $("#sale_total").html("₹ 0");
        $("#sale_amount_due").html("₹ 0");
        $("#amount_tendered_label").html("Amount Tendered");
        $("#amount_tendered:enabled").val('0');
        $(".giftcard-input").attr('disabled', true);
        $(".non-giftcard-input").attr('disabled', false);
    } else {
        $("#sale_total").html("₹ 0");
        $("#sale_amount_due").html("₹ 0");
        $("#amount_tendered_label").html("Amount Tendered");
        $("#amount_tendered:enabled").val('0');
        $(".giftcard-input").attr('disabled', true);
        $(".non-giftcard-input").attr('disabled', false);
    }
}
</script>

<script>

   $(document).bind("contextmenu",function(e) {
 e.preventDefault();
}); 
   
   var check_qty = 0;
   $('.load-cls').hide();
   function myFunction(id,total) {
      var qty = $('#chngQty'+id).val();
      var _token = $('input[name="_token"]').val();
      var check = total - qty;
       check_qty = check
      if(check >=0){
         $.ajax({
          url:"{{ route('updatSaleItemeQty') }}",
          method:"POST",
          data:{quantity:qty, id:id, _token:_token},
          success:function(data){
            setTimeout(function(){
               $('#loading'+id).show();
            }, 1000);
            setTimeout(function(){
               $('#loading'+id).hide();
              }, 3000);
            window.location.reload();
          }
        });
      }
      else{
         alert(qty+' Quantity Not availeble in stock for this item...' )
      }
   }

   function UpdateDiscount(id) {
      var disc = $('#Disco'+id).val();
      var _token = $('input[name="_token"]').val();
      
      if(disc >=0){
         $.ajax({
          url:"{{ route('percentage_update') }}",
          method:"POST",
          data:{disc:disc, id:id, _token:_token},
          success:function(data){
            setTimeout(function(){
               $('#loading'+id).show();
            }, 1000);
            setTimeout(function(){
               $('#loading'+id).hide();
              }, 3000);
            window.location.reload();
          }
        });
      }
      else{
        alert(qty+' Quantity Not availeble in stock for this item...' )
     }
   }                


   function add_payment_button(){  
      //var add_broker = $('#add_broker').val();
      //alert(add_broker);    
      var c = confirm("Click OK to continue?");
      if(c){

        var amount_tendered1 = $('#amount_tendered1').val();
        var remaning_amount = $('#remaning_amount').val();
        var selectCashier = $('#selectCashier').val();
        var customer_name = $('#customer_name').text();
        var sale_amount_due1 = $('#sale_amount_due1').text();
        //var payment_types = $('#payment_types').val();
        var stock_location = $('#stock_location').val();
        var items_id = $('#items_id').text();
        var sgst_cght_sub_total = $('#sub_total').text();
        var igst_sub_total = $('#igst_sub_total').text();
        var customer_id = $('input#customer_id').val();
        var discount_type = $('#discount_type').val();  
        var amount = $('#amount').val();  
        var remark = $('#remark').val();
        var add_broker = $('#add_broker').val();
        var broker_id = $('#broker_id').val();
        var commission_barcode = $("input[name='barcode[]']").map(function(){return $(this).val();}).get();

         
        // alert([typeof(add_broker), typeof(broker_id), commission_barcode])
        
        var sale_comment = $('#sale_comment').val();
        var half_case = $('input#half_case').val();
        var half_paytm = $('input#half_paytm').val();
        var half_debit = $('input#half_debit').val();
        var half_credit = $('input#half_credit').val();
        var cheque_amt = $('input#cheque').val();

        var half_credit_number = $('input#half_credit_number').val();
        var half_debit_number = $('input#half_debit_number').val();
        var half_paytm_number = $('input#half_paytm_number').val();
        var cheque_number = $('input#cheque_number').val();
       
      
        var check_half = 0;
        var billType = $('#billType').val();
        var payment_total_credit = $('#payment_total_credit').val()
        /*********/
        var check_balance = $('#check_balance').val() == 1 ? 1 : 0
        /*********/
        var voucheramount = {{session('voucher_amount') != null ? session('voucher_amount') : -1}};

// console.log(billType+'-'+payment_total_credit+'-'+check_balance+'-'+voucheramount);exit();
         if($('#check_half').is(':checked')){
            check_half = 1;
         }

         else{
            check_half = 0;
         }
        
        if (customer_name == '') {
            alert('Select customer');
        }

        else if (selectCashier == 0) {
            alert('Select Cashier');
        }
        else if({{ session('item') !=null ? $totalAmount:0}} < voucheramount && voucheramount != -1)
        {
            alert('Billing Amount should be greater then voucher amount');
        }
        // console.log("rwr");exit;
         else {
             // alert("test");
             // console.log("rwrewtw");exit;
            $.ajax({
                method: "POST",
                url: 'sales-manage',
                data: {
                    amount_tendered1: amount_tendered1,
                    remaning_amount: remaning_amount,
                    customer_name: customer_name,
                    sale_amount_due1: sale_amount_due1,
                    //bill_type: payment_types,
                    selectCashier: selectCashier,
                    stock_location: stock_location,
                    customer_id: customer_id,
                    sgst_cght_sub_total: sgst_cght_sub_total,
                    cashier_id: selectCashier,
                    half_case: half_case,
                    half_paytm: half_paytm,
                    cheque_amt: cheque_amt,
                    half_debit: half_debit,
                    half_credit: half_credit,
                    half_credit_number: half_credit_number,
                    half_debit_number: half_debit_number,
                    half_paytm_number: half_paytm_number,
                    cheque_number: cheque_number,
                    discount_type: discount_type,
                    amount: amount,
                    remark: remark,
                    add_broker: add_broker,
                    broker_id: broker_id,
                    commission_barcode: commission_barcode,
                    sale_comment: sale_comment,
                    sale_type:billType,
                    payment_total_credit:payment_total_credit,
                    check_balance:check_balance

                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {

                 // console.log(data);exit();
                  // $('#invoice').html(data)   
                  // if(glob != 'true'){                     
                        window.location.href = 'sales-invoice/'+data
                   // }              
                  
                  // $('#showInvoice').modal({backdrop: 'static', keyboard: false})                    
                  // $('#showInvoice').modal('show');


                    // $("#successMsg").html(data).delay(2000).fadeOut();
                    // setTimeout(function() {}, 2000);

                }
            });
        }

        // /*code for add cert items...........*/
        // var data = <?php echo json_encode($item); ?> ;
        // // console.log(data);
        // $.each(data, function(index, value) {
        //     var customer_id = $('input#customer_id').val();
        //     var item_number = value['item_number'];
        //     var name = value['name'];
        //     var quantity = value['quantity'];
        //     var unit_price = value['unit_price'];
        //     var item_id = index;
        //     $.ajax({
        //         url: "{{ route('cert-items') }}",
        //         method: "POST",        //         data: {
        //             item_number: item_number,
        //             name: name,
        //             quantity: quantity,
        //             unit_price: unit_price,
        //             item_id: item_id,
        //             customer_id: customer_id
        //         },
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(data) {
        //             if (data) {
        //                 console.log('Cert Items added successfully')
        //                 window.location.reload();
        //             } else {
        //                 alert('cert intem not added..');
        //             }
        //         }
        //     });
        //     return (value !== 'one');
        // });
     }
   }
   
   $(document).on('click','#close_invoice',function(){
      window.location.reload();
   });

   $(document).on('change','#discount_type',function(){
         var val = $(this).val();

         if(val !=0){
            $('#amount').removeAttr('disabled');
            $('#remark').removeAttr('disabled');
         }
         else{
            $('#amount').attr('disabled','true');  
            $('#remark').attr('disabled','true');  
         }
   })

      $(document).on('click','#check_half',function(){
      if($('#check_half').is(":checked")){

         //var amount_due = $('#sale_amount_due1').text().replace(',', '')
         //$('#due_amount').val()

         $('.default_pay').css('display','none')
         $('.half').css('display','revert');
         $('#amount_tendered1').val('');
         $('.half_tot').val('');
      }else{
         $('.half').css('display','none');
         $('.default_pay').css('display','revert')
         $('#amount_tendered1').val({{ session('item')!=null ? $totalAmount:0}});
      }
   })

   $(document).on('click','#other_discounts',function(){
      if($(this).is(":checked")){
         $('#special_discount').css('display','inline')
      }
      else{
         $('#special_discount').css('display','none')  
      }
   })

   $(document).on('click','#add_broker',function(){
      if($(this).is(":checked")){
         $('#adding_broker').css('display','inline')
      }
      else{
         $('#adding_broker').css('display','none')  
      }
   })

   // Enable button for when returning items
   $(document).ready(function(){

		var last_payment = '{{session('last_payment')}}'
	    if(last_payment){
        	$('#add_payment_button').attr('disabled', false);
        }
   })

   	$(document).on('keyup','.half_tot',function(){


		var total = '{{ session('item') != null ? round($totalAmount) : 0}}'
      var bill_session = '{{ session('billType') }}'
		var sum = 0;
		 $('.half_tot').each(function(){
		     sum += +$(this).val();
		 });

		if(sum <= total ){               

		   if(total >= sum){
            if(bill_session != '1rupee'){
		       $('#remaning_amount').val(total - sum - glob_credit);
            }else{
               $('#remaning_amount').val(1 - sum - glob_credit);
            }
		    }else{
		       $('#amount_tendered1').val(sum);
		    }

		 var test = $('#remaning_amount').val();
		 if(test == 0){
		 $('#add_payment_button').attr('disabled', false);
		 }else{
		    $('#add_payment_button').attr('disabled', false);
		    {{-- @permission('wholesale') --}}
		       // $('#add_payment_button').attr('disabled', false);
		    {{-- @endpermission --}}
		 }
		}
		else{
		 alert('Amount should not be greater then tendered amount...')
		 $('#add_payment_button').attr('disabled', true);
		}
      if(test!=0){
         // alert("tew");
         $('#add_payment_button').attr('disabled', true);
      }
   })

   $(document).on('click','#addmore',function(){
         var count = $('div #total_div > span').length
         // alert()
         if(count < 10){

         $('#total_div').append('<span id="rmv_'+count+'"><a data-id="'+count+'" class="fa fa-minus text-danger rmv"></a><input type="text" class="input-sm form-control" placeholder="Enter Barcode" name="barcode[]" id="commission_barcode"></span>')
         }
   })

   $(document).on('click','.rmv',function(){
      var id = $(this).attr('data-id');
      //alert(id)
      $('#rmv_'+id).remove();
   })

   //Add account no in bill.
   $('#account_check').on('change', function(){

         if($('#account_check').is(":checked")){
            $('#account_no').show()
         }
         else{
            $('#account_no').hide()
         }
   })
   // $(document).on('click','#add_person',function(){

   //    $.ajax({
   //       method:'post',
   //       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
   //       url:'{{route('getBro')}}',
   //       success:function(data){
   //          $('#brocker').html(data)
   //          $('#showBrok').modal('show')
   //       }
   //    })
   // })

   // $(document).on('submit','#brocker_form',function(event){
   //    event.preventDefault()
   //    console.log($('#brocker_form').serialize())
   //    $.ajax({
   //       method:'post',
   //       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
   //       url:'{{route('addPersonPercentage')}}',
   //       data:$(this).serialize(),
   //       success:function(data){
   //          $('#showBrok').modal('hide')
   //       }
   //    })
   // })
   
   
</script>
</div>
</div>
<div id="footer">
</div>
</div>
<ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-1" tabindex="0" style="display: none;"></ul>
<span role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></span>
<ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-2" tabindex="0" style="display: none;"></ul>
<span role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></span>
@endsection