@extends('layouts.layout')

@section('content')
<div class="page-heading" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-content">
                    <h2>Products</h2>
                    <span>Explore the various products available.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ***** Products Area Starts ***** -->
<section class="section products">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Our Latest Products</h2>
                    <span>Check out all of our products.</span>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-lg-4">
                    <div class="item">
                        <div class="thumb">
                            <div class="hover-content">
                                <ul>
                                    <li><a href=""><i class="fa fa-star"></i></a></li>
                                    <li><a href="{{ route('products.show', $product->id) }}"><i class="fa fa-eye"></i></a></li>
                                    <form action="{{ route('cart.store', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" style=" border: none; padding: 15px;">
                                            <i class="fa fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </ul>
                            </div>
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="down-content">
                            <h4>{{ $product->name }}</h4>
                            <span>${{ $product->price }}</span>
                            <ul class="stars">
                                @for ($i = 0; $i < 5; $i++)
                                    <li><i class="fa fa-star{{ $i < $product->rating ? '' : '-o' }}"></i></li> <!-- Assume you have a rating attribute -->
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-lg-12">
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }} 
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
