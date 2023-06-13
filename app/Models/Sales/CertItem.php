<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class CertItem extends Model
{
    //cert_items
    protected $guarded = [];
    protected $table = 'cert_items';

    public function itemsDetails(){
    	return $this->belongsTo('App\Models\Item\Item','item_id');
    	// return $this->belongsTo('App\Models\Sales\CertItem', 'id','sales_manage_id');
    }
    public function itemTaxes(){
    	return $this->belongsTo('App\Models\Item\items_taxes','item_id');
    	// return $this->belongsTo('App\Models\Sales\CertItem', 'id','sales_manage_id');
    }
}
