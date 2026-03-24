<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ReadWithMe') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            @keyframes slide-up {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .animate-fade-in {
                animation: fade-in 0.6s ease-out;
            }
            
            .animate-slide-up {
                animation: slide-up 0.8s ease-out;
            }
            
            .bg-animated {
                background: linear-gradient(-45deg, #e0e7ff, #ffffff, #faf5ff, #fce7f3);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
            }
            
            @keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
                100% {
                    background-position: 0% 50%;
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-animated">
            <div class="w-full sm:max-w-md lg:max-w-2xl mt-8 px-8 py-8 bg-white/80 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-100 animate-slide-up hover:shadow-3xl transition-shadow duration-300">
                {{ $slot }}
            </div>

            <footer class="mt-8 text-center text-sm text-gray-500 animate-fade-in">
                <p>&copy; {{ date('Y') }} Read With Me. All rights reserved.</p>
                <p class="mt-1 text-xs">Empowering students through interactive learning</p>
            </footer>
        </div>
    </body>
</html>
