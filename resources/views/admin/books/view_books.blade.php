@extends('layouts.adminLayout.admin_design')
@section('content')
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Books</a> <a href="#" class="current">View Books</a> </div>
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
                            <h5>View Books</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>Book ID</th>
                                    <th>Category ID</th>
                                    <th>Category Name</th>
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
                                @foreach($books as $book)
                                    <tr class="gradeX">
                                        <td>{{ $book->id }}</td>
                                        <td>{{ $book->category_id }}</td>
                                        <td>{{ $book->category_name }}</td>
                                        <td>{{ $book->book_title }}</td>
                                        <td>
                                            @if(!empty($book->image))
                                            <img src="{{ asset($book->image) }}" style="width: available">
                                            @endif
                                        </td>
                                        <td>{{ $book->isbn }}</td>
                                        <td>{{ $book->price }}</td>
                                        <td>{{ $book->author_id }}</td>
                                        <td>{{ $book->publisher_id }}</td>
                                        <td class="center"> <a href="#myModal{{ $book->id }}" data-toggle="modal" class="btn btn-success btn-mini">View</a>
                                            <a href="{{ url('/admin/edit-book/'.$book->id) }}" class="btn btn-primary btn-mini">Edit</a>
                                            <a href="{{ url('admin/add-attributes/'.$book->id) }}"class="btn btn-success btn-mini">Add</a>
                                            <a rel="{{$book->id}}" rel1="delete-book" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a></td>
                                    </tr>


                                        <div id="myModal{{ $book->id }}" class="modal hide">
                                            <div class="modal-header">
                                                <button data-dismiss="modal" class="close" type="button">×</button>
                                                <h3>{{ $book->book_title }}</h3>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ $book->description }}</p>
                                            </div>
                                        </div>


                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>








@endsection


