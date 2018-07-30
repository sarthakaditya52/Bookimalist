<?php

namespace App\Http\Controllers;

use App\SubCategory;
use Illuminate\Http\Request;
use App\MainCategory;

class SubCategoryController extends Controller
{
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $category = new SubCategory;
            $category->name = $data['category_name'];
            $category->url = $data['url'];
            $category->parent_id = $data['main_category'];
            $category->save();
        }
        $categories = MainCategory::all();
        return view('admin.sub_categories.add_sub_category')->with(['categories' => $categories]);
    }

}
