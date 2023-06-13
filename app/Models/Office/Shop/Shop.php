<?php

namespace App\Models\Office\Shop;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $guarded = [];
    protected $table = 'shops';

    public function employee(){
    	return $this->belongsTo('App\Models\Office\Employees\Employees', 'shop_owner_id');
    }
}
