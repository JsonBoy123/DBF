<table id="table" class="table table-hover table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="table_info">
      <thead id="table-sticky-header">
         <tr>
            <th role="row">S.No.</th>               
            <th>Title</th>
            <th>Discount</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
         </tr>
      </thead>
      <tbody>
         @if(!empty($data))
            @foreach($data as $Data)
               <tr role="row" class="odd">
                  <td class="sorting_1">{{ $Data->id }}</td>                    
                  <td>{{ $Data->category->category_name }}</td>
                  <td>{{ $Data->amount }}</td>
                  <td>{{ $Data->from_date }}</td>
                  <td>{{ $Data->to_date }}</td>
                  <td>
                     <a onclick="edit( {{$Data->id}})" class="fa fa-pencil" ></a>
                        <a onclick="del( {{$Data->id}})" class="fa fa-trash" ></a>
                  </td>
               </tr>
            @endforeach
         @endif
      </tbody>
   </table>