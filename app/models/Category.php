<?php

class Category extends Eloquent{

	protected $table = 'categories';

    public function subcategories(){
        return $this->hasMany('SubCategory', 'category_id');
    }

    public function experts(){
        return $this->hasMany('ExpertCategory', 'category_id');
    }
}