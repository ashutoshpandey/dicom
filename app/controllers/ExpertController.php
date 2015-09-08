<?php

class ExpertController extends BaseController {

    public function __construct(){

        $this->beforeFilter(function(){
            $id = Session::get('expert_id');

            if(isset($id)){
                $expert = Expert::find($id);

                if(isset($expert)) {
                    if (isset($expert->image_name))
                        $expertImage = 'uploads/experts/' . $expert->id . '/' . $expert->image_name;
                    else
                        $expertImage = 'images/expert.jpg';

                    View::share('expertImage', $expertImage);
                    View::share('expert_name', $expert->first_name . " " . $expert->last_name);
                }
            }

            date_default_timezone_set("UTC");

            View::share('root', URL::to('/'));
        });
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

    public function achievements(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return Redirect::to('/');

        return View::make('expert.achievements');
    }

    public function addAchievement(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return json_encode(array('message'=>'not logged'));

        $expertMembership = new ExpertMembership();

        $expertMembership->created_at = date('Y-m-d h:i:s');
        $expertMembership->title = Input::get('title');
        $expertMembership->content = Input::get('content');

        $expertMembership->save();

        return json_encode(array('message'=>'done'));
    }

    public function getAchievements(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return json_encode(array('message'=>'not logged'));

        if(isset($expertId)){

            $memberships = ExpertMembership::where('expert_id','=',$expertId)->
                where('status','=','active')->get();

            return json_encode(array('message'=>'found', 'memberships' =>$memberships));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function removeAchievement($id){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return json_encode(array('message'=>'not logged'));

        if(isset($id)){

            $expertMembership = ExpertMembership::find($id);

            if(isset($expertMembership)){

                $expertMembership->status = 'removed';
                $expertMembership->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getAvailabilities(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return json_encode(array('message'=>'not logged'));

        $expert_id = Session::get('expert_id');

        $start_date = Input::get('start_date');
        $end_date = Input::get('end_date');

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $startDate = $start_date . " 00:00:01";
        $endDate = $end_date . " 23:59:59";

        $appointments = Appointment::where('status','=','pending')
                                   ->where('expert_id','=',$expert_id)
                                   ->where('appointment_date','>',$startDate)
                                   ->where('appointment_date','<',$endDate)->orderBy('appointment_date', 'ASC')->get();

        if(isset($appointments))
            return json_encode(array('message'=>'found', 'appointments' => $appointments));
        else
            return json_encode(array('message'=>'empty'));
    }

    public function edit(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return Redirect::to('/');

        $status = Session::get('status');
        $categories = Category::all();

        $expert = Expert::find($expertId);

        return View::make('expert.profile')->with("expert", $expert)->with('categories', $categories)->with('status',$status);
    }

    public function updateProfile(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return json_encode(array('message'=>'not logged'));

        $expert = Expert::find($expertId);

        if(is_null($expert))
            return json_encode(array('message'=>'invalid'));
        else{
            $expert->email = Input::get('email');
            $expert->password = Input::get('password');
            $expert->first_name = Input::get('first_name');
            $expert->last_name = Input::get('last_name');
            $expert->about = Input::get('about');
            $expert->updated_at = date("Y-m-d H:i:s");

            $expert->save();

            return json_encode(array('message'=>'done'));
        }
    }

    public function updateAbout(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return json_encode(array('message'=>'not logged'));

        $expert = Expert::find($expertId);

        if(is_null($expert))
            return json_encode(array('message'=>'invalid'));
        else{
            $expert->about = Input::get('about');
            $expert->updated_at = date("Y-m-d H:i:s");

            $expert->save();

            return json_encode(array('message'=>'done'));
        }
    }

    function updatePassword(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return json_encode(array('message'=>'not logged'));

        $expert = Expert::find($expertId);

        if(isset($expert)){

            $expert->password = Input::get('password');

            $expert->save();

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    /************** json methods ***************/
    public function dataCancelAppointment($id){

        $appointment = Appointment::find($id);

        if(is_null($appointment))
            return json_encode(array('message'=>'invalid'));
        else{
            $appointment->status = "expert-cancelled";
            $appointment->updated_at = date('Y-m-d H:i:s');

            $appointment->save();

            return json_encode(array('message'=>'done'));
        }
    }

    function dataGetExpert($id){

        $expert = Expert::find($id);

        return $expert;
    }
}