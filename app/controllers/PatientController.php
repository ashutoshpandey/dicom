<?php

class PatientController extends BaseController
{

    function __construct()
    {
        View::share('root', URL::to('/'));

        $id = Session::get('admin_id');

        if(isset($id)){
            $user = User::find($id);

            View::share('name', $user->name);
            View::share('adminType', Session::get('admin_type'));
        }
    }

    function dashboard()
    {

        $patientId = Session::get('patient_id');

        if (!isset($patientId))
            return Redirect::to('/');

        return View::make('patients.patient-section');
    }

    function viewInstitutePatient($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $patient = Patient::find($id);

        $institute_id = Session::get('institute_id');

        $parents = InstituteConnection::where('connection_id', $institute_id)->where('status', 'active')->get();

        $hasParents = isset($parents) && count($parents) > 0;

        if (isset($patient)) {

            Session::set('current_patient_id', $patient->id);

            return View::make('patient.institute-patient')->with('found', true)->with('patient', $patient)->with('hasParents', $hasParents)->with('parents', $parents);
        }
        else
            return View::make('patient.institute-patient')->with('found', false);
    }

    function editPatient()
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $patientId = Session::get('patient_id');

        if (!isset($patientId))
            return Redirect::to('/');

        $patient = Patient::find($patientId);

        if (isset($patient))
            return View::make('patients.edit')->with('patient', $patient);
        else
            return Redirect::to('/');
    }

    function updatePatient()
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $patientId = Session::get('patient_id');

        if (!isset($patientId))
            return json_encode(array('message' => 'not logged'));

        $patient = patient::find($patientId);

        if (isset($patient)) {

            $email = Input::get('email');

            $patientByEmail = patient::where('email', '=', $email)->first();

            if (isset($patientByEmail) && $patientByEmail->id != $patient->id)
                echo 'duplicate';
            else {
                $patient->id = $patientId;
                $patient->email = $email;
                $patient->name = Input::get('name');
                $patient->password = Input::get('password');
                $patient->patient_type = Input::get('patient_type');

                $patient->save();

                return json_encode(array('message' => 'done'));
            }
        } else
            return json_encode(array('message' => 'invalid'));
    }

    function updatePassword()
    {

        $patientId = Session::get('patient_id');

        if (!isset($patientId))
            return json_encode(array('message' => 'not logged'));

        $patient = patient::find($patientId);

        if (isset($patient)) {

            $patient->password = Input::get('password');

            $patient->save();

            return json_encode(array('message' => 'done'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    function updatePicture()
    {

        $patientId = Session::get('patient_id');

        if (!isset($patientId))
            return json_encode(array('message' => 'not logged'));

        $patient = patient::find($patientId);

        if (isset($patient)) {

            if (Input::hasFile('image')) {

                $file = array('image' => Input::file('image'));

                $rules = array('image' => 'required|max:10000|mimes:png,jpg,jpeg,bmp,gif');
                $validator = Validator::make($file, $rules);
                if ($validator->fails()) {
                    echo 'wrong';
                } else {
                    $imageNameSaved = date('Ymdhis');

                    $imageName = Input::file('image')->getClientOriginalName();
                    $extension = Input::file('image')->getClientOriginalExtension();

                    $fileName = $imageNameSaved . '.' . $extension;
                    $destinationPath = "public/patient-images/$patientId/";

                    $directoryPath = base_path() . '/' . $destinationPath;

                    if (!file_exists($directoryPath))
                        mkdir($directoryPath);

                    Input::file('image')->move($destinationPath, $fileName);

                    $patient->image_name = $imageName;
                    $patient->image_name_saved = $fileName;

                    $patient->save();

                    return json_encode(array('message' => 'done'));
                }
            } else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    function uploadDocument()
    {

        $patientId = Session::get('patient_id');

        if (!isset($patientId))
            return json_encode(array('message' => 'not logged'));

        $patient = patient::find($patientId);

        if (isset($patient)) {

            if (Input::hasFile('documents')) {

                $files = Input::file('documents');

                $rules = array('image' => 'required|max:10000|mimes:png,jpg,jpeg,bmp,gif,pdf,doc,docx,xls,csv');

                foreach ($files as $file) {

                    $validator = Validator::make($file, $rules);
                    if ($validator->fails()) {
                        ;
                    } else {
                        $documentNameSaved = date('Ymdhis');

                        $documentName = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();

                        $fileName = $documentNameSaved . '.' . $extension;
                        $destinationPath = "public/patient-documents/$patientId/";

                        $directoryPath = base_path() . '/' . $destinationPath;

                        if (!file_exists($directoryPath))
                            mkdir($directoryPath);

                        $file->move($destinationPath, $fileName);

                        $patientDocument = new PatientDocument();

                        $patientDocument->document_name = $documentName;
                        $patientDocument->document_name_saved = $fileName;
                        $patientDocument->status = 'active';

                        $patientDocument->save();

                    }
                }

                return json_encode(array('message' => 'done'));
            } else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    function removeDocument($id)
    {

        $patientId = Session::get('patient_id');

        if (!isset($patientId))
            return json_encode(array('message' => 'not logged'));

        if (isset($id)) {
            $patientDocument = PatientDocument::find($id);

            if (isset($patientDocument)) {
                $patientDocument->status = 'removed';
                $patientDocument->save();
            }
        } else
            return json_encode(array('message' => 'invalid'));
    }

    /********************************** admin methods **********************************/

    public function patients()
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.patients');
    }

    public function savePatient()
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $email = Input::get('email');

        if ($this->isDuplicatePatient($email) === "no") {

            $patient = new Patient;

            $patient->name = Input::get('name');
            $patient->gender = Input::get('gender');
            $patient->email = $email;
            $patient->contact_number = Input::get('contact_number');
            $patient->country = Input::get('country');
            $patient->institute_id = Session::get('institute_id');

            $patient->status = "active";
            $patient->created_at = date("Y-m-d h:i:s");
            $patient->updated_at = date("Y-m-d h:i:s");

            $patient->save();

            return json_encode(array('message' => 'done'));
        } else
            return json_encode(array('message' => 'duplicate'));
    }

    public function updateInstitutePatient()
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $email = Input::get('email');

        $id = Session::get('current_patient_id');

        if(isset($id)) {
            $patient = Patient::find($id);

            if(isset($patient)) {

                if ($this->isDuplicatePatient($email, $patient->id) === "no") {

                    $patient->name = Input::get('name');
                    $patient->gender = Input::get('gender');
                    $patient->email = $email;
                    $patient->contact_number = Input::get('contact_number');

                    $patient->status = "active";
                    $patient->created_at = date("Y-m-d h:i:s");
                    $patient->updated_at = date("Y-m-d h:i:s");

                    $patient->save();

                    return json_encode(array('message' => 'done'));
                }
                else
                    return json_encode(array('message' => 'invalid'));
            } else
                return json_encode(array('message' => 'duplicate'));
        }
        else
            return json_encode(array('message' => 'invalid'));
    }

    public function updateAdminPatient()
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $patientId = Session::get('patient_id');

        if (isset($patientId)) {

            $patient = Patient::find($patientId);

            if (isset($patient)) {
                $patient->password = Input::get('password');
                $patient->first_name = Input::get('first_name');
                $patient->last_name = Input::get('last_name');
                $patient->gender = Input::get('gender');
                $patient->country = Input::get('country');
                $patient->email = Input::get('email');
                $patient->contact_number = Input::get('contact_number');

                $patient->updated_at = date("Y-m-d h:i:s");

                $patient->save();

                return json_encode(array('message' => 'done'));
            } else
                return json_encode(array('message' => 'invalid'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    public function isDuplicatePatient($email, $id = 0)
    {
        $patient = Patient::where('email', '=', $email)->first();

        if($id==0){
            return is_null($patient) ? "no" : "yes";
        }
        else {
            if (is_null($patient))
                return 'no';
            else
                return $patient->id == $id ? "no" : "yes";
        }
    }

    public function findPatient($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {
            $patient = Patient::find($id);

            if (isset($patient))
                return json_encode(array('message' => 'found', patient => $patient));
            else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    public function viewPatient($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {
            $patient = Patient::find($id);

            if (isset($patient)) {

                return View::make('patient.view-patient')
                    ->with('patient', $patient);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function getPatients($page = 1, $status = 'active')
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $instituteId = Session::get('institute_id');

        $patients = Patient::where('status', $status)->where('institute_id', $instituteId)->get();

        if (isset($patients) && count($patients) > 0) {

            return json_encode(array('message' => 'found', 'patients' => $patients->toArray()));
        } else
            return json_encode(array('message' => 'empty'));
    }

    function removePatient($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        if (isset($id)) {
            $patient = Patient::find($id);

            if (isset($patient)) {
                $patient->status = 'removed';
                $patient->save();

                return json_encode(array('message' => 'done'));
            } else
                return json_encode(array('message' => 'invalid'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    /********************************** admin methods **********************************/

    function removeAccount()
    {

        $patientId = Session::get('patient_id');

        if (!isset($patientId))
            return json_encode(array('message' => 'not logged'));

        if (isset($patientId)) {

            $patient = patient::find($patientId);

            if (isset($patient)) {
                $patient->status = 'removed';

                $patient->save();

                return json_encode(array('message' => 'done'));
            } else
                return json_encode(array('message' => 'invalid'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    /************** json methods ***************/
    function dataGetPatient($id)
    {

        $patient = Patient::find($id);

        if (isset($patient))
            return json_encode(array('message' => 'found', 'patient' => $patient));
        else
            return json_encode(array('message' => 'empty'));
    }

    function dataGetPatients($page = 1, $status = 'active')
    {

        $patients = Patient::where('status', $status)->get();

        if (isset($patients) && count($patients) > 0) {
            return json_encode(array('message' => 'found', 'patients' => $patients));
        } else
            return json_encode(array('message' => 'empty'));
    }

    public function dataPatientDocuments($patientId)
    {

        if (isset($patientId)) {
            $documents = PatientDocument::where('patient_id', '=', $patientId)->
            where('status', '=', 'active')->get();

            if (isset($documents) && count($documents) > 0)
                return json_encode(array('message' => 'found', 'documents' => $documents->toArray()));
            else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    public function patientRequests($type = 'incoming')
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $institute_id = Session::get('institute_id');

        if($type=='incoming') {
            if (isset($institute_id))
                $patientRequests = PatientRequest::where('institute_id', $institute_id)->with('Patient')->with('senderInstitute')->get();
            else
                $patientRequests = PatientRequest::whereIn('status', array('active', 'consultant replied', 'expert replied'))->with('Patient')->with('senderInstitute')->get();
        }
        else if($type=='outgoing'){
            if (isset($institute_id))
                $patientRequests = PatientRequest::where('connection_id', $institute_id)->with('Patient')->with('senderInstitute')->get();
            else
                $patientRequests = PatientRequest::where('status', 'active')->with('Patient')->with('Institute')->get();
        }

        if (isset($patientRequests) && count($patientRequests) > 0) {
            return json_encode(array('message' => 'found', 'patientRequests' => $patientRequests->toArray()));
        } else
            return json_encode(array('message' => 'empty'));
    }

    public function patientRequestHistory($patientId, $page = 1, $status = 'active'){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $institute_id = Session::get('institute_id');

        if(isset($institute_id))
            $patientRequests = PatientRequest::where('connection_id', $institute_id)->where('patient_id', $patientId)->where('status', $status)->with('Institute')->get();
        else
            $patientRequests = PatientRequest::where('status', 'active')->where('patient_id', $patientId)->with('Institute')->get();

        if(isset($patientRequests) && count($patientRequests)>0){
            return json_encode(array('message'=>'found', 'patientRequests' => $patientRequests->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }
/*
    public function addPatientRequest(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $email = Input::get('email');

        $patientRequest = new PatientRequest();

        $patientRequest->password = Input::get('password');
        $patientRequest->name = Input::get('name');
        $patientRequest->gender = Input::get('gender');
        $patientRequest->country = Input::get('country');
        $patientRequest->email = $email;
        $patientRequest->password = hash('sha256', uniqid());
        $patientRequest->contact_number = Input::get('contact_number');

        $patientRequest->status = "active";
        $patientRequest->created_at = date("Y-m-d h:i:s");
        $patientRequest->updated_at = date("Y-m-d h:i:s");

        $patientRequest->save();

        return json_encode(array('message'=>'done'));
    }

    public function forwardPatientRequest(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $patientRequestForward = new PatientRequestForward();

        $patientRequestForward->patient_id = Session::get('patient_id');
        $patientRequestForward->connection_id = Session::get('institute_id');
        $patientRequestForward->consultation_expert_id = Input::get('consultation_expert_id');
        $patientRequestForward->expert_id = Input::get('expert_id');

        $patientRequestForward->status = 'consultation';

        $patientRequestForward->created_at = date("Y-m-d h:i:s");
        $patientRequestForward->updated_at = date("Y-m-d h:i:s");

        $patientRequestForward->save();

        return json_encode(array('message'=>'done'));
    }

    public function patientRequestForwards(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $institute_id = Session::get('institute_id');

        if(isset($institute_id))
            $patientRequestForwards = PatientRequestForward::where('institute_id', $institute_id)->whereIn('status', array('consultation','expert'))->get();
        else
            $patientRequestForwards = PatientRequestForward::whereIn('status', array('consultation','expert'))->get();

        if(isset($patientRequestForwards) && count($patientRequestForwards)>0){
            return json_encode(array('message'=>'found', 'patientRequests' => $patientRequestForwards->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }
*/

    public function forwardPatientRequest(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $patientRequest = new PatientRequest();

        $patientRequest->patient_id = Session::get('current_patient_id');
        $patientRequest->connection_id = Session::get('institute_id');
        $patientRequest->institute_id = Input::get('institute_id');

        $patientRequest->status = 'consultation';

        $patientRequest->created_at = date("Y-m-d h:i:s");
        $patientRequest->updated_at = date("Y-m-d h:i:s");

        $patientRequest->save();

        return json_encode(array('message'=>'done'));
    }

    public function assignPatientRequest(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $id = Input::get('id');

        if(isset($id)) {
            $patientRequest = PatientRequest::find($id);

            $patientRequest->consultant_id = Input::get('consultant_id');
            $patientRequest->expert_id = Input::get('expert_id');
            $patientRequest->status = "assigned";

            $patientRequest->save();

            return json_encode(array('message' => 'done'));
        }
        else
            return json_encode(array('message' => 'invalid'));
    }

    public function patientRequestReplies(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $request_forward_id = Input::get('request_forward_id');

        $patientRequestForwardReplies = PatientRequestForwardReply::where('request_forward_id', $request_forward_id)->where('status', 'active')->get();

        if(isset($patientRequestForwardReplies) && count($patientRequestForwardReplies)>0){
            return json_encode(array('message'=>'found', 'patientRequestForwardReplies' => $patientRequestForwardReplies->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }
}