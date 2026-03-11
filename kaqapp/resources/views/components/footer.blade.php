<nav class="sticky bottom-0 z-10 flex items-center border-t border-black bg-white px-4 py-1 relative gap-2 justify-between">
    <div class="flex items-center gap-2">
        <a href="https://studiokristian.com" target="_blank" class="flex items-center gap-2">
            <img src="{{ asset('assets/ks_logo.svg') }}" alt="studiokristian" class="h-3">
        </a>

        <a href="/" class="flex items-center gap-2">
            <img src="{{ asset('assets/logo_green-white.svg') }}" alt="Logo" class="h-3">
        </a>

        <p class="text-xs text-brand">
            &copy; {{ date('Y') }}
        </p>
    </div>

    <div class="flex items-center gap-2">
        <p class="text-xs text-brand">
            qr code generation engine
        </p>
    </div>

</nav>