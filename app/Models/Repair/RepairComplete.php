<?php

namespace App\Models\Repair;

use Illuminate\Database\Eloquent\Model;

class RepairComplete extends Model
{
    protected $table   = 'repair_table';
    protected $guarded = [];

    public function item(){
    	return $this->belongsTo('App\Models\Item\Item','item_id');
    }

    public function repair_category(){
    	return $this->belongsTo('App\Models\Repair\Repair','repair_cat_id');
    }

}
