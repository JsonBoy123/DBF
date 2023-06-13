@extends('layouts.dbf')

@section('content')


<div class="container">
  <div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" data-tabs="tabs" id="shop_tab">
          @if(!empty($tabs))
            @foreach($tabs as $tab)
              @if(!in_array($tab->id, [16, 17, 18, 29, 31, 32, 33]))
                <li class="tab @if($tab->shop_name == 'LaxyoHouse') active @endif" id="Tab-{{ $tab->id }}" onclick="count_data({{ $tab->id }})" role="presentation">
                  <a data-toggle="tab" href="javascript:void(0)" title="Laxyo Energy Ltd.">{{ $tab->name }}</a>
                </li>
              @endif
            @endforeach
          @endif
        </ul>
        <br>
    </div>

    <div class="col-md-12">
      <div class="row">
        <div class="col-md-4">
          <div class="column">
             <center>
                <div class="card" style="background-color: #00cccc;">
                   <br>
                   <h3>Current Stock</h3>
                   <h1><span class="fa fa-tags" style="color: white;"></span></h1>
                   <h1 id="itemcount" class="loader_wait">0</h1>
                   <br>
                </div>
             </center>
          </div>
        </div>
        <div class="col-md-4">
          <div class="column">
              <center>
                <div class="card" style="background-color: #ffcc66;">
                   <br>
                   <h3>Today's Sales</h3>
                   <h1><span class="fa fa-shopping-cart" style="color: white;"></span></h1>
                   <h1 id="dailySales" class="loader_wait">0</h1>
                   <br>
                </div>
              </center>
          </div>
        </div>
        <div class="col-md-4">
          <div class="column">
            <center>
              <div class="card" style="background-color: #ff704d;">
                 <br>
                 <h3>Today's Earning</h3>
                 <h1><span class="fa fa-inr" style="color: white;"></span></h1>
                 <h1 id="totalSales" class="loader_wait">0</h1>
                 <br>
              </div>
            </center>
          </div>
        </div>

      <div class="col-md-12"><br>

      @permission('show_rceivings')
        <div class="col-md-12 " style="background-color: #e6e6e6; ">
          <div class="dropdown pull-left">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Notifications <span class="badge badge-secondary" style="background-color: #d9534f; color: white">{{count(Auth::user()->unreadNotifications)}}</span>
            <span class="caret"></span></button>
            @if(count(Auth::user()->unreadNotifications) != 0)
            <ul class="dropdown-menu">
              @foreach(Auth::user()->unreadNotifications as $notify)
                <li><a href="{{route('receiving-notification', $notify->id)}}" target="_blank">{{$notify->data['message']}}</a></li><hr>
              @endforeach
            </ul>
            @endif
          </div>
          <a id="all_detai" href="{{route('req_for_item')}}" class="btn btn-success pull-right">Request for Items</a>
       </div>
       @endpermission
       <br><br>
       <div class="col-md-12 ">
         <a type="button" href="{{route('items-quantity.index')}}" class="btn btn-primary">Update Items</a>
       </div>
         <div class="col-md-6">
            <h3>Points Table</h3>
            <table class="table table-hover table-bordered">
               <thead>
                  <tr>
                     <th>Shop Name</th>
                     <th>Total's Earning</th>
                     <th>Total Items</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
         <div class="col-md-6 show_all_details " style="border: 1px solid #ddd; margin-top: 54px;">
            <h3 class=""><b>Login And Logout Details</b></h3>
            <div class="row">
               <div class="col-md-4">
               @if($timing != "")
                  <h5>Login Time:- <span id="logintime">{{ $timing->logintime }}</span></h5>
                  @else
                  <h5>Login Time:- <span id="logintime"></span></h5>
                @endif
               </div>
               <div class="col-md-4">
               @if($timing != "")
                  <h5>LogOut Time:- <span id="logintime">{{ $timing->logouttime }}</span></h5>
                  @else
                  <h5>LogOut Time:- <span id="logintime"></span></h5>
                @endif
               </div>
               <div class="col-md-2 pull-right">                    
                  <a id="all_detai" href="{{route('shop_open_all')}}" class="btn btn-success pull-right">View All</a>
               </div>
            </div>
            <div class="row">
               <br>
               <div class="col-md-12 show_all_details">
                  <table class="table table-hover table-bordered">
                     <thead>
                        <tr>
                           <th>Login Time</th>
                           <th>Logout Time</th>
                           <th>Date</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($open_close))
                         @foreach($open_close as $o_c_t)
                            <tr data-uniqueid="{{ $o_c_t->id }}" role="row" class="odd" style="background-color: rgb(249, 249, 249);">
                               <td>{{ $o_c_t->logintime }}</td>
                               <td>{{ $o_c_t->logouttime }}</td>
                               <td>{{ $o_c_t->date }}</td>
                            </tr>
                         @endforeach
                        @endif
                     </tbody>
                  </table>
                  {{ $open_close->links() }}
               </div>
            </div>
         </div>
      </div>
      <input type="hidden" id="login" value="10:00 ">
      <input type="hidden" id="logout" value="20:00 ">
      <input type="hidden" id="login_date" value=" ">
      <input type="hidden" id="current_date" value="2020-05-01 ">
      <input type="hidden" id="ip" value="157.34.121.12 ">
      <input type="hidden" id="login_type" value="superadmin">
      <input type="hidden" id="store_name" value="DBF Main Panel">




<!------ Modal Popup -->
      <div id="MyPopup" class="modal fade" role="dialog" data-backdrop="false">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header ">
                  <h4 class="modal-title text-center">
                     <b>Welcome To DBF</b><b id="shopName"></b>
                  </h4>
               </div>

               <div class="modal-body  text-center">
                <form id="shopOpenClose">
                  @csrf

                  @php
                  $time = '11:30:00';
                  $date = new DateTime("now", new DateTimeZone('Asia/Kolkata') );
                  $data = $date->format('H:i:s');
                  
                  if(in_array($userId, [4, 18, 19, 20]))
                  {
                    @endphp
                    <input type="hidden" name="time" id="time" value="{{ $data }}">
                      <h3> <b>Hello Admin Pannel</b> </h3>
                      <br>
                    @php 
                  }
                  else
                  {
                    @endphp
                       @if($data > $time)
                        <input type="hidden" name="time" id="time" value="{{ $data }}">

                        <div class=" row col-md-12 form-group">
                          <div class="col-md-2" align="center" style="padding-top: 10px; ">
                          <label>Reason :</label>
                          </div>
                          <div class="col-md-10">
                          <input type="text" name="reason" id="reason" class="form-control" placeholder="why getting late" required="">
                          </div>
                        </div>
                      @endif
                    @php 
                  }
                  @endphp

                  <h5><b>Click on this button</b></h5>
                  <br>
                  {{-- <button type="submit"> submit </button> --}}
                  <button id="start_shop" type="submit" class="btn btn-md btn-primary">Start Session Now</button>
                  <br><br>
                </form>
               </div>
            </div>
         </div>
      </div>

      <div id="discount_modal" class="modal fade" role="dialog" data-backdrop="false">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header ">
                  <h4 class="modal-title text-center">
                     <b>Welcome To DBF</b><b id="shopName"></b>
                  </h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body  text-center" id="show_discount_request">
              
               </div>
            </div>
         </div>
      </div>
  </div> 
</div>
</div>
</div>


<script type="text/javascript">

@permission('pos_superadmin')
  $.ajax({
    method:'get',
    url:"{{'show_discount_alert'}}",
    success:function(data){
      $('#show_discount_request').html(data)
      $('#discount_modal').modal('show')
    },
    error: function(jqXHR, textStatus, errorThrown){
      $('#show_discount_request').html(data)
      // $('#discount_modal').modal('show')
    }
  })
@endpermission

  function takeAction(id,status){
    var discount_value = $('#discount_value_'+id).val()
      
    $.ajax({
      method:'post',
      url:'change_discount_status/'+id+'/'+status,
      headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data:{'discount_value':discount_value},
      success:function(data){
        $('#show_discount_request').html(data)
        $('#discount_modal').modal('show')
      }
    })
  }

  function count_data(tab_id) {
    //alert(tab_id);
    var shop_id = tab_id;
    if(shop_id == '1')
    {
      $.ajax({
        url: '/all_shop_details', 
        type: 'get',
        success: function(data){;
            //alert('Shop opened and Logged in successfully');
          $('#itemcount').text(data.quantity);
          $('#dailySales').text(data.purchase_quantity);
          $('#totalSales').text(data.earning);
        }
      });
    }
    else{
      $.ajax({
        url: '/single_shop_details', 
        type: 'post',
        data: { "shop_id":shop_id },
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(data){;
            //alert('Shop opened and Logged in successfully');
          $('#itemcount').text(data.quantity);
          $('#dailySales').text(data.purchase_quantity);
          $('#totalSales').text(data.earning);
        }
      });
    }

    $(".tab").removeClass("active");
    $(this).addClass("active");
  }

  $(document).ready(function(){
    //var check = isAbleTo('receiving-items-check')

    //alert(1)
    var data = '{{$timing}}';

    @permission('receiving-items-check')
      data = 1;
    @endpermission

    if(data != "")
    {
      //alert("Shop already opened")
    }
    else
    {
        $('#MyPopup').modal('show');

      
    }
  });

{{--@permission('hide_start_session') --}}
  $('#start_shop').on('click', function(e){
     e.preventDefault();
     //alert("test");
     var fixed_time = "11:30:00";
     var time = $("#time").val();

     if(time > fixed_time)
     {
        var reason = $("#reason").val();
        if(reason != ''){
          //alert(time)
          $.ajax({
            url: '/shop_open', 
            type: 'post',
            data: { "reason":reason, "time":time },
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data){;
                //alert('Shop opened and Logged in successfully');
                $('#MyPopup').modal('hide');
                location.reload(true);
            }
          });

        }else{
          alert('reason required')
        }
     }
     else{
        $.ajax({
            url: '/shop_open', 
            type: 'post',
            data: {"time":time },
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data){;
                //alert('Shop opened and Logged in successfully');
                $('#MyPopup').modal('hide');
                location.reload(true);
            }
          });
     }

    });

 {{-- @endpermission --}}

  $('#all_details').on('click', function(e){
     e.preventDefault();
     alert("ok")
     
     $.ajax({
        url: '/shop_open_all', 
        type: 'get',
        success: function(data){;
            alert('Shop opened and Logged in successfully');
        }
      });
    });

</script>

@endsection
