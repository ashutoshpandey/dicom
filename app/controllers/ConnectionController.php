<?php

class ConnectionController extends BaseController
{


	function __construct()
	{
		View::share('root', URL::to('/'));
		View::share('name', Session::get('name'));
	}

	public function manageConnections()
	{

		$adminId = Session::get('admin_id');
		if (!isset($adminId))
			return Redirect::to('/');

		$institutes = Institute::where('status', 'active')->orderBy('name')->get();

		if (isset($institutes) && count($institutes) > 0)
			return View::make('admin.connections')->with('institutesFound', true)->with('institutes', $institutes);
		else
			return View::make('admin.connections')->with('institutesFound', false);
	}

	public function getConnections($status = 'active', $page = 1)
	{
		$adminId = Session::get('admin_id');
		if (!isset($adminId))
			return json_encode(array('message' => 'not logged'));

		$connections = InstituteConnection::where('status', $status)->get();

		if (isset($connections) && count($connections) > 0) {

			$connectionArray = array();

			foreach ($connections as $connection) {
				$connectionFrom = Institute::where('id', $connection->connection_id)->first();
				$connectionTo = Institute::where('id', $connection->institute_id)->first();

				if (isset($connectionFrom) && isset($connectionTo))
					$connectionArray[] = array(
											'id' => $connection->id,
											'connection_from' => $connectionFrom->name,
											'connection_from_location' => $connectionFrom->city . ', ' . $connectionFrom->country,
											'connection_to' => $connectionTo->name,
											'connection_to_location' => $connectionTo->city . ', ' . $connectionTo->country,
										);
			}

			return json_encode(array('message' => 'found', 'connections' => $connectionArray));
		} else
			return json_encode(array('message' => 'empty'));
	}

	public function remove($id){

		$adminId = Session::get('admin_id');
		if (!isset($adminId))
			return json_encode(array('message' => 'not logged'));

		if(isset($id)){

			$connection = InstituteConnection::find($id);

			if(isset($connection)){

				$connection->status = 'removed';

				$connection->save();

				return json_encode(array('message' => 'done'));
			}
			else
				return json_encode(array('message' => 'invalid'));
		}
		else
			return json_encode(array('message' => 'invalid'));
	}

	public function save()
	{

		$adminId = Session::get('admin_id');
		if (!isset($adminId))
			return json_encode(array('message' => 'not logged'));

		$connection_id = Input::get('connection_id');
		$institute_id = Input::get('institute_id');

		$instituteConnectionTemp = InstituteConnection::where('connection_id', $connection_id)->where('institute_id', $institute_id)->where('status', 'active')->get();

		if (isset($instituteConnectionTemp) && count($instituteConnectionTemp) > 0)
			return json_encode(array('message' => 'duplicate'));
		else {
			$instituteConnection = new InstituteConnection();

			$instituteConnection->connection_id = $connection_id;
			$instituteConnection->institute_id = $institute_id;

			$instituteConnection->status = "active";
			$instituteConnection->created_at = date("Y-m-d h:i:s");
			$instituteConnection->updated_at = date("Y-m-d h:i:s");

			$instituteConnection->save();

			return json_encode(array('message' => 'done'));
		}
	}

	public function getInstituteConnections($instituteId, $status = 'active', $page = 1)
	{

		$adminId = Session::get('admin_id');
		if (!isset($adminId))
			return json_encode(array('message' => 'not logged'));

		$connections = InstituteConnection::where('status', $status)->where('$institute_id', $instituteId)->get();

		if (isset($connections) && count($connections) > 0) {

			$connectionArray = array();

			foreach ($connections as $connection) {
				$connectionFromName = InstituteConnection::find($connection->connection_id);
				$connectionToName = InstituteConnection::find($connection->institute_id);

				if (isset($connectionFromName) && isset($connectionToName))
					$connectionArray[] = array('id' => $connection->id, 'connection_from' => $connectionFromName, 'connection_to' => $connectionToName);
			}

			return json_encode(array('message' => 'found', 'connections' => $connectionArray));
		} else
			return json_encode(array('message' => 'empty'));
	}
}