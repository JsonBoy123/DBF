<?php

namespace App\Models\Receivings;

use Illuminate\Database\Eloquent\Model;

class ReceivingItem extends Model
{
    protected $table = 'receivings_items';
    protected $guarded = []; 

    public function item(){
        return $this->belongsTo('App\Models\Item\Item','item_id');
    }
}
