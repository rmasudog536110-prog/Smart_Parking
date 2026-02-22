@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-5xl space-y-1">

        @if (session('success'))
            <div id="success-alert"
                class="flex items-start justify-between bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg p-4 text-sm shadow-sm">
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-check mt-0.5"></i>
                        <span>{{ session('success') }}</span>
                    </div>

                    <button onclick="closeAlert()" class="text-black text-lg cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <button onclick="closeAlert()" class="absolute top-2 right-2 text-red-800 cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
        
        {{-- Hero --}}
        <header class="text-center space-y-4 mb-4">
            <p class="inline-flex mx-auto items-center rounded-full bg-orange-400 px-4 py-1 text-xs font-semibold text-white">
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

            <a href="{{ route('landing') }}" 
            class="inline-flex items-center gap-2 text-gray-200 hover:text-red-600 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

                <h2 class="text-3xl text-center font-semibold text-gray-900 mb-1">Log in</h2>
                <p class="text-xs text-center text-gray-500 mb-4">
                    Access your parking reservations and account settings.
                </p>

                <form action="/login" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Email address
                        </label>
                        <input type="email" name="email" required
                               class="w-full h-10 rounded-md px-3 border border-gray-400 text-sm focus:border-orange-500 focus:ring-orange-500"
                               value="{{ old('email') }}"
                               placeholder="sample@gmail.com">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                        <div class="relative">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="passwordInput" required
                                    class="w-full h-10 rounded-md px-3 border border-gray-400 text-sm focus:border-orange-500 focus:ring-orange-500">
                                
                                <button type="button" onclick="togglePassword('passwordInput', 'eyeIcon')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 transition-colors">
                                    <i id="eyeIcon" class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    

                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2 text-gray-600">
                            <input type="checkbox" name="remember"
                                   class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                            Remember me
                        </label>
                        <a href="{{ route('password.request') }}" class="text-red-300 font-medium hover:text-orange-700">
                            Forgot password?
                        </a>
                    </div>
                <div class="text-right">
                    
                    <a href="{{ route('register') }}"
                            class="w-30 rounded-md px-3 py-2 mt-2 text-sm font-semibold text-blue-600 hover:bg-gray-100 cursor-pointer">
                        Create account
                    </a>

                    <button type="submit"
                            class="w-30 rounded-md bg-blue-600 px-3 py-2 mt-2 text-sm font-semibold text-white hover:bg-blue-400 cursor-pointer">
                        Log in
                    </button>

                </div>
                </form>
                </div>
            </div>
    </div>
</div>
@endsection


