<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>@yield('title', 'Task Manager')</title> --}}

    <!-- Vite for CSS and JS -->
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal min-h-screen flex flex-col">

    <!-- Page Content -->
    <main class="flex-grow container mx-auto px-4 py-6">
        @yield('content')
    </main>
    <!-- Footer -->
    <footer class="bg-red-800 py-4 text-white text-center">
        <p>&copy; {{ date('Y') }} Task Manager. All rights reserved.</p>
    </footer>
</body>

</html>