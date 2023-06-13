@extends('layouts.dbf')
@section('content')
<?php $data = session('show_list'); ?> 

{{-- {{dd(session('show_list'))}} --}}

<div class="container">
   <div class="row">
      <div class="text-right">
        <a class="btn btn-primary btn-sm" id="print">Print</a>        
        <a class="btn btn-success btn-sm mr-2" id="complete">Complete</a>        
      </div>
      <div class="row">
            <div id="table_area">
              @if(session('show_list') !=null)
              <table id="table123" class="table table-hover table-striped ">
                  <thead id="table-sticky-header">
                    <tr>      
                      <th>Item Barcode</th>
                      <th>Item Name</th>
                      <th>Rack By Item Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $count =1; @endphp
                   @foreach ($data as $key => $value)                   
                      <tr data-index="0" data-uniqueid="13158">     
                         <td class="" style="">{{getItem($key)->item_number}} </td>                                       
                         <td>{{getItem($key)->name}}</td>                                       
                         <td>
                            @foreach ($value as $key => $value1)
                              {!! $key !!} | Quantity:-{!! $value1 !!} <br>
                            @endforeach

                         </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                @endif

            </div>
         </span>
      </div>
   </div>
</div>

<script>

  $('#print').click(function() {
    window.print();
});
  $(document).ready(function() {
      $('#table123').DataTable({
         "pageLength": 30,
         "searching": false,         
      });
    });

  $(document).on('click','#complete',function(){

    $.ajax({
      method:'get',
      url:'{{route('delete-list')}}',
      success:function(data){
        window.location.href = "/receivings";
      }
    })
  })
</script>

@endsection