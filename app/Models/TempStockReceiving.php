<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempStockReceiving extends Model
{
    protected $table = "temp_stock_record";

    protected $guarded = [];

    public function itemShop(){
    	return $this->belongsTo('App\Models\Office\Shop\Shop', 'shop_id');
    }

    public function item(){
    	return $this->belongsTo('App\Models\Item\Item');
    }
}