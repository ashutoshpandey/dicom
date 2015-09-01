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
                ->where('status', '=', 'active')->with('category')->with('subcategory')->where('status', 'active')->get();

            if(isset($categories))
                return json_encode(array('message'=>'found', 'categories' => $categories->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}