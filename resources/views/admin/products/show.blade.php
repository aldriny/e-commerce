@extends('admin.layouts.layout')

@section('content')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">@lang('messages.show_product_details')</h5>
                </div>
                <div class="card-body">
                    @if ($product->image)
                        <div class="text-center mb-3">
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid" width="200">
                        </div>
                    @endif
                    <p class="card-text"><strong>@lang('messages.show_product_id'): </strong> {{ $product->id }}</p>
                    <p class="card-text"><strong>@lang('messages.create_product_name'): </strong> {{ $product->name }}</p>
                    <p class="card-text"><strong>@lang('messages.create_product_description'): </strong> {{ $product->description }}</p>
                    <p class="card-text"><strong>@lang('messages.create_product_price'): </strong> ${{ $product->price }}</p>
                    <p class="card-text"><strong>@lang('messages.create_product_quantity'): </strong> {{ $product->quantity }}</p>
                    <p class="card-text"><strong>@lang('messages.create_product_category'): </strong> {{ $product->category->name }}</p>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">@lang('messages.show_product_back')</a>
            </div>
        </div>
    </div>
</div>

@endsection
