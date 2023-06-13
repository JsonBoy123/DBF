<table id="myTable1" class="table table-hover table-striped ">
  <thead id="table-sticky-header">
    <tr>      
       <th class="" style="" data-field="people.person_id">
          <div class="th-inner sortable both desc">Id</div>
          <div class="fht-cell"></div>
       </th>
       <th class="" style="" data-field="last_name">
          <div class="th-inner sortable both">Rack Name</div>
          <div class="fht-cell"></div>
       </th>
       
       <th class="print_hide" style="" data-field="edit">
          <div class="th-inner "> Action</div>
          <div class="fht-cell"></div>
       </th>
    </tr>
  </thead>
  <tbody>
    @php $count =1; @endphp
   @foreach ($data as $datas)

      <tr data-index="0" data-uniqueid="13158">         
         <td class="" style="">{{$count++}}</td>
         <td class="" style="">{{$datas->rack_number}}</td>                           
         <td class="print_hide" style="">
           <a class="fa fa-pencil rack_edit" data-id='{{$datas->id}}' class="fa fa-pencil text-primary"></a>
           <a href="{{route('item_manage_rack.destroy',$datas->id)}}" class="fa fa-trash text-danger"></a>
         </td>
      </tr>
    @endforeach
  </tbody>
</table>

<script>
  $(document).ready( function () {

    $('#myTable1').DataTable();
   })
</script>