<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="google-site-verification" content="9olAR0iGm3JZXhSKgL49tQw_UPrq0FUYm8m0IKonZj0" />

        <title>{{ config('app.name', 'Venture Vigil') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="icon" type="image/x-icon" href="/images/favicon.svg">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col">
        <x-banner />

        <div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            @yield('main')
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
