<?php

class Patient extends Eloquent{

	protected $table = 'patients';

	protected $hidden = array('password');
}