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

    public function dashboard(){

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

    public function appointments(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return Redirect::to('/');

        return View::make('expert.availabilities');
    }

    function listAppointments($status, $page, $startDate=null, $endDate=null){

        $expertId = Session::get('expert_id');
        if(!isset($expertId))
            return json_encode(array('message'=>'not logged'));

        if(isset($expertId)){

            if(isset($startDate) && isset($endDate)){

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $appointments = Appointment::where('expert_id', '=', $expertId)
                    ->where('status', '=', $status)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            }
            else if(isset($startDate)){

                $startDate = date('Y-m-d', strtotime($startDate));

                $appointments = Appointment::where('expert_id', '=', $expertId)
                    ->where('start_date', '>=', $startDate)->get();
            }
            else
                $appointments = Appointment::where('expert_id', '=', $expertId)->get();

            if(isset($appointments))
                return json_encode(array('message'=>'found', 'appointments' => $appointments->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function appointment($id){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return Redirect::to('/');

        $appointment = Appointment::find($id);

        $appointment->appointment_date=$this->toLocalDate($appointment->appointment_date,$appointment->expert_id);

        return View::make('expert.appointment')->with("appointment",$appointment);
    }

    public function history(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return Redirect::to('/');

        $currentDate = date("Y-m-d H:i:s");

        $id = Session::get('expert_id');

        $appointments = Appointment::where('expert_id','=',$id)
                                    ->where(function($q) use($currentDate){
                                        $q->where('status','=','user-cancelled')
                                            ->orWhere('status','=','expert-cancelled')
                                            ->orWhere('appointment_date','<',$currentDate);
                                    })->get();

        return View::make('expert.history')->with('appointments', $appointments);
    }

    public function cancelAvailableAppointment($id){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return json_encode(array('message'=>'not logged'));

        $appointment = Appointment::find($id);

        if(is_null($appointment))
            return json_encode(array('message'=>'invalid'));
        else{
            if($appointment->status==="pending"){

                $appointment->delete();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'booked'));
        }
    }
    public function cancelAppointment($id){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return json_encode(array('message'=>'not logged'));

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

    public function setAvailabilities(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return Redirect::to('/');

        return View::make('expert.set-availability');
    }

    public function saveAvailabilities(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return json_encode(array('message'=>'not logged'));

        $expert_id = Session::get('expert_id');

        $availabilities = Input::get('availability');

        if(is_null($availabilities) || count($availabilities)==0)
            return json_encode(array('message'=>'invalid'));
        else{

            $start_time = $availabilities[0];
            $start = date("Y-m-d H:i:s", strtotime($start_time));

            $end_time = $availabilities[count($availabilities)-1];
            $end = date("Y-m-d H:i:s", strtotime($end_time));

            DB::table('appointments')->where('expert_id', '=', $expert_id)
                              ->where('status', '=', 'pending')
                              ->where('appointment_date', '>=', $start)
                              ->where('appointment_date', '<=', $end)->delete();

            for($i=0; $i<count($availabilities); $i++){

                $appointment = new Appointment();

                $dt=date("Y-m-d H:i:s",strtotime($availabilities[$i]));
                $utc_date = $this->toUTCDate($dt, $expert_id);

                if($utc_date==null)
                    return "error";

                $appointment->appointment_date = $utc_date;
                $appointment->created_at = date("Y-m-d H:i:s");
                $appointment->updated_at = date("Y-m-d H:i:s");
                $appointment->status = "pending";
                $appointment->expert_id = $expert_id;

                $appointment->save();
            }

            return json_encode(array('message'=>'done'));
        }
    }

    public function memberships(){

        $expertId = Session::get('expert_id');

        if(!isset($expertId))
            return Redirect::to('/');

        return View::make('expert.memberships');
    }

    public function addMembership(){

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

    public function getMemberships(){

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

    public function removeMembership($id){

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

    function updatePicture(){

        $expertId = Session::get('expert_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $expert = user::find($expertId);

        if(isset($expert)){

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
                    $destinationPath = "public/expert-images/$userId/";

                    $directoryPath = base_path() . '/' . $destinationPath;

                    if(!file_exists($directoryPath))
                        mkdir($directoryPath);

                    Input::file('image')->move($destinationPath, $fileName);

                    $expert->image_name = $imageName;
                    $expert->image_name_saved = $fileName;

                    $expert->save();

                    return json_encode(array('message'=>'done'));
                }
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function expertLogout(){

        Session::flush();

        Auth::logout();

        return Redirect::to('/');
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

    function dataExpertCategories($id, $status='active'){

        if(isset($id)){

            $categories = ExpertCategory::where('expert_id', $id)
                ->where('status', '=', 'active')->with('category')->with('subcategory')->get();

            if(isset($categories))
                return json_encode(array('message'=>'found', 'categories' => $categories->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function dataListAchievements($expertId, $page=null){

        if(isset($expertId)){

            $achievements = ExpertAchievement::where('expert_id','=',$expertId)->
                where('status','=','active')->get();

            if(isset($achievements) && count($achievements)>0)
                return json_encode(array('message'=>'found', 'achievements' =>$achievements->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function dataListServices($expertId, $page=null){

        if(isset($expertId)){

            $services = ExpertService::where('expert_id','=',$expertId)->
                where('status','=','active')->get();

            if(isset($services) && count($services)>0)
                return json_encode(array('message'=>'found', 'services' =>$services->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function dataListQualification($expertId, $page=null){

        if(isset($expertId)){

            $expertQualifications = ExpertQualification::where('expert_id','=',$expertId)->
            where('status','=','active')->get();

            if(isset($expertQualifications) && count($expertQualifications)>0)
                return json_encode(array('message'=>'found', 'qualifications' =>$expertQualifications->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}