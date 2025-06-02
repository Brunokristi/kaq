@extends('layouts.app')

@section('title', 'Now I Can Focus on What I Love')

@section('content')
<div class="blog-post container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h1 class="mb-4 text-center">Now I Can Focus on What I Love</h1>

            <img src="{{ asset('assets/stories-cook.jpg') }}" alt="Chef in kitchen" class="img-fluid mb-4 rounded">

            <p>Running a restaurant is a labor of love, but it’s also a constant juggling act — from managing staff to handling customer questions and printing updated menus. For <strong>Marco</strong>, a passionate chef and owner of a cozy downtown eatery, all of this was pulling him away from the kitchen — the place where he truly belongs.</p>

            <blockquote class="blockquote my-4 ps-3 border-start border-3 border-dark">
                <p class="mb-0">“I didn’t open a restaurant to spend my day reprinting menus or answering phones,” he says. <br> “I just wanted to cook.”</p>
            </blockquote>

            <p>Marco decided to simplify things. He generated a QR code that links directly to his restaurant’s website, where customers can always find the latest menu. No printing, no hassle — just a quick scan from any smartphone.</p>

            <img src="{{ asset('assets/stories-food.jpg') }}" alt="QR code linking to menu" class="img-fluid my-4 rounded">

            <p>He also created another QR code that allows guests to call the restaurant instantly with one tap. Making a reservation has never been easier for his customers — or for him.</p>

            <img src="{{ asset('assets/stories-menu.jpg') }}" alt="QR code for phone call" class="img-fluid my-4 rounded">

            <h2 class="mt-5">How It Helped</h2>

            <ul>
                <li><strong>Always Up-to-Date Menu:</strong> Customers can scan a code and view the latest dishes online.</li>
                <li><strong>Quick Reservations:</strong> One tap to call means fewer missed opportunities and smoother service.</li>
            </ul>

            <h2 class="mt-5">Back to the Kitchen</h2>

            <p>Thanks to two simple QR codes, Marco spends less time on the phone and more time doing what he loves — cooking unforgettable meals for his guests.</p>

            <blockquote class="blockquote my-4 ps-3 border-start border-3 border-dark">
                <p class="mb-0">“Now I can focus on what I love — cooking for people. And that’s all I ever wanted.”</p>
            </blockquote>

        </div>
    </div>
</div>
@endsection
