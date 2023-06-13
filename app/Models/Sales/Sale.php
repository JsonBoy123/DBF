<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];

    public function sale_payment(){
    	return $this->belongsTo('App\Models\Sales\SalesPayment','id','sale_id');
    }

    public function customer(){
    	return $this->belongsTo('App\Customer','customer_id','id');
    }

    public function shop(){
    	return $this->belongsTo('App\Models\Office\Shop\Shop','employee_id','id');
    }

    public function cashier(){
        return $this->belongsTo('App\Models\Manager\ControlPanel\Cashier','cashier_id','id');
    }

    public function half_payment(){
        return $this->belongsTo('App\Models\Sales\HalfPayment','id','sale_id');
    }

    public function discount_amt(){
        return $this->belongsTo('App\Models\Sales\OtherDiscount','id','sale_id');
    }

    /*public function customers(){
        return $this->hasMany('App\Customer','customer_id','id');
    }*/

    public function sale_items(){
        return $this->hasMany('App\Models\Sales\SalesItem', 'sale_id');
    }

    public function employee(){
        return $this->belongsTo('App\Models\Office\Employees\Employees', 'employee_id');
    }

    public function employee_shop(){
        return $this->belongsTo('App\Models\Office\Shop\Shop', 'employee_id', 'id');
    }

    public function customer_due(){
        return $this->belongsTo('App\Models\Office\wholesaleCustomer\WholesaleCustomer', 'id', 'sale_id');
    }
}
