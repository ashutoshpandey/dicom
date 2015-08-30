<?php

class UserDocument extends Eloquent{

	protected $table = 'user_documents';

    public function user(){
        return $this->belongsTo('User', 'user_id');
    }
}