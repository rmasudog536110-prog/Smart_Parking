@extends('layouts.app')

@section('title', 'Smart Parking')

@section('content')

<div class="max-w-3xl mx-auto px-4 py-10 text-center space-y-6">

    {{-- Hero --}}
    <section class="space-y-3">
        <p class="inline-flex items-center rounded-full bg-orange-50 px-4 py-1 text-md font-semibold text-orange-700">
            🚗 Smart Parking System
        </p>

        <h1 class="text-4xl sm:text-6xl font-bold text-gray-900 leading-tight">
            Park smarter, <span class="text-orange-500">not harder</span>.
        </h1>

        <p class="text-gray-500 text-md max-w-xl mx-auto">
            Find, reserve, and manage parking slots in real time.
            <br> No more guessing, circling, or wasting fuel — everything is in one smart system.
        </p>
    </section>

    <hr class="border-gray-100">

    {{-- Stats --}}
    <section class="grid grid-cols-3 sm:grid-cols-3 gap-4 text-center">
        <div>
            <p class="text-2xl font-bold text-blue-600">24/7</p>
            <p class="text-gray-900 text-xs mt-0.5">Real-time availability</p>
        </div>
        <div>
            <p class="text-2xl font-bold text-blue-600">100%</p>
            <p class="text-gray-900 text-xs mt-0.5">Digital parking system</p>
        </div>
        <div>
            <p class="text-2xl font-bold text-blue-600">Fast</p>
            <p class="text-gray-900 text-xs mt-0.5">Reserve in a minute</p>
        </div>
    </section>

    <hr class="border-gray-100">

    {{-- Features --}}
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-5 text-left">
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:shadow-lg hover:border-blue-500 transition">
            <p class="font-semibold text-gray-900 mb-1 text-sm">📡 Real-time slots</p>
            <p class="text-xs text-gray-500">
                Instantly see which parking slots are available or occupied.
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:shadow-lg hover:border-blue-500 transition">
            <p class="font-semibold text-gray-900 mb-1 text-sm">🅿️ Easy reservations</p>
            <p class="text-xs text-gray-500">
                Book your slot ahead of time and arrive stress-free.
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:shadow-lg hover:border-blue-500 transition">
            <p class="font-semibold text-gray-900 mb-1 text-sm flex items-center gap-1">
            <i class="fa-solid fa-bolt-lightning"></i>
                Lightning-fast entry
            </p>
            <p class="text-xs text-gray-500">
                Skip long queues with automated gate systems and QR code entry.
            </p>
        </div>
    </section>

</div>

@endsection