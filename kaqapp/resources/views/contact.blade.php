@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="mx-auto w-full max-w-3xl p-4 sm:p-6">

    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5 p-4 sm:p-6">
        @csrf
        
        <h2 class="mb-6 text-lg uppercase">Contact Us</h2>

        <div class="absolute -left-[10000px] top-auto h-px w-px overflow-hidden" aria-hidden="true">
            <label for="website">Website</label>
            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="flex flex-col gap-2">
            <label for="name" class="text-xs uppercase tracking-wide">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                class="w-full border border-black p-2 focus:outline-none"
                required
            >
        </div>

        <div class="flex flex-col gap-2">
            <label for="email" class="text-xs uppercase tracking-wide">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                class="w-full border border-black p-2 focus:outline-none"
                required
            >
        </div>

        <div class="flex flex-col gap-2">
            <label for="message" class="text-xs uppercase tracking-wide">Message</label>
            <textarea
                id="message"
                name="message"
                rows="6"
                class="w-full border border-black p-2 focus:outline-none resize-none"
                required
            >{{ old('message') }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="border border-black bg-black text-white px-4 py-2 text-xs uppercase hover:bg-white hover:text-black">
                Send Message
            </button>
        </div>
    </form>
</div>

@endsection
