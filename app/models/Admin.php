<?php

class Admin extends Eloquent{

	protected $table = 'admins';

	protected $hidden = array('password');
}