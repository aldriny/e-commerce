@extends('admin.layouts.layout')

@section('content')

@if (session('success'))
<div class="alert alert-success mt-3">
    {{ session('success') }}
</div>
@endif

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">@lang('messages.products_title')</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> @lang('messages.product_name') </th>
                            <th class="text-truncate" style="max-width: 200px;"> @lang('messages.product_description') </th>
                            <th> @lang('messages.product_price') </th>
                            <th> @lang('messages.product_quantity') </th>
                            <th> @lang('messages.product_image') </th>
                            <th> @lang('messages.product_category') </th>
                            <th class="text-center" style="width: 80px;"> @lang('messages.product_show') </th>
                            <th class="text-center" style="width: 80px;"> @lang('messages.product_edit') </th>
                            <th class="text-center" style="width: 80px;"> @lang('messages.product_delete') </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                        <tr>
                            <td> {{ $products->firstItem() + $index }} </td>
                            <td>
                                <a href="{{ route('admin.products.show', $product->id) }}" class=" show-link">
                                    {{ $product->name }}
                                </a>
                            </td>
                            <td class="text-truncate" style="max-width: 250px;"> {{ $product->description }} </td>
                            <td> ${{ $product->price }} </td>
                            <td> {{ $product->quantity }} </td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid" width="50">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td> {{ $product->category->name }} </td>
                            <td class="text-center" style="width: 80px;">
                                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> 
                                </a>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('@lang('messages.confirm_delete_product')');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <ul class="pagination justify-content-center">
                    {{ $products->links() }}
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
