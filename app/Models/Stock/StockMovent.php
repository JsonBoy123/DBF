<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Model;

class StockMovent extends Model
{
    protected $table = 'stock_movement';
    protected $guarded = []; 
    public function item()
    {
    	return $this->belongsTo('App\Models\Item\Item','item_id');
    }

    public function receiving(){
    	return $this->belongsTo('App\Models\Receivings\ReceivingItem', 'receiving_id', 'receiving_id');
    }

    public function receivingData(){
    	return $this->belongsTo('App\Models\Receivings\Receiving', 'receiving_id', 'id');
    }
}
