<?php

namespace App\Exports;

// use App\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class ItemErrorsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public $errors; 

    public function __construct($errors){
      $this->errors = $errors;
    }

    public function collection()
    {
        $errors = $this->errors;
        return collect($errors);
    }

    public function headings(): array
    {
        return [
            'Item Name', 
            'Category', 
            'Subcategory', 
            'Brand', 
            'Color', 
            'Size', 
            'Model', 
            'Retail Price', 
            'CGST', 
            'SGST', 
            'IGST', 
            'Receiving Quantity', 
            'Reorder Level', 
            'Description', 
            'HSN Code', 
            'Expiry Date', 
            'Stock Edition', 
            'Retail Discount', 
            'Wholesale Discount', 
            'Franchise Discount', 
            'Special Discount', 
            'Empty', 
        ];
    }
}
