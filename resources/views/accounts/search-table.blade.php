<table id="myTable" class="table table-hover table-striped ">
                      <thead id="table-sticky-header">
                        <tr>
                           <th class="text-center" align="center" style="" >
                              <div class="th-inner sortable ">No</div>
                           </th>
                           <th class="text-center" style="" >
                              <div class="th-inner sortable">Barcode</div>
                           </th>
                           <th class="text-center" style="">
                              <div class="th-inner sortable">Item Name</div>
                           </th>
                           <th class="text-center" style="">
                              <div class="th-inner ">Model Number</div>
                           </th>
                           <th class="text-center" style="">
                              <div class="th-inner sortable">Quantity</div>
                           </th>
                           <th class="text-center" style="">
                              <div class="th-inner ">Repair Cost</div>
                           </th>
                           <th class="text-center" style="">
                              <div class="th-inner sortable ">Check</div>
                           </th>
                        </tr>
                      </thead>
                      <tbody>
                       @php $count =1; @endphp
                        @foreach ($items as $data)
                          <tr>
                            <td class="text-center" style="">{{$count++}}</td>
                            <td class="text-center" style="">{{$data->item->item_number}}</td>
                            <td class="text-center" style="">{{$data->item->name}}</td>
                            <td class="text-center" style="">{{$data->item->model}}</td>
                            <td class="text-center" style="">{{$data->qty}}</td>
                            <td class="text-center" style="">
                              {{$data->item->repair_cost}}</td>
                            <td class="text-center" style="">
                              @if($data->status == 0)
                              <input  class="bs-checkbox" type="checkbox" name="items" value="{{$data->id}}">
                              @else
                                 <span style="color: green">Done</span>
                              @endif
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>