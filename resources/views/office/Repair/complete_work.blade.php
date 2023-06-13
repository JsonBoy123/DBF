@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row">
      <div id="title_bar" class="btn-toolbar">
         <button class="btn btn-info btn-sm pull-right modal-dlg" data-btn-submit="Submit" title="New Employee"  data-toggle="modal" data-target="#addEmployee">
         <span class="glyphicon glyphicon-user">&nbsp;</span>New Entry</button>
    </div>
      <div id="table_holder">
         <div class="bootstrap-table">
            <div class="fixed-table-toolbar">
               <br>
               <div class="col-md-12">
                  <table id="table" class="table table-hover table-striped">
                     <thead id="table-sticky-header">
                        <tr>      
                          <th >ID</th>
                          <th >From</th>
                          <th >To</th>
                          <th >Dispatcher</th>
                          <th >Date</th>
                          <th >Amount</th>
                          <th >Status</th>
                          <th >Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     	@if(!empty($complete))
                        <?php $count = 0; ?>
                     		@foreach($complete as $Complete)
		                        <tr role="row" class="odd">
                                  <td class="sorting_1">{{++$count}}</td>
                                  <td>{{get_shop_name($Complete->employee_id)['name']}}</td>
                                  <td>{{get_shop_name($Complete->destination)['name']}}</td>
                                  <td>{{get_cashier_name($Complete->dispatcher_id)['name']}}</td>
                                  <td>{{$Complete->created_at}}</td>
                                  <td>{{$Complete->repair_amount->sum('amount') * $Complete->repair_quantity->sum('complete')}}</td>
                                  <td>{{$Complete->repair == '2' ? 'COMPLETED' : 'PENDING'}}</td>
                                  <td>
                                    {{-- <a href="{{route('manage_Complete.show',$Complete->id)}}"></a>--}}
                                    <a href="{{route('WorkItemDetail', $Complete->id)}}"><span title="Show Excel" class="glyphicon glyphicon-list-alt"></span></a>

                                  </td>
                              </tr>
		                    @endforeach
                        @endif
                     </tbody>
                  </table>
            </div>
         </div>
         <div class="clearfix"></div>
      </div>
   </div>
</div>

<!-- Add Employee Model -->


<script type="text/javascript">
   
	$("document").ready(function(){
		$("#table").DataTable({
			dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
		});
      @if(old('emp_id')== '')
         @if($errors->any()) 
            $('#addEmployee').modal('show');
         @endif
      @else
         @if($errors->any()) 
         $('#updateEmployee'+"{{ old('emp_id')}}").modal('show');
         @endif
      @endif
	})

    $(document).on('change','#getpermission',function(){
    let id = $('#getpermission').val()
    alertt('addd')
    $.ajax({
      method:'get',
      url:'acl/get/'+id,
      success:function(data){
        console.log(data)
        // $('#puttable').html(data)
      }
    })
  })

    $(document).on('click','#employee_permission_info',function(){
      alert('sddsd')
    })
</script>
@endsection