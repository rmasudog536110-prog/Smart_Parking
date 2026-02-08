@extends('layouts.app')

@section('title', 'Smart Parking')

@section('content')

<div class="max-h-[100vh] flex items-center justify-center px-4">
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

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition">
                <p class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-yellow-500">
                        <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.972 9.5h4.778a.75.75 0 0 1 .58 1.222l-11.32 13.5a.75.75 0 0 1-1.285-.794l3.18-8.428H4.125a.75.75 0 0 1-.58-1.222l11.32-13.5a.75.75 0 0 1 .75-.241Z" clip-rule="evenodd" />
                    </svg>
                    Lightning-fast entry
                </p>
                <p class="text-sm text-gray-600">
                    Skip the long queues with our automated gate systems and qr code entry.
                </p>
            </div>
        </section>

    </div>
</div>
@endsection