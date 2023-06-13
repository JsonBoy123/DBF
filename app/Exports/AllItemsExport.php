<?php

namespace App\Exports;

use App\Models\Item\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AllItemsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Item::all();
    }
	public function headings(): array
	    {
	        return [
	            'ID',
	            'Item Name',
	            'Category',
	            'SubCategory',
	            'Brand',
	            'Size',
	            'Color',
	            'Model',
	            'MRP',
	            'HSN',
	            'Barcode',
	            'Stock',
	            'Edition',
	            'COMPANY',
	            'GSTIN',
	            'CGST',
	            'SGST',
	            'IGST',
	            'Disc % (Retail)',
	            'Disc % (Wholesale)',
	            'Disc % (Franchise)',
	            'FP (Retail)',
	            'FP (Wholesale)',
	            'FP (Franchise)',
	            'Quantity',
	        ];
	    }
    

}
