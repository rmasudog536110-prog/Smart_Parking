@extends('layouts.app')

@section('title', 'Admin Dashboard – Smart Parking')

@section('content')
    <div class="p-6 mt-10 mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">
                Admin Dashboard
            </h1>
            <p class="text-sm text-gray-500">
                Real-time overview of users, parking availability, and reservations.
            </p>
        </div>
        {{-- Optional: Add a "Quick Action" button here --}}
        <a href="{{ route('admin.parking-slots.index') }}" class=" text-blue-500 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-400 hover:text-white hover:underline transition-colors">
            +  Manage Slots
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid gap-6 md:grid-cols-4 mb-8">
        {{-- Total Users --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Total Customers</p>
            <p class="text-3xl text-right font-bold text-gray-900">
                {{ $stats['total_users'] }}
            </p>
            <p class="text-xs text-green-600 mt-2">
                <span class="font-semibold">+{{ $stats['new_users_today'] }}</span> today
            </p>
        </div>

        {{-- Slot Availability --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Available Spots</p>
            <div class="flex items-end justify-end gap-2">
                <p class="text-3xl font-bold text-gray-900">{{ $stats['available_spots'] }}</p>
                <p class="text-sm text-gray-500 mb-1">/ {{ $stats['total_spots'] }}</p>
            </div>
            <div class="w-full bg-gray-100 h-1.5 mt-3 rounded-full overflow-hidden">
                @php 
                    $occupancy = $stats['total_spots'] > 0 ? ($stats['active_parking'] / $stats['total_spots']) * 100 : 0;
                @endphp
                <div class="bg-orange-500 h-full" style="width: {{ $occupancy }}%"></div>
            </div>
        </div>

        {{-- Pending Actions --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pending Requests</p>
            <p class="text-3xl font-bold text-orange-600 text-right">
                {{ $stats['pending_reservations'] }}
            </p>
            <p class="text-xs text-gray-500 mt-2">
                Oldest: <br> <span class="text-gray-900 font-medium">{{ $stats['oldest_pending'] }}</span>
            </p>
        </div>

        {{-- Quick Links Card --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Admin Tools</p>
            <ul class="text-sm space-y-2">
                <li>
                    <a href="{{ route('admin.parking-locations.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-orange-600 transition-colors hover:underline">
                        <i class="fa-solid fa-map-location-dot text-xs"></i> Locations
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reservations.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-orange-600 transition-colors hover:underline">
                        <i class="fa-solid fa-calendar-check text-xs"></i> Reservations
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-orange-600 transition-colors hover:underline">
                        <i class="fa-solid fa-users text-xs"></i> Manage Users
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Detailed Sections --}}
    <div class="grid gap-6 lg:grid-cols-2 mb-0">
        {{-- Recent Users Table --}}
        <div class="h-70 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-900">Recent Customers</h3>
                <a href="{{ route('admin.users.index') }}" class="text-xs text-orange-600 hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-[10px]">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Joined</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentUsers as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $user->created_at->format('M d') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $user->is_active ? 'Active' : 'Banned' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Active/Parked Users --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Revenue Overview</h3>
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm text-gray-500">This Month</span>
                <span class="text-lg font-bold text-gray-900">₱{{ number_format($stats['revenue_this_month'], 2) }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Total Lifetime</span>
                <span class="text-lg font-bold text-orange-600">₱{{ number_format($stats['total_revenue'], 2) }}</span>
            </div>
        </div>
    </div>
    <div class="mt-2 mb-0 flex items-center justify-end gap-4 mb-2">
        <a href="{{ route('admin.charts') }}" class="bg-blue-500 text-white px-4 py-2 text-right rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
            Next Page <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
            
@endsection

