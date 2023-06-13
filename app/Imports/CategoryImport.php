<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Manager\MciCategory;

class CategoryImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $items) {
        	// dd($items['brand_name']);
            $category = MciCategory::where('category_name',$items['category_name'])->orWhere('category_name','LIKE','%'. $items['category_name'].'%')->get();
            if(count($category) == '0'){
                MciCategory::create([
                    'category_name' => $items['category_name']
                ]);
            }
        }
    }
    
}
