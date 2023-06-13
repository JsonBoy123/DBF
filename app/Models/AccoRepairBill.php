<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccoRepairBill extends Model
{
    protected $table = 'account_repair_bill';
    protected $guarded = [];

    public function item(){
    	return $this->belongsTo('App\Models\Item\Item', 'item_id');
    }

    public function repairItems(){
    	return $this->hasMany('App\Models\AccoRepairItem', 'bill_id', 'id');
    }
}
