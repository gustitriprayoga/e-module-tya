<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#2563eb">
    @PwaHead
    <title>{{ $title ?? 'Login - PahlawanHub' }}</title>

    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/img/icon-192x192.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(20px, -30px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }
    </style>
</head>

<body class="h-full antialiased bg-slate-50 flex items-center justify-center p-4">

    @include('sweetalert::alert')

    <div class="fixed inset-0 -z-10">
        <div class="absolute top-1/4 -left-20 w-72 h-72 bg-brand-400/30 rounded-full filter blur-[100px] animate-blob">
        </div>
        <div
            class="absolute bottom-1/4 -right-20 w-72 h-72 bg-accent-400/30 rounded-full filter blur-[100px] animate-blob animation-delay-2000">
        </div>
    </div>

    {{ $slot }}

    @livewireScripts
    @RegisterServiceWorkerScript
</body>

</html>
