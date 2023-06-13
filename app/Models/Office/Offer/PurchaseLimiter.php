<?php

namespace App\Models\Office\Offer;

use Illuminate\Database\Eloquent\Model;

class PurchaseLimiter extends Model
{
    protected $guarded = [];
    protected $table = "purchase_limiters";

    public function limits_category(){
    	return $this->belongsTo("App\Models\Manager\MciCategory", "category_id");
    }
}
