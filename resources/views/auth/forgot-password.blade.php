@extends('layouts.app')

@section('title', 'Forgot password')

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="text-xl font-semibold text-gray-900 mb-2">
            Forgot your password?
        </h1>
        <p class="text-xs text-gray-600 mb-4">
            Password reset has not been fully implemented yet for this demo.
            Please contact an administrator if you need to reset your account.
        </p>
        <a href="{{ route('landing') }}"
           class="inline-flex items-center px-4 py-2 rounded-md bg-gray-900 text-white text-sm font-semibold shadow-sm hover:bg-black">
            Back to landing page
        </a>
    </div>
@endsection

