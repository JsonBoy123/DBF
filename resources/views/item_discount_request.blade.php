<table id="table123" class="table table-hover">
   <thead>
      <tr>
         <!-- <th style="background-image: none;" class="sorting_desc" rowspan="1" colspan="1" aria-label=""><input style="margin-left: -8px;" type="checkbox" id="master"></th> -->
         
         <th class="text-center">Location Name</th>
         <th class="text-center">Total Amount </th>
         <th class="text-center">Remark</th>
         <th class="text-center">Amount</th>      
         <th style="background-image:none; padding-right: 50px; padding-left: 24px;">Action</th>
      </tr>
   </thead>
   <tbody>
      
      @if(count($other) != 0)
         @foreach($other as $others)
            <tr data-uniqueid="{{ $others->id }}" role="row" class="odd" style="background-color: rgb(249, 249, 249);">
               
               <td>{{ $others->location_name->name }}</td>
               <td>
                  {{ $others->damage !='null' ? 'Damage:'.$others->damage:'' }} <br>
                  {{ $others->special !='null' ? 'Small Issue:'.$others->special:'' }}<br>
                  {{ $others->refrence !='null' ? 'In Complete:'.$others->refrence:'' }}<br>
                  {{ $others->others !='null' ? 'others:'.$others->others:'' }}<br>
                  {{ 'Total:'.($others->damage + $others->others + $others->refrence + $others->special)}}

               </td>
               <td>{{ $others->remark }}</td>

               <td><input type="text" id="discount_value_{{$others->id}}" name="discount_value" value="{{$others->damage + $others->special + $others->refrence + $others->others }}" style="width:80px;"></td>
               <td>
                  <a class="btn btn-success btn-xs" onclick='takeAction({{$others->id}},1)'>APPROVE</a><br><br>
                  <a class="btn btn-danger btn-xs " onclick='takeAction({{$others->id}},0)'>DECLINE</a>
               </td>               
            </tr>
         @endforeach
      @endif
   </tbody>
</table>