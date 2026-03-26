<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Miksusu Admin') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/logo.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/logo.png') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    @include('layouts.navigation')

    <div class="flex-1 flex flex-col h-screen overflow-hidden w-full">
        
        <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200">
            <button @click="sidebarOpen = true" class="text-gray-500 hover:text-red-600 focus:outline-none lg:hidden transition-colors">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div class="flex-1 px-4 text-xl font-semibold text-gray-800 lg:px-0">
                @if (isset($header))
                    {{ $header }}
                @endif
            </div>
            
            <div class="hidden lg:flex items-center text-sm text-gray-500 font-medium">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 md:p-6">
            {{ $slot }}
        </main>
    </div>

</body>
</html>