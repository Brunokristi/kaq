@extends('layouts.app')

@section('title', __('homepage.title'))

@section('content')
<div class="homepage">
    <!-- Header Section -->
    <div class="row text-center pt-4 mt-5 mb-5 custom-margin">
        <h1>{{ __('homepage.slogan') }}</h1>
        <h2>
            {{ __('homepage.subtitle') }}
            <span class="highlight">{{ __('homepage.no_signups') }}</span>, 
            <span class="highlight">{{ __('homepage.no_subscriptions') }}</span>, 
            {{ __('homepage.always_free') }}.
        </h2>
    </div>

    <!-- QR Code Purpose Section -->
    <div class="row mt-5 mb-5 custom-margin">
        <h2 class="text-center mb-4">{{ __('homepage.qr_code_purpose') }}</h2>
        <div class="container text-center mb-4">
            <div class="row align-items-start">
                <!-- Column 1 -->
                <div class="col-sm-4">
                    <a href="#" class="solid">{{ __('homepage.contacts') }}</a>
                    <a href="#" class="border">{{ __('homepage.vcard') }}</a>
                    <a href="#" class="border">{{ __('homepage.email') }}</a>
                    <a href="#" class="border">{{ __('homepage.discord') }}</a>
                </div>
                <!-- Column 2 -->
                <div class="col-sm-4">
                    <a href="#" class="solid">{{ __('homepage.finance') }}</a>
                    <a href="#" class="border">{{ __('homepage.pay_by_square') }}</a>
                    <a href="#" class="border">{{ __('homepage.qr_pay') }}</a>
                    <a href="#" class="border">{{ __('homepage.google_pay') }}</a>
                </div>
                <!-- Column 3 -->
                <div class="col-sm-4">
                    <a href="#" class="solid">{{ __('homepage.calendar') }}</a>
                    <a href="#" class="border">{{ __('homepage.events') }}</a>
                    <a href="#" class="border">{{ __('homepage.reminders') }}</a>
                    <a href="#" class="border">{{ __('homepage.invitations') }}</a>
                </div>
            </div>
        </div>
        <a href="#">{{ __('homepage.check_more') }}<i class="bi bi-arrow-right"></i></a>
    </div>

    <!-- API Docs Section -->
    <div class="row text-center mb-5 custom-margin " style="padding: 12px;">
        <div class="container text-center mb-4 api-section" style="padding: 20px 0; background: url('{{ asset('assets/image0.jpg') }}') no-repeat center center; background-size: cover; border: 1px solid #000;">
            <h2 class="text-center mb-4 api-section">{{ __('homepage.api_docs_title') }}</h2>
            <div class="container text-center mb-4"  style="padding: 12px;">
                <div class="row align-items-start">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <a href="#" class="solid">{{ __('homepage.api_docs') }}</a>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
            </div>
            <a class="api-section" href="#">{{ __('homepage.get_started') }}<i class="bi bi-arrow-right api-section"></i></a>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row text-center mb-5" style="padding: 12px;">
        <h2>{{ __('homepage.faq_title') }}</h2>
        <div class="accordion" id="firstAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOneFirst">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneFirst" aria-expanded="true" aria-controls="collapseOneFirst">
                        {{ __('homepage.faq_question_1') }}
                    </button>
                </h2>
                <div id="collapseOneFirst" class="accordion-collapse collapse show" data-bs-parent="#firstAccordion">
                    <div class="accordion-body">
                        {{ __('homepage.faq_answer_1') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwoFirst">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoFirst" aria-expanded="false" aria-controls="collapseTwoFirst">
                        {{ __('homepage.faq_question_2') }}
                    </button>
                </h2>
                <div id="collapseTwoFirst" class="accordion-collapse collapse" data-bs-parent="#firstAccordion">
                    <div class="accordion-body">
                        {{ __('homepage.faq_answer_2') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThreeFirst">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeFirst" aria-expanded="false" aria-controls="collapseThreeFirst">
                        {{ __('homepage.faq_question_3') }}
                    </button>
                </h2>
                <div id="collapseThreeFirst" class="accordion-collapse collapse" data-bs-parent="#firstAccordion">
                    <div class="accordion-body">
                        {{ __('homepage.faq_answer_3') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="row text-center p-4">
        <p>{{ __('homepage.not_found') }}</p>
        <a href="#">{{ __('homepage.contact') }}<i class="bi bi-arrow-right"></i></a>
    </div>

    <!-- Stories Section -->
    <div class="row mt-5 mb-5 text-center">
    <h2>{{ __('homepage.stories_title') }}</h2>
    <div class="container text-center mb-4 p-4">
        <div class="row align-items-start justify-content-between g-3">
            <!-- Card 1 -->
            <div class="col-12 col-lg">
                <div class="card h-100">
                    <img src="{{ asset('assets/stories-cook.jpg') }}" class="card-img-top" alt="{{ __('homepage.story_chef_alt') }}">
                    <div class="card-body">
                        <p class="card-text">{{ __('homepage.story_chef') }}</p>
                        <a href="#"><i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-12 col-lg">
                <div class="card h-100">
                    <img src="{{ asset('assets/stories-yoga.jpg') }}" class="card-img-top" alt="{{ __('homepage.story_yoga_alt') }}">
                    <div class="card-body">
                        <p class="card-text">{{ __('homepage.story_yoga') }}</p>
                        <a href="#"><i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-12 col-lg">
                <div class="card h-100">
                    <img src="{{ asset('assets/stories-flower.jpg') }}" class="card-img-top" alt="{{ __('homepage.story_flower_alt') }}">
                    <div class="card-body">
                        <p class="card-text">{{ __('homepage.story_flower') }}</p>
                        <a href="#"><i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
