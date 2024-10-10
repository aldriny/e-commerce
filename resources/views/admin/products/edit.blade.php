@extends('admin.layouts.layout')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5 text-center">@lang('messages.edit_product_title')</h4>
                    <form class="forms-sample" method="post" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="productName">@lang('messages.create_product_name')</label>
                            <input type="text" class="form-control" name="name" id="productName" placeholder="@lang('messages.create_product_name')" value="{{ old('name', $product->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="productDescription">@lang('messages.create_product_description')</label>
                            <textarea class="form-control" name="description" id="productDescription" placeholder="@lang('messages.create_product_description')">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="productPrice">@lang('messages.create_product_price')</label>
                            <input type="number" step="0.01" class="form-control" name="price" id="productPrice" placeholder="@lang('messages.create_product_price')" value="{{ old('price', $product->price) }}">
                        </div>
                        <div class="form-group">
                            <label for="productQuantity">@lang('messages.create_product_quantity')</label>
                            <input type="number" class="form-control" name="quantity" id="productQuantity" placeholder="@lang('messages.create_product_quantity')" value="{{ old('quantity', $product->quantity) }}">
                        </div>
                        <div class="form-group">
                            <label for="productCategory">@lang('messages.create_product_category')</label>
                            <select class="form-control" name="category_id" id="productCategory">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == old('category_id', $product->category_id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="productImage">@lang('messages.create_product_image')</label>
                            <input type="file" class="form-control" name="image" id="productImage">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary me-2">@lang('messages.create_product_submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
