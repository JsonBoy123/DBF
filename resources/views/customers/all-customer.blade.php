<?php foreach ($data as $datas) { ?>
                        
   <tbody>
      <tr data-index="0" data-uniqueid="13158">
         <td class="bs-checkbox print_hide"><input data-index="0" name="btSelectItem" type="checkbox"></td>
         <td class="" style=""></td>
         <td class="" style="">{{$datas->last_name}}</td>
         <td class="" style="">{{$datas->first_name}}</td>
         <td class="" style="">{{$datas->phone_number}}</td>
         <td class="" style="">₹&nbsp;{{$datas->first_name}}</td>
         <td class="" style="">07:58 PM 21st-Mar-2020</td>
         <td class="print_hide" style=""><a href="http://newpos.dbfindia.com/Messages/view/13158" class="modal-dlg" data-btn-submit="Submit" title="Send SMS"><span class="glyphicon glyphicon-phone"></span></a></td>
         <td class="print_hide" style=""><a href="http://newpos.dbfindia.com/customers/view/13158" class="modal-dlg" data-btn-submit="Submit" title="Update Customer"><span class="glyphicon glyphicon-edit"></span></a></td>
      </tr>
     
   </tbody>
   <?php }?>