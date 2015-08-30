<?php

class UserController extends BaseController {

    function __construct(){
        View::share('root', URL::to('/'));
        View::share('name', Session::get('name'));
    }

    function dashboard(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return Redirect::to('/');

        return View::make('users.user-section');
    }

    function editUser(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return Redirect::to('/');

        $user = User::find($userId);

        if(isset($user))
            return View::make('users.edit')->with('user', $user);
        else
            return Redirect::to('/');
    }

    function updateUser(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $user = user::find($userId);

        if(isset($user)){

            $email = Input::get('email');

            $userByEmail = user::where('email', '=', $email)->first();

            if(isset($userByEmail) && $userByEmail->id != $user->id)
                echo 'duplicate';
            else{
                $user->id = $userId;
                $user->email = $email;
                $user->name = Input::get('name');
                $user->password = Input::get('password');
                $user->user_type = Input::get('user_type');

                $user->save();

                return json_encode(array('message'=>'done'));
            }
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function updatePassword(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $user = user::find($userId);

        if(isset($user)){

            $user->password = Input::get('password');

            $user->save();

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function updatePicture(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $user = user::find($userId);

        if(isset($user)){

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
                    $destinationPath = "public/user-images/$userId/";

                    $directoryPath = base_path() . '/' . $destinationPath;

                    if(!file_exists($directoryPath))
                        mkdir($directoryPath);

                    Input::file('image')->move($destinationPath, $fileName);

                    $user->image_name = $imageName;
                    $user->image_name_saved = $fileName;

                    $user->save();

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

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $user = user::find($userId);

        if(isset($user)){

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
                        $destinationPath = "public/user-documents/$userId/";

                        $directoryPath = base_path() . '/' . $destinationPath;

                        if(!file_exists($directoryPath))
                            mkdir($directoryPath);

                        $file->move($destinationPath, $fileName);

                        $userDocument = new UserDocument();

                        $userDocument->document_name = $documentName;
                        $userDocument->document_name_saved = $fileName;
                        $userDocument->status = 'active';

                        $userDocument->save();

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

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        if(isset($id)) {
            $userDocument = UserDocument::find($id);

            if(isset($userDocument)){
                $userDocument->status = 'removed';
                $userDocument->save();
            }
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function removeAccount(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        if(isset($userId)) {

            $user = user::find($userId);

            if(isset($user)){
                $user->status = 'removed';

                $user->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function userAppointments(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return Redirect::to('/');

        return View::make('user.appointments');
    }

    function getUserAppointments($startDate=null, $endDate=null){

        $userId = Session::get('user_id');

        if(isset($userId)){

            if(isset($startDate) && isset($endDate)){

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $appointments = Appointment::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            }
            else if(isset($startDate)){

                $startDate = date('Y-m-d', strtotime($startDate));

                $appointments = Appointment::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)->get();
            }
            else
                $appointments = Appointment::where('user_id', '=', $userId)->get();

            if(isset($appointments))
                return json_encode(array('message'=>'found', 'appointments' => $appointments->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function getUserAppointmentsByType($appointmentType, $startDate=null, $endDate=null){

        $userId = Session::get('user_id');

        if(isset($userId) && isset($appointmentType)){

            if(isset($startDate) && isset($endDate)){

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $appointments = Appointment::where('user_id', '=', $userId)
                    ->where('appointment_type', '>=', $appointmentType)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            }
            else if(isset($startDate)){

                $startDate = date('Y-m-d', strtotime($startDate));

                $appointments = Appointment::where('user_id', '=', $userId)
                    ->where('appointment_type', '>=', $appointmentType)
                    ->where('start_date', '>=', $startDate)->get();
            }
            else
                $appointments = Appointment::where('user_id', '=', $userId)
                    ->where('appointment_type', '>=', $appointmentType);

            if(isset($appointments))
                return json_encode(array('message'=>'found', 'appointments' => $appointments->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function cancelAppointment($id){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $appointment = Appointment::find($id);

        if(isset($appointment)){
            $appointment->status = 'user-cancelled';
            $appointment->cancel_date = date('Y-m-d h:i:s');
            $appointment->save();

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function bookAppointment($id){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $appointment = Appointment::find($id);

        if(isset($appointment)){
            $appointment->status = 'active';
            $appointment->booked_by = Session::get('user_id');
            $appointment->booking_date = date('Y-m-d h:i:s');

            $appointment->save();

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function userDocuments(){

        $userId = Session::get('user_id');

        if(isset($userId)){
            $documents = UserDocument::where('user_id','=',$userId)->
                where('status','=','active')->get();

            if(isset($documents) && count($documents)>0)
                return json_encode(array('message'=>'found', 'documents' => $documents->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'not logged'));
    }

    /************** json methods ***************/
    function dataGetUser($id){

        $user = User::find($id);

        if(isset($user))
            return json_encode(array('message'=>'found', 'user' => $user));
        else
            return json_encode(array('message'=>'empty'));
    }

    function dataUserAppointments($userId, $startDate=null, $endDate=null){

        if(isset($userId)){

            if(isset($startDate) && isset($endDate)){

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $appointments = Appointment::where('user_id', '=', $userId)
                                           ->where('start_date', '>=', $startDate)
                                           ->where('end_date', '<=', $endDate)->get();
            }
            else if(isset($startDate)){

                $startDate = date('Y-m-d', strtotime($startDate));

                $appointments = Appointment::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)->get();
            }
            else
                $appointments = Appointment::where('user_id', '=', $userId)->get();

            if(isset($appointments) && count($appointments)>0)
                return json_encode(array('message'=>'found', 'appointments' => $appointments->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function dataUserAppointmentsByType($userId, $appointmentType, $startDate=null, $endDate=null){

        if(isset($userId) && isset($appointmentType)){

            if(isset($startDate) && isset($endDate)){

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $appointments = Appointment::where('user_id', '=', $userId)
                    ->where('appointment_type', '>=', $appointmentType)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            }
            else if(isset($startDate)){

                $startDate = date('Y-m-d', strtotime($startDate));

                $appointments = Appointment::where('user_id', '=', $userId)
                    ->where('appointment_type', '>=', $appointmentType)
                    ->where('start_date', '>=', $startDate)->get();
            }
            else
                $appointments = Appointment::where('user_id', '=', $userId)
                     ->where('appointment_type', '>=', $appointmentType);

            if(isset($appointments) && count($appointments)>0)
                return json_encode(array('message'=>'found', 'appointments' => $appointments->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function dataCancelledAppointments($userId){

        if(isset($userId)){
            $appointments = Appointment::where('user_id','=',$userId)->
                where('status','=','cancelled')->get();

            if(isset($appointments) && count($appointments)>0)
                return json_encode(array('message'=>'found', 'appointments' => $appointments->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function dataUserDocuments($userId){

        if(isset($userId)){
            $documents = UserDocument::where('user_id','=',$userId)->
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