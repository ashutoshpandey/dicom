<?php

class PatientDocument extends Eloquent{

	protected $table = 'patient_documents';

    public function user(){
        return $this->belongsTo('Patient', 'patient_id');
    }
}