<?php

namespace App\Models\Office\Permission;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
   protected $table   = 'permissions';
   protected $guarded = []; 

    public function module(){
   		return $this->belongsTo('App\Models\Office\Permission\Module','moule_id');
    }
}
