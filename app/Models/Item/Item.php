<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Item extends Model
{
    protected $guarded = [];
    protected $table = 'items';

    public function ItemTax() {
    	return $this->belongsTo('App\Models\item\items_taxes', 'id','item_id');
    }

    public function brandName(){
    	return $this->belongsTo('App\Models\Manager\MciBrand', 'brand');
    }

    public function colorName(){
    	return $this->belongsTo('App\Models\Manager\MciColor', 'color');
    }

    public function categoryName(){
    	return $this->belongsTo('App\Models\Manager\MciCategory', 'category');
    }

    public function subcategoryName(){
    	return $this->belongsTo('App\Models\Manager\MciSubCategory', 'subcategory');
    }

    public function sizeName(){
    	return $this->belongsTo('App\Models\Manager\MciSize', 'size');
    }

    public function item_quantity(){
        return $this->belongsTo('App\Models\Item\item_quantities','id','item_id')->withDefault([
            'quantity' => '0']);
    }

    public function item_discount(){
        return $this->belongsTo('App\Models\Item\Item_Discount','id','item_id')->withDefault([
            'offer_status' => '0']);
    }

    public function item_quantities(){
        return $this->hasMany('App\Models\Item\item_quantities','item_id', 'id');
    }

    public function quantities(){
        return $this->hasMany(item_quantities::class, 'item_id', 'id');
    }   
}
