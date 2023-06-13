<?php

namespace App\Models\Manager\ControlPanel;

use Illuminate\Database\Eloquent\Model;

class CashierShop extends Model
{
    protected $guarded =[];
    protected $table = "cashier_shops";

    public function cashier(){
        return $this->belongsTo('App\Models\Manager\ControlPanel\Cashier','cashier_id','id');
    }
}
