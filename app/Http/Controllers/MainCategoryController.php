<?php

namespace App\Http\Controllers;

use DemeterChain\Main;
use Illuminate\Http\Request;
use  App\MainCategory;
use Image;
use App\Books_Publishers;
use App\Publishers_Books;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;

class MainCategoryController extends Controller
{
    public function add(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data= $request->all();
            // echo "<pre>"; print_r($data); die;
            $category=new MainCategory;
            $category->name=$data['category_name'];
            $category->parent_id=$data['parent_id'];
            $url=strtolower($data['category_name']);
            $url=str_replace(' ','',$url);
            $category->url=$url;
            $category->image='';
            $category->save();
            return redirect('/admin/view-maincategories')->with('flash_message_success','Category Added Succesfully');
        }
        $levels= MainCategory::where(['parent_id'=>0])->get();
        return view('admin.main_categories.add_main_category')->with(compact('levels'));
    }

    public function edit(Request $request,$id=null)
    {
        if ($request->isMethod('post'))
        {
            $data=$request->all();
            //Image Upload
            if ($request->hasFile('category_image'))
            {
                $image_temp=Input::file('category_image');
                if ($image_temp->isValid())
                {
                    $extension= $image_temp->getClientOriginalExtension();
                    $filename=rand(111,999999).'.'.$extension;
                    $large_image_path='images/backend_images/category/large/'.$filename;
                    $medium_image_path='images/backend_images/category/medium/'.$filename;
                    $small_image_path='images/backend_images/category/small/'.$filename;
                    //Resized Images
                    Image::make($image_temp)->resize(1200,1200)->save($large_image_path);
                    Image::make($image_temp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_temp)->resize(300,300)->save($small_image_path);


                    //Store image in book table
                    MainCategory::where(['id'=>$id])->update(['image'=>$filename]);
                }
            }
            //image upload
            MainCategory::where(['id'=>$id])->update(['name'=>$data['category_name'],'url'=>$data['url']]);
            return redirect('/admin/view-maincategories')->with('flash_message_success','Category Edited Succesfully');
        }
        $categoryDetails= MainCategory::where(['id'=>$id])->first();
        $levels= MainCategory::where(['parent_id'=>0])->get();
        return view('admin.main_categories.edit_main_category')->with(compact('categoryDetails','levels'));
    }

    public function delete($id=null)
    {
        if (!empty($id))
        {
            MainCategory::where(['id'=>$id])->delete();
            return redirect('/admin/view-maincategories')->with('flash_message_success','Category Deleted Succesfully');

        }
    }

    public function view(Request $request)
    {
        $categories=MainCategory::get();
        return view('admin.main_categories.view_main_categories')->with(['categories' => $categories]);
    }
}
