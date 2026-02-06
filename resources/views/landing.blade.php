@extends('layouts.app')

@section('title', 'Smart Parking')

@section('content')
{{-- Added my-[10px] for exactly 10px top and bottom margin --}}
<div class="max-h-[80vh] flex items-center justify-center px-4 my-[10px]">
    <div class="max-w-5xl w-full text-center space-y-12">

        {{-- Hero --}}
        <section class="space-y-6">
            <p class="inline-flex mx-auto items-center rounded-full bg-orange-50 px-4 py-1 text-xs font-semibold text-orange-700">
                🚗 Smart Parking System
            </p>

            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight">
                Park smarter, <span class="text-orange-500">not harder</span>.
            </h1>

            <p class="text-gray-600 text-base max-w-2xl mx-auto mb-4">
                Find, reserve, and manage parking slots in real time.  
                No more guessing, circling, or wasting fuel — everything is in one smart system.
            </p>
        </section>

        {{-- Trust / Stats --}}
        <section class="grid grid-cols-3 gap-6 text-sm text-center">
            <div class="space-y-1">
                <p class="text-2xl font-bold text-gray-900">24/7</p>
                <p class="text-gray-600">Real-time availability</p>
            </div>

            <div class="space-y-1">
                <p class="text-2xl font-bold text-gray-900">100%</p>
                <p class="text-gray-600">Digital parking system</p>
            </div>

            <div class="space-y-1 mb-4">
                <p class="text-2xl font-bold text-gray-900">Fast</p>
                <p class="text-gray-600">Reserve in a minute</p>
            </div>
        </section>

        {{-- Features --}}
        <section class="grid gap-6 sm:grid-cols-3 text-left">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition">
                <p class="font-semibold text-gray-900 mb-2">📡 Real-time slots</p>
                <p class="text-sm text-gray-600">
                    Instantly see which parking slots are available or occupied.
                </p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition">
                <p class="font-semibold text-gray-900 mb-2">🅿️ Easy reservations</p>
                <p class="text-sm text-gray-600">
                    Book your slot ahead of time and arrive stress-free.
                </p>
            </div>
        </section>

    </div>
</div>
@endsection