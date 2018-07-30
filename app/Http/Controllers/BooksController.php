<?php

namespace App\Http\Controllers;

use App\BookAttributes;
use App\Books_Publishers;
use App\BooksAuthors;
use App\BooksPublishers;
use App\MainCategory;
use App\Author;
use App\Publisher;
use App\Publishers_Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use App\Book;
use Image;

class BooksController extends Controller
{
    public function add(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data=$request->all();
           // echo "<pre>";print_r($data);die;


            if (empty($data['category_id']))
                return redirect()->back()->with('flash_message_error','Under Category is missing');

            $book=new Book;
            $book->category_id=$data['category_id'];
            $book->book_title=$data['book_title'];
            $book->isbn=$data['book_isbn'];
            $book->price=$data['book_price'];
            $book->author_id=$data['book_author'];
            $book->publisher_id=$data['book_publisher'];
            if (!empty($data['book_details']))
                $book->description=$data['book_details'];
            else
                $book->description='';

            if ($request->hasFile('book_image'))
            {
                $image_temp=Input::file('book_image');
                if ($image_temp->isValid())
                {
                    $extension= $image_temp->getClientOriginalExtension();
                    $filename=rand(111,999999).'.'.$extension;
                    $large_image_path='images/backend_images/books/large/'.$filename;
                    $medium_image_path='images/backend_images/books/medium/'.$filename;
                    $small_image_path='images/backend_images/books/small/'.$filename;
                    //Resized Images
                    Image::make($image_temp)->resize(1200,1200)->save($large_image_path);
                    Image::make($image_temp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_temp)->resize(300,300)->save($small_image_path);


                    //Store image in book table
                    $book->image=$filename;
                }
            }
            //image upload

            $book->save();
            return redirect()->back()->with('flash_message_success','Book Added Succesfully');


        }

        //Categories Drop Down
        $categories=MainCategory::where(['parent_id'=>0])->get();
        $categories_dropdown="<option selected disabled>Select</option>";
        foreach ($categories as $cat)
        {
            $categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories=MainCategory::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat)
            {
                $categories_dropdown .= "<option value = '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }

        //Categories Drop Down

        return view('admin.books.add_book')->with(compact('categories_dropdown'));
    }

    public function view(Request $request)
    {
        $books=Book::get();
        //$books=json_decode(json_encode($books));
        foreach ($books as $key => $val)
        {
            $category_name = MainCategory::where(['id'=>$val->category_id])->first();
            $books[$key]->category_name=$category_name->name;
        }
        //echo "<pre>";print_r($books);die;
        return view('admin.books.view_books')->with(compact('books'));
    }

    public function edit(Request $request, $id=null)
    {
        if ($request->isMethod('post'))
        {
            $data=$request->all();



            //Image Upload
            if ($request->hasFile('book_image'))
            {
                $image_temp=Input::file('book_image');
                if ($image_temp->isValid())
                {
                    $extension= $image_temp->getClientOriginalExtension();
                    $filename=rand(111,999999).'.'.$extension;
                    $large_image_path='images/backend_images/books/large/'.$filename;
                    $medium_image_path='images/backend_images/books/medium/'.$filename;
                    $small_image_path='images/backend_images/books/small/'.$filename;
                    //Resized Images
                    Image::make($image_temp)->resize(1200,1200)->save($large_image_path);
                    Image::make($image_temp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_temp)->resize(300,300)->save($small_image_path);
                }
                else
                    $filename=$data['current_image'];
                Book::where(['id'=>$id])->update(['image'=>$filename]);
            }
            //image upload



            //echo "<pre>";print_r($data);die;
            Book::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'book_title'=>$data['book_title'],'isbn'=>$data['book_isbn'],'price'=>$data['book_price']]);
            if (!empty($data['book_details']))
                Book::where(['id'=>$id])->update(['description'=>$data['book_details']]);
            else
                Book::where(['id'=>$id])->update(['description'=>'']);
            return redirect('/admin/view-books')->with('flash_message_success','Book Edited Succesfully');
        }
        $book_details=Book::where(['id'=>$id])->first();

        //Categories Drop Down
        $categories=MainCategory::where(['parent_id'=>0])->get();
        $categories_dropdown="<option selected disabled>Select</option>";
        foreach ($categories as $cat)
        {
            if ($cat->id==$book_details->category_id)
            {
                $selected="selected";
            }
            else
                $selected="";
            $categories_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
            $sub_categories=MainCategory::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat)
            {
                if ($sub_cat->id==$book_details->category_id)
                {
                    $selected="selected";
                }
                else
                    $selected="";
                $categories_dropdown .= "<option value = '".$sub_cat->id."'".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }

        //Categories Drop Down

        return view('admin.books.edit_book')->with(compact('book_details','categories_dropdown'));
    }

    public function deleteImg($id=null)
    {
        Book::where(['id'=>$id])->update(['image'=>'']);
        return redirect()->back()->with('flash_message_success','Image Deleted Succesfully');

    }

    public function delete($id=null)
    {
        Book::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Book Deleted Succesfully');

    }

    public function addAttributes(Request $request,$id=null)
    {
        $bookDetails=Book::with('attributes')->where(['id'=>$id])->first();
        //$bookDetails=json_decode(json_encode($bookDetails));
        //echo "<pre>";print_r($bookDetails);die;
        if ($request->isMethod('post'))
        {
            $data=$request->all();
           //echo "<pre>";print_r($data);die;
            foreach ($data['sku'] as $key=>$val)
            {
                if (!empty($val))
                {
                    $attribute=new BookAttributes;
                    $attribute->book_id=$id;
                    $attribute->sku=$val;
                    $attribute->edition=$data['edition'][$key];
                    $attribute->cdtn=$data['condition'][$key];
                    $attribute->price=$data['price'][$key];
                    $attribute->stock=$data['stock'][$key];
                    $attribute->save();
                }
            }
            return redirect()->back()->with('flash_message_success','Attribute Added Succesfully');
        }
        return view('admin.books.add_attributes')->with(compact('bookDetails'));
    }

    public function deleteAtr($id=null)
    {
        BookAttributes::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Attribute Deleted Succesfully');

    }

    public function newadd(Request $request)
    {
            if ($request->isMethod('post')) {
                if (!isset($_POST['isbn'])&&!isset($_POST['searchname'])) {
                    $data = $request->all();
                    if (empty($data['category_id']))
                    return redirect()->back()->with('flash_message_error', 'Under Category is missing');


                $book = new Book;
                $publisher=new Publisher;
                $publisher->name=$data['book_publisher'];
                if ($request->has($data['book_publisher']))
                {
                    $publisher->save();
                    $pb=new BooksPublishers;
                    $pb->book_id=$book->id;
                    $pbr=Publisher::where('name','=',$data['book_publisher'])->first();
                    $pb->publisher_id=$pbr->id;
                    $pb->save();
                }

                $book->category_id = $data['category_id'];
                $book->book_title = $data['book_title'];
                $book->isbn = $data['book_isbn'];
                $book->price = $data['book_price'];
                $myArray = explode(',', $data['book_author']);
                array_pop($myArray);
                for ($i=0;$i<sizeof($myArray);$i++)
                {

                    $author=new Author;
                    $ftemp=str_replace(' ', '', $myArray[$i]);
                    $checkA=Author::whereRaw("REPLACE(`name`, ' ', '') = ? ", $ftemp)->first();
                    if ($checkA==null)
                    {
                        $author->name=$myArray[$i];
                        $author->save();
                    }
                }
                $temp=$book->id;
                //$book->author_id = $data['book_author'];
                if (!empty($data['book_details']))
                    $book->description = $data['book_details'];
                else
                    $book->description = '';

                //Image Upload
                /*if ($request->hasFile('book_image')) {
                    $image_temp = Input::file('book_image');
                    if ($image_temp->isValid()) {
                        $extension = $image_temp->getClientOriginalExtension();
                        $filename = rand(111, 999999) . '.' . $extension;
                        $large_image_path = 'images/backend_images/books/large/' . $filename;
                        $medium_image_path = 'images/backend_images/books/medium/' . $filename;
                        $small_image_path = 'images/backend_images/books/small/' . $filename;
                        //Resized Images
                        Image::make($image_temp)->resize(1200, 1200)->save($large_image_path);
                        Image::make($image_temp)->resize(600, 600)->save($medium_image_path);
                        Image::make($image_temp)->resize(300, 300)->save($small_image_path);
*/

                        //Store image in book table
                        $book->image = $data['book_image'];

                //image upload

                $book->save();

                    for ($i=0;$i<sizeof($myArray);$i++) {
                        $ab = new BooksAuthors;
                        $ab->book_id = $book->id;
                        $ftemp=str_replace(' ', '', $myArray[$i]);
                        $atr=Author::whereRaw("REPLACE(`name`, ' ', '') = ? ", $ftemp)->first();
                        $ab->author_id=$atr->id;
                        $ab->save();
                    }

                return redirect()->back()->with('flash_message_success', 'Book Added Succesfully');


            }
        }

        //Categories Drop Down
        $categories=MainCategory::where(['parent_id'=>0])->get();
        $categories_dropdown="<option selected disabled>Select</option>";
        foreach ($categories as $cat)
        {
            $categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories=MainCategory::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat)
            {
                $categories_dropdown .= "<option value = '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }

        //Categories Drop Down

        return view('admin.books.add_books')->with(compact('categories_dropdown'));

    }

    public function books($url=null)
    {
          $categoryDetails=MainCategory::where(['url'=>$url])->first();
          $categories=MainCategory::where(['parent_id'=>0])->get();
          //echo $categoryDetails->id;

          $booksall=Book::where(['category_id'=>$categoryDetails->id])->get();
          $subcats=MainCategory::where(['parent_id'=>$categoryDetails->id])->get();
          foreach ($subcats as $subcat)
          {
              $temp=Book::where(['category_id'=>$subcat->id])->get();
              if (count($temp))
              {
                  $booksall->add(json_decode($temp[0]));
              }
              else
              {
                  continue;
              }
          }
          //$booksall=json_decode(json_encode($booksall));
        return view('books.listings')->with(compact('booksall','categories','categoryDetails','subcats'));
    }

    public function temp($url=null)
    {
        $categoryDetails=MainCategory::where(['url'=>$url])->first();
        $categories=MainCategory::where(['parent_id'=>0])->get();
        //echo $categoryDetails->id;

        $booksall=Book::where(['category_id'=>$categoryDetails->id])->get();
        $subcats=MainCategory::where(['parent_id'=>$categoryDetails->id])->get();
        foreach ($subcats as $subcat)
        {
            $temp=Book::where(['category_id'=>$subcat->id])->get();
            if (count($temp))
            {
                $booksall->add(json_decode($temp[0]));
            }
            else
            {
                continue;
            }
        }
        return view('temp')->with(compact('booksall','categories','categoryDetails','subcats'));
    }
}
