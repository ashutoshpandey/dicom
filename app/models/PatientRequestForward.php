<?php

class PatientRequestForward extends Eloquent{

	protected $table = 'patient_request_forwards';

    public function patient(){
        return $this->belongsTo('Patient', 'patient_id');
    }

    public function consultationExpert(){
        return $this->belongsTo('Expert', 'consultation_expert_id');
    }

    public function expert(){
        return $this->belongsTo('Expert', 'expert_id');
    }
}