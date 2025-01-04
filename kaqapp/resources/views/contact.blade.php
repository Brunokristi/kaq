@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="contact">
    <div class="contact-page">
        <h2>Contact Us</h2>
        <form action="{{ route('contact.submit') }}" method="POST">
            @csrf
            <div class="field-holder">
                <input type="text" class="form-control" id="name" name="name" required>
                <label for="name">Name</label>
            </div>

            <div class="field-holder">
                <input type="email" class="form-control" id="email" name="email" required>
                <label for="email">Email</label>
            </div>

            <div class="field-holder">
                <textarea id="message" class="form-control" name="message" rows="5" required></textarea>
                <label for="message">Message</label>
            </div>

            <button class="btn btn-primary" type="submit">Send Message <i class="bi bi-arrow-right"></i></button>
        </form>

        @if(session('success'))
            <div class="success-message">
                Message sent. We will get back to you soon.  <br><a href="/">home <i class="bi bi-arrow-right"></i></a>
            </div>
        @endif

    </div>
</div>

<script>
    document.querySelectorAll('.field-holder input, .field-holder textarea').forEach(field => {
        field.addEventListener('input', () => {
            if (field.value.trim() !== "") {
                field.classList.add('has-value');
            } else {
                field.classList.remove('has-value');
            }
        });

        // Initialize class on page load for prefilled values
        if (field.value.trim() !== "") {
            field.classList.add('has-value');
        }
    });
</script>

@endsection
