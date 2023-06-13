<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;

class temp_item_sheets extends Model
{
    protected $guarded = [];
    protected $table = 'temp_items_sheet';

    public function uploader_name(){
    	return $this->belongsTo('App\Models\Manager\ControlPanel\CustomTab', "uploader_id");
    }
}
