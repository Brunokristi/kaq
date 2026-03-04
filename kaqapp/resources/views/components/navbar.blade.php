<nav class="sticky top-0 z-10 flex items-center border-b border-black bg-white px-4 py-2 relative">

    <i id="menu-toggle" class="bi bi-list cursor-pointer text-black hover:text-brand text-xl"></i>
    
    <a href="/" class="absolute left-1/2 -translate-x-1/2 flex items-center">
        <img src="{{ asset('assets/logo_green-white.svg') }}" alt="Logo" class="h-8">
    </a>

    <div class="flex gap-4 ml-auto">
        <a href="{{ route('documentation') }}">
            <span class="text-black font-sans text-sm hover:underline hover:text-brand">API</span>
        </a>

        <a href="{{ route('contact') }}">
            <span class="text-black font-sans text-sm hover:underline hover:text-brand">CONTACT</span>
        </a>
    </div>

</nav>