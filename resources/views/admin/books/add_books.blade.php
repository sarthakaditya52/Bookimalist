<?php
require_once ('/Users/sarthak/Projects/Bookimalist/vendor/autoload.php');
use Scriptotek\GoogleBooks\GoogleBooks;
$books = new GoogleBooks(['key' => 'AIzaSyDA8VPC4k7-NdulFJGfDgVARjjSIWcmMy0']);
?>
@extends('layouts.adminLayout.admin_design')
@section('content')
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Books</a> <a href="#" class="current">Add Book</a> </div>
            <h1>Books</h1>
        </div>
        @if(Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_success') !!}</strong>
            </div>
        @endif
        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">

                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>Add Book</h5>
                        </div>
                        <div class="widget-content nopadding">



                            @if(isset($_POST['isbn']))
                                    <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-books') }}" name="add_book" id="add_book" novalidate="novalidate">{{ csrf_field() }}
                                <?php
                                $text="";

                                    $book = $books->volumes->byIsbn($_POST['isbn']);
                                if ($book->authors)
                                {
                                    foreach ($book->authors as $key) {
                                        $text=$text.$key.",";
                                    }
                                }
                                ?>
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Category Name</th>
                                    <th>Select Category</th>
                                    <th>Book Title</th>
                                    <th>Book Image</th>
                                    <th>Book ISBN</th>
                                    <th>Book Price</th>
                                    <th>Book Author</th>
                                    <th>Book Publisher</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr class="gradeX">
                                        <td>1</td>
                                        <td>
                                            @if(!empty($book->categories))
                                                {{ $book->categories[0] }}
                                            @endif
                                        </td>
                                        <td><div class="control-group">
                                                <label>Under Category </label>
                                                    <select name="category_id" id="category_id" style="width: available;">
                                                        <?php echo $categories_dropdown; ?>
                                                    </select>
                                            </div></td>
                                        <td>{{ $book->title }}</td>
                                        <td>
                                            @if(!empty($book->imageLinks->thumbnail))
                                                <img src="{{ asset($book->imageLinks->thumbnail) }}" style="width: available">
                                            @endif
                                        </td>
                                        <td>{{ $book->industryIdentifiers[0]->identifier }}</td>
                                        <td><label>Book Price </label><input type="text" name="book_price" id="book_price" style="width: auto">
                                            </td>
                                        <td><?php if ($book->authors) {foreach ($book->authors as $key) {
                                                echo $key."<br>";
                                            }
                                            }?></td>
                                        @if(!empty($book->publisher))
                                        <td>{{ $book->publisher }}</td>
                                        @endif
                                        <td class="center"><input type="submit" value="Add Book" class="btn btn-success btn-mini"></td>
                                        <input type="hidden" name="book_title" id="book_title" value="{{$book->title}}">
                                        <input type="hidden" name="book_isbn" id="book_isbn" value="{{$book->industryIdentifiers[0]->identifier}}">
                                        @if(!empty($book->imageLinks->thumbnail))
                                            <input type="hidden" name="book_image" id="book_image" value="{{$book->imageLinks->thumbnail}}">
                                        @endif
                                        <input type="hidden" name="book_author" id="book_author" value="{{$text}}">
                                        @if(!empty($book->publisher))
                                            <input type="hidden" name="book_publisher" id="book_publisher" value="{{$book->publisher}}">
                                        @endif
                                        <input type="hidden" name="book_details" id="book_details" value="{{$book->description}}">
                                    </tr>
                                </tbody>
                            </table>
                      </form>

        @endif


            @if(isset($_POST['searchname']))
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Category Name</th>
                        <th>Select Category</th>
                        <th>Book Title</th>
                        <th>Book Image</th>
                        <th>Book ISBN</th>
                        <th>Book Price</th>
                        <th>Book Author</th>
                        <th>Book Publisher</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $book=null;$i=1; ?>
            @foreach($books->volumes->search($_POST['searchname']) as $book)
                <?php
                if (count($book->industryIdentifiers))
                {
                if (isset($_POST['searchname']))
                {
                    $text="";
                    if ($book->authors){
                        foreach ($book->authors as $key) {
                            $text=$text.$key.",";
                        }
                    }
                }
                ?>
                <tr>
                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-books') }}" name="add_book" id="add_book" novalidate="novalidate">{{ csrf_field() }}
                        <td>{{$i}}</td>
                        <td>
                            @if(!empty($book->categories))
                                {{ $book->categories[0] }}
                            @endif
                        </td>
                        <td><div class="control-group">
                                <label>Under Category </label>
                                <select name="category_id" id="category_id" style="width: available;">
                                    <?php echo $categories_dropdown; ?>
                                </select>
                            </div></td>
                        <td>{{ $book->title }}</td>
                        <td>
                            @if(!empty($book->imageLinks->thumbnail))
                                <img src="{{ asset($book->imageLinks->thumbnail) }}" style="width: available">
                            @endif
                        </td>
                        <td>{{ $book->industryIdentifiers[0]->identifier }}</td>
                        <td><label>Book Price </label><input type="text" name="book_price" id="book_price" style="width: auto">
                        </td>
                        <td><?php if ($book->authors) {foreach ($book->authors as $key) {
                                echo $key."<br>";
                            }
                            }?></td>
                        <td>
                        @if(!empty($book->publisher))
                            {{ $book->publisher }}
                        @endif
                        </td>
                        <input type="hidden" name="book_title" id="book_title" value="{{$book->title}}">
                        <input type="hidden" name="book_isbn" id="book_isbn" value="{{$book->industryIdentifiers[0]->identifier}}">
                        @if(!empty($book->imageLinks->thumbnail))
                            <input type="hidden" name="book_image" id="book_image" value="{{$book->imageLinks->thumbnail}}">
                        @endif
                        <input type="hidden" name="book_author" id="book_author" value="{{$text}}">
                        @if(!empty($book->publisher))
                            <input type="hidden" name="book_publisher" id="book_publisher" value="{{$book->publisher}}">
                        @endif
                        <input type="hidden" name="book_details" id="book_details" value="{{$book->description}}">
                     <td class="center"><input type="submit" value="Add Book" class="btn btn-success btn-mini"></td>

            </form>
                </tr>
                <?php $i++; }?>
            @endforeach
                    </tbody>
                </table>

            @endif

    <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-books') }}" name="add_book" id="add_book" novalidate="novalidate">{{ csrf_field() }}
            <div class="control-group">
                <label class="control-label">Search By Isbn</label>
                <div class="controls">
                    <input type="text" name="isbn">
                    <input type="submit" value="submit">
                </div>
            </div>
        </form>
    <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-books') }}" name="add_book_name" id="add_book_name" novalidate="novalidate">{{ csrf_field() }}
            <div class="control-group">
                <label class="control-label">Search By Name</label>
                <div class="controls">
                    <input type="text" name="searchname">
                    <input type="submit" value="submit">
                </div>
            </div>

        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>








@endsection


