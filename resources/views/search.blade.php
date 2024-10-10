@extends('layouts.layout')

@section('content')

    <!-- Start Search Section -->
    <div class="container searchbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Search Our Products</h2>
                    <span>Find what you're looking for below.</span>
                </div>
                <form action="{{ route('search') }}" method="GET" class="mt-4">
                    <div class="input-group input-group-lg mb-5">
                        <input type="text" name="search" class="form-control" value="{{ old('search', $search ?? '') }}"
                            placeholder="Search for products..." required maxlength="255">
                        <div class="input-group-append">
                            <button class="btn btn-dark" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Search Results Section -->
    <section class="section products" id="search-results">
        <div class="container">
            <div class="row">
                <div class="section-heading">
                    <h2 class="mb-4">Search Results for "{{ $search }}"</h2>
                </div>
            </div>

            <!-- Display Products -->
            @if ($products->isNotEmpty())
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-lg-3">
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
                                            <li><i class="fa fa-star{{ $i < $product->rating ? '' : '-o' }}"></i></li>
                                            <!-- Assume you have a rating attribute -->
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
                @endif
                @if($products->isEmpty())
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h4>No results found for "{{ $search }}".</h4>
                    </div>
                </div>
                @endif
            </div>

    </section>

@endsection
