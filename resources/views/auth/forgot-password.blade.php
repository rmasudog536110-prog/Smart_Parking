@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="max-w-md mx-auto px-4 py-10">
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-2xl font-semibold text-gray-900 mb-1">Forgot Password</h2>
        <p class="text-xs text-gray-500 mb-4">Enter your email and we'll send you a reset link.</p>

        @if (session('success'))
            <p class="text-xs text-green-600 mb-4">{{ session('success') }}</p>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Email address</label>
                <input type="email" name="email" required
                       class="w-full h-10 rounded-md px-3 border border-gray-400 text-sm focus:border-orange-500 focus:ring-orange-500"
                       value="{{ old('email') }}"
                       placeholder="sample@gmail.com">
                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full rounded-md bg-blue-600 py-2 text-sm font-semibold text-white hover:bg-blue-500 cursor-pointer">
                Send Reset Link
            </button>

            <a href="{{ route('login') }}" class="block text-center text-xs text-gray-500 hover:text-gray-700">
                Back to login
            </a>
        </form>
    </div>
</div>
@endsection