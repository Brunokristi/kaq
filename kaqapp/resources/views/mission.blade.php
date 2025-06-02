@extends('layouts.app')

@section('title', 'Mission')

@section('content')
<div class="mission">
    <div class="container py-5">
        @foreach ([
            ['image1' => 'image1.jpg', 'image2' => 'image2.jpg', 'title' => 'MISSION', 'link' => false, 'text' => [
                "We believe productivity tools should be simple, accessible, and free for everyone. In a world full of paywalls and signups, we’re breaking the mold—offering a tool that empowers individuals and businesses to succeed without limits.",
                "Whether you’re an entrepreneur, developer, teacher, or student, our platform is here to help you focus on what truly matters—your goals. No fees, no barriers, just seamless QR code solutions for all."
            ]],
            ['image1' => 'image3.jpg', 'image2' => 'image4.jpg', 'title' => 'MOTIVATION', 'link' => false, 'text' => [
                "We’ve had enough of tools that frustrate more than they help. Our service is 100% free because we believe in removing barriers and fostering creativity. Everyone deserves access to tools that make life easier, regardless of their budget or background."
            ]],
            ['image1' => 'image5.jpg', 'image2' => 'image6.jpg', 'title' => 'SUPPORT <i class="bi bi-arrow-down"></i>', 'link' => true, 'text' => [
                "If you believe in our vision and want to help us keep this service free for everyone, consider supporting us with a small contribution. Your support helps us maintain the platform, improve features, and continue empowering others."
            ]]
        ] as $block)
        <div class="row align-items-end mb-5">
            <!-- Image Section -->
            <div class="col-md-6 d-flex justify-content-between flex-column flex-md-row mb-3 mb-md-0">
                <div class="image-holder mb-2 mb-md-0 me-md-3">
                    <img src="{{ asset('assets/' . $block['image1']) }}" alt="Artwork" class="img-fluid">
                </div>
                <div class="image-holder ms-md-3">
                    <img src="{{ asset('assets/' . $block['image2']) }}" alt="Artwork" class="img-fluid">
                </div>
            </div>

            <!-- Text Section -->
            <div class="col-md-6 d-flex flex-column flex-md-row align-items-md-end ps-md-5">
                <!-- Rotated title -->
                <div class="text-holder d-flex justify-content-end justify-content-md-start mb-2 mb-md-0 me-md-3">
                    @if ($block['link'])
                        <a href="#" class="text-rotate">{!! $block['title'] !!}</a>
                    @else
                        <h3 class="text-rotate">{!! $block['title'] !!}</h3>
                    @endif
                </div>

                <!-- Paragraphs -->
                <div class="text-holder">
                    @foreach ($block['text'] as $p)
                        <p class="m-0 mb-2">{{ $p }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
