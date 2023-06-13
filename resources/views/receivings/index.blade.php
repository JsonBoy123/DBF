@extends('layouts.dbf')

@section('content')
<div class="container">
    <div class="row">
        <div id="register_wrapper">
        <!-- Top register controls -->
                <input type="hidden" name="employee_id" value="{{$login_id}}" id="employee_id">
                <button class="btn btn-sm btn-primary pull-left modal-dlg" data-btn-submit="Submit" data-href="http://newpos.dbfindia.com/receivings/quick_transfer" title="Quick Excel Stock Transfer">
                    Quick Transfer
                </button>

                <a href="{{route('manage_transfer.index')}}" id="transfer_manager" class="btn btn-sm btn-info pull-right" target="_blank" title="Transfer Manager">
                    Manage Transfer</a>

                <button style="margin-right: 7px;" class="btn btn-sm btn-info pull-right hit_rmv_btn" disabled="true">Remove</button>   
                
                <a style="display: none; margin-right: 7px;" href="" id="rmv_out" class="btn btn-sm btn-info pull-right" title="Remove All Out Of Stocks">
                    Remove</a>
                
                <a style="display: none; margin-right: 7px;" href="http://newpos.dbfindia.com/receivings/all_delete_item_view" id="reload_btn" class="btn btn-sm btn-info pull-right" title="Remove All Out Of Stocks">
                Remove</a>

                    
            <br><br>

            <div class="panel-body form-group">
                <div class="row">
                    <div class="col-md-4">
                     <label class="control-label">Register Mode</label>
                        <select name="mode" id="mode" class="form-control">
                           <option value="sale" {{session('mode')=='sale' ? 'selected' :''}}>Requisition</option>
                           <option value="repair" {{session('mode')=='repair' ? 'selected' :''}} >Repair</option>
                        </select>
                     </div>
                     <div class="col-md-4">
                     <label class="control-label">Destination Location</label>
                        <select name="destination" id="destination" class="form-control" >
                        @foreach($Shop as  $value)
                            @if(session()->has('receiving_session'))
                                <option value="{{$value->id}}" {{ session()->get('receiving_request')['requested_by']->id == $value->id ? 'selected' : ''}}>{{$value->name}}</option>
                            @else
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endif
                        @endforeach
                        </select>
                     </div>
                     <div class="col-md-4">
                        <label>Dispetchar Name</label>
                        <select name="dispatcher_name" class="form-control" id="dispatcher">
                        <option value="0">-Select Dispatcher-</option>
                       @foreach($cashier as $data1)
                         <option value="{{$data1->cashier->id}}.{{$data1->cashier->webkey}}">{{$data1->cashier->name}}</option>
                       @endforeach
                        </select>
                     </div>
                </div>
                @if(session()->has('receiving_session'))
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('receivings-session.destroy') }}" id="destroy_receivings"><span class="label label-primary" title="Click to Close Request"> {{ strtoupper(session()->get('receiving_request')['requested_to']->name) }} &nbsp; <i class="fa fa-1x fa-long-arrow-right" aria-hidden="true"></i>&nbsp; {{ strtoupper(session()->get('receiving_request')['requested_by']->name) }} &nbsp; <span style="color: white"><i class="fa fa-window-close" aria-hidden="true"></i></span></span></a>
                    </div>
                </div>
                @endif
            </div>
<!-- action="{{route('receivings_item_save')}}" -->
            <form  id="mode_form" class="form-horizontal panel panel-default" accept-charset="utf-8">
                                
                <div class="panel-body form-group">
                    <ul>
                        <li class="pull-left first_li">
                            <label for="item" ,="" class="control-label">Find or Scan Item...</label>
                        </li>
                        <li class="pull-left">
                        
                        <input type="text" name="barcode" value="" placeholder="Start typing Item Name or scan Barcode..." id="item" class="form-control input-sm ui-autocomplete-input" size="50" tabindex="1" autocomplete="off">

                        <input type="hidden" name="status" value="1">
                         <span class="ui-helper-hidden-accessible" role="status"></span>
                            <div id="itemList"></div>
                        </li>
                        <li class="pull-right" style="font-weight:bold; font-size:1.2em">
                            Total Qty:
                            <label class="total_qty" value=""></label></li>
                    </ul>
                </div>
            </form>
            <table class="sales_table_100" id="register">
                <thead>
                    <tr>
                        <th style="width:5%;">Delete</th>
                        <th style="width:15%;">Barcode</th>
                        <th style="width:45%;">Item Name</th>
                        <th style="width:10%;">Cost</th>
                        <th style="width:10%;">Qty.</th>
                        <th style="width:10%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                   <tr>
                      <td colspan="8" id="itemBody">
                        @include('receivings.itmes-display')
                      </td>
                   </tr>
                </tbody>
            </table>
        </div>
        <div id="overall_sale" class="panel panel-default">
            <div class="panel-body">
                <div id="finish_sale">
                    <form action="http://localhost/live_pos/public/receivings/requisition_complete" id="finish_receiving_form" class="form-horizontal" method="post" accept-charset="utf-8">
                        <div class="form-group form-group-sm">
                            <label id="comment_label" for="comment">Comments</label>
                            <textarea name="comment" cols="40" rows="6" id="comment" class="form-control input-sm"></textarea>
                            
                            <a href="{{route('delete_all')}}" class="btn btn-sm btn-danger pull-left" id="cancel_receiving_button"><span class="glyphicon glyphicon-remove">&nbsp;</span>Cancel</a>
                            
                            <input type="hidden" name="location_owner" value="7">

                            <div class="btn btn-sm btn-success pull-right" id="finish_receiving_button"><span class="glyphicon glyphicon-ok">&nbsp;</span>Finish</div>
                        </div>
                    </form>                         
                </div>
            </div>
        </div>
    </div>
      <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              
            </div>
            <div class="modal-body" style="margin-left: 100px; margin-right: 50px;">
              <label>WEBKEY</label>
              <input type="text" name="modal_webkey" id="modal_webkey" value="">
                <input type="hidden" name="match_key" id="match_key" value="">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" id="model_data">submit</button>
            </div>
          </div>
        </div>
    </div>
</div>
<script>

    $(document).on('submit','#mode_form',function(event){
        event.preventDefault()
    })
   $(document).ready(function() {

//Total quantity calculate
    var item_qty = 0;
    $('.qty_item').each(function() {
        item_qty = item_qty + parseInt(($(this).val()));

    });

    $('.total_qty').text(item_qty);
//Total quantity calculate

    $(document).on('keyup','.qty_item',function(e){
        e.preventDefault();
        var item_id = $(this).data('id');
        var qty = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "receivings_item_save",
            method: "post",
            data:{item_id:item_id,qty:qty,_token:_token,flag:'item_quntity_update'},              
            success: function(data) {
                 // console.log(data)
                // $('#itemBody').empty().html(data);
               window.location.reload();
            }
        });
    })

    $(document).on('change','.repair_select',function(){
        var id = $(this).val();
        var item_id = $('#repair_id_'+id).attr('data-item_id');
        var cat_id = $('#repair_id_'+id).attr('data-cat_id');
        var _token = $('input[name="_token"]').val();

        if(id !=''){

            $.ajax({
                    url: "{{ route('save_category_on_item') }}",
                    method: "POST",
                    data: {
                        item_id: item_id,
                        cat_id: cat_id,
                        _token: _token
                    },
                    success: function(data) {
                       window.location.reload();
                    }
                });
            }     

    })


    $('#item').keyup(function(e) {
        var query = $(this).val();
        if (e.keyCode == 13 || e.keyCode == 8 && query !='') {
        if (query != '') {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('get-receiving-item') }}",
                method: "POST",
                data: {
                    query: query,
                    _token: _token
                },
                success: function(data) {
                    $('#itemList').fadeIn();
                    $('#itemList').html(data);
                }
            });
        } else {
            $('#itemList').fadeOut();
        }
     }
    });

    $(document).on('click', '#selectLI', function() {
        $('#item').val($(this).text());
        $('#itemList').fadeOut();
        var mode = $('#mode').val()
        // alert('asdasdsad')
        var value   = $('#item').val();
        var res     = value.split("|");
        var final   = res[1];
        var item    = 'item';
        var _token = $('input[name="_token"]').val();
        if (final != '') {

            if(mode != 'repair'){
                $.ajax({
                    url: "receivings_item_save",
                    method: "post",
                    data:{'barcode':final,_token:_token,flag:'item_list_update',mode:mode}  ,              
                    success: function(data) {
                         // console.log(data)
                        // $('#itemBody').empty().html(data);
                       window.location.reload();
                    }
                });
            }
            else{ 
                $.ajax({
                    url: "repair_items",
                    method: "post",
                    data:{'barcode':final,_token:_token,flag:'item_list_update',mode:mode}  ,              
                    success: function(data) {
                         // console.log(data)
                        // $('#itemBody').empty().html(data);
                       window.location.reload();
                    }
                });
            }
        }
    });


    $('#item').focus();

    // $('.qty').on('change',function(){
    //  var pre_id         = $(this).attr('data-id');
    //  var qty            = $('#qty_'+pre_id).val();
    //  var unit_price     = $('#unit_price_'+pre_id).val();
    //     var actual_qty     = $('#actual_qty_'+pre_id).val();
    //  var total_cost     = unit_price * qty;
    //     var item_qty       = 0;
    //  $('#total_cost_'+pre_id).val(total_cost);


    //     if( parseInt(actual_qty) >= parseInt(qty)){
    //     }
    //     else{
    //     alert("Item Out Of Stock..");

    //     var total = actual_qty * unit_price
    //     $('#qty_'+pre_id).val(actual_qty);
    //     $('#total_cost_'+pre_id).val(total);


    //     }

    //     $('input[name^="qty"]').each(function() {
    //                 item_qty = item_qty + parseInt(($(this).val()));
    //             });

    //     $('.total_qty').text(item_qty)

    // })

    $('#dispatcher').on('change',function(){
        var dispatcher_id  = $(this).val();
        var res            = dispatcher_id.split('.');
        var web_key        = res[1];

        $('#match_key').val(web_key);
        console.log(web_key)

        if(dispatcher_id != 0){
        $('#myModal').modal('show');
        };

        });
    $('#model_data').on('click',function(){
        var user_webkey    = $('#match_key').val();
        var modal_webkey   = $('#modal_webkey').val();

        if(user_webkey == modal_webkey){
            $('#myModal').modal('hide');
            $('#modal_webkey').val('');
            
        }else{

            $('#myModal').modal('hide');
            $('#modal_webkey').val('');
            alert('Wrong');
            $('select[name="dispatcher_name"]').val(0);
        }
    });

    $('#finish_receiving_button').on('click',function(){
          let text = "You can cancle dc if you are not sure check it";
              if (confirm(text) == true) {
                text = "You pressed OK!";
              } else {
                text = "You canceled!";
               alert("You have Cancle DC Please Check Carefully");exit;
              }

            var data            = $('select[name="dispatcher_name"]').val();
            if(data != '0'){
            var comment         = $('#comment').val();
            var login_shop_id   = $('#employee_id').val();
            var destination_id  = $('select[name="destination"]').val();
            var res             = data.split('.');
            var dispatcher_id   = res[0];
            var item_id         = [];
            var item_qty        = [];
            var item_actual_qty = [];
            var mode            = $('#mode').val()
            $('input[name^="item_id"]').each(function() {
                    item_id.push($(this).val());
                });
            $('input[name^="qty"]').each(function() {
                    item_qty.push($(this).val());
                });
            $('input[name^="actual_qty"]').each(function() {
                    item_actual_qty.push($(this).val());
                });
            /*console.log([
                login_shop_id,
                destination_id,dispatcher_id, item_id,
                item_qty, item_actual_qty])*/

            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('save_receiving_items') }}",
                method: "POST",
                data: {
                    comment: comment,
                    login_shop_id: login_shop_id,
                    destination_id: destination_id,
                    dispatcher_id: dispatcher_id,
                    item_id: item_id,
                    item_qty: item_qty,
                    item_actual_qty:item_actual_qty,
                    mode:mode,
                    _token: _token
                },
                beforeSend: function() { 
                   $("#finish_receiving_button").text(' Loading ...');
                   $("#finish_receiving_button").attr('disabled',true);
                 },
                success: function(data) {

                    console.log(mode);
                    window.location.href = "{{url('/receiving_chalan/')}}/"+data;
                }
            });

            }else{
                alert("Please Check Dispatcher and Destination Field")
            }
    });

    $(document).on('click', '#destroy_receivings', function(){
        alert('Are You Sure ?')
    })

});
</script>
@endsection('content')