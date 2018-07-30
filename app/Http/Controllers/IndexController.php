<?php

namespace App\Http\Controllers;

use App\Book;
use App\MainCategory;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $booksall=Book::get();
        $categories=MainCategory::where(['parent_id'=>0])->get();
        //echo "<pre>";print_r($categories);die;
        return view('index')->with(compact('booksall','categories'));
    }
    public function allbooks()
    {
        $booksall=Book::get();
        $categories=MainCategory::where(['parent_id'=>0])->get();
        return view('allbooks')->with(compact('booksall','categories'));
    }
}
