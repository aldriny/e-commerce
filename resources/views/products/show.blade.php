@extends('layouts.layout')

@section('content')
    <!-- ***** Main Banner Area Start ***** -->
    <div class="page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>{{ $product->name }}</h2>
                        <span>Discover the latest and greatest items in our collection.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** Product Area Starts ***** -->
    <section class="section" id="product">
        <div class="container">
            <div class="row">
                <!-- Product Image Section -->
                <div class="col-lg-6">
                    <div class="left-images">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                    </div>
                </div>

                <!-- Product Details Section -->
                <div class="col-lg-4">
                    <div class="right-content">
                        <h4>{{ $product->name }}</h4>
                        <span class="price">${{ number_format($product->price, 2) }}</span>

                        <p><strong>Available Quantity: </strong>{{ $product->quantity }}</p>

                        <p>{{ $product->description }}</p>
                        <p><strong>Category: </strong><a
                                href="{{ route('categories.show', $product->category->id) }}">{{ $product->category->name ?? 'Uncategorized' }}</a>
                        </p>
                        <!-- Order Form Section -->
                            <form action="{{ route('cart.store', $product->id) }}" method="POST" class="">
                                @csrf
                                <!-- Order Quantity Section Inside the Form -->
                                <div class="quantity-content">
                                    <div class="left-content">
                                        <h6>Quantity</h6>
                                    </div>
                                    <div class="right-content">
                                        <div class="quantity buttons_added">
                                            <input type="button" value="-" class="minus">
                                            <input type="number" step="1" min="1" max="{{ $product->quantity }}"
                                                name="quantity" value="1" class="input-text qty text"
                                                size="4" id="quantity" data-price="{{ $product->price }}">
                                            <input type="button" value="+" class="plus">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Total Price -->
                                    <div class="col-md-7">
                                        <div class="total ">
                                            <h4>Total: $<h4 id="totalPrice">{{ number_format($product->price, 2) }}</h4>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <button type="submit" id="addToCartBtn">Add To Cart</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Product Area Ends ***** -->
@endsection
