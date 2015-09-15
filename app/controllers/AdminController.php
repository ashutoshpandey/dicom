<?php

class AdminController extends BaseController {

    public function __construct(){

        $this->beforeFilter(function(){

            View::share('root', URL::to('/'));

            $adminType = Session::get('admin_type');

            if(isset($adminType)) {
                View::share('adminType', Session::get('admin_type'));

                $id = Session::get('admin_id');
                $user = User::find($id);
                View::share('name', $user->name);
                View::share('userType', $user->user_type);
            }
        });
    }

    public function dashboard(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.dashboard');
    }

    public function institutes(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.institutes');
    }

    public function viewInstitute($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){
            $institute = Institute::find($id);

            if(isset($institute)){

                Session::put('institute_id', $id);

                return View::make('admin.view-institute')
                    ->with('institute', $institute);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function adminSection(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        $expertCount = Expert::where('status','=','active')->count();
        $patientCount = Patient::where('status','=','active')->count();

        return View::make('admin.admin-section')
            ->with('expertCount', $expertCount)
            ->with('patientCount', $patientCount);
    }

/********************** categories ***********************/
    public function manageCategories(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.categories');
    }

    public function listCategories(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $instituteId = Session::get('institute_id');
        if(!isset($instituteId))
            return json_encode(array('message'=>'invalid'));

        $categories = Category::where('status','=','active')->where('institute_id', $instituteId)->get();

        if(isset($categories) && count($categories)>0)
            return json_encode(array('message'=>'found', 'categories' => $categories->toArray()));
        else
            return json_encode(array('message'=>'empty'));
    }

    public function saveCategory(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $instituteId = Session::get('institute_id');
        if(!isset($instituteId))
            return json_encode(array('message'=>'invalid'));

        $name = Input::get('name');

        $tempCategory = Category::where('name', $name)->where('status', 'active')->get();

        if(is_null($tempCategory) || $tempCategory->isEmpty()){

            $category = new Category();

            $category->name = $name;
            $category->institute_id = $instituteId;
            $category->created_at = date("Y-m-d h:i:s");
            $category->status = "active";

            $category->save();

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'duplicate'));
    }

    public function saveSubCategory(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $name = Input::get('name');

        $tempSubCategory = SubCategory::where('name','=',$name)->where('status', 'active')->get();

        if(is_null($tempSubCategory) || $tempSubCategory->isEmpty()){

            $category_id = Input::get('category');

            $subCategory = new SubCategory();

            $subCategory->name = $name;
            $subCategory->category_id = $category_id;
            $subCategory->created_at = date("Y-m-d h:i:s");
            $subCategory->status = "active";

            $subCategory->save();

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'duplicate'));
    }

    public function editCategory($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        $category = Category::find($id);

        return View::make('admin.edit-category')->with("category", $category);
    }

    public function removeCategory($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $category = Category::find($id);

        if(is_null($category))
            return json_encode(array('message'=>'invalid'));
        else{
            $category->status = 'removed';
            $category->save();

            $subcategories = SubCategory::where('category_id', '=', $id)->get();

            if(isset($subcategories) && count($subcategories)>0){
                foreach($subcategories as $subcategory){
                    $subcategory->status = 'removed';
                    $subcategory->save();
                }
            }

            return json_encode(array('message'=>'done'));
        }
    }

    public function editSubCategory($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        $subCategory = SubCategory::find($id);
        $categories = Category::where('status','=','active')->get();

        return View::make('admin.edit-subcategory')->with("subCategory", $subCategory)->with("categories", $categories);
    }

    public function removeSubCategory($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $subCategory = SubCategory::find($id);

        if(is_null($subCategory))
            return json_encode(array('message'=>'invalid'));
        else{
            $subCategory->status = 'removed';
            $subCategory->save();

            return json_encode(array('message'=>'done'));
        }
    }

    public function updateCategory(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $id = Input::get('category_id');

        $category = Category::find($id);

        if(is_null($category))
            return json_encode(array('message'=>'invalid'));
        else{
            $category->name = Input::get('name');

            $category->save();

            return json_encode(array('message'=>'done'));
        }
    }

    public function listSubCategories($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $subCategories = SubCategory::where('category_id', '=', $id)
                                    ->where('status','=','active')->get();

        if(isset($subCategories) && count($subCategories)>0)
            return json_encode(array('message'=>'found', 'subcategories' => $subCategories->toArray()));
        else
            return json_encode(array('message'=>'empty'));
    }

    public function updateSubCategory(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $id = Input::get('subcategory_id');

        $subCategory = SubCategory::find($id);

        if(is_null($subCategory))
            return json_encode(array('message'=>'invalid'));
        else{
            $subCategory->name = Input::get('name');

            $subCategory->save();

            return json_encode(array('message'=>'done'));
        }
    }

    public function assignExpertCategory(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $categoryId = Input::get('category');
        $subcategoryId = Input::get('subcategory');

        if(isset($categoryId) && isset($subcategoryId)) {

            $category = Category::find($categoryId);
            $subcategory = SubCategory::find($subcategoryId);

            if (isset($category) && isset($subcategory)) {

                $expertId = Session::get('current_expert_id');

                $tempExpertCategory = ExpertCategory::where('category_id', $categoryId)->where('subcategory_id', $subcategoryId)->where('expert_id', $expertId)->where('status', 'active')->get();

                if (isset($tempExpertCategory) && count($tempExpertCategory) > 0) {
                    return json_encode(array('message' => 'duplicate'));
                } else {
                    $expertCategory = new ExpertCategory();

                    $expertCategory->category_id = $categoryId;
                    $expertCategory->subcategory_id = $subcategoryId;
                    $expertCategory->expert_id = $expertId;
                    $expertCategory->status = "active";

                    $expertCategory->save();

                    return json_encode(array('message' => 'done'));
                }
            } else
                return json_encode(array('message' => 'invalid'));
        }
        else if(isset($categoryId)){

            $category = Category::find($categoryId);

            if (isset($category)) {

                $expertId = Session::get('current_expert_id');

                $tempExpertCategory = ExpertCategory::where('category_id', $categoryId)->where('expert_id', $expertId)->where('status', 'active')->get();

                if (isset($tempExpertCategory) && count($tempExpertCategory) > 0) {
                    return json_encode(array('message' => 'duplicate'));
                } else {
                    $expertCategory = new ExpertCategory();

                    $expertCategory->category_id = $categoryId;
                    $expertCategory->subcategory_id = -1;
                    $expertCategory->expert_id = $expertId;
                    $expertCategory->status = "active";

                    $expertCategory->save();

                    return json_encode(array('message' => 'done'));
                }
            } else
                return json_encode(array('message' => 'invalid'));
        }
    }

    public function removeExpertCategory($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $expertCategory = ExpertCategory::find($id);

        if(isset($expertCategory)){

            $expertCategory->status = 'removed';
            $expertCategory->save();

            return json_encode(array('message' => 'done'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function adminLogout(){

        Session::flush();

        Auth::logout();

        return Redirect::to('admin');
    }

/************************** experts *************************/

    public function experts(){                  // for admin

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.experts');
    }

    public function removeExpertQualification($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $qualification = ExpertQualification::find($id);

        if(is_null($qualification))
            return json_encode(array('message'=>'invalid'));
        else{
            $qualification->status = 'removed';
            $qualification->save();

            return json_encode(array('message'=>'done'));
        }
    }

    public function removeExpertService($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $service = ExpertService::find($id);

        if(is_null($service))
            return json_encode(array('message'=>'invalid'));
        else{
            $service->status = 'removed';
            $service->save();

            return json_encode(array('message'=>'done'));
        }
    }

    public function createExpertQualification(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $qualification = new ExpertQualification();

        $qualification->expert_id = Session::get('expert_id');
        $qualification->name = Input::get('name');
        $qualification->description = Input::get('description');

        $qualification->status = 'active';
        $qualification->created_at = date('Y-m-d h:i:s');
        $qualification->save();

        return json_encode(array('message'=>'done'));
    }

    public function createExpertService(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $service = new ExpertService();

        $service->expert_id = Session::get('expert_id');
        $service->name = Input::get('name');
        $service->details = Input::get('details');

        $service->status = 'active';
        $service->created_at = date('Y-m-d h:i:s');
        $service->save();

        return json_encode(array('message'=>'done'));
    }

    /************************** locations *************************/

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

    public function removeLocation($id){

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

    public function saveLocation(){

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
        else {
            Session::flush();

            return json_encode(array('message' => 'not logged'));
        }
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

    function quotation($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)) {
            $patientRequest = PatientRequest::find($id);

            if (isset($patientRequest)) {

                $quotation = Quotation::where('request_id', $id)->first();

                Session::set('current_request_id', $id);

                return View::make('admin.quotation')->with('quoted', isset($quotation))->with('quotation', $quotation);
            }
        }
    }

    public function saveQuotation(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $requestId = Session::get('current_request_id');
        if(!isset($requestId))
            return json_encode(array('message'=>'not logged'));

        $patientRequest = PatientRequest::find($requestId);

        if(isset($patientRequest)) {

            $quotation = new Quotation();

            $quotation->request_id = $requestId;
            $quotation->kind_attention = Input::get('kind_attention');
            $quotation->dated = Input::get('dated');
            $quotation->file_number = Input::get('file_number');
            $quotation->hostpial_reference = Input::get('hospital_reference');
            $quotation->patient_age = Input::get('patient_age');
            $quotation->sex = Input::get('sex');
            $quotation->nationality = Input::get('nationality');
            $quotation->medical_speciality = Input::get('medical_speciality');
            $quotation->referring_party = Input::get('referring_party');
            $quotation->treating_doctor = Input::get('treating_doctor');

            $quotation->treatment_protocols = Input::get('treatment_protocols');
            $quotation->clinical_success_rate = Input::get('clinical_success_rate');

            $quotation->pre_evaluation_prescribed = Input::get('pre_evaluation_prescribed');
            $quotation->pre_evaluation_cost = Input::get('pre_evaluation_cost');
            $quotation->pre_evolution_duration = Input::get('pre_evolution_duration');
            $quotation->surgery1_prescribed = Input::get('surgery1_prescribed');
            $quotation->surgery1_cost = Input::get('surgery1_cost');
            $quotation->surgery1_duration = Input::get('surgery1_duration');
            $quotation->surgery1_prescribed = Input::get('surgery1_prescribed');
            $quotation->surgery2_cost = Input::get('surgery2_cost');
            $quotation->surgery2_duration = Input::get('surgery2_duration');
            $quotation->followup_post_discharge_prescribed = Input::get('followup_post_discharge_prescribed');
            $quotation->followup_post_discharge_cost = Input::get('followup_post_discharge_cost');
            $quotation->followup_post_discharge_duration = Input::get('followup_post_discharge_duration');
            $quotation->total_prescribed = Input::get('total_prescribed');
            $quotation->total_cost = Input::get('total_cost');
            $quotation->total_duration = Input::get('total_duration');

            $quotation->status = "active";

            $quotation->created_at = date("Y-m-d h:i:s");
            $quotation->created_at = date("Y-m-d h:i:s");

            $quotation->save();

            $patientRequest->status = 'complete';

            $patientRequest->updated_at = date('Y-m-d h:i:s');

            $patientRequest->save();

            return json_encode(array('message' => 'done'));
        }
        else
            return json_encode(array('message' => 'invalid'));
    }

    public function manageRequests(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        $currentInstituteId = Session::get('institute_id');
        if(!isset($currentInstituteId))
            return Redirect::to('/');

        $categories = Category::where('status', 'active')->get();

        $found = isset($categories) && count($categories)>0;

        return View::make('requests.manage')->with('found', $found)->with('categories', $categories)->with('currentInstitute', $currentInstituteId);
    }
}