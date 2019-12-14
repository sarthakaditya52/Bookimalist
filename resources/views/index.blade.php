<?php
use App\MainCategory;

?>
@extends('layouts.frontLayout.front_desgin')
@section('content')

<!-- Slider -->

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="margin-top: 200px">

    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="{{asset('images/frontend_images/slider_1.jpg')}}" alt="First slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


    <div class="row">
        <div class="col text-center">
            <div class="main_categories">
                <h2>Main Categories</h2>
            </div>
        </div>
    </div>


<!-- Banner -->

<div class="banner">
    <div class="container">
        @foreach($categories as $category)
        <div class="col-md-4">
            <div class="banner_item align-items-center" style="background-image:url({{ asset('/images/backend_images/category/small/'.$category->image) }})">
                <div class="banner_category">
                    <a href="{{ asset('/books/'.$category->url) }}">{{$category->name}}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- New Arrivals -->

<div class="new_arrivals">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="section_title new_arrivals_title">
                    <h2>New Arrivals</h2>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col text-center">
                <div class="new_arrivals_sorting">
                    <ul class="arrivals_grid_sorting clearfix button-group filters-button-group">
                        <li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center active is-checked" data-filter="*">all</li>
                        @foreach($categories as $category)
                        <li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center" data-filter=".{{$category->url}}">{{$category->name}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="product-grid" data-isotope='{ "itemSelector": ".product-item", "layoutMode": "fitRows" }'>

                    @foreach($booksall as $book)
                        <?php
                                $temp=MainCategory::where(['id'=>$book->category_id])->get();
                                if ($temp[0]->parent_id==0)
                                    $cat=$temp[0];
                                else
                                   {
                                       $temp=MainCategory::where(['id'=>$temp[0]->parent_id])->get();
                                       $cat=$temp[0];
                                   }
                        ?>
                    <div class="product-item {{$cat->url}}" style="margin-bottom: 1px">
                        <div class="product discount product_filter">
                            <div class="product_image">
                                <img src="{{$book->image}}"   style="height:171px;width: 128px;margin-left: 23%;margin-top: 23%;"   alt="">
                            </div>
                            <div class="favorite favorite_left"></div>
                           <!-- <div class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center"><span>-$20</span></div>-->
                            <div class="product_info" style="float: bottom">
                                <h6 class="product_name"><a href="single.html">{{ $book->book_title }}</a></h6>
                                <div class="product_price">Rs : {{$book->price}}</div>
                            </div>
                        </div>
                        <div class="red_button add_to_cart_button"><a href="#">add to cart</a></div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deal of the week -->

<div class="deal_ofthe_week">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="deal_ofthe_week_img">
                    <img src="{{ asset('images/frontend_images/deal_ofthe_week.png') }}" alt="">
                </div>
            </div>
            <div class="col-lg-6 text-right deal_ofthe_week_col">
                <div class="deal_ofthe_week_content d-flex flex-column align-items-center float-right">
                    <div class="section_title">
                        <h2>Deal Of The Week</h2>
                    </div>
                    <ul class="timer">
                        <li class="d-inline-flex flex-column justify-content-center align-items-center">
                            <div id="day" class="timer_num">03</div>
                            <div class="timer_unit">Day</div>
                        </li>
                        <li class="d-inline-flex flex-column justify-content-center align-items-center">
                            <div id="hour" class="timer_num">15</div>
                            <div class="timer_unit">Hours</div>
                        </li>
                        <li class="d-inline-flex flex-column justify-content-center align-items-center">
                            <div id="minute" class="timer_num">45</div>
                            <div class="timer_unit">Mins</div>
                        </li>
                        <li class="d-inline-flex flex-column justify-content-center align-items-center">
                            <div id="second" class="timer_num">23</div>
                            <div class="timer_unit">Sec</div>
                        </li>
                    </ul>
                    <div class="red_button deal_ofthe_week_button"><a href="#">shop now</a></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Benefit -->

<div class="benefit">
    <div class="container">
        <div class="row benefit_row">
            <div class="col-lg-3 benefit_col">
                <div class="benefit_item d-flex flex-row align-items-center">
                    <div class="benefit_icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
                    <div class="benefit_content">
                        <h6>free shipping</h6>
                        <p>Suffered Alteration in Some Form</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 benefit_col">
                <div class="benefit_item d-flex flex-row align-items-center">
                    <div class="benefit_icon"><i class="fa fa-money" aria-hidden="true"></i></div>
                    <div class="benefit_content">
                        <h6>cach on delivery</h6>
                        <p>The Internet Tend To Repeat</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 benefit_col">
                <div class="benefit_item d-flex flex-row align-items-center">
                    <div class="benefit_icon"><i class="fa fa-undo" aria-hidden="true"></i></div>
                    <div class="benefit_content">
                        <h6>45 days return</h6>
                        <p>Making it Look Like Readable</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 benefit_col">
                <div class="benefit_item d-flex flex-row align-items-center">
                    <div class="benefit_icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
                    <div class="benefit_content">
                        <h6>opening all week</h6>
                        <p>8AM - 09PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Blogs

<div class="blogs">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="section_title">
                    <h2>Latest Blogs</h2>
                </div>
            </div>
        </div>
        <div class="row blogs_container">
            <div class="col-lg-4 blog_item_col">
                <div class="blog_item">
                    <div class="blog_background" style="background-image:url(images/frontend_images/blog_1.jpg)"></div>
                    <div class="blog_content d-flex flex-column align-items-center justify-content-center text-center">
                        <h4 class="blog_title">Here are the trends I see coming this fall</h4>
                        <span class="blog_meta">by admin | dec 01, 2017</span>
                        <a class="blog_more" href="#">Read more</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 blog_item_col">
                <div class="blog_item">
                    <div class="blog_background" style="background-image:url(images/frontend_images/blog_2.jpg)"></div>
                    <div class="blog_content d-flex flex-column align-items-center justify-content-center text-center">
                        <h4 class="blog_title">Here are the trends I see coming this fall</h4>
                        <span class="blog_meta">by admin | dec 01, 2017</span>
                        <a class="blog_more" href="#">Read more</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 blog_item_col">
                <div class="blog_item">
                    <div class="blog_background" style="background-image:url(images/frontend_images/blog_3.jpg)"></div>
                    <div class="blog_content d-flex flex-column align-items-center justify-content-center text-center">
                        <h4 class="blog_title">Here are the trends I see coming this fall</h4>
                        <span class="blog_meta">by admin | dec 01, 2017</span>
                        <a class="blog_more" href="#">Read more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->
<!-- Newsletter

<div class="newsletter">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="newsletter_text d-flex flex-column justify-content-center align-items-lg-start align-items-md-center text-center">
                    <h4>Newsletter</h4>
                    <p>Subscribe to our newsletter and get 20% off your first purchase</p>
                </div>
            </div>
            <div class="col-lg-6">
                <form action="post">
                    <div class="newsletter_form d-flex flex-md-row flex-column flex-xs-column align-items-center justify-content-lg-end justify-content-center">
                        <input id="newsletter_email" type="email" placeholder="Your email" required="required" data-error="Valid email is required.">
                        <button id="newsletter_submit" type="submit" class="newsletter_submit_btn trans_300" value="Submit">subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
-->
@endsection