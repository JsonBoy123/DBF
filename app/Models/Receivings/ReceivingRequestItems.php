<?php

namespace App\Models\Receivings;

use Illuminate\Database\Eloquent\Model;

class ReceivingRequestItems extends Model
{ 
    protected $table = 'receivings_request_items';
    protected $guarded = [];
    
    public function item(){
    	return $this->belongsTo('App\Models\Item\Item', 'item_id');
    }
    
    
}
