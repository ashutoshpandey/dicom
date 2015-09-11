<?php

class Quotation extends Eloquent{

	protected $table = 'quotations';

    public function request(){
        return $this->belongsTo('Request', 'request_id');
    }
}