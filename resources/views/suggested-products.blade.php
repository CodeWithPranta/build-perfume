@extends('layouts.app')
@section('content')
    <!-- CONTAINER -->
    <div class="container d-flex align-items-center min-vh-100">
    <div class="row g-0 justify-content-center">
        <!-- TITLE -->
        <div class="px-0 mx-0 col-lg-4 offset-lg-1">
            <div id="title-container">
                <img class="covid-image rounded-circle" src="{{asset('images/perfume-bottle2.jpg')}}">
                <h2>Perfume</h2>
                <h3>Get your desired perfume</h3>
                <p>Answers carefully and make your adjustable perfume!</p>
                @include('components.language-switch')
            </div>
        </div>
        <!-- FORMS -->
        <div class="px-0 mx-0 col-lg-7">
            <div class="progress">
                <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 0%"></div>
            </div>
            <div id="qbox-container">

           <!-- Suggested Products Section -->
            @if(isset($suggestedProducts) && (is_array($suggestedProducts) ? count($suggestedProducts) > 0 : $suggestedProducts->isNotEmpty()))
            <div class="mt-5">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-4 alert alert-success d-flex justify-content-between align-items-center" role="alert">
                        <span class="font-weight-bold">{{ session('success') }}</span>
                        <button type="button" class="btn-close" aria-label="Close" onclick="this.parentElement.remove()"></button>
                    </div>
                @endif
                <h3>Suggested Products</h3>
                <div class="row">
                    @foreach($suggestedProducts as $product)
                    <div class="mb-3 col-md-4">
                        <div class="card">
                            <img src="{{ asset('storage/'.$product->photos[0]) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <a href="#" class="btn btn-danger">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            </div>
        </div>
    </div>
</div><!-- PRELOADER -->
<div id="preloader-wrapper">
    <div id="preloader"></div>
    <div class="preloader-section section-left"></div>
    <div class="preloader-section section-right"></div>
</div>

@endsection
