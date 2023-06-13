<?php

namespace App\Exports;

use App\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class CustomersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'FIRST NAME',
            'LAST NAME',
            'GENDER',
            'EMAIL',
            'PHONE NUMBER',
            'ADDRESS_1',
            'ADDRESS_2',
            'CITY',
            'STATE',
            'POSTAL CODE',
            'COUNTRY',
            'COMMENTS',
            'COMPANY',
            'GSTIN',
            'ACCOUNT',
            'DELETED AT',
            'CREATED AT',
            'UPDATED AT',
        ];
    }
}
