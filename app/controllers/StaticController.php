<?php

class StaticController extends BaseController
{

    public function __construct()
    {

        $this->beforeFilter(function () {
            View::share('root', URL::to('/'));
            View::share('public_path', public_path());
        });
    }

    public function home()
    {
        return View::make('home')
                ->with('location', '')
                ->with('search', '')
                ->with('locationId', '');
    }

    public function expertLogin()
    {
        return View::make('expert-login');
    }

    public function experts()
    {
        $location = Input::get('location');
        $locationId = Input::get('search-city');
        $keyword = Input::get('search');

        if (isset($locationId) && strlen($locationId)>0) {

            if(isset($keyword) && strlen(trim($keyword))>0){

                $sql = "(select experts.id,first_name,last_name,title,highest_qualification,city,state,image_name from experts, locations, expert_locations where experts.id=expert_locations.expert_id
                        and expert_locations.location_id=locations.id and
                        experts.id in(select expert_id from expert_locations where location_id=$locationId) and first_name like '%$keyword%' or last_name like '%$keyword%')";

                $sql .= " union ";

                $sql .= "(select experts.id,first_name,last_name,title,highest_qualification,city,state,image_name from experts, locations, expert_locations where experts.id=expert_locations.expert_id
                        and expert_locations.location_id=locations.id and
                        experts.id in(select expert_id from expert_locations where location_id=$locationId) and experts.id in (select expert_id from expert_specialties where name like '%$keyword%'))";
            }
            else{
                $sql = "select * from experts, locations, expert_locations where experts.id=expert_locations.expert_id and expert_locations.location_id=locations.id and experts.id in(select expert_id from expert_locations where location_id=$locationId) group by experts.id";
            }

        } else if (isset($keyword) && strlen(trim($keyword))>0) {
            $sql = "(select experts.id,first_name,last_name,title,highest_qualification,city,state,image_name from experts, locations, expert_locations where experts.id=expert_locations.expert_id
                        and expert_locations.location_id=locations.id and first_name like '%$keyword%' or last_name like '%$keyword%')";

            $sql .= " union ";

            $sql .= "(select experts.id,first_name,last_name,title,highest_qualification,city,state,image_name from experts, locations, expert_locations where experts.id=expert_locations.expert_id
                        and expert_locations.location_id=locations.id and experts.id in (select expert_id from expert_specialties where name like '%$keyword%'))";
        }
        else if(isset($location)){
            $sql = "select experts.id,first_name,last_name,title,highest_qualification,city,state,image_name from experts, locations, expert_locations where experts.id=expert_locations.expert_id
            and expert_locations.location_id=locations.id and city like '%$location%' or state like '%$location%'";
        }

        if(isset($sql)) {
            $expertsArray = DB::select(DB::raw($sql));

            if (isset($expertsArray) && count($expertsArray) > 0) {
                $experts = array();
                $expertsTemp = array();
                foreach ($expertsArray as $itemObj) {

                    $item = get_object_vars($itemObj);

                    if (!isset($expertsTemp[$item['id']])) {
                        $expertsTemp[$item['id']] = 'y';
                        $experts[] = $item;
                    }
                }

                if (isset($experts) && count($experts) > 0)
                    return View::make('expert.experts')
                        ->with('found', true)
                        ->with('location', $location)
                        ->with('search', $keyword)
                        ->with('locationId', $locationId)
                        ->with('experts', $experts);
                else
                    return View::make('expert.experts')
                        ->with('found', false)
                        ->with('location', '')
                        ->with('search', '')
                        ->with('locationId', '');
            } else
                return View::make('expert.experts')
                    ->with('found', false)
                    ->with('location', '')
                    ->with('search', '')
                    ->with('locationId', '');
        }
        else
            return View::make('expert.experts')
                ->with('found', false)
                ->with('location', '')
                ->with('search', '')
                ->with('locationId', '');
    }

    public function expert($id)
    {

        if (isset($id)) {

            $expert = Expert::find($id)->with('specialties')->with('memberships')->with('qualifications')->with('achievements')->with('services')->with('socials')->first();

            if (isset($expert)) {

                if (isset($expert->image_name)) {
                    $expertPic = asset('public/uploads/experts/' . $expert->id . '/' . $expert->image_name);
                    $fileLocation = public_path() . '\\uploads\\experts\\' . $expert->id . '\\' . $expert->image_name;

                    if (!file_exists($fileLocation))
                        $expertPic = asset('public/images/expert.jpg');
                } else
                    $expertPic = asset('public/images/expert.jpg');

                $expertTitle = 'Mr';
                if (strtolower($expert->gender) == 'female')
                    $expertTitle = 'Ms';

                $expertName = $expert->first_name . ' ' . $expert->last_name;

                return View::make('expert.detail')
                    ->with('expert', $expert)
                    ->with('expertPic', $expertPic)
                    ->with('expertTitle', $expertTitle)
                    ->with('expertName', $expertName);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function searchCities($key)
    {
        if (isset($key)) {

            $locations = Location::where('city', 'like', '%' . $key . '%')->orWhere('state', 'like', '%' . $key . '%')->where('status', '=', 'active')->get();

            if (isset($locations) && count($locations) > 0) {

                return json_encode(array('message' => 'found', 'locations' => $locations->toArray()));
            } else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    public function searchByKeyword($key, $cityId = null)
    {
        if (isset($key)) {

            if (isset($cityId)) {
                $experts = Expert::where('first_name', 'like', '%' . $key . '%')->Orwhere('last_name', 'like', '%' . $key . '%')->where('status', '=', 'active')->get();
                $institutes = Institute::where('name', 'like', '%' . $key . '%')->where('status', '=', 'active')->get();
            } else {
                $experts = Expert::where('first_name', 'like', '%' . $key . '%')->Orwhere('last_name', 'like', '%' . $key . '%')->where('status', '=', 'active')->get();
                $institutes = Institute::where('name', 'like', '%' . $key . '%')->where('status', '=', 'active')->get();
            }

            $data = array();

            if (isset($experts) && count($experts) > 0)
                foreach ($experts as $expert)
                    $data[] = array('id' => $expert->id, 'name' => $expert->first_name . ' ' . $expert->last_name, 'group' => 'Experts');


            if (isset($institutes) && count($institutes) > 0)
                foreach ($institutes as $institute)
                    $data[] = array('id' => $institute->id, 'name' => $institute->name, 'group' => 'Institutes');

            if (isset($data) && count($data) > 0)
                return json_encode(array('message' => 'found', 'data' => $data));
            else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    public function getCities($state)
    {

        if (isset($state)) {

            $locations = Location::where('state', '=', $state)->where('status', '=', 'active')->get();

            if (isset($locations) && count($locations) > 0)
                return json_encode(array('message' => 'found', 'locations' => $locations->toArray()));
            else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }
}