<?php

class AdminController extends BaseController {

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
        $userCount = User::where('status','=','active')->count();

        return View::make('admin.admin-section')
            ->with('expertCount', $expertCount)
            ->with('userCount', $userCount);
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

        $categories = Category::where('status','=','active')->get();

        if(isset($categories) && count($categories)>0)
            return json_encode(array('message'=>'found', 'categories' => $categories->toArray()));
        else
            return json_encode(array('message'=>'empty'));
    }

    public function saveCategory(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $name = Input::get('name');

        $tempCategory = Category::where('name', $name)->where('status', 'active')->get();

        if(is_null($tempCategory) || $tempCategory->isEmpty()){

            $category = new Category();

            $category->name = $name;
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

        $category = Category::find($categoryId);
        $subcategory = SubCategory::find($subcategoryId);

        if(isset($category) && isset($subcategory)){

            $expertId = Session::get('expert_id');

            $tempExpertCategory = ExpertCategory::where('category_id', $categoryId)->where('subcategory_id', $subcategoryId)->where('expert_id', $expertId)->get();

            if(isset($tempExpertCategory) && count($tempExpertCategory)>0){
                return json_encode(array('message' => 'duplicate'));
            }
            else {
                $expertCategory = new ExpertCategory();

                $expertCategory->category_id = $categoryId;
                $expertCategory->subcategory_id = $subcategoryId;
                $expertCategory->expert_id = Session::get('expert_id');
                $expertCategory->status = "active";

                $expertCategory->save();

                return json_encode(array('message' => 'done'));
            }
        }
        else
            return json_encode(array('message'=>'invalid'));
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
    public function experts(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.experts');
    }

    public function listExperts($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $experts = Expert::where('status','=',$status)->get();

        if(isset($experts) && count($experts)>0){

            return json_encode(array('message'=>'found', 'experts' => $experts->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function saveExpert(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        if($this->isDuplicateExpert()==="no"){

            $expert = new Expert;

            $expert->email = Input::get('email');
            $expert->contact_number = Input::get('contact_number');
            $expert->password = Input::get('password');
            $expert->first_name = Input::get('first_name');
            $expert->last_name = Input::get('last_name');
            $expert->gender = Input::get('gender');
            $expert->country = 'India';
            $expert->title = Input::get('title');
            $expert->highest_qualification = Input::get('highest_qualification');
            $expert->about = Input::get('about');
            $expert->experience = Input::get('experience');
            $expert->contact_number = Input::get('contact_number');
            $expert->extension_number = Input::get('extension_number');

            $expert->status = "active";
            $expert->created_at = date("Y-m-d h:i:s");
            $expert->updated_at = date("Y-m-d h:i:s");

            $expert->save();

            if (Input::hasFile('image'))
            {
                $image_name = Input::file('image')->getClientOriginalName();

                $destinationPath = public_path() . "/uploads/experts/" . $expert->id;
                if(!file_exists($destinationPath))
                    mkdir($destinationPath);

                Input::file('image')->move($destinationPath, $image_name);

                $expert->image_name = $image_name;
            }

            if (Input::hasFile('banner_image'))
            {
                $banner_image_name = Input::file('banner_image')->getClientOriginalName();

                $destinationPath = public_path() . "/uploads/experts/" . $expert->id;
                if(!file_exists($destinationPath))
                    mkdir($destinationPath);

                Input::file('banner_image')->move($destinationPath, $banner_image_name);

                $expert->banner_image_name = $banner_image_name;
            }

            $expert->save();

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'duplicate'));
    }

    public function isDuplicateExpert()
    {
        $email = Input::get('email');

        $expert = Expert::where('email', '=', $email)->first();

        return is_null($expert) ? "no" : "yes";
    }

    public function editExpert($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        $expert = Expert::find($id);
        $categories = Category::where('status','=','active')->get();

        $ardate = explode("-", $expert->date_of_birth);

        return View::make('admin.edit-expert')->with('expert', $expert)
            ->with('categories',$categories)
            ->with('ardate',$ardate);
    }

    public function updateExpert(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $id = Session::get('expert_id');

        $expert = Expert::find($id);

        if(is_null($expert))
            return json_encode(array('message'=>'invalid'));
        else{

            if (Input::hasFile('image') && Input::file('image')->isValid())
            {
                $image_name = Input::file('image')->getClientOriginalName();

                $destinationPath = public_path() . "/uploads/experts/" . $expert->id;
                if(!file_exists($destinationPath))
                    mkdir($destinationPath);

                Input::file('image')->move($destinationPath, $image_name);
                $expert->image_name = $image_name;
            }

            if (Input::hasFile('banner_image') && Input::file('banner_image')->isValid())
            {
                $banner_image_name = Input::file('banner_image')->getClientOriginalName();

                $destinationPath = public_path() . "/uploads/experts/" . $expert->id;
                if(!file_exists($destinationPath))
                    mkdir($destinationPath);

                Input::file('banner_image')->move($destinationPath, $banner_image_name);
                $expert->banner_image_name = $banner_image_name;
            }

            $expert->email = Input::get('email');
            $expert->contact_number = Input::get('contact_number');
            $expert->password = Input::get('password');
            $expert->first_name = Input::get('first_name');
            $expert->last_name = Input::get('last_name');
            $expert->gender = Input::get('gender');
            $expert->country = 'India';
            $expert->status = "active";
            $expert->about = Input::get('about');
            $expert->experience = Input::get('experience');
            $expert->contact_number = Input::get('contact_number');
            $expert->extension_number = Input::get('extension_number');
            $expert->title = Input::get('title');
            $expert->highest_qualification = Input::get('highest_qualification');

            $expert->status = "active";
            $expert->updated_at = date("Y-m-d h:i:s");

            $expert->save();

            return json_encode(array('message'=>'done'));
        }
    }

    public function removeExpert($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $expert = Expert::find($id);

        if(is_null($expert))
            return json_encode(array('message'=>'invalid'));
        else{
            $expert->delete();

            return json_encode(array('message'=>'done'));
        }
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

    /************************** software users *************************/
    public function softwareUsers(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.software-users');
    }

    public function viewSoftwareUser($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){
            $softwareUser = SoftwareUser::find($id);

            if(isset($softwareUser)){

                Session::put('software_user_id', $id);

                if($softwareUser->gender=='male'){
                    $male_checked = 'checked="checked"';
                    $female_checked = '';
                }
                else{
                    $female_checked = 'checked="checked"';
                    $male_checked = '';
                }

                return View::make('admin.view-software-user')
                    ->with('softwareUser', $softwareUser)
                    ->with('male_checked', $male_checked)
                    ->with('female_checked', $female_checked);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function listSoftwareUsers($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $softwareUsers = SoftwareUser::where('status','=',$status)->get();

        if(isset($softwareUsers) && count($softwareUsers)>0){

            return json_encode(array('message'=>'found', 'software_users' => $softwareUsers->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

/************************** users *************************/
    public function users(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.users');
    }

    public function viewUser($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){
            $user = User::find($id);

            if(isset($user)){

                Session::put('user_id', $id);

                if($user->gender=='male'){
                    $male_checked = 'checked="checked"';
                    $female_checked = '';
                }
                else{
                    $female_checked = 'checked="checked"';
                    $male_checked = '';
                }

                return View::make('admin.view-user')
                    ->with('user', $user)
                    ->with('male_checked', $male_checked)
                    ->with('female_checked', $female_checked);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function listUsers($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $users = User::where('status','=',$status)->get();

        if(isset($users) && count($users)>0){

            return json_encode(array('message'=>'found', 'users' => $users->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }


    public function removeUser($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $user = User::find($id);

        if(is_null($user))
            return json_encode(array('message'=>'invalid'));
        else{
            $user->status = 'removed';
            $user->save();

            return json_encode(array('message'=>'done'));
        }
    }

    public function updateUser(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $id = Input::get('id');

        $user = User::find($id);

        if(is_null($user))
            return json_encode(array('message'=>'invalid'));
        else{
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->email = Input::get('email');
            $user->phone = Input::get('phone');
            $user->password = Input::get('password');
            $user->country = Input::get('country');
            $user->timezone = Input::get('timezone');
            $user->save();

            return json_encode(array('message'=>'done'));
        }
    }
    /************************** users *************************/

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
}