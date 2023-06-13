<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccoRepairItem extends Model
{
    protected $table = 'account_repair_items';
    protected $guarded = [];

    public function item(){
    	return $this->belongsTo('App\Models\Item\Item', 'item_id');
    }
}
