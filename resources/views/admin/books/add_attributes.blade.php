@extends('layouts.adminLayout.admin_design')
@section('content')

    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Books</a> <a href="#" class="current">Add Book Attributes</a> </div>
            <h1>Attributes</h1>
        </div>
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
        <div class="container-fluid"><hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Add Attribute</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-attributes/'.$bookDetails->id) }}" name="add_attribute" id="add_attribute" >{{ csrf_field() }}
                                <input type="hidden" name="book_id" value="{{$bookDetails->id}}">
                                <div class="control-group">
                                    <label class="control-label">Book Title</label>
                                    <label class="control-label"><strong>{{$bookDetails->book_title}}</strong></label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Book ISBN</label>
                                    <label class="control-label"><strong>{{$bookDetails->isbn}}</strong></label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Book Author</label>
                                    <label class="control-label"><strong>{{$bookDetails->author_id}}</strong></label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Book Publisher</label>
                                    <label class="control-label"><strong>{{$bookDetails->publisher_id}}</strong></label>
                                </div>


                                <div class="control-group">
                                    <label class="control-label"></label>
                                    <div class="field_wrapper">
                                        <div>
                                            <input type="text" name="sku[]" id="sku" placeholder="SKU" style="width: 120px" required/>
                                            <input type="text" name="edition[]" id="edition" placeholder="Edition" style="width: 120px" required/>
                                            <input type="text" name="condition[]" id="condition" placeholder="Condition" style="width: 120px" required/>
                                            <input type="text" name="price[]" id="price" placeholder="Price" style="width: 120px" required/>
                                            <input type="text" name="stock[]" id="stock" placeholder="Stock" style="width: 120px" required/>
                                            <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                        </div>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <div class="form-actions">
                                        <input type="submit" value="Add Attributes" class="btn btn-success">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">

                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>View Attributes</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>Attribute ID</th>
                                    <th>Book ID</th>
                                    <th>SKU</th>
                                    <th>Edition</th>
                                    <th>Condition</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bookDetails['attributes'] as $attribute)
                                    <tr class="gradeX">
                                        <td>{{ $attribute->id }}</td>
                                        <td>{{ $attribute->book_id }}</td>
                                        <td>{{ $attribute->sku }}</td>
                                        <td>{{ $attribute->edition }}</td>
                                        <td>{{ $attribute->cdtn }}</td>
                                        <td>{{ $attribute->price }}</td>
                                        <td>{{ $attribute->stock }}</td>
                                        <td class="center">
                                            <a rel="{{$attribute->id}}" rel1="delete-attribute" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a></td>
                                    </tr>


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






