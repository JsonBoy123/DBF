<?php

namespace App\Models\Office\Employees;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table = 'employees';
    protected $guarded = [];

    public function usersInfo(){
        return $this->belongsTo('App\User','user_id');
    }

    public function shop(){
        return $this->hasOne('App\Models\Office\Shop\Shop', 'shop_owner_id');
    }
    
}