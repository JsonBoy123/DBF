<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Model;

class MciSubCategory extends Model
{
    protected $guarded = [];
    protected $table = 'mci_sub_categories';

    public function categoryName(){
    	return $this->belongsTo('App\Models\Manager\MciCategory', 'parent_id', 'id');
    }
}
