<?php

class LocationController extends BaseController {

    public function __construct(){

        $this->beforeFilter(function(){
            $id = Session::get('admin_id');

            if(isset($id)){
                $admin = Admin::find($id);

                View::share('root', URL::to('/'));
                View::share('name', $admin->name);
            }
        });
    }

    public function locations(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.locations');
    }

    public function listLocations($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $locations = Location::where('status','=',$status)->get();

        if(isset($locations) && count($locations)>0){

            return json_encode(array('message'=>'found', 'locations' => $locations->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function remove($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $location = Location::find($id);

        if(is_null($location))
            return json_encode(array('message'=>'invalid'));
        else{
            $location->status = 'removed';
            $location->save();

            return json_encode(array('message'=>'done'));
        }
    }

    public function save(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $pin = Input::get('pin');

        if(isset($pin)) {
            $location = Location::where('pin', '=', $pin)->where('status', '=', 'active')->first();

            if (!isset($location)) {
                $location = new Location();

                $location->country = 'India';
                $location->state = Input::get('state');
                $location->city = Input::get('city');
                $location->pin = $pin;

                $location->status = 'active';
                $location->created_at = date("Y-m-d h:i:s");
                $location->updated_at = date("Y-m-d h:i:s");

                $location->save();

                return json_encode(array('message' => 'done'));
            } else
                return json_encode(array('message' => 'duplicate'));
        }
        else
            return json_encode(array('message' => 'invalid'));
    }

    public function getCities($state){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        if(isset($state)) {

            $locations = Location::where('state', '=', $state)->where('status', '=', 'active')->get();

            if (isset($locations) && count($locations) > 0)
                return json_encode(array('message' => 'found', 'locations' => $locations->toArray()));
            else
                return json_encode(array('message' => 'empty'));
        }
        else
            return json_encode(array('message' => 'invalid'));
    }
}