@extends('admin.layouts.layout')

@section('content')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">@lang('messages.category_details')</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>@lang('messages.category_id'):</strong> {{ $category->id }}</p>
                    <p class="card-text"><strong>@lang('messages.category_name'):</strong> {{ $category->name }}</p>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">@lang('messages.back_to_categories')</a>
            </div>
        </div>
    </div>
</div>

@endsection
