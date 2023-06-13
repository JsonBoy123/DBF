@extends('layouts.dbf')

@section('content')
<div class="container">
   <div class="row">
      <div class="row">
         <h3 class="text-center">Create Limit</h3>
         <div class="col-md-12">
            <form id="addLimits">
               @csrf
               <div class="form-inline">
                  <div class="form-group">
                     <select id="plimit_category" name="plimit_category" class="form-control">
                        <option value="">Select Category</option>
                        @if(!empty($category))
                           @foreach($category as $cat)
                              <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                           @endforeach
                        @endif
                     </select>
                  </div>
                  <div class="form-group">
                     <input type="number" class="form-control" id="plimit_count" name="plimit_count">
                  </div>
                  <button id="create_plimit" type="submit" class="btn btn-sm btn-success">Submit</button>
               </div>
            </form>
         </div>
      </div>
      <hr>
      <div id="active_plimit_window">
         <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
               <div class="panel-heading">
                  <h3 class="panel-title">Active Limit</h3>
               </div>

               @if(!empty($limits))
                  @foreach($limits as $limit)
                     <div class="panel-body">
                        <a href="#" class="modal-dlg" data-toggle="modal"  data-target="#UpdateVoucher{{ $limit->id }}" title="Edit">{{ $limit['limits_category']->category_name }} | {{ $limit->limit_count }}</a>

                        <span class="pull-right" id="1">
                           <input onchange="updateStatus('{{ $limit->id }}', '{{ $limit->status }}')" value="{{ $limit->status }}" class="toggle-one" name="status" @if($limit->status == '0') checked @endif type="checkbox" data-size="mini">
                        </span>
                     </div>

                     <!-- Update Modal -->
                     <div class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" id="UpdateVoucher{{ $limit->id }}" role="dialog">
                         <div class="modal-dialog">
                           <!-- Modal content-->
                           <div class="modal-content">
                             <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal">&times;</button>
                               <h4 class="modal-title">UPDATE Voucher</h4>
                             </div>
                             <div class="modal-body">
                                <form id="EditVoucher{{ $limit->id }}">
                                 @csrf
                                 @method('PUT')
                                  <div class="form-group">
                                      <label for="plimit_count">Update Limits</label>
                                      <input type="number" name="plimit_count" class="form-control" value="{{ $limit->limit_count }}">
                                      <input type="hidden" name="id" class="form-control" value="{{ $limit->id }}">
                                  </div>
                                  <button type="submit" name="submit" class="btn btn-primary" style="float: right">UPDATE</button>
                              </form>
                             </div>
                           </div>   
                         </div>
                     </div>
                     <!-- Modal -->

                     <script type="text/javascript">
                        $("document").ready(function(){
                           $("#EditVoucher{{ $limit->id }}").on("submit", function(e){
                              e.preventDefault();
                              $.ajax({
                                 type: "put",
                                 url: "update_limit_counts",
                                 data: $("#EditVoucher{{ $limit->id }}").serialize(),
                                 success: function(data){
                                    location.reload();
                                 }
                              });
                           });
                        });
                     </script>
                  @endforeach
               @endif
            </div>
         </div>
      </div>
      <script>
         $(document).ready( function () {
            $('.toggle-one').bootstrapToggle();
            $("#addLimits").on("submit", function(e){
               e.preventDefault();
               $.ajax({
                  type: "post",
                  url: "add_limits",
                  data: $("#addLimits").serialize(),
                  success: function(data){
                     // alert(data);
                     location.reload();
                  }
               });
            });
         });

         function updateStatus(id, status){
            var _token = $('input[name="_token"]').val();
            $.ajax({
               method: "POST",
               url: "update__limiter_status",
               data: { id:id, status:status, _token:_token },
               success: function(data){
                  console.log(data);
               }
            });
         }
      </script>
   </div>
</div>

@endsection