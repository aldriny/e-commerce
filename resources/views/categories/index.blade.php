@extends('layouts.layout')

@section('content')

<!-- ***** Category Banner Area Start ***** -->
<div class="page-heading about-page-heading" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-content">
                    <h2>Categories</h2>
                    <span>Explore the various categories available.</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Category Banner Area End ***** -->

<!-- ***** Categories Area Starts ***** -->
<section class="section" id="categories">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2>Available Categories</h2>
                    <span>Check out all categories.</span>
                </div>
            </div>
        </div>
        <div class="row">
            @if($categories->isEmpty())
                <div class="col-lg-12">
                    <div class="alert alert-info text-center">
                        <strong>No categories available.</strong>
                    </div>
                </div>
            @else
                @foreach($categories as $category)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('categories.show', $category->id) }}">
                        <div class="category-card">
                            <div class="">
                                <h4>{{ $category->name }}</h4>
                            </div>
                        </div>
                    </a>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-lg-12">
            <div class="d-flex justify-content-center mt-4">
                {{ $categories->links() }} 
            </div>
        </div>
    </div>
</section>
<!-- ***** Categories Area Ends ***** -->

@endsection
