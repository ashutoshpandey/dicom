<?php

class InstituteConnection extends Eloquent{

	protected $table = 'institute_connections';

	public function institute(){
		return $this->belongsTo('Institute', 'institute_id');
	}

	public function connectedInstiute(){
		return $this->belongsTo('Institute', 'connection_id');
	}
}