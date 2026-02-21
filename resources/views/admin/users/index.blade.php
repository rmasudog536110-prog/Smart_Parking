@extends('layouts.app')

@section('title', 'Admin Dashboard – Smart Parking')

@section('content')

<div class="text-right mt-5 mb-1 px-7">        
    <a href="{{ route('admin.parking-slots.index') }}" class="justify-self-end cursor-pointer inline-flex items-center gap-2 hover:bg-blue-600 text-black hover:text-white font-bold py-2 px-4 rounded transition">
        <i class="fa-solid fa-car-side text-sm"></i>
        Manage Slots
    </a>
</div>

<div class="grid gap-6 md:grid-cols-4 mt-1 mb-1 px-6">
    
    {{-- Total Users --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Total Customers</p>
        <p class="text-3xl text-right font-bold text-gray-900">
            {{ $users->count() }}
        </p>
        <p class="text-xs text-gray-500 mt-2">
            Latest user: 
            <span class="font-semibold">
                {{ $users->first()?->created_at?->format('M d, Y') ?? 'N/A' }}
            </span>
        </p>
    </div>

    {{-- Admin Count --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Admins</p>
        <div class="flex items-end justify-end gap-2">
            <p class="text-3xl font-bold text-gray-900">
                {{ $users->where('role', 'admin')->count() }}
            </p>
        </div>
    </div>

    {{-- Regular Users --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Regular Users</p>
        <p class="text-3xl font-bold text-black text-right">
            {{ $users->where('role', 'user')->count() }}
        </p>
    </div>

    {{-- Quick Links Card --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Admin Tools</p>
        <ul class="text-sm space-y-2">
            <li>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-orange-600 transition-colors hover:underline">
                    <i class="fa-solid fa-users text-xs"></i> Manage Users
                </a>
            </li>
        </ul>
    </div>
</div>

{{-- Detailed Sections --}}
<div class="grid gap-6 lg:grid-cols-2 mt-5 px-6">

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
                        <th class="px-4 py-3">Role</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users->take(5) as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">
                            {{ $user->name }}
                        </td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $user->created_at->format('M d') }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-[10px] 
                                {{ $user->role === 'admin' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Users Summary --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
        <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">User Summary</h3>

        <div class="flex items-center justify-between mb-4">
            <span class="text-sm text-gray-500">Total Users</span>
            <span class="text-lg font-bold text-gray-900">
                {{ $users->count() }}
            </span>
        </div>

        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500">Admins</span>
            <span class="text-lg font-bold text-orange-600">
                {{ $users->where('role', 'admin')->count() }}
            </span>
        </div>
    </div>

</div>

<div class="mt-2 mb-0 flex items-center justify-end gap-4 mb-2 px-6">
    <a href="{{ route('admin.users.index') }}" class="bg-blue-500 text-white px-4 py-2 text-right rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
        Manage Users <i class="fa-solid fa-arrow-right"></i>
    </a>
</div>

@endsection