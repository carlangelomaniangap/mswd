<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MUNICIPAL SOCIAL WELFARE DEVELOPMENT')</title>

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
        <main class="min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/background.jpg') }}');">
            <div class="grid grid-cols-1 md:grid-cols-2 min-h-screen backdrop-blur-sm bg-white/50 dark:bg-gray-900/40">
                <!-- Left side - Image -->
                <div class="hidden md:flex md:flex-col justify-center items-center">
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('images/mswd_logo.png') }}" alt="Logo" class="w-38 h-36">
                        <h1 class="text-8xl text-[#0600b8] font-black">MSWD</h1>
                    </div>
                    <em class="text-[#f70000]">MUNICIPAL SOCIAL WELFARE DEVELOPMENT OFFICE</em>
                    <h2 class="text-8xl text-[#ffd000]">ABUCAY</h2>
                </div>

                <!-- Right side - Content -->
                <div class="flex justify-center items-center">
                    <div class="p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>

            <x-footer />
        </main>

        <div class="fixed top-10 right-10">
            <x-button
                type="button"
                icon-only
                variant="secondary"
                sr-text="Toggle dark mode"
                x-on:click="toggleTheme"
                class="bg-white/65 dark:bg-gray-900/65"
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
