<?php

class ExpertController extends BaseController {

    function __construct()
    {
        View::share('root', URL::to('/'));

        $adminType = Session::get('admin_type');

        if(isset($adminType)) {
            View::share('name', Session::get('name'));
            View::share('adminType', Session::get('admin_type'));

            $id = Session::get('expert_id');
            $expert = Expert::find($id);
            View::share('name', $expert->name);
        }
    }

    public function expertSection(){

        $expertId = Session::get('expert_id');
        if(!isset($expertId))
            return Redirect::to('/');

        return View::make('expert.expert-section');
    }

    public function requests(){

        $expertId = Session::get('expert_id');
        if(!isset($expertId))
            return Redirect::to('/');

        return View::make('expert.requests')->with('currentExpertId', $expertId);
    }

    public function manage(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return Redirect::to('/');

        $appointment_count = Appointment::where('expert_id', '=', $expertId)
                                        ->where('status','=','booked')
                                        ->where('appointment_date','>=', date('Y-m-d H:i:s'))->count();

        $availability_count = Appointment::where('expert_id', '=', $expertId)
            ->where('status','=','pending')
            ->where('appointment_date','>=', date('Y-m-d H:i:s'))->count();

        return View::make('expert.dashboard')
                    ->with('appointment_count', $appointment_count)
                    ->with('availability_count', $availability_count);
    }

    public function getExpertRequests($type = 'incoming'){

        $expertId = Session::get('expert_id');
        if (!isset($expertId))
            return json_encode(array('message' => 'not logged'));

        if($type=='incoming') {
            if (isset($expertId))
                $patientRequests = PatientRequest::whereIn('status', array('assigned', 'consultant replied', 'expert replied'))->with('Patient')->with('senderInstitute')->with('receiverInstitute')->get();
            else
                $patientRequests = PatientRequest::where('status', 'active')->with('Patient')->with('receiverInstitute')->get();
        }
        else if($type=='outgoing'){
            if (isset($institute_id))
                $patientRequests = PatientRequest::where('connection_id', $institute_id)->with('Patient')->with('senderInstitute')->get();
            else
                $patientRequests = PatientRequest::where('status', 'active')->with('Patient')->with('receiverInstitute')->get();
        }

        if (isset($patientRequests) && count($patientRequests) > 0) {
            return json_encode(array('message' => 'found', 'patientRequests' => $patientRequests->toArray()));
        } else
            return json_encode(array('message' => 'empty'));
    }

    public function getConsultantRequestReply($requestId){

        $expertId = Session::get('expert_id');
        if (!isset($expertId))
            return json_encode(array('message' => 'not logged'));

        $requestReply = PatientRequestReply::where('request_id', $requestId)->where('reply_from', 'consultant')->first();

        if (isset($requestReply)) {
            return json_encode(array('message' => 'found', 'requestReply' => $requestReply->toArray()));
        } else
            return json_encode(array('message' => 'empty'));
    }

    public function addRequestReply(){

        $expertId = Session::get('expert_id');
        if(!isset($expertId))
            return json_encode(array('message'=>'not logged'));

        $requestId = Input::get('id');

        if(isset($requestId)) {

            $patientRequest = PatientRequest::find($requestId);

            if (isset($patientRequest)) {

                if($patientRequest->status == "consultant replied") {
                    $patientRequest->status = 'expert replied';
                    $replyFrom = "expert";
                }
                else if($patientRequest->status == "assigned") {
                    $patientRequest->status = 'consultant replied';
                    $replyFrom = "consultant";
                }

                $patientRequestReply = new PatientRequestReply();

                $patientRequestReply->request_id = $requestId;
                $patientRequestReply->reply_from = $replyFrom;
                $patientRequestReply->expert_id = Session::get('expert_id');
                $patientRequestReply->comment = Input::get('reply');

                $patientRequestReply->status = 'active';

                $patientRequestReply->created_at = date("Y-m-d h:i:s");
                $patientRequestReply->updated_at = date("Y-m-d h:i:s");

                $patientRequestReply->save();

                $patientRequest->save();

                return json_encode(array('message' => 'done'));
            } else
                return json_encode(array('message' => 'invalid'));
        }
        else
            return json_encode(array('message' => 'invalid'));
    }

    function dataGetExpert($id){

        $expert = Expert::find($id);

        return $expert;
    }

    function viewPatient($id)
    {
        
        $expertId = Session::get('expert_id');
        if (!isset($expertId))
            return json_encode(array('message' => 'not logged'));

        $patientRequest = PatientRequest::find($id);

        if(isset($patientRequest)) {

            $patient = Patient::find($patientRequest->patient_id);

            if (isset($patient)) {

                return View::make('expert.view-patient')->with('found', true)->with('patient', $patient);
            } else
                return View::make('expert.view-patient')->with('found', false);
        }
        else
            return View::make('expert.view-patient')->with('found', false);
    }

    function viewInstitute($id)
    {

        $expertId = Session::get('expert_id');
        if (!isset($expertId))
            return json_encode(array('message' => 'not logged'));

        $patientRequest = PatientRequest::find($id);

        if(isset($patientRequest)) {

            $institute = Institute::find($patientRequest->connection_id);

            if (isset($institute)) {

                return View::make('expert.view-institute')->with('found', true)->with('institute', $institute);
            }
            else
                return View::make('expert.view-institute')->with('found', false);
        }
        else
            return View::make('expert.view-institute')->with('found', false);
    }
}