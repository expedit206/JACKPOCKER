<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

        <title>{{ config('app.name', 'POTJACKER') }}</title>

        <!-- Fonts -->
        <link rel="shortcut icon" href="/img/logo_flashcash.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Dans la section <head> -->
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @vite(['build/assets/app-DB79hNgi.css ', 'public/build/assets/app-DLXkxiZ3.js']) --}}
    <link rel="stylesheet" href="/build/assets/app-DB79hNgi.css">
    <script src="/build/assets/app-DLXkxiZ3.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    </head>
    <body class="font-sans antialiased   ">
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
        <div class="">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class=" shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-7">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="">
                {{ $slot }}
            </main>
        </div>

            {{-- <a href="https://api.whatsapp.com/send?text={{ urlencode('Check%20out%20this%20amazing%20app:%20https://potjacker-a78c3d041f48.herokuapp.com/') }}" target="_blank" class="fixed text-green-500 top-[90vh] left-[80vw] flex items-center gap-1">Partage<i class="fas fa-share-alt text-2xl"></i>
            </a> --}}

            <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const swiper = new Swiper('.swiper-container', {
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        loop: true, // Pour faire défiler en boucle
                        autoplay: {
                            delay: 2000, // Délai en millisecondes avant de passer à la diapositive suivante
                            disableOnInteraction: false, // Ne pas désactiver l'autoplay après une interaction
                        },
                    });
                });
            </script>   
    </body>
</html>
