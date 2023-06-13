<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;

class Item_Discount extends Model
{
    protected $guarded = [];
    protected $table = 'item_discount';

    public function item(){
    	return $this->belongsTo('App\Models\Item\Item','item_id','id');
    }
}
