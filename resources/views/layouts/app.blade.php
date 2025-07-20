<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Instacart Clone</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex items-center lg:justify-center flex-col">

    <header class="header container">
        @include('components.navbar')
    </header>
    <main class="container">
        {{-- Display Flashed Messages using the Component --}}
        @if (session('success'))
        <x-alert-message type="success" :message="session('success')" />
        @endif

        @if (session('error'))
        <x-alert-message type="danger" :message="session('error')" />
        @endif

        @if (session('warning'))
        <x-alert-message type="warning" :message="session('warning')" />
        @endif

        @if (session('info'))
        <x-alert-message type="info" :message="session('info')" />
        @endif

        @yield('content')
    </main>

    @livewireScripts
</body>

</html>
