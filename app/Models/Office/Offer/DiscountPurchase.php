<?php

namespace App\Models\Office\Offer;

use Illuminate\Database\Eloquent\Model;

class DiscountPurchase extends Model
{
    protected $table   = 'discount_on_purches';
    protected $guarded = []; 

    public function category(){
    	return $this->belongsTo('App\Models\Manager\MciCategory','category_id','id');
    }
}
