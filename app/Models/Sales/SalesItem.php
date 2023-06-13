<?php
namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    protected $table = 'sales_items';
    protected $guarded = [];

    public function item(){
    	
    	return $this->belongsTo('App\Models\Item\Item','item_id', 'id');
    }

    public function sale(){
    	return $this->belongsTo('App\Models\Sales\Sale','sale_id', 'id');
    }

    public function category(){
    	return $this->belongsTo('App\Models\Manager\MciCategory', 'category_id');
    }

    public function scopeGetCateIds($query, $date){

        return $query->whereDate('created_at', date('Y-m-d', strtotime($date)))
                ->whereHas('sale', function($q){
                    $q->where('sale_type', 'retail');
                })
                ->groupBy('category_id')
                ->pluck('category_id');
    }

    //Get collect category IDs of specific date
    public function scopeGetDateItems($query, $date){

        return $query->with(['item'])
                ->whereHas('sale', function($q){
                    $q->where('sale_type', 'retail');
                })
                ->whereDate('created_at', date('Y-m-d', strtotime($date)));
    }

    //Get collect category IDs of specific date
    public function scopeSearchTaxRates($query, $date, $tax){

        return $query->whereDate('created_at', date('Y-m-d', strtotime($date)))
                ->whereHas('sale', function($q){
                    $q->where('sale_type', 'retail');
                })
                ->where('sale_type', 'retail')
                ->where('taxe_rate', $tax)->with(['item']);
    }

    //For Sale items search report
    public function scopeSearchCatItems($query, $date, $categ){

        return $query->whereDate('created_at', date('Y-m-d', strtotime($date)))
                ->whereHas('sale', function($q){
                    $q->where('sale_type', 'retail');
                })
                ->where('category_id', $categ)->with(['item']);
    }

    //For Sale items search report
    public function scopeSearchItems($query, $date, $categ, $tax){

        return $query->where('sale_type', 'retail')
                    ->whereHas('sale', function($q){
                    $q->where('sale_type', 'retail');
                })
                ->whereDate('created_at', date('Y-m-d', strtotime($date)))
                ->where([['category_id', $categ], ['taxe_rate', $tax]])
                ->with(['item']);
    }
}