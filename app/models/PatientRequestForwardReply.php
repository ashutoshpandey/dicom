<?php

class PatientRequestForwardReply extends Eloquent{

	protected $table = 'patient_request_forward_replies';

    public function patientRequestForward(){
        return $this->belongsTo('PatientRequestForward', 'request_forward_id');
    }

    public function expert(){
        return $this->belongsTo('Expert', 'expert_id');
    }
}