<?php

namespace App\Http\Controllers\Manager\Reports;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Item\Item;
use App\Models\Office\Shop\Shop;
use App\Models\Manager\MciBrand;
use App\Models\Manager\MciCategory;
use App\Models\Manager\MciSubCategory;
use App\Models\Manager\Report\SaleItemsReport;
use App\Models\Manager\Report\SaleItemsReportMast;

use App\Models\Sales\Sale;
use App\Models\Sales\SaleTaxe;
use App\Models\Sales\SalesItem;
use App\Models\Sales\SalesPayment;
use App\Models\Sales\SaleItemTaxe;
use Illuminate\Support\Collection;

use App\Models\Office\Employees\Employees;
use App\Models\Manager\ControlPanel\Cashier;
use App\Models\Manager\ControlPanel\CashierShop;
use App\Models\Manager\ControlPanel\ShopLocation;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("manager.Reports.index");
    }

/*-----------------------------------------------------------------*/
    public function tallyFormatReport()
    {
        $get_cat = MciCategory::get();
        $brand = MciBrand::get();
        return view("manager.Reports.tally_report", compact("get_cat", "brand"));
    }

    public function monthlyFormatReport()
    {
        $location = Shop::get();
        return view("manager.Reports.monthly_report", compact("location"));
    }
    
    public function customFormatReport()
    {
        $location = Shop::get();
        return view("manager.Reports.custom_report", compact("location"));
    }

    public function emailReport()
    {
        return view("manager.Reports.email_report");
    }

/*------------------------------------------------------------------*/

    public function tallyFormatReportGen(Request $request)
    {
        $category  = $request->category;
        $subcategory = $request->subcategory;
        $brand      = $request->brand;
        
        $fromDate = $request->fromDate;
        $toDate  = $request->toDate;
        
        /*if($category =='' && $subcategory =='' && $brand =='')
        {
            $sales_repo = Sale::whereBetween('sale_time', [$fromDate, $toDate])->get();
            dd($sales_repo);
        }*/

        $sales_repo = Sale::whereBetween('sale_time', [$fromDate, $toDate])
                        ->where('cancelled', 0)
                        ->get();
        
        $table = '<table id="extras_sublist" class="table table-hover" style="width: 100%;" role="grid" aria-describedby="cashier_list_info">
              <thead>
                 <tr>
                    <th>ID</th>
                    <th>Sale Date</th>
                    <th>Customer name</th>
                    <th style="display:none;">Customer GST number</th>
                    <th style="display:none;">Invoice Number</th>
                    <th style="display:none;">Reference Number</th>
                    <th>Shop Id</th>
                    <th>Item Name</th>
                    <th style="display:none;">Barcode</th>
                    <th style="display:none;">Item Category</th>
                    <th style="display:none;">Item subcategory</th>
                    <th style="display:none;">Item brand</th>
                    <th>Taxable value</th>
                    <th style="display:none;">HSN</th>
                    <th>CGST %</th>
                    <th style="display:none;">CGST Amt.</th>
                    <th>SGST %</th>
                    <th style="display:none;">SGST Amt.</th>
                    <th style="display:none;">IGST %</th>
                    <th style="display:none;">IGST Amt.</th>
                    <th style="display:none;">Quantity</th>
                    <th style="display:none;">Item Type</th>
                    <th >Discount</th>
                    <th style="display:none;">Gross value</th>
                    <th style="display:none;">MRP per Item</th>
                    <th style="display:none;">P P</th>

                    <th style="display:none;">Sale Payment</th>
                    <th style="display:none;">Sale Type</th>
                    <th>Sale Status</th>
                    <th style="display:none;">Customer Type</th>
                    <th>Stock Edition</th>
                    <th>Stock From</th>
                 </tr>
              </thead>
              <tbody>';
            if(!empty($sales_repo))
            {
                foreach($sales_repo as $val) 
                {
        /*............................................................*/

                    $customer = Customer::where('id', $val->customer_id)->first();
                    $customer_name = $customer['first_name']." ".$customer['last_name'];
                    $customer_gst = $customer['gstin'];
        /*.............................................................*/

                    $shop = Shop::where('id', $val->employee_id)->first();
                    $shop_name = $shop['name'];
        /*.............................................................*/

                    $salesItem = SalesItem::where('sale_id', $val->id)
                                ->where('sale_status', 0)
                                ->get();
                    
                    foreach($salesItem as $values) {

                        $item_id = $values['item_id'];

                        if($values['item_unit_price'] != 0.00)
                        {
                            $mrp_prise = $values['item_unit_price'];
                            
                            $discount = $values['discount_percent'];
                            
                            $dis_value = ($mrp_prise*$discount)/100;
                            
                            $gross_value = $mrp_prise-$dis_value; 

                            $ItemType = "DISC";
                        }
                        else
                        {
                            $mrp_prise = $values['fixed_selling_price'];
                            
                            $dis_value = "0";

                            $gross_value = $mrp_prise-$dis_value;

                            $ItemType = "FP";
                        }

                        $tax_rate = $values['taxe_rate'];
                        //dd($gross_value*$tax_rate);
                        $tax_amt = ($gross_value*(float)$tax_rate)/(100+ (float)$tax_rate);

                        $taxable_value = $gross_value - $tax_amt;
                        
                        $CGST = (float)$tax_rate/2;
                        $CGST_amt = $tax_amt/2;

                        $SGST = (float)$tax_rate/2;
                        $SGST_amt = $tax_amt/2;
                        
                        $item_quantity = $values['quantity_purchased'];

                        //$gross_value = $CGST_amt+$SGST_amt+$taxable_value;
                    /*.................................................*/

                        $item = Item::where('id', $item_id)->first();
                        $item_name = $item['name'];
                        $item_number = $item['item_number'];
                        $item_pp = $item['actual_cost'];
                        $hsn_no = $item['hsn_no'];
                        $cat_id = $item['category'];
                        $brand_id = $item['brand'];
                        $subcat_id = $item['subcategory'];
                        $stock_from = $item['stock_from'];
                        $stock_ed = $item['custom6'];
                    /*.................................................*/

                        $cat = MciCategory::where('id', $cat_id)->first();
                        $cat_name = $cat['category_name'];
                    /*.................................................*/

                        $sub_cat = MciSubCategory::where('id', $subcat_id)->first();
                        $sub_cat_name = $sub_cat['sub_categories_name'];
                    /*.................................................*/

                        $brand = MciBrand::where('id', $brand_id)->first();
                        $brand_name = $brand['brand_name'];
        /*.............................................................*/
                    
                        
                        $table .= '<tr>
                            <td>'.$val->id.'</td>
                            <td>'.$val->sale_time.'</td>
                            <td>'.$customer_name.'</td>
                            <td style="display:none;">'.$customer_gst.'</td>
                            <td style="display:none;">'.$val->tally_number.'</td>
                            <td style="display:none;">'.$val->invoice_number.'</td>
                            <td>'.$shop_name.'</td>
                            <td>'.$item_name.'</td>
                            <td style="display:none;">'.$item_number.'</td>
                            <td style="display:none;">'.$cat_name.'</td>
                            <td style="display:none;">'.$sub_cat_name.'</td>
                            <td style="display:none;">'.$brand_name.'</td>
                            <td>'.number_format($taxable_value*$item_quantity,2).'</td>
                            <td style="display:none;">'.$hsn_no.'</td>
                            <td>'.$CGST.'</td>
                            <td style="display:none;">'.number_format($CGST_amt*$item_quantity,2).'</td>
                            <td>'.$SGST.'</td>
                            <td style="display:none;">'.number_format($SGST_amt*$item_quantity,2).'</td>
                            <td style="display:none;">'.$tax_rate.'</td>
                            <td style="display:none;">'.number_format($tax_amt,2).'</td>
                            <td style="display:none;">'.$item_quantity.'</td>
                            <td style="display:none;">'.$ItemType.'</td>
                            <td>'.$dis_value*$item_quantity.'</td>
                            <td style="display:none;">'.$gross_value*$item_quantity.'</td>
                            <td style="display:none;">'.$mrp_prise.'</td>
                            <td style="display:none;">'.$item_pp.'</td>
                            
                            <td style="display:none;">'.$val->sale_status.'</td>
                            <td style="display:none;">'.$val->sale_status.'</td>
                            <td>'.$val->sale_status.'</td>
                            <td style="display:none;">'.$val->sale_status.'</td>
                            <td>'.$stock_ed.'</td>
                            <td>'.$stock_from.'</td>
                        </tr>';
                    }
                }
            }

        $table .= '</tbody>
        </table>';

        return $table;
    }   

   
/*-----------------------------------------------------------------*/

    public function itemsReport(){

        $cats = MciCategory::all();

        return view('manager.Reports.SaleItemsReport.index', compact('cats'));
    }

    public function getCategories(Request $request){

        //Fetch Cates IDs
        $items = SalesItem::getCateIds($request->date);

        //Get All Categories which matched date
        $cates = MciCategory::getCategories($items);

        return $cates;
    }

    public function itemsReportSearch(Request $request){

        //dd($request->all());

		if($request->categ != null && $request->tax == null){

            $items = SalesItem::searchCatItems($request->date, $request->categ)->get();

        }elseif($request->tax != null && $request->categ == null){

        	$items = SalesItem::searchTaxRates($request->date, $request->tax)->get();
        }elseif($request->categ == null && $request->tax == null){

			$items = SalesItem::getDateItems($request->date)->get();
        }elseif($request->categ != null && $request->tax != null){

        	$items = SalesItem::searchItems($request->date, $request->categ, $request->tax)->get();
        }
   			//dd($items);

        return view('manager.Reports.SaleItemsReport.search', compact('items'));
    }

    public function itemsReportGenerate(Request $request){

        // dd($request->saleItemsRecord);
        $lastID = SaleItemsReportMast::latest()->first()->id;

        SaleItemsReportMast::create([
            'invoice'       =>  $lastID++,
            'total_qty'     =>  $request->total_qty,
            'total_price'   =>  $request->total_price,
            'date'          =>  date('Y-m-d', strtotime(now()))
        ]);

        $items = $request->saleItemsRecord;
        $lastID = SaleItemsReportMast::latest()->first()->id;
        foreach($items as $itemRecord){
            SaleItemsReport::create([
                'report_id' => $lastID,
                'sale_id'   => $itemRecord[0],
                'barcode'   => $itemRecord[2],
                'price'     => $itemRecord[3],
                'qty'       => round($itemRecord[4]),
                'tax'       => str_replace('    %', '', $itemRecord[5]),
                'discount'  => $itemRecord[6] == null ? '0' : $itemRecord[6],
            ]);
        }

        return $lastID;

    }

    //Multiply item price with discount on each item
    //Add Location to child table

    public function itemsReportChallan( $id){
        return 5824;
    }

}
