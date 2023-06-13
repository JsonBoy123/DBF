<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class OtherDiscount extends Model
{
    protected $table   = 'other_discount';
    protected $guarded = [];

    public function location_name(){
    	return $this->belongsTo('App\Models\Office\Shop\Shop','location_id','id');
    }
}
