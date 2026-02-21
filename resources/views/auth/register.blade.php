@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-5xl space-y-10 mt-0">

        {{-- Hero --}}
        <header class="text-center space-y-4 mb-4 mt-0">
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

        {{-- Sign Up --}}
        <div id="signup" class="rounded-xl border border-orange-300 bg-white p-6 shadow-sm">


            <a href="{{ route('landing') }}" 
            class="inline-flex items-center gap-2 text-gray-200 hover:text-red-600 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            <h2 class="text-3xl text-center font-semibold text-gray-900 mb-1">Sign up</h2>
            <p class="text-xs text-center text-gray-500 mb-4 mt-1">
                Create a driver account to start reserving parking slots.
            </p>

            <form action="/register" method="POST" class="space-y-4">
                @csrf
                
                {{-- Full Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Full name
                    </label>
                    <input type="text" name="name" required
                           class="w-full h-10 rounded-md px-3 border border-gray-400 text-sm focus:border-orange-500 focus:ring-orange-500"
                           placeholder="Juan Dela Cruz">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email address
                    </label>
                    <input type="email" name="email" required
                           class="w-full h-10 rounded-md px-3 border border-gray-400 text-sm focus:border-orange-500 focus:ring-orange-500"
                           placeholder="sample@gmail.com">
                </div>

                {{-- Password --}}
                <div class="relative">
                    <label class="block text-xs font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <div class="relative">
                    <input type="password" name="password" id="password" required
                           class="w-full h-10 rounded-md px-3 border border-gray-400 text-sm focus:border-orange-500 focus:ring-orange-500">
                    <button type="button" onclick="togglePassword('password', 'eyeIcon')" 
                            class="absolute inset-y-0 mt-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 transition-colors">
                        <i id="eyeIcon" class="fa-solid fa-eye"></i>
                    </button>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="relative">
                    <label class="block text-xs font-medium text-gray-700 mb-1">
                        Confirm password
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full h-10 rounded-md px-3 border border-gray-400 text-sm focus:border-orange-500 focus:ring-orange-500">
                    
                    <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon')" 
                            class="absolute inset-y-0 mb-10 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 transition-colors">
                        <i id="eyeIcon" class="fa-solid fa-eye"></i>
                    </button>
                
                    <a href="{{ route('login') }}"
                            class="w-30 rounded-md px-3 py-2 mt-2 text-sm font-semibold text-blue-400 cursor-pointer hover:underline">
                        Already have an account? Log in
                    </a>

                <div class="text-right">
                    <button type="submit"
                            class="w-30 rounded-md px-3 bg-blue-500 py-2 mt-2 text-sm font-semibold text-white hover:bg-blue-600 cursor-pointer">
                        Create account
                    </button>
                </div>



                </div>
            </form>
        </div>
    </div>
</div>

@endsection