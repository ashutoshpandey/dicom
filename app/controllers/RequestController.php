<?php

class RequestController extends BaseController {

    public function __construct(){

        $this->beforeFilter(function(){
            $id = Session::get('admin_id');

            if(isset($id)){
                $user = User::find($id);

                if(isset($user)) {
                    View::share('root', URL::to('/'));
                    View::share('name', $user->name);
                }
            }
        });
    }

    public function manageRequests(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('requests.manage');
    }
}