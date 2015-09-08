<?php

class PatientRequestReply extends Eloquent{

	protected $table = 'patient_request_replies';

    public function patientRequest(){
        return $this->belongsTo('PatientRequest', 'request_id');
    }

    public function expert(){
        return $this->belongsTo('Expert', 'expert_id');
    }
}