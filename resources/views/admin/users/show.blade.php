@extends('layouts.app')

@section('title', 'User Details')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6">

    {{-- USER INFO --}}
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
        <h2 class="text-lg font-semibold mb-4">User Information</h2>

        <div class="space-y-3 text-sm">

            <div>
                <span class="font-medium text-gray-600">Name:</span>
                <div>{{ $user->name }}</div>
            </div>

            <div>
                <span class="font-medium text-gray-600">Email:</span>
                <div>{{ $user->email }}</div>
            </div>

            <div>
                <span class="font-medium text-gray-600">Role:</span>
                <div>{{ ucfirst($user->role) }}</div>
            </div>

            <div>
                <span class="font-medium text-gray-600">Registered:</span>
                <div>{{ $user->created_at->format('M d, Y') }}</div>
            </div>

        </div>
    </div>

    {{-- UPDATE FORM --}}
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
        <h2 class="text-lg font-semibold mb-4">Update User</h2>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>
                        User
                    </option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                </select>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-600">
                    Update User
                </button>
            </div>

        </form>
    </div>

    {{-- RELATED DATA --}}
    <div class="space-y-6">

        {{-- Vehicles --}}
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">
                Vehicles ({{ $user->vehicles->count() }})
            </h2>

            @forelse($user->vehicles as $vehicle)
                <div class="text-sm border-b py-2 last:border-0">
                    <div class="font-medium">{{ $vehicle->plate_number }}</div>
                    <div class="text-gray-500">{{ $vehicle->brand }} - {{ $vehicle->model }}</div>
                </div>
            @empty
                <div class="text-sm text-gray-500">
                    No vehicles found.
                </div>
            @endforelse
        </div>

        {{-- Reservations --}}
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">
                Reservations ({{ $user->reservations->count() }})
            </h2>

            @forelse($user->reservations as $reservation)
                <div class="text-sm border-b py-2 last:border-0">
                    <div class="font-medium">
                        {{ $reservation->parkingSlot->slot_number ?? 'Slot' }}
                    </div>
                    <div class="text-gray-500">
                        {{ $reservation->start_time }} → {{ $reservation->end_time }}
                    </div>
                </div>
            @empty
                <div class="text-sm text-gray-500">
                    No reservations found.
                </div>
            @endforelse
        </div>

    </div>

</div>

@endsection