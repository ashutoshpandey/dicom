<?php

class Location extends Eloquent{

	protected $table = 'locations';

	public function institutes(){
		return $this->belongsTo('Institute', 'location_id');
	}

	public function experts(){
		return $this->belongsTo('Expert', 'location_id');
	}
}