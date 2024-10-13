@extends('layouts.layout')

@section('content')

<!-- Start Search Section -->
<section class="section searchbar" id="search">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 text-center">
                <h2 class="mb-4">Search Our Products</h2>
                <form action="{{ route('search') }}" method="GET">
                    <div class="input-group input-group-lg mb-5">
                        <input type="text" name="search" class="form-control" placeholder="Search for products..." required maxlength="255">
                        <div class="input-group-append">
                            <button class="btn btn-dark" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<!-- Start Banner -->
<div class="main-banner" id="top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="left-content">
                    <div class="thumb">
                        <div class="inner-content">
                            <h4>We Are Hexashop</h4>
                            <span>Awesome, clean &amp; creative HTML5 Template</span>
                            <div class="main-border-button">
                                <a href="#">Purchase Now!</a>
                            </div>
                        </div>
                        <img src="{{asset('storage/images')}}/left-banner-image.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="right-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="right-first-image">
                                <div class="thumb">
                                    <div class="inner-content">
                                        <h4>Women</h4>
                                        <span>Best Clothes For Women</span>
                                    </div>
                                    <div class="hover-content">
                                        <div class="inner">
                                            <h4>Women</h4>
                                            <p>Lorem ipsum dolor sit amet, conservisii ctetur adipiscing elit incid.</p>
                                            <div class="main-border-button">
                                                <a href="#">Discover More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <img src="{{asset('storage/images')}}/baner-right-image-01.jpg">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-first-image">
                                <div class="thumb">
                                    <div class="inner-content">
                                        <h4>Men</h4>
                                        <span>Best Clothes For Men</span>
                                    </div>
                                    <div class="hover-content">
                                        <div class="inner">
                                            <h4>Men</h4>
                                            <p>Lorem ipsum dolor sit amet, conservisii ctetur adipiscing elit incid.</p>
                                            <div class="main-border-button">
                                                <a href="#">Discover More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <img src="{{asset('storage/images')}}/baner-right-image-02.jpg">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-first-image">
                                <div class="thumb">
                                    <div class="inner-content">
                                        <h4>Kids</h4>
                                        <span>Best Clothes For Kids</span>
                                    </div>
                                    <div class="hover-content">
                                        <div class="inner">
                                            <h4>Kids</h4>
                                            <p>Lorem ipsum dolor sit amet, conservisii ctetur adipiscing elit incid.</p>
                                            <div class="main-border-button">
                                                <a href="#">Discover More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <img src="{{asset('storage/images')}}/baner-right-image-03.jpg">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-first-image">
                                <div class="thumb">
                                    <div class="inner-content">
                                        <h4>Accessories</h4>
                                        <span>Best Trend Accessories</span>
                                    </div>
                                    <div class="hover-content">
                                        <div class="inner">
                                            <h4>Accessories</h4>
                                            <p>Lorem ipsum dolor sit amet, conservisii ctetur adipiscing elit incid.</p>
                                            <div class="main-border-button">
                                                <a href="#">Discover More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <img src="{{asset('storage/images')}}/baner-right-image-04.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Start Categories -->
<section class="section mt-5" id="categories">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h2>Categories</h2>
                    <span>Explore our diverse range of product categories.</span>
                </div>
            </div>
            <div class="col-lg-6 text-lg-right">
                <a href="{{ route('categories.index') }}" class="btn btn-dark mt-3">View All Categories</a>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row">
            @foreach($categories as $category)
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="">
                    <div class="category-content">
                        <h4>{{ $category->name }}</h4>
                        <a href="{{ route('categories.show', $category->id)}}" class="view-btn btn-dark">View Products</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Start Products -->
<section class="section" id="men">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h2>Our Latest Products</h2>
                    <span>Discover unique products that cater to your every need.</span>
                </div>
            </div>
            <div class="col-lg-6 text-lg-right">
                <a href="{{ route('products.index') }}" class="btn btn-dark mt-3">View All Products</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="men-item-carousel">
                    <div class="owl-men-item owl-carousel">
                        @foreach($products as $product)
                        <div class="item">
                            <div class="thumb">
                                <div class="hover-content">
                                    <ul>
                                        <li>
                                            <form action="{{ route('favourites.store', $product->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" style="border: none; padding: 15px;">
                                                    @if(in_array($product->id, $favourites))
                                                        <i class="fa fa-heart" style="color: red;"></i> <!-- Filled star for favourite -->
                                                    @else
                                                        <i class="fa fa-heart-o"></i> <!-- Empty star for not favourite -->
                                                    @endif
                                                </button>
                                            </form>
                                        </li>
                                        
                                        <li><a href="{{ route('products.show', $product->id) }}"><i class="fa fa-eye"></i></a></li>
                                        <li>
                                            <form action="{{ route('cart.store', $product->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" style=" border: none; padding: 15px;">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            </div>
                            <div class="down-content">
                                <h4>{{ $product->name }}</h4>
                                <span>${{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>






@endsection