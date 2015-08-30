<?php

class Expert extends Eloquent{

	protected $table = 'experts';

    public function appointments(){
        return $this->hasMany('Appointment', 'expert_id');
    }

    public function specialties(){
        return $this->hasMany('ExpertSpecialty', 'expert_id');
    }

    public function services(){
        return $this->hasMany('ExpertService', 'expert_id');
    }

    public function memberships(){
        return $this->hasMany('ExpertMembership', 'expert_id');
    }

    public function achievements(){
        return $this->hasMany('ExpertAchievement', 'expert_id');
    }

    public function qualifications(){
        return $this->hasMany('ExpertQualification', 'expert_id');
    }

    public function socials(){
        return $this->hasMany('ExpertSocial', 'expert_id');
    }
}