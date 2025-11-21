@extends('layouts.app')

@section('title', 'Lumospace - Illuminate Your Home')

@section('content')

<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-3"> Brighten Your Space<br> With Modern Lighting & Furniture </h1>
                <p class="lead mb-4"> Discover minimalist design and timeless craftsmanship for every room. </p>
                <a href="{{ route('products') }}" class="btn btn-dark btn-lg px-4">Explore Collection</a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('assets/images/hero_lamp.png') }}" alt="Lamp" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-4">About Us</h2>
        <p class="mb-4">At Lumospace, we are passionate about creating minimalist and modern lighting solutions that enhance every home. Our designs focus on elegance, functionality, and timeless craftsmanship, ensuring your space shines brightly and beautifully.</p>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Our Mission</h5>
                        <p class="card-text">To illuminate homes with modern, stylish, and sustainable lighting and furniture solutions.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Our Vision</h5>
                        <p class="card-text">To become a trusted brand for minimalist design lovers, blending beauty and functionality in every product.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
