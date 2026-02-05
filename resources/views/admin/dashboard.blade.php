@extends('layouts.app')

@section('title', 'Admin dashboard')

@section('content')
    <div class="mb-4 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">
                Admin dashboard
            </h1>
            <p class="text-xs text-gray-500">
                Overview of users and reservations in the system.
            </p>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3 mb-6">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Total users</p>
            <p class="text-2xl font-semibold text-gray-900">
                {{ $users }}
            </p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Total reservations</p>
            <p class="text-2xl font-semibold text-gray-900">
                {{ $reservations }}
            </p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Admin tools</p>
            <ul class="mt-1 text-xs text-orange-700 space-y-1">
                <li><a href="{{ route('admin.parking-locations.index') }}" class="hover:underline">Manage parking locations</a></li>
                <li><a href="{{ route('admin.parking-slots.index') }}" class="hover:underline">Manage parking slots</a></li>
                <li><a href="{{ route('admin.reservations.index') }}" class="hover:underline">Review reservations</a></li>
                <li><a href="{{ route('admin.users.index') }}" class="hover:underline">Manage users</a></li>
            </ul>
        </div>
    </div>
@endsection

