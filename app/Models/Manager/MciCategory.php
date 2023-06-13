<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Model;

class MciCategory extends Model
{
    protected $guarded = [];
    protected $table = 'mci_categories';

    public function saleItems(){
    	return $this->hasMany('App\Models\Sales\SalesItem', 'category_id');
    }

    public function salescat(){
    	return $this->hasManyThrough('App\Models\Sales\Sale','App\Models\Sales\SalesItem','category_id','id','id','sale_id');
    }

    //Get categories on specific date
    public function scopeGetCategories($query, $items){

        return $query->whereIn('id', $items)->pluck('category_name', 'id');
    }

}