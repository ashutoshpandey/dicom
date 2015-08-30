<?php

class ExpertSpecialty extends Eloquent{

	protected $table = 'expert_specialties';

    public function expert(){
        return $this->belongsTo('Expert', 'expert_id');
    }
}