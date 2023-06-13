<?php

namespace App\Models\Manager\ControlPanel;

use Illuminate\Database\Eloquent\Model;

class ShopLocation extends Model
{
    protected $guarded = [];
    protected $table = "stock_locations";

    public function cashier(){
        return $this->belongsTo('App\Models\Manager\ControlPanel\Cashier','cashier_id','id');
    }

}
