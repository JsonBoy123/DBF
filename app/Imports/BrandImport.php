<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Manager\MciBrand;

class BrandImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $items) {
        	// dd($items['brand_name']);
            $brand = MciBrand::where('brand_name',$items['brand_name'])->get();
            if(count($brand) == '0'){
                MciBrand::create([
                    'brand_name' => $items['brand_name']
                ]);
            }
        }
    }
    
}
