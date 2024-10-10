@extends('layouts.layout')

@section('content')

    <!-- ***** Main Banner Area Start ***** -->
    <div class="pageTop">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="inner-content">
                        <h2 class="mb-2">Your Favourites</h2>
                        <span>Review your favourite products before making a decision.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** Favourites Area Starts ***** -->
    @if(!empty($favourites) && count($favourites) > 0)
    <section class="section" id="favourites">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-5">
                    <table class="table table-striped mb-5">
                        <thead>
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Add to Cart</th>
                                <th scope="col">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($favourites as $favourite)
                                <tr>
                                    <td>
                                        <a href="{{ route('products.show', $favourite->id) }}" class="product-link">{{ $favourite->name }}</a>
                                    </td>
                                    <td>${{ number_format($favourite->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.store', $favourite->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit"  class="btn btn-success" >
                                                <i class="fa fa-shopping-cart"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('favourites.store', $favourite->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" title="Remove from favourites">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Favourites Area Ends ***** -->

    @else
    <div class="text-center mb-5 p-5">
        <h4>Your Favourites List is Currently Empty</h4>
        <p>It looks like you haven't added any items to your favourites yet. Browse our products and find something you love!</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Start Shopping</a>
    </div>
    @endif

@endsection
