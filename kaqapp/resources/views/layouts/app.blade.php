<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" defer></script>

    
    <!-- Vite -->
    @vite(['resources/js/app.js'])
    @vite('resources/sass/app.scss')

</head>
<body class="{{ Route::is('create') ? 'create' : '' }}">
    <!-- Top Navbar -->
    <x-app-navbar />
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Bottom Navbar -->
    <x-app-bottom-navbar />
</body>
<style>
body {
    padding: 46px 10rem;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
    background: #fff;
}

h1, h2, h3 {
    text-transform: uppercase;
    color: #000;
}

h2 {
    font-size: 1rem !important;
    font-weight: 400 !important;
}

h1 {
    font-size: 1.3rem !important;
}

h3 {
    font-size: 0.9rem !important;
    text-transform: uppercase;
}

p {
    font-size: 0.9rem !important;
}

@media (max-width: 768px) {
    body {
        padding: 46px 1rem;
    }
}
</style>
</html>
