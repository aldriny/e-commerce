@extends('admin.layouts.layout')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5 text-center">@lang('messages.create_category_title')</h4>
                    <form class="forms-sample" method="post" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">@lang('messages.create_category_name')</label>
                            <input type="text" class="form-control" name="name" id="exampleInputUsername1" placeholder="@lang('messages.create_category_placeholder')">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary me-2">@lang('messages.create_category_submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
