

 @extends('layouts.dbf')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <label class="alert alert-success "  id="msg" style="display: none;"></label>
    </div>
    <div class="col-md-12">
      @if($message = Session::get('success'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
      @endif
    </div>
  </div>
    <div class="row">
      
        <div id="table_holder">
          <div class="bootstrap-table">
            <div class="fixed-table-toolbar">
               <div class="bs-bars pull-left">
                  <div id="toolbar">
                     <div class="pull-left btn-toolbar">
                        
                     </div>
                  </div>
               </div>
            </div>

{{-- Record Table Start --}}
            {{-- <div class="fixed-table-container" style="padding-bottom: 0px;"> --}}
               <div class="fixed-table-header">
               </div>
                <div class="table-body" style="padding-top: 20px">
                 <table id="myTable" class="table table-hover table-striped" style="padding-top: 10px">
                      <thead >
                        <tr style="padding-top: 20px">
                           <th class="" style="" data-field="people.person_id">
                              <div class="th-inner sortable both desc">Barcode</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="last_name">
                              <div class="th-inner sortable both">Name</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="first_name">
                              <div class="th-inner sortable both">Category</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Subcatagory</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">brand</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Color</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Size</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Model</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">HSN</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Unit Price</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">IGST</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Retail Discount</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Quantity</div>
                              <div class="fht-cell"></div>
                           </th>
                           <th class="" style="" data-field="phone_number">
                              <div class="th-inner sortable both">Location</div>
                              <div class="fht-cell"></div>
                           </th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $count =1; @endphp
                        @foreach ($items as $datas)
                          <tr data-index="0" data-uniqueid="13158">
                             <td class="" style="">{{$datas->item_number}}</td>
                             <td class="" style="">{{$datas->name}}</td>
                             <td class="" style="">{{$datas['categoryName']->category_name}}</td>
                             <td class="" style="">{{$datas['subcategoryName']->sub_categories_name}}</td>
                             <td class="" style="">{{$datas['brandName']->brand_name}}</td>
                             <td class="" style="">{{$datas['colorName']->color_name}}</td>
                             <td class="" style="">{{$datas['sizeName']->sizes_name}}</td> 
                             <td class="" style="">{{$datas->model}}</td>
                             <td class="" style="">{{$datas->hsn_no}}</td>
                             <td class="" style="">{{$datas->unit_price}}</td>
                             <td class="" style="">{{$datas['ItemTax']->IGST}}</td>
                             <td class="" style="">{{$datas['item_discount']->retail}}</td>
                             <td class="" style="">{{$datas->receiving_quantity}}</td>
                             <td class="" style="">{{$datas->location_id}}</td>
                          </tr>
                        @endforeach
                      </tbody> 
                    </table>
                </div>

            {{-- </div> --}}

          </div>
        </div>
   </div>
</div>

<script type="text/javascript">
   
   $(document).ready(function(){

    /*======================================*/
 
    $('#myTable').DataTable({
      dom: 'Bfrtip',
       buttons: [ { extend: 'copyHtml5' },
            { extend: 'excelHtml5' },
            { extend: 'print'},
            { extend: 'pdfHtml5'}
            ]
      });

});
</script>

@endsection