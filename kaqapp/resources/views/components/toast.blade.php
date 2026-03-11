@props([
    'type' => 'success',
    'message' => null,
    'autoclose' => 4000,
])

@php
    $text = $message ?? trim((string) $slot);
    $isError = $type === 'error';
@endphp

@if($text !== '')
<div
    data-toast
    data-autoclose="{{ (int) $autoclose }}"
    class="pointer-events-auto w-full max-w-sm border border-black bg-black text-white shadow-sm transition-all duration-200 opacity-0 -translate-y-2"
    role="alert"
    aria-live="assertive"
>
    <div class="flex items-start gap-3 p-3">
        <i class="bi {{ $isError ? 'bi-exclamation-triangle' : 'bi-check-circle' }} text-sm mt-0.5"></i>

        <p class="text-xs leading-5 flex-1">{{ $text }}</p>

        <button
            type="button"
            class="text-white hover:text-brand"
            data-toast-close
            aria-label="Close"
        >
            <i class="bi bi-x"></i>
        </button>
    </div>
</div>
@endif
