<?php

namespace App;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public function module(){
    	return $this->belongsTo('App\Models\Office\Permission\Module','moule_id');
    }
}
