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
      <div class="col-md-12 mb-5">
        <a href="{{route('item_manage_rack.index')}}" class="pull-right btn btn-primary">Back</a>
        <a id="create_rack" class="pull-right btn btn-primary mr-2  ">Create Rack</a>
      </div>
      <div id="rack_table">
        <table id="myTable" class="table table-hover table-striped ">
          <thead id="table-sticky-header">
            <tr>
               <th class="" style="" data-field="people.person_id">
                  <div class="th-inner sortable both desc">Id</div>
                  <div class="fht-cell"></div>
               </th>
               <th class="" style="" data-field="last_name">
                  <div class="th-inner sortable both">Rack Name</div>
                  <div class="fht-cell"></div>
               </th>
               
               <th class="print_hide" style="" data-field="edit">
                  <div class="th-inner "> Action</div>
                  <div class="fht-cell"></div>
               </th>
            </tr>
          </thead>
          <tbody>
            @php $count =1; @endphp
           @foreach ($data as $datas)
              <tr data-index="0" data-uniqueid="13158">                
                 <td class="" style="">{{$datas->id}}</td>
                 <td class="" style="">{{$datas->rack_number}}</td>                           
                 <td class="print_hide" style="">
                    <a class="fa fa-pencil rack_edit" data-id='{{$datas->id}}' id="{{$datas->rack_number}}" class="fa fa-pencil text-primary"></a>
                    <a href="{{route('item_manage_rack.destroy',$datas->id)}}" class="fa fa-trash text-danger"></a>
                 </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
              
          
{{-- Record Table End --}}


          </div>
        </div>
   </div>
</div>

<div class="modal fade" id="addrack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" >
          <h5 class="modal-title" id="titleModal" ></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="bootstrap-dialog-body">
            <div class="bootstrap-dialog-message" id="creat_form">                
                  <form action="{{route('item_manage_rack.save_rack')}}" method="post">
                   @csrf 
                      <div class="tab-content">
                        <div class="tab-pane fade in active" id="customer_basic_info">
                          <fieldset>
                              <div class="form-group form-group-sm"> 
                               <label for="rack_number" class="required control-label col-xs-3" aria-required="true">Rack Name</label>  
                                <div class="col-xs-8">
                                  <input type="text" name="rack_number" value="" id="rack_number" class="form-control input-sm">
                                </div>
                              </div>
                                @error('rack_number')
                                  <span class="text-danger" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror          
                               
                          </fieldset>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <input type='hidden' value="" name="rack_id" id="rack_id">
                        <input type="hidden" name="flag" value="add" id="flag">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                  </form>

            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>


<script type="text/javascript">
   
   $(document).ready( function () {

    $('#myTable').DataTable();
   })

   $(document).on('click','#create_rack',function(){
        $('#flag').val('add');
        $('#titleModal').empty().html('Create Rack');
        $('#rack_id').val('');
          $('#addrack').modal('show');

   })

   $(document).on('click','.rack_edit',function(){
      var id = $(this).attr('data-id');
      var rack_number = $(this).attr('id');
      $('#flag').val('edit');
      $('#rack_id').val(id);
      $('#titleModal').empty().html('Update Rack');

      $('#rack_number').val(rack_number);
      $('#addrack').modal('show');
        // alert(id)
   })


 

  
 




</script>

@endsection