@extends('layouts.app')

@section('title', 'I Managed to Get Enough Customers')

@section('content')
<div class="blog-post container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h1 class="mb-4 text-center">I Managed to Get Enough Customers</h1>

            <img src="{{ asset('assets/stories-seeds.jpg') }}" alt="Woman gardener at work" class="img-fluid mb-4 rounded">

            <p><strong>Elena</strong> had a gift for gardening — transforming dull spaces into vibrant green corners. But turning her talent into a steady source of income wasn’t easy. As a solo gardener offering maintenance and landscaping, she needed visibility — and fast.</p>

            <blockquote class="blockquote my-4 ps-3 border-start border-3 border-dark">
                <p class="mb-0">“I knew people loved my work once they saw it,” Elena says. “The pobem was getting them to see it in the first place.”</p>
            </blockquote>

            <h2 class="mt-5">Smart and Simple Promotion</h2>

            <p>Elena started adding QR codes to everything — her flyers, plant labels at markets, even her work van. One scan led people directly to her photo gallery, testimonials, and booking form.</p>

            <img src="{{ asset('assets/stories-calm.jpg') }}" alt="QR code for garden services" class="img-fluid my-4 rounded">

            <p>She also created a QR code that lets potential clients call her instantly. With zero effort on their part, new customers could reach out the moment they were interested.</p>

            <h2 class="mt-5">The Growth</h2>

            <ul>
                <li><strong>New Clients Weekly:</strong> People found her easily and could see her work right away.</li>
                <li><strong>Professional Touch:</strong> The QR codes gave her business a clean, modern image.</li>
                <li><strong>Less Chasing:</strong> Customers came to her — no need for door-to-door pitches.</li>
            </ul>

            <h2 class="mt-5">Gardening Full-Time</h2>

            <p>Now, Elena works with a steady stream of clients across the city. She no longer worries about where her next job will come from — because QR codes help bring work right to her.</p>

            <blockquote class="blockquote my-4 ps-3 border-start border-3 border-dark">
                <p class="mb-0">“I finally have enough customers — and I didn’t need a marketing agency to do it.”</p>
            </blockquote>
        </div>
    </div>
</div>
@endsection
