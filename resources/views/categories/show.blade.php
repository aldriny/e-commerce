@extends('layouts.layout')

@section('content')

<!-- ***** Category Banner Area Start ***** -->
<div class="page-heading about-page-heading" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-content">
                    <h2>{{ $category->name }}</h2>
                    <span>Explore the products available in this category.</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Category Banner Area End ***** -->

<!-- ***** Products Area Starts ***** -->
<section class="section products">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Products in {{ $category->name }}</h2>
                    <span>Check out all products in this category.</span>
                </div>
            </div>
        </div>
        <div class="row">
            @if($products->isEmpty())
                <div class="col-lg-12">
                    <div class="alert alert-info text-center">
                        <strong>No products available in this category.</strong>
                    </div>
                </div>
            @else
                @foreach($products as $product)
                    <div class="col-lg-4">
                        <div class="item">
                            <div class="thumb">
                                <div class="hover-content">
                                    <ul>
                                        <li>
                                            <form action="{{ route('favourites.store', $product->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" style="border: none; padding: 15px;">
                                                    @if(Auth::user() && Auth::user()->isFavourite($product->id))
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
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                            </div>
                            <div class="down-content">
                                <h4><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h4>
                                <span>${{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-lg-12">
            <div class="pagination">
                {{ $products->links() }} <!-- This will display the pagination links -->
            </div>
        </div>
    </div>
</section>
<!-- ***** Products Area Ends ***** -->

@endsection
