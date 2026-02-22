@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="max-w-md mx-auto px-4 py-10">
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-2xl font-semibold text-gray-900 mb-1">Reset Password</h2>
        <p class="text-xs text-gray-500 mb-4">Enter your new password below.</p>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Email address</label>
                <input type="email" name="email" required readonly
                       class="w-full h-10 rounded-md px-3 border border-gray-400 text-sm focus:border-orange-500 focus:ring-orange-500"
                       value="{{ old('email', $email) }}">
                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">New Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="w-full h-10 rounded-md px-3 pr-10 border border-gray-400 text-sm focus:border-orange-500 focus:ring-orange-500">
                    <button type="button" onclick="togglePassword('password', 'eyeIconPassword')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 cursor-pointer">
                        <i id="eyeIconPassword" class="fa-solid fa-eye-slash"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Confirm Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full h-10 rounded-md px-3 pr-10 border border-gray-400 text-sm focus:border-orange-500 focus:ring-orange-500">
                    <button type="button" onclick="togglePassword('password_confirmation', 'eyeIconConfirm')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 cursor-pointer">
                        <i id="eyeIconConfirm" class="fa-solid fa-eye-slash"></i>
                    </button>
                </div>
            </div>
            <button type="submit"
                    class="w-full rounded-md bg-blue-600 py-2 text-sm font-semibold text-white hover:bg-blue-500 cursor-pointer">
                Reset Password
            </button>
            <a href="{{ route('login') }}" class="block text-center text-xs text-gray-500 hover:text-gray-700 hover:underline transition cursor-pointer">
                Back to login
            </a>
        </form>
    </div>
</div>


@endsection