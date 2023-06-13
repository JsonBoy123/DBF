<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class ItemUpdateErrorsExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        	'Barcode',
        	'Quantity'
        ];

    }
}
