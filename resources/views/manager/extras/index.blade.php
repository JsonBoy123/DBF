@extends('layouts.dbf')

@section('content')
<div class="container">
   <div class="row">
      <div class="row">
         <div class="bg-info" style="color:#fff;padding:10px;margin-bottom:20px;">
            <a style="color:#fff" href="http://newpos.dbfindia.com/manager">
               <h4 style="display:inline">Manager</h4>
            </a>
            &gt;&gt; Extras 
         </div>
         <div class="col-md-4">
            <button class="btn btn-info btn-sm modal-dlg col-md-6 col-md-offset-3" data-btn-submit="Submit" data-href="http://newpos.dbfindia.com/manager/quick_convert" title="Quick Transfer/Billing">
            Quick Convert
            </button>
            <select id="extSwitch" class="form-control">
               <option value="">Select an Option</option>
               <option value="active_items">Active Items</option>
               <option value="deleted_items">Deleted Items</option>
            </select>
         </div>
         <div class="col-md-4">
            <button class="btn btn-info btn-sm modal-dlg col-md-6 col-md-offset-3" data-btn-submit="Submit" data-href="http://newpos.dbfindia.com/manager/quick_taxes" title="Fetch Item Taxes">
            Tax me up!
            </button>
            <select id="extSwitch1" class="form-control">
               <option value="">Select an Option</option>
               <option value="items_taxes">Show Item Taxes</option>
            </select>
         </div>
      </div>
      <hr>
      <div id="extras_table_area"></div>

      <script>
         $(document).ready(function(){         
           $('#extSwitch').on('change', function(){
             var extSwitch = $(this).val();
             var _token = $('input[name="_token"]').val();
             $.ajax({
                url: 'quickdata', 
                type: 'post',
                data: { "quick":extSwitch, "_token":_token },
                success: function(data){
                  $('#extras_table_area').html(data);
                  $('#extras_sublist').DataTable({
                    "scrollX": true,
                     dom: 'Bfrtip',
                     buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                     ]
                  });
                }
             });
           });
         });
      </script>
   </div>
</div>
@endsection
