<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Smart Parking'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @stack('styles')
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col font-sans">
    <header class="bg-white border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold text-lg">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-orange-500 text-white font-bold">
                    P
                </span>
                <span>{{ config('app.name', 'Smart Parking') }}</span>
            </a>

            <nav class="flex items-center gap-4 text-sm">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900">
                    Home
                </a>
                <a href="{{ route('parking.index') }}" class="text-gray-700 hover:text-gray-900">
                    Parking
                </a>

                @auth
                    <a href="{{ route('vehicles.index') }}" class="text-gray-700 hover:text-gray-900">
                        My vehicles
                    </a>
                    <a href="{{ route('reservations.index') }}" class="text-gray-700 hover:text-gray-900">
                        Reservations
                    </a>
                    <a href="{{ route('subscription.index') }}" class="text-gray-700 hover:text-gray-900">
                        Subscription
                    </a>

                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-orange-600 font-medium hover:text-orange-700">
                            Admin
                        </a>
                    @endif

                    @if (Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700">
                                Logout
                            </button>
                        </form>
                    @endif
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">
                            Login
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-orange-500 text-white text-xs font-semibold shadow-sm hover:bg-orange-600">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if (session('success'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-xs text-gray-500 flex items-center justify-between">
            <span>&copy; {{ date('Y') }} {{ config('app.name', 'Smart Parking') }}</span>
            <span>IT10 Smart Parking</span>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

