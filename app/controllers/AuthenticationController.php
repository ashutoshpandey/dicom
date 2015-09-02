<?php

class AuthenticationController extends BaseController {

    public function __construct(){

        $this->beforeFilter(function(){
            View::share('root', URL::to('/'));
        });
    }

	public function adminLogin(){
		return View::make('admin.login');
	}

    public function registerExpert(){
        return View::make('authentication.register-expert');
    }

	public function registerUser(){
		return View::make('authentication.register-user');
	}

    public function isValidAdmin()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        $admin = Admin::where('username', '=', $username)
                        ->where('password','=',$password)->first();

        if(is_null($admin))
            return json_encode(array("message"=>"invalid"));
        else{
            Session::put('admin_id', $admin->id);
            Session::put('institute_id', $admin->institute_id);

            return json_encode(array("message"=>"correct"));
        }
    }

	public function isValidUser()
	{
        $email = Input::get('email');
        $password = Input::get('password');

        $user = User::where('email', '=', $email)
                    ->where('password','=',$password)->first();

        if(is_null($user)){
            return json_encode(array("message"=>"invalid"));
        }
        else{
            Session::put('user_id', $user->id);
            Session::put('login_type', 'user');

            $ar = array(
                "message"       =>  "correct",
                "name"    =>  $user->name
            );

            return json_encode($ar);
        }
	}

    public function isValidExpert()
    {
        $email = Input::get('email');
        $password = Input::get('password');

        $expert = Expert::where('email', '=', $email)->where('password','=', $password)->first();

        if(is_null($expert))
            return json_encode(array("message"=>"invalid"));
        else{
            Session::put('expert_id', $expert->id);
            Session::put('login_type', 'expert');

            $ar = array("message" => "correct");

            return json_encode($ar);
        }
    }

    public function isDuplicateCustomer($email)
    {
        $customer = Customer::where('email', '=', $email)->first();

        return is_null($customer) ? "no" : "yes";
    }

    public function saveCustomer(){

        $email = Input::get('email');

        if($this->isDuplicatecustomer($email)==="no"){

            $customer = new Customer();

            $country = Input::get('country');       // from payment create customer
            $customer->email = Input::get('email');
            $customer->password = Input::get('password');
            $customer->first_name = Input::get('first_name');
            $customer->last_name = Input::get('last_name');
            $customer->country = $country;
            $customer->status = "active";
            $customer->created_at = date("Y-m-d h:i:s");
            $customer->updated_at = date("Y-m-d h:i:s");

            $customer->save();

            Session::put('customerId', $customer->id);

            $this->sendcustomerEmail();

            $ar = array(
                "message"   =>  "done",
                "id"        =>  $customer->id
            );
        }
        else
            $ar = array(
                "message"   =>  "duplicate"
            );

        return $ar;
    }

    public function customerSaved(){

        if(is_null(Session::get('name')))
            return View::make('static.index');
        else{
            $id=Session::get('customer_id');

            $customer=customer::find($id);

            return View::make('authentication.customer-saved')
                            ->with('customer_email',$customer->email)
                            ->with('name',$customer->first_name . ' ' . $customer->last_name);
        }
    }

    public function expertRegister(){
        return View::make('authentication.expert-register');
    }

    public function saveExpert(){
        $email = Input::get('email');

        if($this->isDuplicateExpert($email)==="no"){

            $expert = new Expert;

            $expert->email = $email;
            $expert->password = Input::get('password');
            $expert->first_name = Input::get('first_name');
            $expert->last_name = Input::get('last_name');
            $expert->country = Input::get('country-sign');
            $expert->timezone = Input::get('timezone-sign');
            $expert->city = Input::get('city');
            $expert->about = "";
            $expert->status = "pending";
            $expert->created_at = date("Y-m-d h:i:s");
            $expert->updated_at = date("Y-m-d h:i:s");

            $expert->save();

            Session::put('name', $expert->name);
            Session::put('expert_id', $expert->id);

            return "done";
        }
        else
            return "duplicate";
    }

    public function expertSaved(){
        Session::put('status','pending');

        return View::make('authentication.expert-saved');
    }

    public function isDuplicateExpert($email)
    {
        $expert = Expert::where('email', '=', $email)->first();

        return is_null($expert) ? "no" : "yes";
    }

    public function sendCustomerPassword(){

        $email = Input::get('email');

        $customer = customer::where('customer.email','=',$email)->first();

        $data = array('name'=>$customer->name);

        Mail::send('emails.customer-reset-password', $data, function($message)use ($customer){

            $message->to($customer->email, $customer->name)->subject('You requested your password');
        });
    }

    public function sendCustomerEmail(){

        ini_set('max_execution_time',3600);

        if(is_null(Session::get('name')))
            return View::make('static.index');
        else{
            $id=Session::get('customer_id');
            $customer=customer::find($id);

            $data = array('name' => $customer->email);

            Mail::send('emails.customer-register-mail', $data, function($message)use ($customer){

                $message->to($customer->email, $customer->name)->subject('Welcome to ..');
            });
        }
        return View::make('authentication.customer-saved')->with('customer_email',$customer->email);
    }

    public function sendExpertEmail(){

        ini_set('max_execution_time',3600);

        if(is_null(Session::get('expert_id')))
            return View::make('static.index');
        else{
            $id=Session::get('expert_id');

            $expert=Expert::find($id);

            $data = array('name'=>$expert->email);

            Mail::send('emails.expert-register-mail', $data, function($message)use ($expert){

                $message->to($expert->email, $expert->first_name.' '.$expert->last_name)->subject('Welcome to ..');
            });
        }
        return View::make('authentication.expert-saved')->with('expert_email',$expert->email);
    }

    public function sendExpertPassword(){

        $email = Input::get('email');

        $expert = Expert::where('Expert.email','=',$email)->first();

        $data = array('name'=>$expert->name);

        Mail::send('emails.expert-reset-password', $data, function($message)use ($expert){

            $message->to($expert->email, $expert->name)->subject('You requested your password');
        });
    }
    /************************ expert methods ************************/

    public function logout(){
        Session::flush();

        return Redirect::to('/');
    }
}