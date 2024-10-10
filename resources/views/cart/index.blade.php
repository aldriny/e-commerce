@extends('layouts.layout')

@section('content')

    <!-- ***** Main Banner Area Start ***** -->
    <div class="pageTop">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="inner-content">
                        <h2 class="mb-2">Your Shopping Cart</h2>
                        <span>Review your selected products before proceeding to checkout.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->
         <!-- ***** Message Area Start ***** -->
         @if (session('success'))
         <div class="container mt-1">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    <!-- ***** Cart Area Starts ***** -->
    @if (!empty($cart) && count($cart) > 0)
        <section class="section" id="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $item)
                                    <tr>
                                        <td>
                                            <a
                                                href="{{ route('products.show', $item['id']) }}"class="product-link">{{ $item['name'] }}</a>
                                        </td>
                                        <td>
                                            ${{ number_format($item['price'], 2) }}
                                        </td>
                                        <td>
                                            <div class="quantity buttons_added">
                                                <form action="{{ route('cart.update', $item['id']) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="button" value="-" class="minus">
                                                    <input type="number" step="1" min="1"
                                                        max="{{ $item['stock'] }}" name="quantity"
                                                        value="{{ $item['quantity'] }}" class="input-text qty text"
                                                        size="4" id="quantity-{{ $item['id'] }}"
                                                        data-price="{{ $item['price'] }}">
                                                    <input type="button" value="+" class="plus">
                                                    <button type="submit" class="btn btn-primary btn-sm ml-2 mt-1">
                                                        <i class="fa fa-refresh"></i>
                                                    </button>
                                                    <div class="text-center mt-1">
                                                        <span
                                                            data-id="{{ $item['id'] }}">available:{{ $item['stock'] }}</span>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            $<span class="item-total"
                                                id="totalPrice">{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('cart.destroy', $item['id']) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4 mb-4 text-center">
                            <h4>Total Price: $<span id="overallTotal">{{ number_format($totalPrice, 2) }}</span></h4>
                        </div>

                        <form action="{{ route('order.store') }}" method="POST">
                            @csrf
                            @foreach ($cart as $item)
                                <!-- Hidden inputs for each item in the cart -->
                                <input type="hidden" name="products[{{ $loop->index }}][product_id]"
                                    value="{{ $item['id'] }}">
                                <input type="hidden" name="products[{{ $loop->index }}][price]"
                                    value="{{ $item['price'] }}">
                                <input type="hidden" name="products[{{ $loop->index }}][quantity]"
                                    value="{{ $item['quantity'] }}">
                            @endforeach
                            <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">

                            <div class="text-center">
                                <button type="submit" id="checkoutBtn" class="btn btn-primary">Confirm Order</button>
                            </div>
                        </form>
                    @else
                        <div class="text-center mb-5 p-5">
                            <h4>Your Shopping Cart is Currently Empty</h4>
                            <p>It looks like you haven't added any items to your cart yet. Browse our products and find
                                something you love!</p>
                            <a href="{{ route('products.index') }}" id="checkoutBtn"class="btn btn-primary mt-3">Start
                                Shopping</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- ***** Cart Area Ends ***** -->



@endsection
