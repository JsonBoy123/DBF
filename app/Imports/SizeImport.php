<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Manager\MciSize;

class SizeImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $items) {
        	// dd($items['brand_name']);
            $size = MciSize::where('sizes_name',$items['sizes_name'])->orWhere('sizes_name','LIKE','%'. $items['sizes_name'].'%')->get();
            if(count($size) == '0'){
                MciSize::create([
                    'sizes_name' => $items['sizes_name']
                ]);
            }
        }
    }
    
}
