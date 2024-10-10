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
            <h4 class="card-title">@lang('messages.categories_title')</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> @lang('messages.category_name') </th>
                            <th style="width: 80px;"> @lang('messages.category_show') </th>
                            <th style="width: 80px;"> @lang('messages.category_edit') </th>
                            <th style="width: 80px;"> @lang('messages.category_delete') </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $index => $category)
                        <tr>
                            <td> {{ $categories->firstItem() + $index }} </td>
                            <td> {{ $category->name }} </td>
                            <td>
                                <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> @lang('messages.category_show')
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> @lang('messages.category_edit')
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('@lang('messages.confirm_delete')');">
                                        <i class="fas fa-trash-alt"></i> @lang('messages.category_delete')
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
                    {{ $categories->links() }}
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
