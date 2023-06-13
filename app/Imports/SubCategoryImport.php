<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Manager\MciSubCategory;

class SubCategoryImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $items) {
        	// dd($items['brand_name']);

            /*$subCategory = MciSubCategory::where('sub_categories_name',$items['sub_categories_name'])->orWhere('sub_categories_name','LIKE','%'. $items['sub_categories_name'].'%')->first();
*/


            /*if(count($subCategory) == '0'){
                MciSubCategory::create([
                    'sub_category_name' => $items['sub_category_name'],
                    'parent_id' => $items['parent_id']
                ]);
            }*/
        }
    }
    
}
