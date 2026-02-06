<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/svg+xml"
          href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='50' fill='%23f97316'/><text x='50%25' y='50%25' text-anchor='middle' fill='white' font-family='sans-serif' font-weight='bold' font-size='60' dy='.3em'>P</text></svg>">

    <title>@yield('title', 'Smart Parking')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col font-sans">

@guest
<header class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="{{ route('landing') }}" class="flex items-center gap-2 font-semibold text-lg">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-orange-500 text-white text-lg">P</span>
            <span>Smart Parking</span>
        </a>

        <nav class="flex items-center gap-4 text-sm">
            <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
            <a href="{{ route('register') }}"
               class="inline-flex items-center px-3 py-1.5 rounded-md bg-orange-500 text-white text-xs font-semibold shadow-sm hover:bg-orange-600">
                Register
            </a>
        </nav>
    </div>
</header>

<main class="flex-1">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @yield('content')
    </div>
</main>

@endguest

@auth
<div class="flex flex-1 overflow-hidden">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
           class="w-64 bg-white border-r shadow-sm flex flex-col shrink-0 transition-all duration-300">

        <div class="h-16 flex items-center gap-2 px-4 border-b">    
            <span class="sidebar-text font-semibold text-lg whitespace-nowrap">
                Smart Parking
            </span>

            <button id="sidebarToggle"
                    class="ml-auto text-gray-500 hover:text-gray-900 focus:outline-none">
                ☰
            </button>
        </div>

                        <nav class="flex-1 px-4 py-6 space-y-4 overflow-y-auto">
                    <div class="space-y-1">
                        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition sidebar-link">Home</a>
                        <a href="{{ route('parking.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition sidebar-link">Parking</a>
                        <a href="{{ route('vehicles.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition sidebar-link">My vehicles</a>
                        <a href="{{ route('reservations.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition sidebar-link">Reservations</a>
                        <a href="{{ route('subscription.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition sidebar-link">Subscription</a>
                    </div>

                    @if (auth()->user()->hasAdminAccess())
                        <div class="pt-4 border-t border-gray-100">
                            <p class="px-3 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Administration</p>
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-orange-600 hover:bg-orange-50 transition sidebar-link">Admin Panel</a>
                        </div>
                    @endif
                </nav>

        <div class="p-4 border-t bg-gray-50 sidebar-text">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full px-3 py-2 text-sm rounded-md text-gray-600 hover:text-red-600 hover:bg-red-50">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="max-w-7xl mx-auto my-auto px-6 py-8 lg:px-10">

            @if (session('success'))
                <div class="mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-10">
                @yield('content')
            </div>
        </div>
    </main>
</div>
@endauth

<footer class="bg-white mt-10 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-xs text-gray-500 flex items-center justify-between">
        <span>&copy; {{ date('Y') }} Smart Parking</span>
        <div class="flex gap-4">
            <span class="hover:text-gray-900 cursor-pointer">Privacy Policy</span>
            <span class="hover:text-gray-900 cursor-pointer">Terms of Service</span>
        </div>
    </div>
</footer>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');

    toggle?.addEventListener('click', () => {
        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-16');

        document.querySelectorAll('.sidebar-text, .sidebar-link')
            .forEach(el => el.classList.toggle('hidden'));
    });
</script>

<style>
    .sidebar-link {
        @apply block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition;
    }
</style>

@stack('scripts')
</body>
</html>
