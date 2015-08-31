<?php

class InstituteController extends BaseController {

    public function __construct(){

        $this->beforeFilter(function(){
            View::share('name', Session::get('name'));
            View::share('root', URL::to('/'));
        });
    }

    public function save(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $institute = new Institute();

        $institute->name = Input::get('name');
        $institute->establish_date = date('Y-m-d h:i:s', strtotime(Input::get('establish_date')));
        $institute->address = Input::get('address');
        $institute->city = Input::get('city');
        $institute->state = Input::get('state');
        $institute->country = Input::get('country');
        $institute->land_mark = Input::get('land_mark');
        $institute->contact_number_1 = Input::get('contact_number_1');
        $institute->contact_number_2 = Input::get('contact_number_2');
        $institute->latitude = Input::get('latitude');
        $institute->longitude = Input::get('longitude');
        $institute->status = 'active';

        $institute->save();

        return json_encode(array('message'=>'done'));
    }

    public function update(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $id = Session::get('institute_id');

        $institute = Institute::find($id);

        if(is_null($institute))
            return json_encode(array('message'=>'invalid'));
        else{
            $institute->name = Input::get('name');
            $institute->establish_date = date('Y-m-d h:i:s', strtotime(Input::get('establish_date')));
            $institute->address = Input::get('address');
            $institute->city = Input::get('city');
            $institute->state = Input::get('state');
            $institute->country = Input::get('country');
            $institute->zip = Input::get('zip');
            $institute->land_mark = Input::get('land_mark');
            $institute->contact_number_1 = Input::get('contact_number_1');
            $institute->contact_number_2 = Input::get('contact_number_2');
            $institute->latitude = Input::get('latitude');
            $institute->longitude = Input::get('longitude');

            $institute->save();

            return json_encode(array('message'=>'done'));
        }
    }

    public function instituteExperts($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $institute = Institute::find($id);

            if(isset($institute)){

                Session::put('current_institute', $id);

                return View::make('admin.institute-experts')->with('institute', $institute);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function saveExpert(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $instituteId = Session::get('current_institute');
        if(!isset($instituteId))
            return Redirect::to('/');

        $expert = new Expert();

        $expert->institute_id = $instituteId;
        $expert->name = Input::get('name');
        $expert->contact_number = Input::get('contact_number');
        $expert->email = Input::get('email');
        $expert->status = 'active';

        $expert->save();

        return json_encode(array('message'=>'done'));
    }

    public function listExperts($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $instituteId = Session::get('current_institute');
        if(!isset($instituteId))
            return json_encode(array('message'=>'invalid'));

        $experts = Expert::where('status','=',$status)->where('institute_id', $instituteId)->get();

        if(isset($experts) && count($experts)>0){

            return json_encode(array('message'=>'found', 'experts' => $experts->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function removeExpert($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $expert = Expert::find($id);

        if(is_null($expert))
            return json_encode(array('message'=>'invalid'));
        else{
            $expert->status = 'removed';
            $expert->save();

            return json_encode(array('message'=>'done'));
        }
    }

    public function adminListInstitutes($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $institutes = Institute::where('status','=',$status)->with('location')->get();

        if(isset($institutes) && count($institutes)>0){

            return json_encode(array('message'=>'found', 'institutes' => $institutes->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function listInstitutes($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $institutes = Institute::where('status','=',$status)->get();

        if(isset($institutes) && count($institutes)>0){

            return json_encode(array('message'=>'found', 'institutes' => $institutes->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function remove($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $institute = Institute::find($id);

        if(is_null($institute))
            return json_encode(array('message'=>'invalid'));
        else{
            $institute->status = 'removed';
            $institute->save();

            return json_encode(array('message'=>'done'));
        }
    }

    public function dashboard(){

        $institute_id = Session::get('institute_id');

        if(!isset($institute_id))
            return Redirect::to('/');

        $expert_count = Expert::where('institute_id', '=', $institute_id)
                                        ->where('status','=','active')->count();

        return View::make('institute.dashboard')
                    ->with('expert_count', $expert_count);
    }

    public function experts(){

        $institute_id = Session::get('institute_id');

        if(!isset($institute_id))
            return Redirect::to('/');

        return View::make('institute.experts');
    }

    public function createExpert(){

        $institute_id = Session::get('institute_id');

        if(!isset($institute_id))
            return Redirect::to('/');

        return View::make('institute.create-expert');
    }

    public function viewExpert($id){

        $institute_id = Session::get('institute_id');

        if(!isset($institute_id))
            return Redirect::to('/');

        if(isset($id)){
            $expert = Expert::find($id);

            if(isset($expert))
                return View::make('admin.view-expert')->with("expert", $expert);
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function updateExpert(){

        $institute_id = Session::get('institute_id');

        if(!isset($institute_id))
            return 'not logged';

        $email = Input::get('email');

        if($this->isDuplicateExpert($email)==='no'){

            $expert = new Expert;

            $expert->email = $email;
            $expert->password = Input::get('password');
            $expert->first_name = Input::get('first_name');
            $expert->last_name = Input::get('last_name');
            $expert->city = Input::get('city');
            $expert->about = "";
            $expert->status = "active";
            $expert->created_at = date("Y-m-d h:i:s");
            $expert->updated_at = date("Y-m-d h:i:s");

            $expert->save();

            return 'done';
        }
        else
            return 'duplicate';
    }

    public function setExpertAppointments(){
        return View::make('institute.set-appointments');
    }

    public function profile(){

        $id = Session::get('institute_id');

        $institute = Institute::find($id);

        return View::make('institute.profile')->with("institute", $institute);
    }

    public function updateProfile(){

		$id = Session::get('institute_id');

        $institute = Institute::find($id);

        if(is_null($institute))
            return "invalid";
        else{

            $institute->category_id = Input::get('category_id');

            $institute->email = Input::get('email');
            $institute->password = Input::get('password');
            $institute->name = Input::get('first_name');
            $institute->country = Input::get('country');
            $institute->about = Input::get('about');
            $institute->updated_at = date("Y-m-d H:i:s");

            $institute->save();

            return "done";
        }
    }

    /************** json methods ***************/

    function dataGetInstitute($id){

        $institute = Institute::find($id);

        return $institute;
    }

    public function dataCancelAppointment($id){

        $instituteId = Session::get('institute_id');

        if(!isset($instituteId))
            return 'not logged';

        if(!isset($id))
            return 'invalid';

        $appointment = Appointment::find($id);

        if(is_null($appointment))
            return 'invalid';
        else{
            $appointment->status = 'institute-cancelled';
            $appointment->updated_at = date('Y-m-d H:i:s');

            $appointment->save();

            return 'done';
        }
    }

    function dataInstituteExperts($id){

        if(isset($id)){
            $experts = Expert::where('institute_id', '=', $id)->get();
        }
        else{
            $institute_id = Session::get('institute_id');

            if(!isset($institute_id))
                return 'not logged';

            $experts = Expert::where('institute_id', '=', $institute_id)->get();
        }

        if(isset($experts))
            return json_encode(array('message' => 'found', 'experts' => $experts));
        else
            return json_encode(array('message' => 'empty'));
    }

    function dataInstituteAppointments($id, $startDate=null, $endDate=null){

        if(isset($id)){

            if(isset($startDate) && isset($endDate)){

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $appointments = Appointment::where('institute_id', '=', $id)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            }
            else if(isset($startDate)){

                $startDate = date('Y-m-d', strtotime($startDate));

                $appointments = Appointment::where('institute_id', '=', $id)
                    ->where('start_date', '>=', $startDate)->get();
            }
            else
                $appointments = Appointment::where('institute_id', '=', $id)->get();

            if(isset($appointments))
                return json_encode(array('message'=>'found', 'appointments' => $appointments->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function dataInstituteAppointmentsByType($id, $appointmentType, $startDate=null, $endDate=null){

        if(isset($id) && isset($appointmentType)){

            if(isset($startDate) && isset($endDate)){

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $appointments = Appointment::where('institute_id', '=', $id)
                    ->where('appointment_type', '>=', $appointmentType)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            }
            else if(isset($startDate)){

                $startDate = date('Y-m-d', strtotime($startDate));

                $appointments = Appointment::where('institute_id', '=', $id)
                    ->where('appointment_type', '>=', $appointmentType)
                    ->where('start_date', '>=', $startDate)->get();
            }
            else
                $appointments = Appointment::where('institute_id', '=', $id)
                    ->where('appointment_type', '>=', $appointmentType);

            if(isset($appointments))
                return json_encode(array('message'=>'found', 'appointments' => $appointments->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function dataCancelledAppointments(){

        $id = Session::get('institute_id');

        $appointments = Appointment::where('institute_id','=',$id)->
            where('status','=','cancelled')->get();

        return $appointments;
    }
}