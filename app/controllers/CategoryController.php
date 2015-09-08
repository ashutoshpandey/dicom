<?php

class CategoryController extends BaseController {

   public function categories(){

        $categories = Category::where('status','=','active')->get();

        if(isset($categories) && count($categories)>0)
            return json_encode(array('message'=>'found', 'categories' =>$categories->toArray()));
        else
            return json_encode(array('message'=>'empty'));
    }

    public function subcategories($categoryId){

        if(isset($categoryId)) {

            $category = Category::find($categoryId);

            if(isset($category)) {

                $subcategories = SubCategory::where('status','active')->where('category_id', $categoryId)->get();

                if (isset($subcategories) && count($subcategories) > 0)
                    return json_encode(array('message' => 'found', 'subcategories' => $subcategories->toArray()));
                else
                    return json_encode(array('message' => 'empty'));
            }
            else
                return json_encode(array('message' => 'invalid'));
        }
        else
            return json_encode(array('message' => 'invalid'));
    }

    function dataExpertCategories($id, $status='active'){

        if(isset($id)){

            $categories = ExpertCategory::where('expert_id', $id)
                                        ->with('category')->with('subcategory')->where('status', 'active')->get();

            if(isset($categories))
                return json_encode(array('message'=>'found', 'categories' => $categories->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function getCategoryConsultants($id){

        if(isset($id)){

            $experts = Expert::whereIn('id', function($query) use ($id){
                $query->select('expert_id')
                    ->from('expert_categories')
                    ->where('category_id', $id)
                    ->where('status', 'active');
            })->get();

            if(isset($experts) && count($experts)>0)
                return json_encode(array('message'=>'found', 'experts' => $experts->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function getCategoryExperts($id){

        if(isset($id)){

            $experts = Expert::whereIn('id', function($query) use ($id){
                $query->select('expert_id')
                    ->from('expert_categories')
                    ->where('category_id', $id)
                    ->where('status', 'active');
            })->get();

            if(isset($experts) && count($experts)>0)
                return json_encode(array('message'=>'found', 'experts' => $experts->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}