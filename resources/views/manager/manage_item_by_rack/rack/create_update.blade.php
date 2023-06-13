

<form class="form-horizontal" id="rack_form" accept-charset="utf-8" novalidate="novalidate" >
 @csrf
    <div class="tab-content">
      <div class="tab-pane fade in active" id="customer_basic_info">
        <fieldset>
            <div class="form-group form-group-sm"> 
             <label for="first_name" class="required control-label col-xs-3" aria-required="true">Rack Name</label>  
              <div class="col-xs-8">
                <input type="text" name="rack_number" value="{{count($data) > 0 ? $data->rack_number :''}}" id="first_name" class="form-control input-sm">
              </div>
            </div>
              @error('rack_name')
                <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror          
             
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
   $(document).on('submit','#rack_form',function(event){
    event.preventDefault()
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method:'post',
        url:'{{route('item_manage_rack.save_rack')}}',
        data:$(this).serialize(),
        success:function(data){
          // console.log(data);
         $('#rack_table').html(data)
          $('#addrack').modal('hide');
          location.reload();
        }

      })
   })
</script>