@extends('layouts.app')

@section('title', 'I Grew My Passion into a Job')

@section('content')
<div class="blog-post container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h1 class="mb-4 text-center">I Grew My Passion into a Job</h1>

            <img src="{{ asset('assets/stories-yogamat.jpg') }}" alt="Yoga instructor" class="img-fluid mb-4 rounded">

            <p><strong>Sophia</strong> always dreamed of sharing her love for yoga with others. What started as a weekend hobby quickly grew into small community classes in the park. But it wasn’t until she discovered how to market herself effectively with <strong>QR codes</strong> that her dream became a full-time job.</p>

            <blockquote class="blockquote my-4 ps-3 border-start border-3 border-dark">
                <p class="mb-0">“I knew I could help people feel better in their bodies,” Sophia says. “I just didn’t know how to reach them.”</p>
            </blockquote>

            <h2 class="mt-5">Reaching New Students with a Simple Scan</h2>

            <p>Sophia created QR codes that led to her class schedule, pricing, and booking form. She printed flyers and posters with the QR codes and placed them in local cafes, gyms, and wellness centers. With just one scan, people could instantly sign up for a class.</p>

            <img src="{{ asset('assets/stories-back.jpg') }}" alt="QR code for yoga class" class="img-fluid my-4 rounded">

            <p>She also made QR codes that link directly to her website and social media. By placing them on her yoga mat bag and business cards, she turned every outing into an opportunity to gain new followers and students.</p>

            <h2 class="mt-5">The Results</h2>

            <ul>
                <li><strong>More Visibility:</strong> Her classes started filling up thanks to word of mouth and easy access via QR codes.</li>
                <li><strong>Streamlined Booking:</strong> No more chasing texts or emails — students could register in seconds.</li>
                <li><strong>Professional Presence:</strong> Her branded QR codes added credibility and made her services feel premium.</li>
            </ul>

            <h2 class="mt-5">Living the Dream</h2>

            <p>Today, Sophia teaches yoga full-time. She runs regular classes, offers private sessions, and even holds weekend retreats — all managed from her phone, with the help of QR codes.</p>

            <blockquote class="blockquote my-4 ps-3 border-start border-3 border-dark">
                <p class="mb-0">“I turned my passion into my career. And all it took was making it easier for people to find me.”</p>
            </blockquote>




        </div>
    </div>
</div>
@endsection
