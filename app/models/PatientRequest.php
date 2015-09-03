<?php

class PatientRequest extends Eloquent{

	protected $table = 'patient_requests';

    public function patient(){
        return $this->belongsTo('Patient', 'patient_id');
    }
}