@extends('layouts.app')

@section('title', 'Admin Dashboard – Smart Parking')

@section('content')
<div class="px-6 py-4 space-y-6">

    {{-- Actions --}}
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-bold text-gray-900">Overview</h2>
        <a href="{{ route('admin.parking-slots.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold px-4 py-2 rounded-lg border border-gray-200 bg-white hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all">
            <i class="fa-solid fa-car-side text-sm"></i> Manage Slots
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Customers</p>
                <p class="text-xs text-gray-400 mt-1">
                    Latest: {{ $users->first()?->created_at?->format('M d, Y') ?? 'N/A' }}
                </p>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $users->count() }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Regular</p>
                <p class="text-xs text-gray-400 mt-1">Users</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $users->where('role', 'user')->count() }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Staff</p>
                <p class="text-xs text-gray-400 mt-1">Operators</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $users->where('role', 'staff')->count() }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Admins</p>
                <p class="text-xs text-gray-400 mt-1">Managers</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $users->where('role', 'admin')->count() }}</p>
        </div>
    </div>

    {{-- Tables --}}
    <div class="grid gap-6 lg:grid-cols-2">

        {{-- Recent Users --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-900">Recent Customers</h3>
                <a href="{{ route('admin.users.index') }}" class="text-xs text-blue-600 hover:underline">View All</a>
            </div>
            <div class="overflow-y-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-[10px]">
                        <tr>
                            <th class="px-5 py-3 text-left">Name</th>
                            <th class="px-5 py-3 text-left">Joined</th>
                            <th class="px-5 py-3 text-left">Role</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users->take(5) as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold
                                    {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-700' :
                                       ($user->role === 'staff' ? 'bg-emerald-100 text-emerald-700' :
                                       'bg-gray-100 text-gray-700') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Summary --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-900">User Summary</h3>
            </div>
            <div class="p-5 space-y-3">
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Regular Users</span>
                    <span class="text-lg font-bold text-blue-600">{{ $users->where('role', 'user')->count() }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Staff</span>
                    <span class="text-lg font-bold text-emerald-600">{{ $users->where('role', 'staff')->count() }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Admins</span>
                    <span class="text-lg font-bold text-gray-900">{{ $users->where('role', 'admin')->count() }}</span>
                </div>
                <div class="flex items-center justify-between pt-3">
                    <span class="text-sm font-semibold text-gray-700">Total Users</span>
                    <span class="text-2xl font-bold text-gray-900">{{ $users->count() }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Analytics Link --}}
    <div class="flex justify-end">
        <a href="{{ route('admin.charts') }}"
            class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
            Analytics <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

</div>
@endsection