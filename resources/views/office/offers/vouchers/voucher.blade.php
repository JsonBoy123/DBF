@extends('layouts.dbf')
@section('content')
<?php
    $session = Session::get('data');
?>
<div class="container">
   <div class="row">
        @foreach($session as $ses)
         <div class="pagewidth" style="">
            <table>
               <tbody>
                  <tr>
                     <td class="bg_img_div col" style="position:absolute;">
                        <img src="http://dbf.laxyo.org/dbf-style/images/v2.png" style="width:425px; height:300px;"> 
                     </td>
                     <td style="text-align:center; position:relative; width:425px; height:300px;">
                        <img class="dbf_logo" src="http://dbf.laxyo.org/dbf-style/images/dbflogo.png">
                        <h2 style="color: white">{{ $ses['customer']->first_name.' '.$ses['customer']->last_name }}</h2>
                        <p class="gift_voucher">GIFT VOUCHER</p>
                        <p class="vc_value">₹&nbsp;{{ $ses->amount }}</p>
                        <p class="code">CODE : {{ $ses->code }}</p>
                        <p class="exp_date">Valid till : {{ $ses->expiry }} </p>
                        <p class="tnc">T&amp;C Apply</p>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
        @endforeach
      <style>
         .pagewidth {            
         margin-left:30px;
         width :45%;
         float:left;
         margin-top:50px;
         }
         .dbf_logo{
         margin-top:-57px;
         width:73px;
         height:43px;
         }
         .gift_voucher, .vc_value, .code{
         text-align: center;
         color: #fff;
         font-size: 15px;
         margin-top: 10.5px;
         font-family: sans-serif;
         }
         .vc_value{
         font-size:40px;
         font-weight: 700;
         margin-bottom:0px;
         }
         .tnc {
         position: absolute;
         bottom: 0;
         right: 8px;
         color: #fff;
         }
         .exp_date {
         position: absolute;
         bottom: 0;
         font-family: sans-serif;
         left: 10px;
         font-size:14px ;
         color: #fff;
         }
         .code{
         font-size: 11px;
         margin-top: 4px;
         }
         @media print {
         * {
         -webkit-print-color-adjust:exact!important;
         }
         p {
         color: white !important;
         }
         }
      </style>
   </div>
</div>
@endsection