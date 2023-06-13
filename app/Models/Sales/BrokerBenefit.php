<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class BrokerBenefit extends Model
{
    protected $table   = 'person_benefit';
    protected $guarded = [];  

    public function person_sale_detail(){
    	return $this->belongsTo('App\Models\Office\Broker\Broker' ,'brok_id','id');
    }

    public function item_name(){
    	return $this->belongsTo('App\Models\Item\Item','item_id','id');
    }

    public function discount(){
    	return $this->belongsTo('App\Models\Office\Broker\BrokerCommission' ,'discount_id','id');
    }

    public function shop_name(){
    	return $this->belongsTo('App\Models\Office\Shop\Shop' ,'location_id','id');
    }
    
    public function item_discounts(){
        return $this->belongsTo('App\Models\Item\Item_Discount','item_id','item_id');
    }    
}
