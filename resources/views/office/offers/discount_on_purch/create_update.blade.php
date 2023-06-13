<form id="DiscountAdd">
	@csrf		

   <div class="form-group">
      <label for="pointer">Category</label>
      <select class="form-control" name="category_id" id="location">
         <option selected="" disabled="">Select</option>       
            @foreach($category as $Category)
               <option value="{{ $Category->id }}" {{ !empty($data) ? $data->category_id == $Category->id ? 'selected':'':''}}>{{ $Category->category_name }}</option>
            @endforeach
         
      </select>
   </div>	    
   <div class="form-group">
      <label for="title">Amount</label>
      <input type="text" class="form-control" id="title" value="{{!empty($data) ? $data->amount: ''}}" name="amount" placeholder="Amount">
   </div> 
   <div class="form-group">
      <label for="title">Item Barcode</label>
      <input type="text" class="form-control" id="title" value="{{!empty($data) ? $data->item_barcode: ''}}" name="item_barcode" placeholder="Item Barcode">
   </div>
   
   <div class="row">
      <div class="col-md-6">
         <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="text" name="daterangepicker" value="" class="form-control input-sm" id="daterangepicker" style="width: 180px;">
         </div>
      </div>
   </div>
   <input type="hidden" name="update_id" value="{{$id}}">
   <button type="submit" name="submit" class="btn btn-primary" style="float: right">ADD</button>
</form>

<script>
   
$(document).ready( function () {
      var start = moment().subtract(29, 'days');
      var end = moment();

      function cb(start, end) {
         $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      }

      $('#daterangepicker').daterangepicker({

          startDate: start,
          endDate: end,
          ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
           }
      }, cb);

      cb(start, end);

   });

 $("#DiscountAdd").validate({
      errorElement: 'p',
      errorClass: 'help-inline',
      
      rules: {
         category_id:{
            required:true,            
         },
         amount:{
            required:true
         },
         item_barcode:{
            required:true,
            number:true
         },
       },
       
       messages: {
       },
      submitHandler: function(form) {
         $.ajax({
            method:'post',
            url:'{{route('dicount_on_purchase.store')}}',
            data:$('#DiscountAdd').serialize(),
            success:function(data){
               $('#table').html(data)
               $('#AddPricing').modal('hide')
            }
         })
      }
   });

</script>