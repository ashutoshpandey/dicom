<?php

class ExpertQualification extends Eloquent{

	protected $table = 'expert_qualifications';

    public function expert(){
        return $this->belongsTo('Expert', 'expert_id');
    }
}