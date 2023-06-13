<?php

namespace App\Models\Office\Offer;

use Illuminate\Database\Eloquent\Model;

class DynamicPricing extends Model
{
    protected $guarded = [];
    protected $table = "dynamic_pricings";

    public function pointers(){
    	return $this->belongsTo("App\Models\Manager\ControlPanel\OfferBundles", "pointer");
    }

    public function locations(){
    	return $this->belongsTo("App\Models\Manager\ControlPanel\LocationGroup", "location");
    }
}
