<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $casts = [
    	'name' => 'json',
    	'shop_id' => 'json',
    	'address' => 'json'
    ];
}