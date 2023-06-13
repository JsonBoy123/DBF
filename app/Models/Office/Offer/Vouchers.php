<?php

namespace App\Models\Office\Offer;

use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    protected $guarded = [];
    protected $table = "vouchers";


    public function customer(){
    	return $this->belongsTo('App\Customer','customer_id','id');
    }
}
