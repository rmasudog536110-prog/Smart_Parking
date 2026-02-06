@extends('layouts.app')

@section('title', 'Smart Parking – Welcome')

@section('content')
<div class="max-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-5xl space-y-1">
    
        {{-- Hero --}}
        <header class="text-center space-y-4 mb-4">
            <p class="inline-flex mx-auto items-center rounded-full bg-orange-50 px-4 py-1 text-xs font-semibold text-orange-700">
                Smart Parking System
            </p>

            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900">
                Park smarter, not harder.
            </h1>

            <p class="text-gray-600 max-w-2xl mx-auto text-sm">
                Reserve parking slots, view real-time availability, and manage your account — all in one place.
            </p>
        </header>
            {{-- Login --}}
            <div id="login" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold text-gray-900 mb-1">Log in</h2>
                <p class="text-xs text-gray-500 mb-4">
                    Access your parking reservations and account settings.
                </p>

                <form action="/login" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Email address
                        </label>
                        <input type="email" name="email" required
                               class="w-full h-10 rounded-md px-3 border-gray-300 text-sm focus:border-orange-500 focus:ring-orange-500"
                               placeholder="you@example.com">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Password
                        </label>
                        <input type="password" name="password" required
                               class="w-full h-10 rounded-md px-3 border-gray-300 text-sm focus:border-orange-500 focus:ring-orange-500">
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2 text-gray-600">
                            <input type="checkbox" name="remember"
                                   class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                            Remember me
                        </label>
                        <a href="#" class="text-orange-600 font-medium hover:text-orange-700">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit"
                            class="w-full rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-300">
                        Log in
                    </button>
                </form>
            </div>
    </div>
</div>
@endsection
