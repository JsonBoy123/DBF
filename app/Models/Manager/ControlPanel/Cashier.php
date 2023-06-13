<?php

namespace App\Models\Manager\ControlPanel;

use Illuminate\Database\Eloquent\Model;

class Cashier extends Model
{
    protected $guarded = [];
    protected $table = 'cashiers';

    public function CashierData(){
    	return $this->belongsTo("App\Models\Manager\ControlPanel\CashierShop");
    }
}