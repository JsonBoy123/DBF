@extends('layouts.dbf')
@section('content')
<div class="container">
   <div class="row">
      <div id="title_bar" class="btn-toolbar">
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
                          <th >Barcode</th>
                          <th >Item Name</th>
                          <th >Repair Category</th>
                          <th >Per Item Cost</th>
                          <th >Amount</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($data))
                        <?php $count = 0; ?>
                           @foreach($data as $Data)                           
                              <tr role="row" class="odd">
                                  <td class="sorting_1">{{++$count}}</td>
                                  <td>{{$Data->item->item_number}}</td>
                                  <td>{{$Data->item->name}}</td>
                                  <td>{{$Data->repair_category->name}}</td>
                                  <td>{{(int)$Data->repair_category->cost}}</td>
                                  <td>{{(int)$Data->repair_category->cost * $Data->complete}}</td>                 
                                 
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