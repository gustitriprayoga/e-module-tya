<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @PwaHead
    <title>{{ $title ?? 'Dashboard - PahlawanHub' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="h-full font-sans antialiased text-slate-800 overflow-hidden" x-data="{ sidebarOpen: false }">
    @include('sweetalert::alert')

    <div class="flex h-full">
        @include('layouts.partials.dashboard-sidebar')

        <div class="flex-1 flex flex-col h-full overflow-hidden relative">

            <div
                class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-200/30 rounded-full filter blur-[120px] -z-10 pointer-events-none">
            </div>

            @include('layouts.partials.dashboard-header')

            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 relative z-0 hide-scrollbar">
                {{ $slot }}
            </main>

            @include('layouts.partials.dashboard-footer')
        </div>
    </div>

    @livewireScripts
    @RegisterServiceWorkerScript
    @include('sweetalert::alert')
</body>

</html>
