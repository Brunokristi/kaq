@extends('layouts.app')

@section('title', 'KAQ Dashboard - Create QR Codes')

@section('content')
<div class="h-full min-h-0 flex flex-col lg:flex-row">
    <div class="min-w-0 lg:overflow-y-auto p-4 flex-1">
        <div id="main-content" class="break-words">
            {{-- dynamic content loads here --}}
        </div>
    </div>

    @include('components.right-panel')
</div>

<script>
    window.kaqDashboardConfig = {
        qrApiBaseUrl: @json(config('services.qr_api.base_url')),
    };
</script>

@vite('resources/js/dashboard.js')
@endsection
