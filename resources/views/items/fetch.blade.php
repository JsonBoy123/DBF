<table id="table123" class="table table-hover">
   <thead>
      <tr>
         <!-- <th style="background-image: none;" class="sorting_desc" rowspan="1" colspan="1" aria-label=""><input style="margin-left: -8px;" type="checkbox" id="master"></th> -->
         <th>Id</th>
         <th>Barcode</th>
         <th>HSN Code</th>
         <th>Name</th>
         <th>Model</th>
         <th>Category</th>
         <th>Sub Cat.</th>
         <th>Brand</th>
         <th>Size</th>
         <th>Color</th>
         <th style="display: none">Expiry</th>
         <th style="display: none">Stock Edition</th>
         <th>Retail / Fixed</th>
         <th>Qty</th>
         @permission('discount_edit')
         <th style="background-image:none; padding-right: 50px; padding-left: 24px;">Action</th>
         @endpermission
      </tr>
   </thead>
   <tbody>
      
      @if(count($items) != 0)
         @foreach($items as $item)
            <tr data-uniqueid="{{ $item->id }}" role="row" class="odd" style="background-color: rgb(249, 249, 249);">
               <td>{{ $item->id }}</td>
               <td>{{ $item->item_number }}</td>
               <td>{{ $item->hsn_no }}</td>
               <td>{{ $item->name }}</td>
               <td>{{ $item->model }}</td>
               <td>{{ $item->categoryName['category_name'] }}</td>
               <td>{{ $item->subcategoryName['sub_categories_name'] }}</td>
               <td>{{ $item->brandName['brand_name'] }}</td>
               <td>{{ $item->sizeName['sizes_name'] }}</td>
               <td>{{ $item->colorName['color_name'] }}</td>
               <td style="display: none">{{ (!empty($item->custom5)) ? $item->custom5 : "0000-00-00" }}</td>
               <td style="display: none">{{ $item->custom6 }}</td>
               @if($item->unit_price != 0.00)
               <td>MRP-{{ $item->unit_price }}</td>
               @else
               <td>SP-{{ $item->fixed_sp }}</td>
               @endif
               <td class="qty_td">{{ $item->item_quantity !=null ? $item->item_quantity->quantity:0 }}</td>
               {{-- <input type="text" value="{{ $item->item_quantity->item_id }}"> --}}
               <td class="print_hide">
                  {{-- <a href="JavaScript:void(0)" class="qty_update" id="{{ $item->receiving_quantity }}" data-btn-submit="Submit" title="Quick Quantity Update" style="margin-right: 9px;color: #000022d6;"><span class="glyphicon glyphicon-erase"></span></a> --}}                
                  &nbsp;&nbsp;&nbsp;
                  @permission('discount_edit')
                  <a class="modal-dlg quantityIncrementBtn"  title="Update quantity" data-loc_id ="{{$item->item_quantity ? $item->item_quantity->location_id:0}}" data-item_id="{{ $item->item_quantity ? $item->item_quantity->item_id:0 }}"  style="margin-right: 9px;color: #000022d6;"><span class="glyphicon glyphicon-erase"></span></a>

                  &nbsp;&nbsp;&nbsp;&nbsp;
                  {{-- <a href="http://newpos.dbfindia.com/items/inventory/{{ $item->id }}" class="modal-dlg" data-btn-submit="Submit" title="Update Inventory"><span style="padding-right: 10px;" class="glyphicon glyphicon-pushpin"></span></a>

                  <a href="http://newpos.dbfindia.com/items/count_details/{{ $item->id }}" class="modal-dlg" title="Inventory Count Details"><span style="padding-right: 10px;" class="glyphicon glyphicon-list-alt"></span></a> --}}

                  <a class="modal-dlg itemUpdateBtn" id="{{ $item->id }}" data-btn-submit="Submit" title="Update Item"><span class="glyphicon glyphicon-edit"></span></a>
                  @endpermission
               </td>
            </tr>
         @endforeach
      @endif
   </tbody>
</table>
{{ $items->links() }}



{{-- Item quantity update model --}}


<div id="myModal-1" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;">
                     <button class="close" data-dismiss="modal">×</button>
               </div>
               <div class="bootstrap-dialog-title" id="c0535119-0563-480e-a1ee-c9f1f55db5f3_title">Quick Quantity Update</div>
            </div>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
               <div class="bootstrap-dialog-message">
                  <div>
                    <div id="required_fields_message">Fields in red are required</div>
                    <form class="form-horizontal" id="update_quty" method="post">
                     @csrf
                        <fieldset id="item_basic_info">
                           <div class="form-group col-md-12">
                              <label for="name" class="required" aria-required="true">Item Quantity</label>        
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="receiving_quantity" id="receiving_quantity" value=" " class="form-control input-sm">
                                 <input type="text" name="item_id" value="" class="item_id">
                                 <input type="hidden" name="loc_id" id="shop_loc_id" value="" class="loc_id">
                              </div>
                           </div>

                        </fieldset>
                        
                     <div class="modal-footer" style="display: block;">
                        <div class="bootstrap-dialog-footer">
                           <div class="bootstrap-dialog-footer-buttons">
                              <button class="btn btn-primary" id="submit1" name="submit1">Submit</button>
                           </div>
                        </div>
                     </div>
                    </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

{{-- Item quantity update model end --}}

{{-- =============Item update modal================= --}}

<div id="myModalItemUpdate" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;">
                     <button class="close" data-dismiss="modal">×</button>
               </div>
               <div class="bootstrap-dialog-title" id="c0535119-0563-480e-a1ee-c9f1f55db5f3_title">Update Item</div>
            </div>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
               <div class="bootstrap-dialog-message">
                  <div>
                   <div id="required_fields_message">Fields in red are required</div>
                    <div id="putform">
                       
                    </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

{{-- =============Item new modal================= --}}
<!-- Item Add Modal -->
<div id="myModal" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;">
                     <button class="close" data-dismiss="modal">×</button>
               </div>
               <div class="bootstrap-dialog-title" id="c0535119-0563-480e-a1ee-c9f1f55db5f3_title">New Item</div>
            </div>
         </div>
         <div class="modal-body">
            <div class="bootstrap-dialog-body">
               <div class="bootstrap-dialog-message">
                  <div>
                    <div id="required_fields_message">Fields in red are required</div>
                    <form action="{{ route('items.store') }}" id="formValidate" class="form-horizontal" method="post">
                     @csrf
                        <fieldset id="item_basic_info">
                           <div class="form-group col-md-12">
                              <label for="name" class="required" aria-required="true">Item Name</label>        
                              <div class="col-md-8" style="float: right;">                                
                                 <input type="text" name="name" id="name" class="form-control input-sm">
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="category" class="required" aria-required="true">Category</label>        
                              <div class="col-md-8" style="float: right;">
                                  <select name="category" class="form-control" id="category1">
                                    <option value="" selected="selected" >Select</option>
                                    @if(!empty($category))
                                       @foreach($category as $categorys)
                                          <option value="{{ $categorys->id }}">{{ $categorys->category_name }}</option>
                                       @endforeach
                                    @endif
                                 </select> 
                                 {{-- <select class="form-control input-sm" name="category" id="category1">
                                    <option value=""> None </option>
                                    @if(!empty($category))
                                       @foreach($category as $cat)
                                          <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                       @endforeach
                                    @endif
                                 </select> --}}
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="subcategory" class="required" aria-required="true">Subcategory</label>        
                              <div class="col-md-8" style="float: right;">
                                 {{-- <select name="subcategory" class="form-control" id="level2">
                                    <option value="" selected="selected" >Select</option>
                                    @if(!empty($subcategory))
                                       @foreach($subcategory as $subcat)
                                          <option value="{{ $subcat->id }}">{{ $subcat->sub_categories_name }}</option>
                                       @endforeach
                                    @endif
                                 </select> --}}
                                 <select name="subcategory" class="form-control input-sm" id="sub_cat1">
                                          <option value=''>-- None --</option>
                                       </select>
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="brand" class="required" aria-required="true">Brand</label>        
                              <div class="col-md-8" style="float: right;">
                                 <select name="brand" class="form-control" id="brand">
                                    <option value="" selected="selected" >Select</option>
                                    @if(!empty($brand))
                                       @foreach($brand as $brands)
                                          <option value="{{ $brands->id }}">{{ $brands->brand_name }}</option>
                                       @endforeach
                                    @endif
                                 </select>
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="size">Size</label>         
                              <div class="col-md-8" style="float: right;">
                                 <select name="size" class="form-control ui-autocomplete-input" id="size" autocomplete="off">
                                    <option value="0" selected="selected" >Select</option>
                                    @if(!empty($size))
                                       @foreach($size as $sizes)
                                          <option value="{{ $sizes->id }}">{{ $sizes->sizes_name }}</option>
                                       @endforeach
                                    @endif
                                 </select>
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="color">Color</label>       
                              <div class="col-md-8" style="float: right;">
                                 <select name="color" class="form-control ui-autocomplete-input" id="color" autocomplete="off">
                                    <option value="0" selected="selected" >Select</option>
                                    @if(!empty($color))
                                       @foreach($color as $colors)
                                          <option value="{{ $colors->id }}">{{ $colors->color_name }}</option>
                                       @endforeach
                                    @endif
                                 </select>
                              </div>
                           </div>

                        {{--    <div class="form-group col-md-12">
                              <label for="color">Rack</label>       
                              <div class="col-md-8" style="float: right;">
                                 <select name="rack" class="form-control ui-autocomplete-input" id="color" autocomplete="off">
                                    <option value="" selected="selected" >Select</option>
                                    @if(!empty($rack))
                                       @foreach($rack as $racks)
                                          <option value="{{ $racks->id }}">{{ $racks->rack_number}}</option>
                                       @endforeach
                                    @endif
                                 </select>
                                 <input type="number" placeholder="Quantity of item on rack" class="form-control" name="rack_item_qty">
                              </div>
                           </div> --}}

                           <div class="form-group col-md-12">
                              <label for="model">Model</label>
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="model" value="" id="model" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                              </div>
                           </div>
                           <!-- WHOLESALE PRICE COLUMN REMOVED FROM HERE -->
                           <div class="form-group col-md-12">
                              <label for="unit_price" aria-required="true">Retail Price</label>       
                              <div class="col-md-8" style="float: right;">
                                 <div class="input-group input-group-sm">
                                    <span class="input-group-addon input-sm"><b>₹</b></span>
                                    <input type="text" name="unit_price" value="0" id="unit_price" class="form-control input-sm">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="fixed_s_price" aria-required="true">Fixed Price</label>       
                              <div class="col-md-8" style="float: right;">
                                 <div class="input-group input-group-sm">
                                    <span class="input-group-addon input-sm"><b>₹</b></span>
                                    <input type="text" name="fixed_s_price" value="0" id="fixed_s_price" class="form-control input-sm">
                                 </div>
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="tax_percent_3" class="col-md-4" style="float: left;">Tax </label>
                              <div class="col-xs-4">
                                 <input type="text" value="IGST" id="tax_name_3" class="form-control input-sm" readonly="true">
                              </div>
                              <div class="col-xs-4">
                                 <div class="input-group input-group-sm">
                                    <input type="text" name="IGST" value="" class="form-control input-sm" id="tax_percent_name_3" required>
                                    <span class="input-group-addon input-sm"><b>%</b></span>
                                   
                                 </div>
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="receiving_quantity" aria-required="true">Receiving Quantity</label>        
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="receiving_quantity" value="0" id="receiving_quantity" readonly="true" aria-required="true" class="form-control input-sm">
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="reorder_level" aria-required="true">Reorder Level</label>         
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="reorder_level" value="1" id="reorder_level" class="form-control input-sm">
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="description">Description</label>
                              <div class="col-md-8" style="float: right;">
                                 <textarea name="description" cols="40" rows="10" id="description" class="form-control input-sm"></textarea>
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="deleted">Deleted</label>

                              <div class="col-md-8" style="float: right;">
                                 <input type="checkbox" name="deleted" value="1" id="deleted">
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="hsn_no" class="required" aria-required="true">HSN Code</label>       
                              <div class="col-md-8" style="float: right;">
                                 <input type="number" name="hsn_no" value="" id="hsn_no" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                              </div>
                           </div>
                           <!-----Expiry Date-->
                           <div class="form-group col-md-12">
                              <label for="expiry">Expiry</label>        
                              <div class="col-md-8" style="float: right;">
                                 <input type="date" name="custom5" id="expiry" class="form-control input-sm">
                              </div>
                           </div>
                           <!------Stock Locations---->
                           <div class="form-group col-md-12">
                              <label for="stock_edition">Stock Edition</label>         
                              <div class="col-md-8" style="float: right;">
                                 <input type="date" name="custom6" id="stock_edition" class="form-control input-sm" required>
                              </div>
                           </div>

                           <hr>
                           <p class="col-md-12" name="custom_price_label" id="custom_price_label" value="fixed" style="text-align:center; font-weight:bold; font-size: 1.2em; color:#9C27B0">Fixed Prices</p>
                           <p class="col-md-12" name="custom_dis_price_label" id="custom_dis_price_label" value="fixed" style="text-align:center; font-weight:bold; font-size: 1.2em; color:#9C27B0; display: none;">Discount Values</p>

                           <div class="form-group col-md-12">
                              <label for="retail" id="retail_label">RETAIL</label>           
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="retail" value="" id="retail" class="form-control input-sm">
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="wholesale">WHOLESALE</label>           
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="wholesale" value="" id="wholesale" class="form-control input-sm">
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="franchise">FRANCHISE</label>           
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="franchise" value="" id="franchise" class="form-control input-sm">
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="special" class=" col-md-3">SPECIAL APPROVAL</label>               
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="special" value="" id="special" class="form-control input-sm">
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="special" class=" col-md-3">Stock-from</label>               
                              <div class="col-md-8" style="float: right;">
                                 <select name="stock_from" class="form-control" required>
                                    <option value="">select</option>
                                    <option value="amz">AMZ</option>
                                    <option value="other">OTHER</option>
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                        
                     <div class="modal-footer" style="display: block;">
                        <div class="bootstrap-dialog-footer">
                           <div class="bootstrap-dialog-footer-buttons">
                              <button class="btn btn-primary" id="submit" name="submit">Submit</button>
                           </div>
                        </div>
                     </div>
                    </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Item Add Modal --> 



<!-- Sheet Import Modal --> 
<div id="sheetImport" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;"><button class="close" data-dismiss="modal">×</button></div>
               <div class="bootstrap-dialog-title" id="86eb159f-1194-4d0e-8190-5e3598f1bf52_title">Item Import from Excel</div>
            </div>
         </div>
         <form id="excel_form" enctype="multipart/form-data" action="{{ route('excel_import') }}" method="post">
            @csrf
            <div class="modal-body">
               <div class="bootstrap-dialog-body">
                  <div class="bootstrap-dialog-message">
                     <div>
                        <!-- <ul id="error_message_box" class="error_message_box">dddd</ul> -->
                        <div class="errMsg alert-danger"></div>
                        <fieldset id="item_basic_info1">

                           <div class="form-group col-md-12">
                              <label>Sheet Uploader</label>
                              <div class="col-md-8" style="float: right;">
                                 <select class="form-control input-sm" name="sheet_uploader" id="sheet_uploader">
                                    <option value="">Select Name</option>
                                    @if(!empty($custom))
                                       @foreach($custom as $customs)
                                          <option value="{{ $customs->id }}">{{ $customs->title }}</option>
                                       @endforeach
                                    @endif
                                 </select>
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="password">Password</label>       
                              <div class="col-md-8" style="float: right;">
                                 <input type="password" id="password" name="password" class="form-control input-sm">
                                 <div id="pwdError" style="color:red"></div>
                              </div>
                           </div>
                             <div class="form-group col-md-12">
                              <label for="stock_edition">Stock Edition</label>       
                              <div class="col-md-8" style="float: right;">
                                 <input type="date" id="rwr" name="stockeditiondate" class="form-control input-sm" required>
                                 <div id="stockeditiondate" style="color:red"></div>
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label>Function</label>
                              <div class="col-md-8" style="float: right;">
                                 <select name="sheet_type" class="form-control input-sm">
                                    <option value="">-- Select --</option>
                                    <option value="new_stock">Excel Import</option>
                                    <option value="undelete_stock">Excel Undelete</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="col-xs-12">
                                 <a  href="{{ route('download_sheet') }}">Download Import Excel Template (XLS)</a>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <input type="hidden" name="location_id" id='location_id' required >
                              <input type="file" name="file_path" accept=".xlsx" class="form-control input-sm">
                           </div>
                        </fieldset>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer" style="display: block;">
               <div class="bootstrap-dialog-footer">
                  <div class="bootstrap-dialog-footer-buttons">
                     <button class="btn btn-primary" type="submit">Submit</button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Sheet Import Modal --> 

<!-- Sheet Import Update Modal --> 
<div id="sheetImportUpdate" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;"><button class="close" data-dismiss="modal">×</button></div>
               <div class="bootstrap-dialog-title" id="86eb159f-1194-4d0e-8190-5e3598f1bf52_title">Item Import Update from Excel</div>
            </div>
         </div>
         <form id="excel_update_form" enctype="multipart/form-data" action="{{ route('excel_update_import') }}" method="post">
            @csrf
            <div class="modal-body">
               <div class="bootstrap-dialog-body">
                  <div class="bootstrap-dialog-message">
                     <label>Select Sheet</label>
                     <div class="form-group">
                        <input type="file" name="file_path" accept=".xlsx" class="form-control input-sm">
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer" style="display: block;">
               <div class="bootstrap-dialog-footer">
                  <div class="bootstrap-dialog-footer-buttons">
                         <input type="hidden" name="location_upload" >
                     <button class="btn btn-primary" type="submit">Submit</button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Sheet Import Update Modal --> 


<!-- Sheet Import Update repair cost Modal --> 
<div id="update_Repair_Cost" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;"><button class="close" data-dismiss="modal">×</button></div>
               <div class="bootstrap-dialog-title" id="86eb159f-1194-4d0e-8190-5e3598f1bf52_title">Update repair cost using Excel</div>
            </div>
         </div>
         <form id="excel_update_form" enctype="multipart/form-data" action="{{ route('update_repair_cost') }}" method="post">
            @csrf
            <div class="modal-body">
               <div class="bootstrap-dialog-body">
                  <div class="bootstrap-dialog-message">
                     <label>Select Sheet</label>
                     <div class="form-group">
                        <input type="file" name="file_path" accept=".xlsx" class="form-control input-sm">
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer" style="display: block;">
               <div class="bootstrap-dialog-footer">
                  <div class="bootstrap-dialog-footer-buttons">
                         <input type="hidden" name="location_upload" >
                     <button class="btn btn-primary" type="submit">Submit</button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Sheet Import Update repair cost Modal --> 


<!-- Update PP Modal --> 
<div id="update_Purchase_Price" class="modal bootstrap-dialog modal-dlg type-primary fade size-normal in" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <div class="bootstrap-dialog-header">
               <div class="bootstrap-dialog-close-button" style="display: block;"><button class="close" data-dismiss="modal">×</button></div>
               <div class="bootstrap-dialog-title" >Update PP</div>
            </div>
         </div>
         <form enctype="multipart/form-data" action="{{ route('purchase-price.update') }}" method="post">
            @csrf
            <div class="modal-body">
               <div class="bootstrap-dialog-body">
                  <div class="bootstrap-dialog-message">
                     <label>Select Sheet PP</label>
                     <div class="form-group">
                        <input type="file" name="file_path" accept=".xlsx" class="form-control input-sm">
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer" style="display: block;">
               <div class="bootstrap-dialog-footer">
                  <div class="bootstrap-dialog-footer-buttons">
                         <input type="hidden" name="location_upload" >
                     <button class="btn btn-primary" type="submit">Submit</button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Sheet Import Update Modal --> 


<style type="text/css">
   #table123_length{
      display: none !important;
   }
   .errMsg{
      padding: 10px;
      font-weight: bold;
      margin-bottom: 15px;
      display: none;
   }
</style>

<script type="text/javascript">


   $('input#unit_price').on('keyup mouseup', function(){
      var value = $(this).val();
      if(value == 0)
      {
         //alert(value)
         $("#retail").attr('required', false);
         $('#retail_label').removeClass('required')
      }else{
         $('#custom_price_label').hide()
         $('#custom_dis_price_label').show()
         $('#retail_label').addClass('required')
         $("#retail").attr('required', true)

      }
   });

   $('#fixed_s_price').on('keyup mouseup', function(e){

      var value = $(this).val()

      if(value != 0){
         
         $('#unit_price').attr('disabled', true)
         $('#retail').attr('disabled', true)
         $('#wholesale').attr('disabled', true)
         $('#franchise').attr('disabled', true)
         $('#special').attr('disabled', true)

      }else{
         $('#unit_price').attr('disabled', false)
         $('#retail').attr('disabled', false)
         $('#wholesale').attr('disabled', false)
         $('#franchise').attr('disabled', false)
         $('#special').attr('disabled', false)
      }

   });

   $("#formValidate").validate({
      errorElement: 'p',
      errorClass: 'help-inline',
      
      rules: {
         name:{
            required:true
         },
         category:{
            required:true
         },
         subcategory:{
            required:true
         },
         brand:{
            required:true
         }, 
         /*rack:{
            required:true
         },
         rack_item_qty:{
            required:true
         },*/
         unit_price:{
            required:true
         },
         reorder_level:{
            required:true
         },
         hsn_no:{
            required:true,
         },
      },
       
      messages: {},
      submitHandler: function(form) { 
         form.submit();
      }
   });




   $(document).ready(function() {
      $('#table123').DataTable({
         "pageLength": 30,
         "searching": false
      });


      $("#password").on("keyup", function(e){
         e.preventDefault();
         $('#location_id').val($('#stock_location').val());

         var password = $("#password").val();
         var sheet_uploader = $("#sheet_uploader").val();
         var _token = $('input[name="_token"]').val();
         $.ajax({
            method: "POST",
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "item_sheet_password",
            data: { password:password, sheet_uploader:sheet_uploader, _token:_token },
            success: function(data){
               if(data != ""){
                  $("#pwdError").html(data);
               }else{
                  $("#pwdError").empty();
               }
            }
         });
      });

/*========================================================*/

      $('#category1').on('change', function(){
       var cat_id = $(this).children("option:selected").val();
       $.ajax({
         type: 'post',
         url: 'getSubcategory',
         data: {'cat_id':cat_id},
         headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         success: function(res){
         //alert(res);
         $("#sub_cat1").html(res);
          
         }
      });
     });
/*===================================================*/

/*   Item update modal  */

      $('.itemUpdateBtn').on('click',function(e){      
         e.preventDefault();
         var item_id = $(this).attr('id');
         //alert(item_id)
         $.ajax({
            method:'get',
            url:'/items_edit/'+item_id,
            success:function(data){
               //console.log(data);
               $('#putform').html(data)
            }
         });
         $('#myModalItemUpdate').modal('show')
         //alert(item_id);
      });

/*  Item update modal  */


   /*============Item Quantity increment ===============*/

   $('.quantityIncrementBtn').on('click',function(e){      
         e.preventDefault();

         var item_id = $(this).attr('data-item_id');
         //alert(item_id);
         var loc_id = $(this).attr('data-loc_id');
         $('.item_id').val(item_id);
         $('.loc_id').val(loc_id);
         $('#myModal-1').modal('show')
      });

   $('#submit1').on('click',function(event){
         event.preventDefault()        
         var item_id = $(".item_id").val();
         var loc_id = $(".loc_id").val();
         var qty = $("#receiving_quantity").val();
         //alert(item_id+'t'+loc_id+'t'+qty);

        /* alert(item_id)
         console.log(item_id)*/

         $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'update_quantity',
            data: { "item_id":item_id, "loc_id":loc_id, "qty":qty },
            beforeSend: function() { 
               $("#submit1").text(' Loading ...');
               $("#submit1").attr('disabled',true);
             },
            success:function(data){
               console.log(data);exit;
               $('#item-table').empty().html(data);
               $('#myModal-1').modal('hide');
               location.reload(true);
            }

         });
      });

   /*=========== Item Quantity increment  ============*/

   });


   $("#excel_form").validate({
      errorElement: 'p',
      errorClass: 'help-inline',
      
      rules: {
         sheet_uploader:{
            required:true
         },
         password:{
            required:true
         },
         sheet_type:{
            required:true
         },
         file_path:{
            required:true
         }
      },
       
      messages: {},
      submitHandler: function(form) { 

         form.submit();
         /*alert($("#excel_form").serialize());
         $.ajax({
            method: "POST",
            url: "excel_import",
            cache: false,
            contentType: false,
            processData: false,
            data: $("#excel_form").serialize(),
            success: function(data){
               alert(data);
            }
         });*/
      }
   });
</script>

