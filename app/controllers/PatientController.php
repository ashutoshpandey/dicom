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

    function editPatient(){

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
}