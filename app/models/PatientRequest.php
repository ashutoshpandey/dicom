<?php

class PatientRequest extends Eloquent{

	protected $table = 'patient_requests';

    public function patient(){
        return $this->belongsTo('Patient', 'patient_id');
    }

    public function senderInstitute(){
        return $this->belongsTo('Institute', 'connection_id');
    }

    public function receiverInstitute(){
        return $this->belongsTo('Institute', 'institute_id');
    }
}