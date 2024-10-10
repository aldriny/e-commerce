{{-- @extends('layout')

@section('body') --}}
    <div class="container mt-5">
        <h1 class="text-danger">Oops! Something went wrong.</h1>
        <p>{{ $message}}</p>


        <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
    </div>
{{-- @endsection --}}
