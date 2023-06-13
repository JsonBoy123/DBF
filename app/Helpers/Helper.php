<?php 
	namespace App\Helpers;
	use DB;

	class Helper
	{
	    public function getItemsAutoIncrementId()
	    {
	        $autoId = DB::select(DB::raw("SELECT nextval('items_id_seq')"));
        	return $nextval = $autoId[0]->nextval;
	    }
	}