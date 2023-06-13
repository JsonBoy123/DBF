<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
<script type="text/javascript">
    $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
    
    
} );
</script>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<div class="container">
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Barcode</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>SubCategory</th>
                <th>Brand</th>
                <th>Expiry Date</th>
                <th>Stock Edition</th>
                <th>Size</th>
                <th>Color</th>
                <th>Model</th>
                <th>MRP</th>
                <th>HSN</th>
                <th>CGST%</th>
                <th>SGST%</th>
                <th>IGST%</th>
                <th>Disc%(Retail)</th>
                <th>Disc%(Wholesale)</th>
                <th>Disc%(Franchise)</th>
                <th>Disc%(Special)</th>
                <th>FP(Retail)</th>
                <th>FP(Franchise)</th>
                <th>FP(Special)</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $value){ ?>
            <tr>
                <td>{{$value->id}}</td>
                <td>{{$value->item_number}}</td>
                <td>{{$value->name}}</td>
                <td>{{$value->categoryName->category_name}}</td>
                <td>{{$value->subcategoryName->sub_categories_name}}</td>
                <td>{{$value->brandName->brand_name}}</td>
                <td>{{$value->custom5}}</td>
                <td>{{$value->custom6}}</td>
                <td>{{$value->sizeName->size_name}}</td>
                <td>{{$value->colorName->color_name}}</td>
                <td>{{$value->model}}</td>
                <td>{{$value->unit_price}}</td>
                <td>{{$value->hsn_no}}</td>
                <td>{{$value->discounts}}</td>
                <td>{{$value->discounts}}</td>
                <td>{{$value->discounts}}</td>
                <td>{{$value->retail}}</td>
                <td>{{$value->wholesale}}</td>
                <td>{{$value->franchise}}</td>
                <td>{{$value->special}}</td>
                <td>FP(Retail)</td>
                <td>FP(Franchise)</td>
                <td>FP(Special)</td>
                <td>Quantity</td>
                

            </tr>
       <?php } ?>
            </tbody>
    </table>
</div>