<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MobileShop') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen gradient-bg flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-6">
                <a href="/" wire:navigate>
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-9 h-9 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-3xl font-bold text-white">MobileShop</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-xl">
                {{ $slot }}
            </div>

            <p class="mt-6 text-blue-100 text-sm">
                &copy; {{ date('Y') }} MobileShop. All rights reserved.
            </p>
        </div>
    </body>
</html>
