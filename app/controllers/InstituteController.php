<?php

class InstituteController extends BaseController {

    public function __construct(){

        $this->beforeFilter(function(){

            View::share('root', URL::to('/'));
        });
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

    public function saveExpert(){

        $institute_id = Session::get('institute_id');

        if(!isset($institute_id))
            return 'not logged';

        $email = Input::get('email');

        if($this->isDuplicateExpert($email)==="no"){

            $expert = new Expert;

            $expert->institute_id = Session::get('institute_id');
            $expert->email = $email;
            $expert->password = Input::get('password');
            $expert->first_name = Input::get('first_name');
            $expert->last_name = Input::get('last_name');
            $expert->city = Input::get('city');
            $expert->about = "";
            $expert->status = "pending";
            $expert->created_at = date("Y-m-d h:i:s");
            $expert->updated_at = date("Y-m-d h:i:s");

            $expert->save();

            return 'done';
        }
        else
            return 'duplicate';
    }

    public function editExpert($id){

        $institute_id = Session::get('institute_id');

        if(!isset($institute_id))
            return Redirect::to('/');

        if(isset($id)){
            $expert = Expert::find($id);

            if(isset($expert))
                return View::make('institute.edit-expert')->with("expert", $expert);
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

    public function saveInstituteExpertAppointments(){

        $institute_id = Session::get('institute_id');

        if(!isset($institute_id))
            return 'not logged';

        $appointments = Input::get('appointments');
        $expert_id = Input::get('expert_id');

        if(is_null($appointments) || count($appointments)==0)
            return 'invalid';
        else{

            $start_time = Input::get('start_time');
            $start = date('Y-m-d H:i:s', strtotime($start_time));

            $end_time = Input::get('end_time');
            $end = date("Y-m-d H:i:s", strtotime($end_time));

            $gap = Input::get('gap');       # in minutes

//            DB::table('appointments')->where('institute_id', '=', $institute_id)
//                              ->where('status', '=', 'pending')
//                              ->where('appointment_date', '>=', $start)
//                              ->where('appointment_date', '<=', $end)->delete();

            $current = $start;

            for($i=strtotime($current); $i<strtotime($end); $i++){

                $appointment = new Appointment();

                $appointment->appointment_date = $current;
                $appointment->created_at = date("Y-m-d H:i:s");
                $appointment->updated_at = date("Y-m-d H:i:s");
                $appointment->status = "pending";
                $appointment->expert_id = $expert_id;

                $appointment->save();

                $current = date('Y-m-d h:i:s',  strtotime("+ $gap minutes", strtotime( $current ) ));
            }

            return 'done';
        }
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