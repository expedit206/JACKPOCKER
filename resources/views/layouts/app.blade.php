<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'POTJACKER') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="/build/assets/app.css">
    </head>
    <body class="font-sans antialiased  bg-gray-800 ">
        <style>
            .fa-times{
                background: rgb(47, 68, 182);
                padding: .5rem .9rem;
                border-radius: 7px;
                font-size: 1.5rem
            }
            .fa-edit{
                background: rgb(47, 200, 182);
                padding: .5rem .6rem;
                border-radius: 7px;
                font-size: 1.3rem
            }
        </style>
        <div class="min-h-screen  bg-gray-800">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-gray-600 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-7">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="bg-gray-400">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
