<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;

class item_quantities extends Model
{
    protected $table = 'item_quantities';
    protected $fillable = ['item_id','location_id','quantity'];
    protected $primaryKey = null;
    public $incrementing = false;


    public function item(){
    	return $this->belongsTo('App\Models\Item\Item','item_id','id');
    }

    public function item_discount(){
    	return $this->belongsTo('App\Models\Item\Item_Discount','item_id','item_id');
    }

    public function shop(){
    	return $this->belongsTo('App\Models\Office\Shop\Shop','location_id','id');
    }
}
