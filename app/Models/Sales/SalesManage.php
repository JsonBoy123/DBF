<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class SalesManage extends Model
{
    protected $guarded = [];
    protected $table = 'sales_manages';

    public function Location(){
    	return $this->belongsTo('App\Models\Office\Shop\Shop', 'stock_location');
    }
    public function certItems(){
    	return $this->belongsTo('App\Models\Sales\CertItem', 'id','sales_manage_id');
    }
}
