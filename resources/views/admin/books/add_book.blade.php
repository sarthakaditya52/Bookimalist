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
                            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-book') }}" name="add_book" id="add_book" novalidate="novalidate">{{ csrf_field() }}
                                <div class="control-group">
                                    <label class="control-label">Under Category</label>
                                    <div class="controls">
                                        <select name="category_id" id="category_id" style="width: 220px;">
                                            <?php echo $categories_dropdown; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Book Title</label>
                                    <div class="controls">
                                        <input type="text" name="book_title" id="book_title">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Book ISBN</label>
                                    <div class="controls">
                                        <input type="text" name="book_isbn" id="book_isbn">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Book image</label>
                                    <div class="controls">
                                        <input type="file" name="book_image" id="book_image">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Book Price</label>
                                    <div class="controls">
                                        <input type="text" name="book_price" id="book_price">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Book Author</label>
                                    <div class="controls">
                                        <input type="text" name="book_author" id="book_author">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Book Publisher</label>
                                    <div class="controls">
                                        <input type="text" name="book_publisher" id="book_publisher">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Book Details</label>
                                    <div class="controls">
                                        <textarea name="book_details" id="book_details"></textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="form-actions">
                                        <input type="submit" value="Add Book" class="btn btn-success">
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






