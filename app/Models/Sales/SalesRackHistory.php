<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class SalesRackHistory extends Model
{
    protected $guarded = [];

    protected $table = 'sales_rack_history';

    public function item(){

    	return $this->belongsTo('App\Models\Item\Item', 'item_id');
    }

    public function rack(){

    	return $this->belongsTo('App\Models\Manager\ItemRack', 'rack_id');
    }
}
