<?php

class PatientController extends BaseController {

    function __construct(){
        View::share('root', URL::to('/'));
        View::share('name', Session::get('name'));
    }

    function dashboard(){

        $patientId = Session::get('patient_id');

        if(!isset($patientId))
            return Redirect::to('/');

        return View::make('patients.patient-section');
    }

    function viewInstitutePatient($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $patient = Patient::find($id);

        if(isset($patient))
            return View::make('patient.institute-patient')->with('found', true)->with('patient', $patient);
        else
            return View::make('patient.institute-patient')->with('found', false);
    }

    function editPatient(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $patientId = Session::get('patient_id');

        if(!isset($patientId))
            return Redirect::to('/');

        $patient = Patient::find($patientId);

        if(isset($patient))
            return View::make('patients.edit')->with('patient', $patient);
        else
            return Redirect::to('/');
    }

    function updatePatient(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $patientId = Session::get('patient_id');

        if(!isset($patientId))
            return json_encode(array('message'=>'not logged'));

        $patient = patient::find($patientId);

        if(isset($patient)){

            $email = Input::get('email');

            $patientByEmail = patient::where('email', '=', $email)->first();

            if(isset($patientByEmail) && $patientByEmail->id != $patient->id)
                echo 'duplicate';
            else{
                $patient->id = $patientId;
                $patient->email = $email;
                $patient->name = Input::get('name');
                $patient->password = Input::get('password');
                $patient->patient_type = Input::get('patient_type');

                $patient->save();

                return json_encode(array('message'=>'done'));
            }
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function updatePassword(){

        $patientId = Session::get('patient_id');

        if(!isset($patientId))
            return json_encode(array('message'=>'not logged'));

        $patient = patient::find($patientId);

        if(isset($patient)){

            $patient->password = Input::get('password');

            $patient->save();

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function updatePicture(){

        $patientId = Session::get('patient_id');

        if(!isset($patientId))
            return json_encode(array('message'=>'not logged'));

        $patient = patient::find($patientId);

        if(isset($patient)){

            if (Input::hasFile('image')){

                $file = array('image' => Input::file('image'));

                $rules = array('image' => 'required|max:10000|mimes:png,jpg,jpeg,bmp,gif');
                $validator = Validator::make($file, $rules);
                if ($validator->fails()) {
                    echo 'wrong';
                }
                else {
                    $imageNameSaved = date('Ymdhis');

                    $imageName = Input::file('image')->getClientOriginalName();
                    $extension = Input::file('image')->getClientOriginalExtension();

                    $fileName = $imageNameSaved . '.' . $extension;
                    $destinationPath = "public/patient-images/$patientId/";

                    $directoryPath = base_path() . '/' . $destinationPath;

                    if(!file_exists($directoryPath))
                        mkdir($directoryPath);

                    Input::file('image')->move($destinationPath, $fileName);

                    $patient->image_name = $imageName;
                    $patient->image_name_saved = $fileName;

                    $patient->save();

                    return json_encode(array('message'=>'done'));
                }
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function uploadDocument(){

        $patientId = Session::get('patient_id');

        if(!isset($patientId))
            return json_encode(array('message'=>'not logged'));

        $patient = patient::find($patientId);

        if(isset($patient)){

            if (Input::hasFile('documents')){

                $files = Input::file('documents');

                $rules = array('image' => 'required|max:10000|mimes:png,jpg,jpeg,bmp,gif,pdf,doc,docx,xls,csv');

                foreach($files as $file) {

                    $validator = Validator::make($file, $rules);
                    if ($validator->fails()) {
                        ;
                    }
                    else {
                        $documentNameSaved = date('Ymdhis');

                        $documentName = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();

                        $fileName = $documentNameSaved . '.' . $extension;
                        $destinationPath = "public/patient-documents/$patientId/";

                        $directoryPath = base_path() . '/' . $destinationPath;

                        if(!file_exists($directoryPath))
                            mkdir($directoryPath);

                        $file->move($destinationPath, $fileName);

                        $patientDocument = new PatientDocument();

                        $patientDocument->document_name = $documentName;
                        $patientDocument->document_name_saved = $fileName;
                        $patientDocument->status = 'active';

                        $patientDocument->save();

                    }
                }

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function removeDocument($id){

        $patientId = Session::get('patient_id');

        if(!isset($patientId))
            return json_encode(array('message'=>'not logged'));

        if(isset($id)) {
            $patientDocument = PatientDocument::find($id);

            if(isset($patientDocument)){
                $patientDocument->status = 'removed';
                $patientDocument->save();
            }
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

/********************************** admin methods **********************************/

    public function patients(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.patients');
    }

    public function savePatient(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $email = Input::get('email');

        if($this->isDuplicatePatient($email)==="no"){

            $patient = new Patient;

            $patient->password = Input::get('password');
            $patient->name = Input::get('name');
            $patient->gender = Input::get('gender');
            $patient->country = Input::get('country');
            $patient->email = $email;
            $patient->password = hash('sha256', uniqid());
            $patient->contact_number = Input::get('contact_number');

            $patient->status = "active";
            $patient->created_at = date("Y-m-d h:i:s");
            $patient->updated_at = date("Y-m-d h:i:s");

            $patient->save();

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'duplicate'));
    }

    public function updateAdminPatient(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $patientId = Session::get('patient_id');

        if(isset($patientId)){

            $patient = Patient::find($patientId);

            if(isset($patient)) {
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
            }
            else
                return json_encode(array('message' => 'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function isDuplicatePatient($email)
    {
        $patient = Patient::where('email', '=', $email)->first();

        return is_null($patient) ? "no" : "yes";
    }

    public function findPatient($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){
            $patient = Patient::find($id);

            if(isset($patient))
                return json_encode(array('message' => 'found', patient => $patient));
            else
                return json_encode(array('message' => 'empty'));
        }
        else
            return json_encode(array('message' => 'invalid'));
    }

    public function viewPatient($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){
            $patient = Patient::find($id);

            if(isset($patient)){

                Session::put('patient_id', $id);

                if($patient->gender=='male'){
                    $male_checked = 'checked="checked"';
                    $female_checked = '';
                }
                else{
                    $female_checked = 'checked="checked"';
                    $male_checked = '';
                }

                return View::make('admin.view-patient')
                    ->with('patient', $patient)
                    ->with('male_checked', $male_checked)
                    ->with('female_checked', $female_checked);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function getPatients($page = 1, $status = 'active'){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $patients = Patient::where('status', $status)->get();

        if(isset($patients) && count($patients)>0){

            return json_encode(array('message'=>'found', 'patients' => $patients->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    function removePatient($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        if(isset($id)) {
            $patient = Patient::find($id);

            if(isset($patient)){
                $patient->status = 'removed';
                $patient->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

/********************************** admin methods **********************************/

    function removeAccount(){

        $patientId = Session::get('patient_id');

        if(!isset($patientId))
            return json_encode(array('message'=>'not logged'));

        if(isset($patientId)) {

            $patient = patient::find($patientId);

            if(isset($patient)){
                $patient->status = 'removed';

                $patient->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    /************** json methods ***************/
    function dataGetPatient($id){

        $patient = Patient::find($id);

        if(isset($patient))
            return json_encode(array('message'=>'found', 'patient' => $patient));
        else
            return json_encode(array('message'=>'empty'));
    }

    function dataGetPatients($page=1, $status='active'){

        $patients = Patient::where('status', $status)->get();

        if(isset($patients) && count($patients)>0){
            return json_encode(array('message'=>'found', 'patients' => $patients));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function dataPatientDocuments($patientId){

        if(isset($patientId)){
            $documents = PatientDocument::where('patient_id','=',$patientId)->
                where('status','=','active')->get();

            if(isset($documents) && count($documents)>0)
                return json_encode(array('message'=>'found', 'documents' => $documents->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function patientRequests(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $institute_id = Session::get('institute_id');

        if(isset($institute_id))
            $patientRequests = PatientRequest::where('connection_id', $institute_id)->where('status', 'active')->get();
        else
            $patientRequests = PatientRequest::where('status', 'active')->get();

        if(isset($patientRequests) && count($patientRequests)>0){
            return json_encode(array('message'=>'found', 'patientRequests' => $patientRequests->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

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

        $patientRequestForward->patient_id = Input::get('patient_id');
        $patientRequestForward->connection_id = Input::get('connection_id');
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

    public function addForwardPatientRequestReply(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $patientRequestForwardReply = new PatientRequestForwardReply();

        $patientRequestForwardReply->request_forward_id = Input::get('request_forward_id');
        $patientRequestForwardReply->forward_id = Input::get('forward_id');
        $patientRequestForwardReply->expert_id = Input::get('expert_id');
        $patientRequestForwardReply->comment = Input::get('comment');

        $patientRequestForwardReply->status = 'active';

        $patientRequestForwardReply->created_at = date("Y-m-d h:i:s");
        $patientRequestForwardReply->updated_at = date("Y-m-d h:i:s");

        $patientRequestForwardReply->save();

        return json_encode(array('message'=>'done'));
    }

    public function patientRequestForwardReplies(){

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