<?php

class UserController extends BaseController {


	function __construct(){
		View::share('root', URL::to('/'));
		View::share('name', Session::get('name'));
	}

	public function manageUsers(){

		$adminId = Session::get('admin_id');
		if(!isset($adminId))
			return Redirect::to('/');

		$institutes = Institute::where('status', 'active')->orderBy('name')->get();

		if(isset($institutes) && count($institutes)>0)
			return View::make('admin.users')->with('institutesFound', true)->with('institutes', $institutes);
		else
			return View::make('admin.users')->with('institutesFound', false);
	}

	public function viewUser($id){

		$adminId = Session::get('admin_id');
		if(!isset($adminId))
			return Redirect::to('/');

		if(isset($id)){
			$user = User::find($id);

			if(isset($user)){

				Session::put('user_id', $id);

				return View::make('admin.view-user')
					->with('user', $user);
			}
			else
				return Redirect::to('/');
		}
		else
			return Redirect::to('/');
	}

	public function listUsers($status = 'active', $page = 1){

		$adminId = Session::get('admin_id');
		if(!isset($adminId))
			return json_encode(array('message'=>'not logged'));

		$users = User::where('status', $status)->get();

		if(isset($users) && count($users)>0){

			return json_encode(array('message'=>'found', 'users' => $users->toArray()));
		}
		else
			return json_encode(array('message'=>'empty'));
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

		$adminId = Session::get('admin_id');
		if(!isset($adminId))
			return json_encode(array('message'=>'not logged'));

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

	public function saveUser(){

		$adminId = Session::get('admin_id');
		if(!isset($adminId))
			return json_encode(array('message'=>'not logged'));

		$email = Input::get('email');

		if($this->isDuplicateUser($email)==="no"){

			$user = new User;

			$user->password = Input::get('password');
			$user->name = Input::get('name');
			$user->gender = Input::get('gender');
			$user->country = Input::get('country');
			$user->email = $email;
			$user->password = hash('sha256', uniqid());
			$user->contact_number = Input::get('contact_number');

			$user->status = "active";
			$user->created_at = date("Y-m-d h:i:s");
			$user->updated_at = date("Y-m-d h:i:s");

			$user->save();

			return json_encode(array('message'=>'done'));
		}
		else
			return json_encode(array('message'=>'duplicate'));
	}

	public function isDuplicateUser($email)
	{
		$user = User::where('email', '=', $email)->first();

		return is_null($user) ? "no" : "yes";
	}

	public function findUser($id){

		$adminId = Session::get('admin_id');
		if(!isset($adminId))
			return Redirect::to('/');

		if(isset($id)){
			$user = User::find($id);

			if(isset($user))
				return json_encode(array('message' => 'found', user => $user));
			else
				return json_encode(array('message' => 'empty'));
		}
		else
			return json_encode(array('message' => 'invalid'));
	}

	public function getUsers($page = 1, $status = 'active'){

		$adminId = Session::get('admin_id');
		if(!isset($adminId))
			return json_encode(array('message'=>'not logged'));

		$users = User::where('status', $status)->get();

		if(isset($users) && count($users)>0){

			return json_encode(array('message'=>'found', 'users' => $users->toArray()));
		}
		else
			return json_encode(array('message'=>'empty'));
	}

	function removeUser($id){

		$adminId = Session::get('admin_id');
		if(!isset($adminId))
			return json_encode(array('message'=>'not logged'));

		if(isset($id)) {
			$user = User::find($id);

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

	/********************************** admin methods **********************************/

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

	/************** json methods ***************/
	function dataGetUser($id){

		$user = User::find($id);

		if(isset($user))
			return json_encode(array('message'=>'found', 'user' => $user));
		else
			return json_encode(array('message'=>'empty'));
	}

	function dataGetUsers($page=1, $status='active'){

		$users = User::where('status', $status)->get();

		if(isset($users) && count($users)>0){
			return json_encode(array('message'=>'found', 'users' => $users));
		}
		else
			return json_encode(array('message'=>'empty'));
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