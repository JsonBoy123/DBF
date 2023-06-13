<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class inventory extends Model
{
    protected $guarded = [];
    protected $table = 'inventory';
    protected $primaryKey = 'trans_id';
    public $timestamps = false;


}
