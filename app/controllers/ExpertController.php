<?php

class ExpertController extends BaseController {

    function __construct()
    {
        View::share('root', URL::to('/'));

        $id = Session::get('admin_id');

        if(isset($id)){
            $expert = Expert::find($id);

            View::share('name', $expert->name);
        }
    }

    public function expertSection(){
        return View::make('expert.expert-section');
    }

    public function requests(){
        return View::make('expert.requests');
    }

    public function manage(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return Redirect::to('/');

        $expert = Expert::find($expertId);

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

    public function getExpertRequests($type = 'incoming')
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        if($type=='incoming') {
            if (isset($adminId))
                $patientRequests = PatientRequest::where('consultant_id', $adminId)->with('Patient')->with('senderInstitute')->with('receiverInstitute')->get();
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

    public function addRequestReply(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $requestId = Input::get('id');

        if(isset($requestId)) {

            $patientRequest = PatientRequest::find($requestId);

            if (isset($patientRequest)) {

                $patientRequestReply = new PatientRequestReply();

                $patientRequestReply->request_id = $requestId;
                $patientRequestReply->reply_from = 'consultant';
                $patientRequestReply->expert_id = Session::get('expert_id');
                $patientRequestReply->comment = Input::get('reply');

                $patientRequestReply->status = 'active';

                $patientRequestReply->created_at = date("Y-m-d h:i:s");
                $patientRequestReply->updated_at = date("Y-m-d h:i:s");

                $patientRequestReply->save();

                $patientRequest->status = 'consultant replied';
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
}