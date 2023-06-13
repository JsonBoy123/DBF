
<div class="text-center">
    <div id="error" style="display: none; color: red;">All fields are required.</div>
</div>
<form class="form-horizontal" id="item_form" accept-charset="utf-8" novalidate="novalidate" >
 @csrf
    <div class="tab-content">
      <div class="tab-pane fade in active" id="customer_basic_info">
        <fieldset>
            <div class="form-group form-group-sm"> 
             <label for="first_name" class="required control-label col-xs-3" aria-required="true">Item Name (Barcode)</label>  
              <div class="col-xs-8">
                <input class="form-control" name="item_id" required="true">
                {{-- <span id="error" style="display: none; color:red;">Item Not In Record...</span> --}}
              </div>

            </div> 

            <div class="form-group form-group-sm"> 
             <label for="first_name" class="required control-label col-xs-3"  aria-required="true">Item Quantity</label>  
              <div class="col-xs-8">
                <input class="form-control" required="true" name="quantity">
              </div>

            </div>             
            <div class="form-group form-group-sm"> 
             <label for="first_name" class="required control-label col-xs-3" aria-required="true">Rack Number</label>  
              <div class="col-xs-8">
                <select name="rack_id" class="form-control">
                  <option> Select Rack </option>
                  @foreach($rack as $Rack)
                    <option value="{{$Rack->id}}">{{$Rack->rack_number}}</option>
                  @endforeach
                </select>
              </div>
            </div>                          
        </fieldset>
      </div>
    </div>
    <div class="modal-footer">
      <input type='hidden' value="{{$id}}" name="update_id">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<script>
   $(document).on('submit','#item_form',function(event){
    event.preventDefault()
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method:'post',
        url:'{{route('item_manage_rack.store')}}',
        data:$(this).serialize(),
        success:function(data){
          // $('#rack_table').html(data)
          // alert('dgdfg')
          $('#itemrack').modal('hide');
          $('#error').css('display','none')
        },
        error: function (xhr, ajaxOptions, thrownError) {
          if(xhr.status){
            $('#error').css('display','inline')
          }
        }

      })
   })
</script>