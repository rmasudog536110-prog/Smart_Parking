@extends('layouts.app')

@section('title', 'Smart Parking – Welcome')

@section('content')
    <div class="grid gap-10 lg:grid-cols-2 items-start">
        <section class="space-y-6">
            <header class="space-y-3">
                <p class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-[11px] font-semibold text-orange-700">
                    Smart Parking System · IT10
                </p>
                <h1 class="text-3xl sm:text-4xl font-semibold text-gray-900">
                    Park smarter, not longer.
                </h1>
                <p class="text-sm text-gray-600 max-w-xl">
                    Our smart parking system helps drivers quickly find and reserve available slots,
                    while admins manage locations, pricing, and real-time occupancy in one place.
                </p>
                <div class="flex flex-wrap gap-3 pt-1">
                    <a href="#signup"
                       class="inline-flex items-center px-4 py-2 rounded-md bg-orange-500 text-white text-sm font-semibold shadow-sm hover:bg-orange-600">
                        Get started – sign up
                    </a>
                    <a href="#login"
                       class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                        Already have an account? Log in
                    </a>
                </div>
            </header>

            <div class="grid gap-4 sm:grid-cols-3 text-xs">
                <div class="rounded-lg border border-gray-200 bg-white p-3">
                    <p class="font-semibold text-gray-900 mb-1">Real-time slots</p>
                    <p class="text-gray-600">
                        See which parking slots are available or occupied in real-time.
                    </p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-3">
                    <p class="font-semibold text-gray-900 mb-1">Easy reservations</p>
                    <p class="text-gray-600">
                        Reserve a slot in advance and avoid circling the block.
                    </p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-3">
                    <p class="font-semibold text-gray-900 mb-1">Admin dashboard</p>
                    <p class="text-gray-600">
                        Manage locations, users, and payments from one clean dashboard.
                    </p>
                </div>
            </div>
        </section>

        <section class="space-y-5">
            <div id="signup" class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold text-gray-900 mb-1">
                    Sign up
                </h2>
                <p class="text-xs text-gray-500 mb-3">
                    Create a driver account to start reserving parking slots.
                </p>

                <form action="/register" method="POST" class="space-y-3">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-medium text-gray-700 mb-1">
                            Full name
                        </label>
                        <input id="name" name="name" type="text" required
                               class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                               placeholder="Juan Dela Cruz"
                               value="{{ old('name') }}">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-medium text-gray-700 mb-1">
                            Email address
                        </label>
                        <input id="email" name="email" type="email" required
                               class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                               placeholder="you@example.com"
                               value="{{ old('email') }}">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="password" class="block text-xs font-medium text-gray-700 mb-1">
                                Password
                            </label>
                            <input id="password" name="password" type="password" required
                                   class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-medium text-gray-700 mb-1">
                                Confirm password
                            </label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                   class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full inline-flex justify-center items-center px-3 py-2 rounded-md bg-gray-900 text-white text-sm font-semibold shadow-sm hover:bg-black">
                        Create account
                    </button>
                </form>
            </div>

            <div id="login" class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold text-gray-900 mb-1">
                    Log in
                </h2>
                <p class="text-xs text-gray-500 mb-3">
                    Access your parking reservations and account settings.
                </p>

                <form action="/login" method="POST" class="space-y-3">
                    @csrf

                    <div>
                        <label for="login_email" class="block text-xs font-medium text-gray-700 mb-1">
                            Email address
                        </label>
                        <input id="login_email" name="email" type="email" required
                               class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                               placeholder="you@example.com">
                    </div>

                    <div>
                        <label for="login_password" class="block text-xs font-medium text-gray-700 mb-1">
                            Password
                        </label>
                        <input id="login_password" name="password" type="password" required
                               class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    </div>

                    <div class="flex items-center justify-between text-xs text-gray-600">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="remember"
                                   class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="text-orange-600 hover:text-orange-700 font-medium">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit"
                            class="w-full inline-flex justify-center items-center px-3 py-2 rounded-md bg-white border border-gray-300 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50">
                        Log in
                    </button>
                </form>
            </div>
        </section>
    </div>
@endsection

