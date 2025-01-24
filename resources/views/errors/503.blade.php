@extends('layout.default')

@section('title', '503')

@section('content')

		<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h2><i class="bi bi-tools"></i></h2>
                <h1 class="display-4">Website Under Maintenance</h1>
                <img src="{{ asset('/images/maintenance.png') }}" alt="Your Logo" class="img-fluid mt-5 mb-3">
                <p class="lead">We apologize for the inconvenience. Our website is currently undergoing maintenance. Please check back later.</p>
            </div>
        </div>
    </div>


@endsection