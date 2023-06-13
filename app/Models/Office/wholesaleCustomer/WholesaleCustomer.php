<?php

namespace App\Models\Office\wholesaleCustomer;

use Illuminate\Database\Eloquent\Model;

class WholesaleCustomer extends Model
{
    protected $guarded = [];
    protected $table = 'wholesale_customers_details';

    public function customer(){
    	return $this->belongsTo('App\Customer','customer_id','id');
    }
}
