@extends('layouts.app')

@section('title', 'Admin – User profile')

@section('content')
    <div class="mb-4 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">
                {{ $user->name }}
            </h1>
            <p class="text-xs text-gray-500">
                {{ $user->email }}
            </p>
        </div>
        <div class="text-right text-xs text-gray-700">
            <p>Role: <span class="font-semibold">{{ ucfirst($user->role) }}</span></p>
            <p>Joined: {{ $user->created_at?->format('Y-m-d') }}</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2 items-start">
        <section class="bg-white rounded-lg border border-gray-200 p-4">
            <h2 class="text-sm font-semibold text-gray-900 mb-3">
                Edit basic details
            </h2>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-3">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1" for="name">
                        Name
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        required
                        class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                        value="{{ old('name', $user->name) }}"
                    >
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1" for="email">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        required
                        class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                        value="{{ old('email', $user->email) }}"
                    >
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1" for="role">
                        Role
                    </label>
                    <select
                        id="role"
                        name="role"
                        class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                    >
                        @foreach (['admin', 'driver', 'operator'] as $role)
                            <option value="{{ $role }}" @selected(old('role', $user->role) === $role)>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('admin.users.index') }}"
                       class="text-xs text-gray-500 hover:text-gray-700">
                        Back to list
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-3 py-2 rounded-md bg-gray-900 text-white text-xs font-semibold shadow-sm hover:bg-black">
                        Save changes
                    </button>
                </div>
            </form>
        </section>

        <section class="space-y-4">
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h2 class="text-sm font-semibold text-gray-900 mb-2">
                    Vehicles
                </h2>
                @if ($user->vehicles->isEmpty())
                    <p class="text-xs text-gray-500">
                        No vehicles registered.
                    </p>
                @else
                    <ul class="text-xs text-gray-700 space-y-1">
                        @foreach ($user->vehicles as $vehicle)
                            <li>
                                <span class="font-semibold">{{ $vehicle->plate_num }}</span>
                                – {{ $vehicle->brand }} {{ $vehicle->model }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h2 class="text-sm font-semibold text-gray-900 mb-2">
                    Reservations
                </h2>
                @if ($user->reservations->isEmpty())
                    <p class="text-xs text-gray-500">
                        No reservations yet.
                    </p>
                @else
                    <ul class="text-xs text-gray-700 space-y-1">
                        @foreach ($user->reservations as $reservation)
                            <li>
                                #{{ $reservation->id }} –
                                {{ $reservation->start_time }} – {{ $reservation->end_time }}
                                ({{ ucfirst($reservation->status) }})
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>
    </div>
@endsection

