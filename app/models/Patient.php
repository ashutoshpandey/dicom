<?php

class Patient extends Eloquent{

	protected $table = 'patients';

	protected $hidden = array('password');

	public function institute(){
		return $this->belongsTo('Institute', 'institute_id');
	}
}