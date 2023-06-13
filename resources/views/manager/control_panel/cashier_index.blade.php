<div class="content" style="margin-top:30px;">
  <div class="row">
    <div class="col-md-8">
      <span class="successMsg" id="successMsg"></span>
    </div>
    <div class="col-md-4">
       <div class="form-group">
          <select class="form-control location_id" id="location_id">
             <option value="" selected="" disabled="">Select Location</option>
              @if(!empty($shop))
                @foreach($shop as $shops)
                  <option value="{{ $shops->id }}">{{$shops->name}}</option>
              @endforeach
          @endif
          </select>
       </div>
    </div>
  </div>
  <div id="data"></div>
</div>
<script>
  $(document).ready( function () {
    $('#location_id').on('change',function(){
      var id = $(this).val();
       var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('getShopDetails') }}",
                method: "POST",
                data: {
                    id: id,
                    _token: _token
                },
                success: function(data) {
                  console.log(data)
                  $('#data').html(data);
                }
            });

    })

     });
</script>