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
