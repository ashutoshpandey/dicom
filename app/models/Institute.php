<?php

class Institute extends Eloquent{

	protected $table = 'institutes';

	public function location(){
		return $this->belongsTo('Location', 'location_id');
	}
}