@extends('admin.layouts.layout')

@section('content')
<div class="row">
    <!-- Categories Card -->
    <div class="col-xl-6 col-sm-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <a href="{{ route('admin.categories.index') }}" class="card-link">
                                <h3 class="mb-0">@lang('messages.categories_card_title')</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-info">
                            <span class="mdi mdi-view-list icon-item"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">@lang('messages.categories_card_description')</h6>
            </div>
        </div>
    </div>
    <!-- Products Card -->
    <div class="col-xl-6 col-sm-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <a href="{{ route('admin.products.index') }}" class="card-link">
                                <h3 class="mb-0">@lang('messages.products_card_title')</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-info">
                            <span class="mdi mdi-cube-outline icon-item"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">@lang('messages.products_card_description')</h6>
            </div>
        </div>
    </div>
</div>
@endsection
