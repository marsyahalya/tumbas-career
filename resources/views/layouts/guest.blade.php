<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-stone-50 relative overflow-hidden">
        <!-- Tumbas Decorative Background for Auth -->
        <div class="absolute -top-20 -left-20 w-80 h-80 bg-tumbas/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 -right-20 w-80 h-80 bg-orange-300/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
                <p class="text-center font-semibold text-gray-400 text-sm mt-1 uppercase tracking-widest">Career Riders</p>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white shadow-xl border border-stone-100 overflow-hidden sm:rounded-2xl relative">
                <!-- Top Accents -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-tumbas to-orange-400"></div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
