<?php

class ExpertCategory extends Eloquent{

	protected $table = 'expert_categories';

    public function expert(){
        return $this->belongsTo('Expert', 'expert_id');
    }

    public function category(){
        return $this->belongsTo('Category', 'category_id');
    }

    public function subcategory(){
        return $this->belongsTo('SubCategory', 'subcategory_id');
    }
}