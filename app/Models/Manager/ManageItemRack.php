<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Model;

class ManageItemRack extends Model
{
    protected $table   = 'manage_item_by_rack';
    protected $guarded = [];

    public function rack_name(){
    	return $this->belongsTo('App\Models\Manager\ItemRack','rack_id','id');
    }

    public function rack_item(){
    	return $this->belongsTo('App\Models\Item\Item','item_id','id');
    }

    public function items(){
    	return $this->belongsTo('App\Models\Item\Item', 'item_id', 'id');
    }
}
