<?php

namespace App\Exports;

use App\Models\Item\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ListActionExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Item::with(["ItemTax", "brandName", "categoryName", "subcategoryName", "sizeName", "colorName",'item_discount'])->get();
    }

    public function map($item): array
    {
        // dd($item);
        return [ 
            $item->id,
            $item->item_number,
            $item->name,
            $item['categoryName']->category_name,
            $item['subcategoryName']->sub_categories_name,
            $item['brandName']->brand_name,
            $item['sizeName']['sizes_name'],
            $item['colorName']['color_name'],
            $item->model,
            $item->cost_price,
            $item->hsn_no,
            !empty($item->ItemTax) ? $item->ItemTax->CGST:'0',
            !empty($item->ItemTax) ? $item->ItemTax->SGST:'0',
            !empty($item->ItemTax) ? $item->ItemTax->IGST:'0',
            json_decode($item->item_discount)->retail,
            json_decode($item->item_discount)->wholesale,
            json_decode($item->item_discount)->franchise,
            json_decode($item->item_discount)->special,
            "0",
            "0",
            "0",
            "0",
            "0",
            "0",
            "0",
            "0",
            "0",
      ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Barcode',
            'Item Name',
            'Category',
            'SubCategory',
            'Brand',
            'Size',
            'Color',
            'Model',
            'MRP',
            'HSN',
            'CGST',
            'SGST',
            'IGST',
            'Disc % (Retail)',
            'Disc % (Wholesale)',
            'Disc % (Franchise)',
            'FP (Retail)',
            'FP (Wholesale)',
            'FP (Franchise)',
            'AP_Quantity',
            'BT_Quantity',
            'IP_Quantity',
            'AR_Quantity',
            'LH_Quantity',
            'MH_Quantity',
            'SHOP114_Quantity',
        ];
    }
}
