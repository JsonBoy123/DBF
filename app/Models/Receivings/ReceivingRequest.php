<?php

namespace App\Models\Receivings;

use Illuminate\Database\Eloquent\Model;

class ReceivingRequest extends Model
{ 
    protected $table = 'receivings_request';
    protected $guarded = [];
    
    public function requested_items(){
    	return $this->hasMany(ReceivingRequestItems::class, 'receiving_request_id');
    }

    public function receivings(){
    	return $this->belongsTo(Receiving::class, 'reference_receiving_id', 'id');
    }
    
    public function return_receivings(){
    	return $this->belongsTo(Receiving::class, 'return_receiving_id', 'id');
    }
}
