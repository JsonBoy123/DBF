
@extends('layouts.dbf')

@section('content')
<div class="container">
  <div class="row">
    @permission('repair_panel')
    <div class="col-md-12 mb-4 text-right">
      <a href="{{route('complete_work')}}" class="btn btn-primary">Completeeee Work</a>      
    </div>
    @endpermission()
    <div class="col-md-12" style="margin-top: 20px; ">
      <div class="col-md-12">
        <ul class="nav nav-tabs" data-tabs="tabs">
          {{-- <li class="active" role="presentation" id="pendingblock">
            <a class="btn btn" id="pendingTransfer" >Pending Transfers</a>
          </li> --}}
          @if($stocks_in)
          <li role="presentation" class="active" id="stockinblock">
            <a class="btn btn" id="stockin">Stock In</a>
          </li>
          @endif
          <li role="presentation" class="" id="transferblock">
            <a class="btn btn" id="TransferLog">Transfer Log</a>
          </li>
          
          <li role="presentation" class="" id="requestblock">
            <a class="btn btn" id="request">Receiving Request</a>
          </li>
          <li role="presentation" class="" id="requestlogblock">
            <a class="btn btn" id="requestlog">Request Log</a>
          </li>
        </ul>
      </div>
      <hr>
      {{-- <div class="clearfix"> </div>
        <div class="content" style="margin-top:30px;display: block;" id="pendingTransfer_Content">
          @foreach($receivings as $receiving)
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse{{$receiving->id}}">
                    {{ get_shop_name($receiving->employee_id)['name'] }}         &gt;&gt;
                    {{ get_shop_name($receiving->destination)['name'] }} <span>({{$receiving->created_at}})</span>
                  </a>
                  <p class="pull-right">Items Left: {{count($receiving->stock_movement)}}</p>
                </h4>
              </div>
              <div id="collapse{{$receiving->id}}" class="panel-collapse collapse">
                @php $qty = 0; @endphp
                
                @foreach($receiving->stock_movement as $stock)
                @php $qty = $qty + $stock->quantity; @endphp
                <ul class="list-group">
                  <li class="list-group-item">
                    <span class="pull-right">{{$stock->quantity}}</span>
                  </li>
                </ul>
                @endforeach
                <div class="panel-footer">Total Quantity: {{$qty}}</div>
              </div>
            </div>
          </div>
          @endforeach
          {{dd(13)}}
        </div> --}}
        <div class="clearfix"> </div>
        <div class="content" style="margin-top:30px; display: none;" id="TransferLog_content">
          <div class="table_list">
            <div id="list_wrapper" class="dataTables_wrapper no-footer">
              
              <table id="list" class="table" >
                <thead>
                  <tr >
                    <th >ID</th>
                    <th >From</th>
                    <th >To</th>
                    <th >Dispatcher</th>
                    <th >Date</th>
                    <th >Action</th>
                    <th >Status</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @foreach($transfers as $transfer)
                  
                  <tr role="row" class="odd">
                    <td class="sorting_1">{{$transfer->id}}</td>
                    <td>{{get_shop_name($transfer->employee_id)['name']}}</td>
                    <td>{{get_shop_name($transfer->destination)['name']}}</td>
                    <td>{{get_cashier_name($transfer->dispatcher_id)['name']}}</td>
                    <td>{{$transfer->created_at}}</td>
                    <td>
                      {{-- <a href="{{route('manage_transfer.show',$transfer->id)}}"></a>--}}
                      <a href="{{route('challan.table', $transfer->id)}}" class="glyphicon glyphicon-list-alt"></a>
                      <a href="{{route('receiving_chalan.show', $transfer->id)}}" class="glyphicon glyphicon glyphicon-barcode"></a>
                      @permission('repair_panel')
                      <a href="{{route('update_repair', $transfer->id)}}" class="fa fa-eye"></a>
                      @endpermission  
                      
                    </td>
                    <td>{{$transfer->completed == '2' ? 'COMPLETED' : 'PENDING'}}</td>
                  </tr>
                  
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>


        <div class="content" style="margin-top:30px; display: block;" id="stock_in_content">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                  <th>All Receivings</th>
                  
                  <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($stocks_in as $stock)

                {{-- @php 

                  if($user->isAbleTo('stock-maintainance')){
                    $shop = get_shop_id_name()->id;
                  }else{
                    $shop = $shop_id;
                  }

                  echo $shop;

                @endphp --}}

                    <tr class="data_{{$stock->id}}" >
                      <td>{{get_shop_name($stock->employee_id)['name']}} |  | {{$stock->created_at}}| Challan ID- {{$stock->id }}</td>        
                      <td>
                        <button type="button" value="{{$stock->id}}"  name="recv_data" class="recv btn btn-sm btn-info recv_data">View</button>
                       
                        <button type="button" value="{{$stock->id}}"  name="accept_data" class="accept btn btn-sm btn-success " style="margin:0 10px"> Accept</button>

                        <button type="button" value="{{$stock->id}}"  name="" class="f_comment btn btn-sm btn-warning " style="margin:0 10px"> Add Comment</button>
                      </td>
                    </tr>

                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="content" style="margin-top:30px; display: none;" id="request_content">
          <div class="table_list">
            <div id="list_wrapper" class="dataTables_wrapper no-footer">
           
              <table id="list" class="table" >
                <thead>
                  <tr >
                    <th class="text-center">#</th>
                    <th class="text-center">FROM</th>
                    <th class="text-center">TO</th>
                    <th class="text-center">DATE</th>
                    <th class="text-center">VIEW</th>
                    <th class="text-center">NOTE</th>
                    <!-- <th class="text-center">CHALLAN</th> -->
                    <th class="text-center">STATUS</th>
                  </tr>
                </thead>
                <tbody>
                  @php $count = 0; @endphp
                  @foreach($receivings_request as $request)
                  	@if($request->status != 2 )

                     @php $shop_id    = get_shop_id_name()->id; @endphp
                     <tr role="row" class="odd">
                        <td class="sorting_1 text-center">{{$request->id}}</td>
                        @if($request->requested_to === $shop_id && in_array(get_shop_id_name()->id, [1, 16, 17, 19]) == false)
                           <td class="text-center">{{get_shop_name(1)['name']}}</td>
                        @else
                           <td class="text-center">{{get_shop_name($request->requested_by)['name']}}</td>
                        @endif
                         <td class="text-center">{{get_shop_name($request->requested_to)['name']}}</td>
                         <td class="text-center">{{$request->time}}</td>
                         <td class="text-center">

                         	@if($request['receivings'])
                           		@if(in_array(get_shop_id_name()->id, [1, 16, 17, 19]) || $request['receivings']->destination == get_shop_id_name()->id)
                           			<a href="{{route('receiving_chalan.show', $request['receivings']->id)}}" class="glyphicon glyphicon glyphicon-barcode" title="Click to see Challan"></a>

                                <!-- <a href="{{route('receiving_chalan.show', $request['receivings']->id)}}" title="Click to see Challan" class="btn btn-sm">{{$request['receivings']->id}}</a> -->
                           		@endif

                          @endif
                           <a href="{{route('request-items.show', $request->id)}}" class="fa fa-eye"></a>
                           	{{-- Check return Challan --}}

                         	@if($request['return_receivings'])

                         		@if(in_array(get_shop_id_name()->id, [1, 16, 17, 19]) || $request['return_receivings']->employee_id == get_shop_id_name()->id)
								             <a href="{{route('receiving_chalan.show', $request['return_receivings']->id)}}" 
                              class="glyphicon glyphicon glyphicon-barcode" title="Click to see Challan"></a>
                              <!-- <a href="{{route('receiving_chalan.show', $request['return_receivings']->id)}}" 
                              title="Click to see Challan">{{$request['return_receivings']->id}}</a> -->
							              @endif

                         	@endif

                        </td>
                         <td class="text-center">{{$request->comment}}</td>
                         <!-- <td class="text-center"></td> -->
                        <td class="text-center">
                        @php
                        /****  Button and status for Admin ****/

                        if(in_array(get_shop_id_name()->id, [1, 16, 17, 19])){

                           if($request->laxyo_admin == 0){

                            @endphp <button class="btn btn-sm btn-info acceptBtn" id="acceptAdminBtn_{{$request->id}}" data-request="{{$request->id}}" value="1" data-process="accept_admin" data-approvedby="{{$shop_id}}">ACCEPT</button>

                            <b><span id="processAdminMsg_{{$request->id}}" style="display: none; color: green" >PROCESSING</span></b> @php

                           }else if($request->laxyo_admin == 1 && $request->status === 1){

                              @endphp <button class="btn btn-sm btn-success apprveBtn" id="approveAdminBtn_{{$request->id}}" data-request="{{$request->id}}" value="2" data-process="approve_admin">APPROVE</button>

                              <b><span id="approveAdminMsg_{{$request->id}}" style="display: none; color: green" >APPROVED</span></b>
                              @php

                           }else if($request->laxyo_admin == 2 && $request->status === 1){

                              @endphp 
                              	<button class="btn btn-sm btn-primary generateDC" id="generateBtn_{{$request->id}}" data-request="{{$request->id}}" value="2" >GENERATE DC</button>

                              	<button class="btn btn-sm btn-danger decline" id="declineBtn_{{$request->id}}" data-request="{{$request->id}}" value="decline-admin" >DECLINE <i class="fa fa-times fa-lg" aria-hidden="true"></i></button>

                              @php

                           }else if($request->laxyo_admin == 1){
                              @endphp <b><span  style="color: green" >PROCESSING</span></b> @php
                           }else if($request->laxyo_admin == 3 && $request->status === 2){
                            @endphp <b><span style="color: #337ab7" >ACCEPTED</span></b> @php
                           }else if($request->laxyo_admin == 3){
                            @endphp 

                            <b>
                            @if($request['receivings']->security_check == 0 && $request->status = 1)
                              <button class="btn btn-sm btn-danger deletedc" id="deletdcBtn_{{$request->id}}" data-request="{{$request->id}}" data-receiving="{{$request['receivings'] == true ? $request['receivings']->id : ''}}" value="admin" >DELETE DC</button>
                            @else
                              <span style="color: #337ab7" >GENERATED</span>
                            @endif
                            </b>

                            @php
                           }else if($request->laxyo_admin == 4){
                           		@endphp <b><span style="color: #d43f3a" >DECLINED</span></b> @php
                           }

                        /****  Button and status for shops who requested items ****/

                        }elseif($request->requested_by === $shop_id ){

                           if($request->laxyo_admin == 2 && $request->status === 1){

                              @endphp <b><span style="color: green" >PROCESSING</span></b>@php

                           }else if($request->laxyo_admin == 0 || $request->laxyo_admin == 1 ){

                              @endphp <b><span >PENDING</span></b> @php
                           }else if($request->status == 2 && $request->laxyo_admin == 3){

                               @endphp <b><span style="color: green" >ACCEPTED</span></b> @php

                           }else if($request->laxyo_admin == 3 && $request->status == 1){

                              @endphp
                                 <button class="btn btn-sm btn-info apprveBtn" id="acceptBtn_{{$request->id}}" data-request="{{$request->id}}" data-process="accept_request" value="2" data-approvedby="{{$shop_id}}">ACCEPT</button>
                                <b><span id="acceptMsg_{{$request->id}}" style="display: none; color: green" >ACCEPTED</span></b>
                              @php
                           }else if($request->laxyo_admin == 4){
                              @endphp <b><span style="color: #d43f3a" >DECLINED</span></b> @php
                           }

                        /****  Button and status for 3rd party shops ****/

                        }else if($request->requested_to == $shop_id){

                           if($request->laxyo_admin == 1 && $request->status === 0){
                              @endphp
                                 <button class="btn btn-sm btn-primary generateDC" id="generateOthersBtn_{{$request->id}}" data-request="{{$request->id}}" data-process="generate_others" value="1" data-approvedby="{{$shop_id}}">GENERATE DC</button> 
                                 <b><span id="generateOthersMsg_{{$request->id}}" style="display: none; color: green" >GENERATED</span></b>
                              @php
                           }else if($request->laxyo_admin == 1 && $request->status === 1){
                              @endphp <b><span style="color: green" >GENERATED</span></b> @php
                           }else if($request->laxyo_admin == 2 || $request->laxyo_admin == 3){
                              @endphp <b><span style="color: green" >ACCEPTED</span></b> @php
                           }

                     } @endphp 
                        </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>


        <div class="content" style="margin-top:30px; display: none;" id="request_log_content">
          <div class="table_list">
            <div id="list_wrapper" class="dataTables_wrapper no-footer">
           
              <table id="request_log" class="table" >
                <thead>
                  <tr >
                    <th >ID</th>
                    <th class="text-center">From</th>
                    <th class="text-center">To</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">NOTE</th>
                    <th class="text-center">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @php $count = 0; @endphp
                  @foreach($request_log as $request_log)
                    @php $shop_id    = get_shop_id_name()->id; @endphp
                    <tr role="row" class="odd">
                      <td class="sorting_1">{{$request_log->id}}</td>
                      	@if($request_log->requested_by === get_shop_id_name()->id || in_array(get_shop_id_name()->id, [1, 16, 17, 19]))
                      		<td class="text-center">{{get_shop_name($request_log->requested_by)['name']}}</td>
                      	@else
                      		<td class="text-center">{{get_shop_name(1)['name']}}</td>
                    	@endif
                    	{{-- @if($request_log->requested_to === get_shop_id_name()->id || in_array(get_shop_id_name()->id, [1, 16, 17, 19])) --}}
                      		<td class="text-center">{{get_shop_name($request_log->requested_to)['name']}}</td>
                      	{{-- @else@endif --}}
                      <td class="text-center">{{$request_log->created_at}}</td>
                      {{-- <td class="text-center">{{$request_log->reference_receiving_id}}</td> --}}
                      <td class="text-center">
                      	@if($request_log['receivings'])
                           	@if(in_array(get_shop_id_name()->id, [1, 16, 17, 19]) || $request_log['receivings']->destination == get_shop_id_name()->id)
                      			<a href="{{route('receiving_chalan.show', $request_log['receivings']->id)}}" class="glyphicon glyphicon glyphicon-barcode"></a>
                      		@endif
                      	@endif
                      	<a href="{{route('request-items.show', $request_log->id)}}" class="fa fa-eye"></a>
                      	@if($request_log['return_receivings'])
                           	@if(in_array(get_shop_id_name()->id, [1, 16, 17, 19]) || $request_log['return_receivings']->employee_id == get_shop_id_name()->id)
                      			<a href="{{route('receiving_chalan.show', $request_log['return_receivings']->id)}}" class="glyphicon glyphicon glyphicon-barcode"></a>
                      		@endif
                      	@endif
                      </td>
                      <td class="text-center">{{$request_log->comment}}</td>
                      <td class="text-center">
                      	@if($request_log->status == '2')
                      		<b><span style="color: #004daa" >COMPLETED</span></b>
                      	@elseif($request_log->status == '4')
                      		<b><span style="color: #d43f3a" >DECLINED</span></b>
                      	@endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        {{-- End of request log --}}

    </div>
  </div>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Receiving Information</h4>
        </div>
        <div class="modal-body" id="modalTable">
          TEMPLATE WILL SHOW HERE
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Comment</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="receiving_id" value="" id="receiving_id">
         <textarea rows="" cols="72"  value="" id="f_comment"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="submit" >submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
</div>
<script>
$(document).ready( function () {

       $('#list').DataTable( {
              dom: 'Bfrtip',
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5'
              ],
              order:[[0, 'desc']]
          } );

       

      /*$('#pendingTransfer').on('click',function(){
          $('#pendingTransfer_Content').show();
          $('#TransferLog_content').hide();
          $('#stock_in_content').hide();
          $('#request_content').hide();
          $('#request_log_content').hide();

          $("#transferblock").removeClass();
          $("#stockinblock").removeClass();
          $("#pendingblock").addClass("active");
          $("#requestblock").removeClass();
          $("#requestlogblock").removeClass();

      })*/

      $('#TransferLog').on('click',function(){
          $('#pendingTransfer_Content').hide();
          $('#stock_in_content').hide();
          $('#TransferLog_content').show();
          $('#request_content').hide();
          $('#request_log_content').hide();

          $("#pendingblock").removeClass();
          $("#stockinblock").removeClass();
          $("#transferblock").addClass("active");
          $("#requestblock").removeClass();
          $("#requestlogblock").removeClass();
      })

      $('#stockin').on('click',function(){
          $('#pendingTransfer_Content').hide();
          $('#stock_in_content').show();
          $('#TransferLog_content').hide();
          $('#request_content').hide();
          $('#request_log_content').hide();

          $("#pendingblock").removeClass();
          $("#stockinblock").addClass("active");
          $("#transferblock").removeClass();
          $("#requestblock").removeClass();
          $("#requestlogblock").removeClass();
      })

      $('#request').on('click',function(){
          $('#pendingTransfer_Content').hide();
          $('#stock_in_content').hide();
          $('#TransferLog_content').hide();
          $('#request_content').show();
          $('#request_log_content').hide();

          $("#pendingblock").removeClass();
          $("#stockinblock").removeClass();
          $("#transferblock").removeClass();
          $("#requestblock").addClass("active");
          $("#requestlogblock").removeClass();
      })

      $('#requestlog').on('click',function(){

          $('#pendingTransfer_Content').hide();
          $('#stock_in_content').hide();
          $('#TransferLog_content').hide();
          $('#request_content').hide();
          $('#request_log_content').show();

          $("#pendingblock").removeClass();
          $("#stockinblock").removeClass();
          $("#transferblock").removeClass();
          $("#requestblock").removeClass();
          $("#requestlogblock").addClass("active");
          
      })

      $('.recv').click(function(){

        var receive_id = $(this).val()

        var _token = $('input[name="_token"]').val()

        $.ajax({
          type: 'POST',
          url: '/stock_in_data',
          data: {
            _token: _token,
            'receive_id': receive_id
          },
          success:function(data){
          
            $('#myModal').modal('show')
            $('#modalTable').html(data)

          }
        })

      })
      

      $('.accept').on('click',function(){
          var id = $(this).val();

          var tr = $(this).closest("tr");

          var _token = $('input[name="_token"]').val();

          $.ajax({
              url: "{{ route('accept_data_stockIn') }}",
              method: "POST",
              data: {
                  id: id,
                  _token: _token
              },
              async:false,
              beforeSend: function() { 
                   $(".accept").text(' Loading ...');
                   $(".accept").attr('disabled',true);


                 },
              success: function(data) {
                console.log(data);
                tr.remove();
                

              }
          }); 
      })


      //Decline Request
	$('.decline').on('click', function(){

  		var value		= $(this).val()
		var request_id	= $(this).data('request')
		var reason 		= prompt('Please mention reason here.')

		if(reason.length != 0){
			$.ajax({
				type: 'post',
				url: '{{route('generated-dc.decline')}}',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {value:value, request_id: request_id, reason:reason},
        beforeSend: function() { 
                   $(".decline").text(' Loading ...');
                   $(".decline").attr('disabled',true);
                    window.location.reload();
                 },
				success: function(){ 
        }
			})
		}else{
			alert('Please give reason.')
		}

				
	})


	//Delete DC

	$(document).on('click', '.deletedc', function(){
		var receiving 	= $(this).data('receiving')
		var request_id	= $(this).data('request')
    var btnValue    = $(this).val()

    //alert(btnValue)

    if(confirm('Are you sure ?')){

  		$.ajax({
  			type: 'post',
  			url: '{{route('delete-dc')}}',
  			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  			data:{receiving:receiving, request_id:request_id},
  			success: function(res){

          $('#deletdcBtn_'+request_id).hide()
  			}
  		})
    }
	})



      $('.f_comment').on('click',function(){
          var id = $(this).val();

          $('#myModal1').modal('show');
          $('#receiving_id').val(id);

      })

      $('#submit').on('click',function(){
          var id        = $('#receiving_id').val();
          var f_comment = $('#f_comment').val();

          $('#myModal1').modal('hide');

          var _token = $('input[name="_token"]').val();

          $.ajax({
              url: "{{ route('f_comment_stockIn') }}",
              method: "POST",
              data: {
                  id: id,
                  f_comment: f_comment,
                  _token: _token
              },
              success: function(data) {
                console.log(data);                

              }
          }); 

      })

      // 

      $(document).on('click', '.acceptBtn', function(){

          var value      = $(this).val()
          var request_id = $(this).data('request')
          var apprved_by = $(this).data('approvedby')
          var process    = $(this).data('process')
          
          $.ajax({
            type: 'post',
            url: '{{route('receiving-request.update')}}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {value:value, request_id: request_id, apprved_by: apprved_by, process: process},
            beforeSend: function() { 
              $("#acceptAdminBtn_"+request_id).text(' Loading ...');
              $("#acceptAdminBtn_"+request_id).attr('disabled',true);
                 },
            success: function(res){

              $('#processAdminMsg_'+request_id).show()
              $('#acceptAdminBtn_'+request_id).hide()

              alert(res)

            }
          })
      })

      $(document).on('click', '.apprveBtn', function(){

          var value      = $(this).val()
          var request_id = $(this).data('request')
          var process    = $(this).data('process')

          //alert(request_id)
          $.ajax({
            type: 'post',
            url: '{{route('receiving.approve')}}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {value:value, request_id: request_id, process: process},
            beforeSend: function() { 
                   $("#acceptBtn_"+request_id).text(' Loading ...');
                   $("#acceptBtn_"+request_id).attr('disabled',true);
                   $("#acceptAdminBtn_"+request_id).attr('disabled',true);
                   $("#acceptAdminBtn_"+request_id).attr('disabled',true);
                 },
            success: function(res){

              if(process == 'approve_admin'){
                $('#approveAdminMsg_'+request_id).show()
                $('#approveAdminBtn_'+request_id).hide()
              }else{
                $('#acceptMsg_'+request_id).show()
                $('#acceptBtn_'+request_id).hide()
              }
              alert(res)

            }
          })
      })

      $(document).on('click', '.generateDC', function(){
        var request_id = $(this).data('request')

        $.ajax({
            type: 'get',
            url: '{{route('generate-receiving.show')}}',
            data: {'request_id': request_id},
            beforeSend: function() { 
                   $("#generateBtn_"+request_id).text(' Loading ...');
                   $("#generateBtn_"+request_id).attr('disabled',true);
                   $("#generateOthersBtn_"+request_id).attr('disabled',true);
                   $("#generateOthersBtn_"+request_id).attr('disabled',true);
                 },
            success: function(res){

              window.location.href = "receivings";
              
              
            }
          })
      })

      $('#request_log').DataTable( {
              
              order:[[0, 'desc']]
        } );


});


</script>
@endsection
