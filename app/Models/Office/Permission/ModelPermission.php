<?php

namespace App\Models\Office\Permission;

use Illuminate\Database\Eloquent\Model;


class ModelPermission extends Model
{
    protected $table = 'module_has_permissions';
    protected $guarded = [];

    public function shop(){
    	return $this->belongsTo('App\Models\Office\Shop\Shop','permission_id');
    }
}
