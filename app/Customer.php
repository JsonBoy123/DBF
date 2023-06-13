<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];
    protected $table = 'customers';

    public function sales(){
    	return $this->hasManyThrough('App\Models\Sales\SalesItem','App\Models\Sales\Sale','customer_id','sale_id','id','id');
    }
}

