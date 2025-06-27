<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('images/mswd_logo.png') }}" type="image/x-icon">
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Styles -->
    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div
        x-data="mainState"
        class="font-sans antialiased"
        :class="{dark: isDarkMode}"
        x-cloak
    >
        <main class="flex min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-eval-0 dark:text-gray-200">
            <!-- Left side - Image -->
            <div class="w-1/2 hidden md:block">
                <img src="{{ asset('images/mswd_bg.PNG') }}" alt="Side image" class="object-cover w-full h-full">
            </div>

            <!-- Right side - Content -->
            <div class="w-full md:w-1/2 flex justify-center items-center">
                <div class="p-8">
                    {{ $slot }}
                </div>

                <x-footer />
            </div>
        </main>


        <div class="fixed top-10 right-10">
            <x-button
                type="button"
                icon-only
                variant="secondary"
                sr-text="Toggle dark mode"
                x-on:click="toggleTheme"
            >
                <x-heroicon-o-moon
                    x-show="!isDarkMode"
                    aria-hidden="true"
                    class="w-6 h-6"
                />

                <x-heroicon-o-sun
                    x-show="isDarkMode"
                    aria-hidden="true"
                    class="w-6 h-6"
                />
            </x-button>
        </div>
    </div>
</body>
</html>
