<form action="{{ route('items.update', $data->id) }}" id="formValidate" class="form-horizontal" method="post">
                     @csrf
                     @method('PUT')
                        <fieldset id="item_basic_info">
                           <div class="form-group col-md-12">
                              <label for="name" class="required" aria-required="true">Item Name</label>        
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="name" id="name" class="form-control input-sm" value=" {{ $data->name }} ">
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="category" class="required" aria-required="true">Category</label>        
                              <div class="col-md-8" style="float: right;">
                                 <select name="category" class="form-control" id="level1">
                                    <option value="" selected="selected" >Select</option>
                                    @if(!empty($category))
                                       @foreach($category as $categorys)
                                          <option {{ $data->category == $categorys->id ? 'selected':''}} value="{{ $categorys->id }}">{{ $categorys->category_name }}</option>
                                       @endforeach
                                    @endif
                                 </select>
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="subcategory" class="required" aria-required="true">Subcategory</label>        
                              <div class="col-md-8" style="float: right;">
                                 <select name="subcategory" class="form-control" id="level2">
                                    <option value="" selected="selected" >Select</option>
                                    @if(!empty($subcategory))
                                       @foreach($subcategory as $subcat)
                                          <option {{ $data->subcategory == $subcat->id ? 'selected':''}} value="{{ $subcat->id }}">{{ $subcat->sub_categories_name }}</option>
                                       @endforeach
                                    @endif
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
                                          <option {{ $data->brand == $brands->id ? 'selected':''}} value="{{ $brands->id }}">{{ $brands->brand_name }}</option>
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
                                          <option {{ $data->size == $sizes->id ? 'selected':''}} value="{{ $sizes->id }}">{{ $sizes->sizes_name }}</option>
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
                                          <option {{ $data->color == $colors->id ? 'selected':''}} value="{{ $colors->id }}">{{ $colors->color_name }}</option>
                                       @endforeach
                                    @endif
                                 </select>
                              </div>
                           </div>

                           <div class="form-group col-md-12">

                              <label for="color"  >Rack</label>       
                              <div class="col-md-8" style="float: right;">
                                 <select name="rack" class="form-control ui-autocomplete-input " id="color" autocomplete="off">
                                    <option value="" selected="selected" >Select</option>
                                    @if(!empty($racks))
                                       @foreach($racks as $rack )
                                          <option {{!empty($item_rack) ? $item_rack->rack_id == $rack->id ? 'selected':'':''}} value="{{$rack->id}}">{{$rack->rack_number}}</option>
                                       @endforeach
                                    @endif
                                 </select>

                                 @if(!empty($racks))
                                    @foreach($racks as $rack )
                                       <input type="hidden" name="previous_rack" value="{{$rack->id}}">
                                    @endforeach
                                 @endif

                                 <input type="number" placeholder="Quantity of item on rack" class="form-control " name="rack_item_qty" value="{{!empty($item_rack) ? $item_rack->quantity : ''}}"  autocomplete="off">
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="model">Model</label>
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="model" value="{{ $data->model }}" id="model" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                              </div>
                           </div>
                           <!-- WHOLESALE PRICE COLUMN REMOVED FROM HERE -->
                           <div class="form-group col-md-12">
                              <label for="unit_price" aria-required="true">Retail Price</label>       
                              <div class="col-md-8" style="float: right;">
                                 <div class="input-group input-group-sm">
                                    <span class="input-group-addon input-sm"><b>₹</b></span>
                                    <input type="text" name="unit_price" value="{{ $data->unit_price }}" id="unit_price" class="form-control input-sm">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="fixed_s_price" aria-required="true">Fixed Price</label>       
                              <div class="col-md-8" style="float: right;">
                                 <div class="input-group input-group-sm">
                                    <span class="input-group-addon input-sm"><b>₹</b></span>
                                    <input type="text" name="fixed_s_price" value="{{ $data->fixed_sp }}" id="fixed_s_price" class="form-control input-sm">
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
                                    <input type="text" name="IGST" value="@if($tax == null) 0 @else {{ $tax->IGST  }} @endif" class="form-control input-sm" id="tax_percent_name_3">
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
                                 <input type="text" name="reorder_level" value="{{ $data->reorder_level }}" id="reorder_level" class="form-control input-sm">
                              </div>
                           </div>

                           <div class="form-group col-md-12">
                              <label for="description">Description</label>
                              <div class="col-md-8" style="float: right;">
                                 <textarea name="description" cols="40" rows="10" id="description" {{ $data->description }} class="form-control input-sm"></textarea>
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
                                 <input type="number" name="hsn_no" value="{{ $data->hsn_no }}" id="hsn_no" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                              </div>
                           </div>
                           <!-----Expiry Date-->
                           <div class="form-group col-md-12">
                              <label for="expiry">Expiry</label>        
                              <div class="col-md-8" style="float: right;">
                                 <input type="date" name="custom5" value="{{ $data->custom5 }}" id="expiry" class="form-control input-sm">
                              </div>
                           </div>
                           <!------Stock Locations---->
                           <div class="form-group col-md-12">
                              <label for="stock_edition">Stock Edition</label>         
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="custom6" id="stock_edition" class="form-control input-sm" value="{{ $data->custom6 }}">
                              </div>
                           </div>

                           <hr>
                           <p class="col-md-12" name="custom_price_label" id="custom_price_label" value="fixed" style="text-align:center; font-weight:bold; font-size: 1.2em; color:#9C27B0">Fixed Prices</p>
                           <p class="col-md-12" name="custom_dis_price_label" id="custom_dis_price_label" value="fixed" style="text-align:center; font-weight:bold; font-size: 1.2em; color:#9C27B0; display: none;">Discount Values</p>

                           <div class="form-group col-md-12">
                              <label for="retail" id="retail_label">RETAIL</label>           
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="retail" value="@if($dis_data == null) 0 @else {{ $dis_data->retail  }} @endif" id="retail" class="form-control input-sm">
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="wholesale">WHOLESALE</label>           
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="wholesale" value="@if($dis_data == null) 0 @else {{ $dis_data->wholesale  }} @endif" id="wholesale" class="form-control input-sm">
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="franchise">FRANCHISE</label>           
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="franchise" value="@if($dis_data == null) 0 @else {{ $dis_data->franchise  }} @endif" id="franchise" class="form-control input-sm">
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="special" class=" col-md-3">SPECIAL APPROVAL</label>               
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="special" value="@if($dis_data == null) 0 @else {{ $dis_data->special  }} @endif " id="special" class="form-control input-sm">
                              </div>
                           </div>
                            <div class="form-group col-md-12">
                              <label for="special" class=" col-md-3">Stock-from</label>               
                              <div class="col-md-8" style="float: right;">
                                 <input type="text" name="Stock_from" value="{{ $data->stock_from }}" readonly>
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

<script type="text/javascript">

   $('input#unit_price').on('keyup mouseup', function(){
      var value = $(this).val();
      if(value == 0)
      {
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
   
</script>