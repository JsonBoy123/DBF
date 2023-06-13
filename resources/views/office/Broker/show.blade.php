@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row">
      <div id="title_bar" class="btn-toolbar">
         {{-- <button class="btn btn-info btn-sm pull-right modal-dlg" data-btn-submit="Submit" title="New Employee"  data-toggle="modal" data-target="#addEmployee">
         <span class="glyphicon glyphicon-user">&nbsp;</span>Back</button> --}}
         <a href="{{ route('broker.index') }}" class="btn btn-primary"><span class="glyphicon glyphicon-user">&nbsp;</span>Back</a>
         <br>
      </div>
      <div id="table_holder">
         <div class="bootstrap-table">
            <div class="fixed-table-toolbar">

               <div class="col-md-12">
                  <table id="table" class="table table-hover table-striped">
                     <thead id="table-sticky-header">
                        <tr>
                           
                           <th class="" style="" data-field="people.person_id">
                              <div class="th-inner sortable both desc">Id</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="first_name">
                              <div class="th-inner sortable both">Broker Name</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Phone Number</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Item Name</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Item Barcode</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Item Price</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Commission Amt</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="print_hide" style="" data-field="edit">
                              <div class="th-inner ">Status / Action</div>
                              <div class="fht-cell"></div>
                           </th>
                        </tr>
                     </thead>
                     <tbody>
                     	@if(!empty($broker))
                        <?php $count = 1; ?>
                     		@foreach($broker as $emp)
		                        <tr data-index="1" data-uniqueid="">
		                           
		                           <td class="" style="">{{ $count++ }}</td>
                                 <td class="" style="">{{ $emp->person_sale_detail->name }}</td>
                                 <td class="" style="">{{ $emp->person_sale_detail->contact_no  }}</td>
		                           <td class="" style="">{{ $emp->item_name->name }}</td>
		                           <td class="" style="">{{ $emp->item_name->item_number  }}</td>
                                 <td class="" style="">{{ $emp->item_price }}</td>   
                                 <td>
                                    <?php 
                                       $item_wholesale_dis = $emp->item_discounts->wholesale;
                                       if($item_wholesale_dis != 0)
                                       {
                                          $price  = $emp->item_price;
                                          $disc_value = ($emp->item_discount/100)*$price;
                                          $gross_value = $price - $disc_value;

                                          $comm_percent = $item_wholesale_dis-$emp->item_discount;
                                          $commission_amt = ($comm_percent/100)*$gross_value;
                                          echo $commission_amt;
                                       }
                                       elseif(!empty($emp->discount->commission_percent))
                                       {
                                          $price  = $emp->item_price;
                                          $disc_value = ($emp->item_discount/100)*$price;
                                          $gross_value = $price - $disc_value;

                                          $comm_percent = $emp->discount->commission_percent;
                                          $commission_amt = ($comm_percent/100)*$gross_value;
                                          echo $commission_amt;
                                       }else{
                                          echo "0";
                                       }
                                    ?> 
                                 </td>   
                                 <td>
                                    @if($emp->status != 0)
                                       <span style="color: green">Completed</span>
                                    @else
                                       <span style="color: orange">Pending &nbsp; / &nbsp; <a class="btn btn-success" href="{{ route('complete_commission',$emp->id) }}">Complete it</a> </span>
                                    @endif
                                 </td>   
		                        </tr>
		                    @endforeach
                        @endif
                     </tbody>
                  </table>
            </div>
         </div>
      </div>
   </div>
</div>



<script type="text/javascript">
   
	$("document").ready(function(){
		$("#table").DataTable({
			dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
		});     
</script>
@endsection