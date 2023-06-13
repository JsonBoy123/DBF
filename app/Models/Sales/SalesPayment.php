<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class SalesPayment extends Model
{
    protected $table = 'sales_payments';
    protected $guarded = [];

    public function sale(){
    	return $this->belongsTo('App\Models\Sales\Sale', 'sale_id');
    }
}
