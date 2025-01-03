@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
    <div class="homepage">
    <div class="row text-center pt-4 m-4 mb-5">
      <h1>Simplify Connections. Empower Accessibility.</h1>
      <h2>QR codes, made stupidly simple. <span class="highlight">No sign-ups</span>, <span class="highlight">No subscriptions</span>, and <span class="highlight">Always free</span>. Just click, create, and flex your code!</h2>
    </div>

    <div class="row m-4 mt-5 mb-5 custom-margin">
      <h2 class="text-center mb-4">Create QR codes tailored to your needs.</h2>
      <div class="container text-center mb-4">
        <div class="row align-items-start">
          <!-- Column 1 -->
          <div class="col-sm-4">
            <a href="#" class="solid">Contacts</a>
            <a href="#" class="border">Vcard - digital business card</a>
            <a href="#" class="border">Email</a>
            <a href="#" class="border">Discord</a>
          </div>

          <!-- Column 2 -->
          <div class="col-sm-4">
            <a href="#" class="solid">Finance</a>
            <a href="#" class="border">Pay By Square</a>
            <a href="#" class="border">QR Pay</a>
            <a href="#" class="border">Google Pay</a>
          </div>

          <!-- Column 3 -->
          <div class="col-sm-4">
            <a href="#" class="solid">Calendar</a>
            <a href="#" class="border">Events</a>
            <a href="#" class="border">Reminders</a>
            <a href="#" class="border">Invitations</a>
          </div>
        </div>
      </div>
      <a href="#">check out even more<i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="row m-4 text-center mb-5 custom-margin">
      <h2 class="text-center mb-4">Ready to integrate? Access our API docs and start today.</h2>
      <div class="container text-center mb-4">
        <div class="row align-items-start">
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
                <a href="#" class="solid">API docs</a>
          </div>
          <div class="col-sm-4">
          </div>
        </div>
      </div>
      <a href="#">get started<i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="row m-4 text-center mb-5">
      <h3>FREQUENT QUESTIONS ABOUT QR CODES</h3>
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Accordion Item #1
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Accordion Item #2
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Accordion Item #3
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row m-4 text-center mb-5">
      <h3>questions for developers</h3>
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Accordion Item #1
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Accordion Item #2
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Accordion Item #3
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row text-center m-4">
      <p>Didn't find what you were looking for?</p>
      <a href="#">get in touch<i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="row m-4 mt-5 mb-5 text-center">
      <h3>GET INSPIRED WITH GREAT STORIES.</h3>
      <div class="container text-center mb-4">
        <div class="row align-items-start justify-content-between">
          <!-- Card 1 -->
          <div class="card mx-3" style="width: 20rem;">
            <img src="{{ asset('assets/stories-cook.jpg') }}" class="card-img-top" alt="Chef Story">
            <div class="card-body">
              <p class="card-text">Now I can focus on what I love</p>
               <a href="#">
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
           
          </div>

          <!-- Card 2 -->
          <div class="card mx-3" style="width: 20rem;">
            <img src="{{ asset('assets/stories-yoga.jpg') }}" class="card-img-top" alt="Yoga Story">
            <div class="card-body">
              <p class="card-text">I grew my passion into a job</p>
              <a href="#">
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
            
          </div>

          <!-- Card 3 -->
          <div class="card mx-3" style="width: 20rem;">
            <img src="{{ asset('assets/stories-flower.jpg') }}" class="card-img-top" alt="Flower Shop Story">
            <div class="card-body">
              <p class="card-text">I managed to get enough customers</p>
              <a href="#">
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
@endsection
