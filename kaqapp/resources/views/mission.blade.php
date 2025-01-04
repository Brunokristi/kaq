@extends('layouts.app')

@section('title', 'Mission')

@section('content')
<div class="mission">
    <div class="container py-5">
        <div class="row align-items-end mb-5" style="height: 100%;">

            <div class="col-md-6 d-flex justify-content-between">
                <!-- Image 1 -->
                <div class="image-holder me-3">
                    <img src="{{ asset('assets/image1.jpg') }}" alt="Blue Artwork" class="img-fluid">
                </div>
                <!-- Image 2 -->
                <div class="image-holder ms-3">
                    <img src="{{ asset('assets/image2.jpg') }}" alt="Marble Artwork" class="img-fluid">
                </div>
            </div>

            <div class="col-md-6 d-flex align-items-end ps-5" style="height: 100%;">
                <!-- Rotated Text -->
                <div class="text-holder d-flex justify-content-end" style="flex: 1;">
                    <h3 class="text-rotate">MISSION</h3>
                </div>

                <!-- Paragraphs -->
                <div class="text-holder">
                    <p>
                        We believe productivity tools should be simple, accessible, and free for everyone.
                        In a world full of paywalls and signups, we’re breaking the mold—offering a tool that
                        empowers individuals and businesses to succeed without limits.
                    </p>
                    <p class="m-0">
                        Whether you’re an entrepreneur, developer, teacher, or student, our platform is here
                        to help you focus on what truly matters—your goals. No fees, no barriers, just seamless
                        QR code solutions for all.
                    </p>
                </div>
            </div>
        </div>


        <div class="row align-items-end mb-5" style="height: 100%;">

            <div class="col-md-6 d-flex justify-content-between">
                <!-- Image 1 -->
                <div class="image-holder me-3">
                    <img src="{{ asset('assets/image3.jpg') }}" alt="Blue Artwork" class="img-fluid">
                </div>
                <!-- Image 2 -->
                <div class="image-holder ms-3">
                    <img src="{{ asset('assets/image4.jpg') }}" alt="Marble Artwork" class="img-fluid">
                </div>
            </div>

            <div class="col-md-6 d-flex align-items-end ps-5" style="height: 100%;">
                <!-- Rotated Text -->
                <div class="text-holder d-flex justify-content-end" style="flex: 1;">
                    <h3 class="text-rotate">MOTIVATION</h3>
                </div>

                <!-- Paragraphs -->
                <div class="text-holder">
                    <p class="m-0">
                        We’ve had enough of tools that frustrate more than they help. Our service is 100% free because we believe in removing barriers and fostering creativity. Everyone deserves access to tools that make life easier, regardless of their budget or background.
                    </p>
                </div>
            </div>
        </div>



        <div class="row align-items-end mb-5" style="height: 100%;">

            <div class="col-md-6 d-flex justify-content-between">
                <!-- Image 1 -->
                <div class="image-holder me-3">
                    <img src="{{ asset('assets/image5.jpg') }}" alt="Blue Artwork" class="img-fluid">
                </div>
                <!-- Image 2 -->
                <div class="image-holder ms-3">
                    <img src="{{ asset('assets/image6.jpg') }}" alt="Marble Artwork" class="img-fluid">
                </div>
            </div>

            <div class="col-md-6 d-flex align-items-end ps-5" style="height: 100%;">
                <!-- Rotated Text -->
                <div class="text-holder d-flex justify-content-end" style="flex: 1;">
                    <a href="#" class="text-rotate">SUPPORT <i class="bi bi-arrow-down"></i></a>
                </div>

                <!-- Paragraphs -->
                <div class="text-holder">
                    <p class="m-0">
                        If you believe in our vision and want to help us keep this service free for everyone, consider supporting us with a small contribution. Your support helps us maintain the platform, improve features, and continue empowering others.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
