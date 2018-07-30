
<?php
require_once ('/Users/sarthak/Projects/Bookimalist_beta_2/vendor/autoload.php');
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
        <div class="container-fluid"><hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        @if(Session::has('flash_message_success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{!! session('flash_message_success') !!}</strong>
                            </div>
                        @endif
                        @if(Session::has('flash_message_error'))
                            <div class="alert alert-error alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{!! session('flash_message_error') !!}</strong>
                            </div>
                        @endif
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Add Book</h5>
                        </div>
                            <div class="widget-content nopadding">
                            @if(isset($_POST['searchname']))
                                        <?php $book=null; ?>
                                @foreach($books->volumes->search($_POST['searchname']) as $book)
                                        <?php
                                                if (count($book->industryIdentifiers))
                                                {
                                        if (isset($_POST['searchname']))
                                        {
                                            $text="";
                                            if (count($book->authors)){
                                            foreach ($book->authors as $key) {
                                                $text=$text.$key.",";
                                            }
                                            }
                                        }
                                        ?>

                            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-books-new') }}" name="add_book" id="add_book" novalidate="novalidate">{{ csrf_field() }}

                                <div class="column">
                                    <div class="card">
                                        <?php
                                            $imgs=null;
                                            $imgs=count($book->imageLinks);
                                        $pbs=count($book->publisher);
                                        if (count($book->imageLinks)){
                                        $imageData = $book->imageLinks->thumbnail;
                                        echo '<img src="'.$imageData.'" style="width:100%" height="200px"><br>';
                                        }

                                        ?>
                                        <div class="container">
                                            <h2><?php echo $book->title;?></h2>
                                            <p class="title"> by: <br><?php if (count($book->authors)) {foreach ($book->authors as $key) {
                                                echo $key."<br>";
                                                }
                                                    echo $book->industryIdentifiers[0]->identifier;

                                                }?></p>
                                            <p>One from our latest </p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="book_title" id="book_title" value="{{$book->title}}">
                                <input type="hidden" name="book_isbn" id="book_isbn" value="{{$book->industryIdentifiers[0]->identifier}}">
                                @if($imgs>0)
                                <input type="hidden" name="book_image" id="book_image" value="{{$book->imageLinks->thumbnail}}">
                                @endif
                                <div class="control-group">
                                    <label class="control-label">Under Category </label>
                                    <div class="controls">
                                        <select name="category_id" id="category_id" style="width: 220px;">
                                            <?php echo $categories_dropdown; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Book Price </label>
                                    <div class="controls">
                                        <input type="text" name="book_price" id="book_price">
                                    </div>
                                </div>
                                <input type="hidden" name="book_author" id="book_author" value="{{$text}}">
                                @if($pbs>0)
                                    <input type="hidden" name="book_publisher" id="book_publisher" value="{{$book->publisher}}">
                                @endif
                                <input type="hidden" name="book_details" id="book_details" value="{{$book->description}}">


                                <div class="control-group">
                                    <div class="form-actions">
                                        <input type="submit" value="Add Book" class="btn btn-success">
                                    </div>
                                </div>


                            </form>
                                    <?php }?>
                                    @endforeach


                                    @endif
                                @if(isset($_POST['notname']))
                                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-books-new') }}" name="add_book" id="add_book" novalidate="novalidate">{{ csrf_field() }}

                                            <div class="column">
                                                <div class="card">
                                                    <?php
                                                    $text="";
                                                    $book=null;
                                                    $book = $books->volumes->byIsbn($_POST['notname']);
                                                    //$book=json_decode(json_encode($book));
                                                    //echo "<pre>";print_r($book);
                                                        if (count($book->authors))
                                                            {
                                                    foreach ($book->authors as $key) {
                                                    $text=$text.$key.",";
                                                    }
                                                    }
                                                    $imgs=null;
                                                    $imgs=count($book->imageLinks);
                                                    $pbs=count($book->publisher);
                                                    if (count($book->imageLinks)){
                                                    $imageData = $book->imageLinks->thumbnail;
                                                    echo '<img src="'.$imageData.'" style="width:100%" height="200px"><br>';
                                                    }

                                                    ?>
                                                    <div class="container">
                                                        <h2><?php echo $book->title;?></h2>
                                                        <p class="title"> by: <br><?php if (count($book->authors)){foreach ($book->authors as $key) {
                                                                echo $key."<br>";
                                                            }
                                                            }?></p>
                                                        <p>One from our latest </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="book_title" id="book_title" value="{{$book->title}}">
                                            <input type="hidden" name="book_isbn" id="book_isbn" value="{{$book->industryIdentifiers[0]->identifier}}">
                                            @if($imgs>0)
                                                <input type="hidden" name="book_image" id="book_image" value="{{$book->imageLinks->thumbnail}}">
                                            @endif
                                            <div class="control-group">
                                                <label class="control-label">Book Price</label>
                                                <div class="controls">
                                                    <input required type="text" name="book_price" id="book_price">
                                                </div>
                                            </div>
                                            <input type="hidden" name="book_author" id="book_author" value="{{$text}}">
                                            @if($pbs>0)
                                            <input type="hidden" name="book_publisher" id="book_publisher" value="{{$book->publisher}}">
                                            @endif
                                            <input type="hidden" name="book_details" id="book_details" value="{{$book->description}}">
                                            <div class="control-group">
                                                <label class="control-label">Under Category</label>
                                                <div class="controls">
                                                    <select name="category_id" id="category_id" style="width: 220px;">
                                                        <?php echo $categories_dropdown; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <div class="form-actions">
                                                    <input type="submit" value="Add Book" class="btn btn-success">
                                                </div>
                                            </div>


                                        </form>
                                @endif
                                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-books-new') }}" name="add_book" id="add_book" novalidate="novalidate">{{ csrf_field() }}
                                    <div class="control-group">
                                        <label class="control-label">Search By Isbn</label>
                                        <div class="controls">
                                            <input type="text" name="notname">
                                            <input type="submit" value="submit">
                                        </div>
                                    </div>

                                </form>
                                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-books-new') }}" name="add_book_name" id="add_book_name" novalidate="novalidate">{{ csrf_field() }}
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
