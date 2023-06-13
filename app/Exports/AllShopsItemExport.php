<?php

namespace App\Exports;
use App\User;
use App\Models\Item\Item;
use App\Models\Item\items_taxes;
use App\Models\Office\Shop\Shop;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Office\Employees\Employees;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
class AllShopsItemExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $items      = Item::select('id', 'item_number', 'name', 'unit_price', 'category', 'subcategory', 'actual_cost', 'fixed_sp','custom6')
                        ->whereHas('item_quantities',function($query){
                            $query->whereIN('location_id',[1, 2, 5, 6, 7, 12])
                        ->where('quantity','>','0');
                        })->with(['item_quantities' => function($q){
                            $q->select('item_id','location_id','quantity')
                        ->whereIn('location_id',[1, 2, 5, 6, 7, 12])
                        ->orderBy('location_id');
                        }, 'categoryName', 'subcategoryName', 'item_discount', 'ItemTax'])
                        ->get();

        $item_arr   = [];

        foreach($items as $item){

            $data['item_number']    = $item->item_number;
            $data['name']           = $item->name;
            $data['unit_price']     = $item->unit_price;
            $data['actual_cost']    = $item->actual_cost;
            $data['fixed_sp']       = $item->fixed_sp;
            $data['gst']            = $item['ItemTax']->IGST;
            $data['disc_retail']    = $item['item_discount'] ? $item['item_discount']->retail : 'sofa';
            $data['disc_wholesale'] = $item['item_discount'] ? $item['item_discount']->wholesale : 'sofa';
            $data['disc_franchise'] = $item['item_discount'] ? $item['item_discount']->franchise : 'sofa';
            $data['disc_special']   = $item['item_discount'] ? $item['item_discount']->special : 'sofa';
            $data['category']       = $item['categoryName']->category_name;
            $data['subcategory']    = $item['subcategoryName']->sub_categories_name;
            $data['custom6']    = $item['custom6'];

            $count = 0;

            foreach($item->item_quantities as $item_quantity){

                if(in_array($item_quantity->location_id, [1, 2, 5, 6, 7, 12])){

                    $data['quantity'][$count++] = $item_quantity->quantity;
                }
            }

            $item_arr[] = [
                'Barcode'           =>  $data['item_number'],
                'Name'              =>  $data['name'],
                'Category'          =>  $data['category'],
                'Subcategory'       =>  $data['subcategory'],
                'Price'             =>  $data['unit_price'],
                'PP'                =>  $data['actual_cost'],
                'Fixed SP'          =>  $data['fixed_sp'],
                'Gst'               =>  $data['gst'],
                'Retail'            =>  $data['disc_retail'],
                'Wholesale'         =>  $data['disc_wholesale'],
                'Franchise'         =>  $data['disc_franchise'],
                'Special'           =>  $data['disc_special'],
                'Laxyo House'  		=>  $data['quantity'][0],
                'Mahalakshmi Shop'  =>  $data['quantity'][1],
                '114 Shop'          =>  $data['quantity'][2],
                'Annpurna Shop'     =>  $data['quantity'][3],
                'Indraprasth Shop'  =>  $data['quantity'][4],
                'Bapat Shop'        =>  $data['quantity'][5],
                'custom6'        =>  $data['custom6'],
                //'Bapat Shop'        =>  $data['quantity'][5],
            ];
        }

        return collect($item_arr);
    }

    public function headings(): array
    {
        return [
        	'Barcode',
        	'Name',
            'Category',
            'Subcategory',
            'Price',
            'PP',
            'Fixed SP',
            'Gst',
            'Retail',
            'Wholesale',
            'Franchise',
            'Special',
            'Laxyo House',
            'Mahalakshmi Shop',
            '114 Shop',
            'Annpurna Shop',
            'Indraprasth Shop',
            'Bapat Shop',
            'Stock Exhibit',
        ];
    }
}
