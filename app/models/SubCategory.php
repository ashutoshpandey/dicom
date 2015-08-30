<?php

class SubCategory extends Eloquent{

	protected $table = 'sub_categories';

	public function category(){
		return $this->belongsTo('Category', 'category_id');
	}
}