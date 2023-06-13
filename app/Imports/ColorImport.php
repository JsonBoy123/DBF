<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Manager\MciColor;

class ColorImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $items) {
        	 //dd($items);
            $color = MciColor::where('color_name',$items['color_name'])->orWhere('color_name','LIKE','%'. $items['color_name'].'%')->get();
            if(count($color) == '0'){
                MciColor::create([
                    'color_name' => $items['color_name']
                ]);
            }
        }
    }
    
}
