<?php

namespace App\Models\Receivings;

use Illuminate\Database\Eloquent\Model;

class Receiving extends Model
{ 
    protected $table = 'receivings';
    protected $guarded = [];
    
    public function stock_movement(){
    	return $this->hasMany('App\Models\Stock\StockMovent','receiving_id');
    }

    public function receiving_items(){
    	return $this->hasMany('App\Models\Receivings\ReceivingItem','receiving_id');
    }

    public function repair_amount(){
        return $this->hasMany('App\Models\Repair\RepairComplete','rec_id');
    }

    public function shopName(){
    	return $this->belongsTo('App\Models\Office\Employees\Employees', 'employee_id');
    }

    public function repair_quantity(){
        return $this->hasMany('App\Models\Repair\RepairComplete', 'rec_id');
    }
    public function stocks_transfer(){
        return $this->hasMany('App\Models\Stock\StockTransfer','receiving_id');
    }
}
