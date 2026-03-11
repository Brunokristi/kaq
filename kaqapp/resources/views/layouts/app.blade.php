<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'kaq')</title>

  <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Inter:wght@400;700&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

    <body class="font-sans bg-white m-0 box-border h-screen flex flex-col overflow-hidden">
        <div id="toast-container" class="pointer-events-none fixed top-4 right-4 z-50 flex w-[calc(100%-2rem)] max-w-sm flex-col gap-2 sm:w-full">
            @if(session('success'))
                <x-toast type="success" :message="session('success')" />
            @endif

            @if(session('error'))
                <x-toast type="error" :message="session('error')" />
            @endif

            @if($errors->any())
                <x-toast type="error" :message="$errors->first()" :autoclose="6000" />
            @endif
        </div>

        <x-navbar />

        <main class="flex flex-1 min-h-0">
            <div id="sidebar" class="w-72 border-r border-black overflow-y-auto min-h-0 transition-all duration-300">
                <x-sidebar />
            </div>

            <div id="content" class="flex-1 overflow-y-auto min-h-0">
                @yield('content')
            </div>
        </main>

        <x-footer />
    </body>
</html>