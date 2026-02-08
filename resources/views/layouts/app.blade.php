<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
    @if (!Route::is('login') && !Route::is('register') && !Route::is('password.request'))
        <header class="sticky top-0 z-50 bg-white shadow-sm p-2">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="{{ route('landing') }}" class="flex items-center gap-2 font-semibold text-lg">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-orange-500 text-white text-lg">P</span>
                    <span>Smart Parking</span>
                </a>

                <nav class="flex items-center gap-1 text-sm">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-1.5 rounded-md text-sm text-white bg-blue-600 hover:underline hover:bg-blue-400">Login</a>
                    <a href="{{ route('register') }}"
                    class="inline-flex items-center px-3 py-2 rounded-md text-blue-500 text-sm font-semibold hover:bg-gray-200 hover:underline">
                        Register
                    </a>
                </nav>
            </div>
            
        </header>
    @endif

<main class="flex-1">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @yield('content')
    </div>
</main>

@endguest

@auth
<div class="flex flex-1 overflow-hidden">

    {{-- SIDEBAR --}}
        <aside id="sidebar" class="w-64 min-h-screen bg-white border-r border-dotted shadow-sm flex flex-col shrink-0 transition-all duration-300 overflow-x-hidden">

        <div class="h-16 flex items-center gap-2 px-4 border-b border-gray-200 shrink-0">     
            <span class="sidebar-text font-semibold text-lg whitespace-nowrap transition-opacity duration-300">
                Smart Parking
            </span>

            <button id="sidebarToggle"
                    class="ml-auto text-gray-500 hover:text-gray-900 focus:outline-none p-1">
                ☰
            </button>
        </div>

        <nav class="flex-1 px-2 py-4 space-y-6 overflow-y-auto">
            <div class="space-y-1">
                <a href="{{ route('home') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition sidebar-link">
                    <span class="sidebar-text truncate">Home</span>
                </a>
                <a href="{{ route('parking.index') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition sidebar-link">
                    <span class="sidebar-text truncate">Parking</span>
                </a>
                <a href="{{ route('vehicles.index') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition sidebar-link">
                    <span class="sidebar-text truncate">My vehicles</span>
                </a>
                <a href="{{ route('reservations.index') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition sidebar-link">
                    <span class="sidebar-text truncate">Reservations</span>
                </a>
                <a href="{{ route('subscription.index') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition sidebar-link">
                    <span class="sidebar-text truncate">Subscription</span>
                </a>
            </div>

            @if (auth()->user()->hasAdminAccess())
                <div class="space-y-1 pt-4 border-t border-gray-50">
                    <p class="px-3 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider truncate sidebar-text">
                        Administration
                    </p>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-orange-600 hover:bg-orange-50 transition sidebar-link">
                        <span class="sidebar-text truncate">Admin Panel</span>
                    </a>
                </div>
            @endif
        </nav>

        <div class="border-t border-gray-100 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center px-4 py-4 text-sm font-medium text-gray-600 transition-all duration-200 hover:text-red-700 hover:bg-red-50 active:scale-95 cursor-pointer overflow-hidden">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="sidebar-text ml-3 truncate transition-opacity duration-300">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="max-w-7xl mx-auto my-auto px-6 py-1 lg:px-10">

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

@if (!Route::is('login') && !Route::is('register')  && !Route::is('password.request'))
    <footer class="bg-gray-40 mt-10 shadow-sm p-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-m text-gray-500 flex items-center justify-between">
            <span>&copy; {{ date('Y') }} Smart Parking</span>
            <div class="flex gap-4">
                <a href="{{ route('privacy') }}" class="hover:text-gray-900 cursor-pointer">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="hover:text-gray-900 cursor-pointer">Terms of Service</a>
            </div>
        </div>
    </footer>
@endif


<script>
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');

    toggle?.addEventListener('click', () => {
        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-16');

        document.querySelectorAll('.sidebar-text, .sidebar-link')
            .forEach(el => el.classList.toggle('hidden'));
    });

    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>

<style>
    .sidebar-link {
        @apply block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition;
    }
</style>

@stack('scripts')
</body>
</html>
