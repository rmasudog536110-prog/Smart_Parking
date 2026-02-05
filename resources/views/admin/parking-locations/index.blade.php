@extends('layouts.app')

@section('title', 'Admin – Parking locations')

@section('content')
    <div class="mb-4 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">
                Parking locations
            </h1>
            <p class="text-xs text-gray-500">
                Create and manage parking locations in the system.
            </p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[3fr,2fr] items-start">
        <section class="bg-white rounded-lg border border-gray-200 p-4">
            <h2 class="text-sm font-semibold text-gray-900 mb-3">
                All locations
            </h2>

            @if ($locations->isEmpty())
                <p class="text-xs text-gray-500">
                    No parking locations have been created yet.
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="py-2 pr-4">Name</th>
                            <th class="py-2 pr-4">Address</th>
                            <th class="py-2 pr-4">Capacity</th>
                            <th class="py-2 pr-4">Rate</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2 pr-4"></th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach ($locations as $location)
                            <tr>
                                <td class="py-2 pr-4 text-gray-900 font-medium">
                                    {{ $location->name }}
                                </td>
                                <td class="py-2 pr-4 text-gray-700">
                                    {{ $location->address }}
                                </td>
                                <td class="py-2 pr-4 text-gray-700">
                                    {{ $location->capacity }}
                                </td>
                                <td class="py-2 pr-4 text-gray-700">
                                    ₱{{ number_format($location->hourly_rate, 2) }}/hour
                                </td>
                                <td class="py-2 pr-4">
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium
                                        {{ $location->is_available ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $location->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </td>
                                <td class="py-2 pr-0 text-right">
                                    <form action="{{ route('admin.parking-locations.destroy', $location) }}" method="POST"
                                          onsubmit="return confirm('Delete this location? This cannot be undone.');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-[11px] text-red-600 hover:text-red-700 font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <section class="bg-white rounded-lg border border-gray-200 p-4">
            <h2 class="text-sm font-semibold text-gray-900 mb-3">
                Add a location
            </h2>

            <form action="{{ route('admin.parking-locations.store') }}" method="POST" class="space-y-3">
                @csrf

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
                        value="{{ old('name') }}"
                    >
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1" for="address">
                        Address
                    </label>
                    <input
                        id="address"
                        type="text"
                        name="address"
                        required
                        class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                        value="{{ old('address') }}"
                    >
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1" for="capacity">
                            Capacity
                        </label>
                        <input
                            id="capacity"
                            type="number"
                            name="capacity"
                            min="1"
                            required
                            class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ old('capacity') }}"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1" for="hourly_rate">
                            Hourly rate (₱)
                        </label>
                        <input
                            id="hourly_rate"
                            type="number"
                            name="hourly_rate"
                            step="0.01"
                            min="0"
                            required
                            class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ old('hourly_rate') }}"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1" for="latitude">
                            Latitude
                        </label>
                        <input
                            id="latitude"
                            type="number"
                            name="latitude"
                            step="0.000001"
                            required
                            class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ old('latitude') }}"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1" for="longitude">
                            Longitude
                        </label>
                        <input
                            id="longitude"
                            type="number"
                            name="longitude"
                            step="0.000001"
                            required
                            class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ old('longitude') }}"
                        >
                    </div>
                </div>

                <div class="flex items-center gap-2 text-xs">
                    <input id="is_available" type="checkbox" name="is_available" value="1"
                           class="rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                           {{ old('is_available', true) ? 'checked' : '' }}>
                    <label for="is_available" class="text-gray-700">
                        Location is currently available
                    </label>
                </div>

                <button type="submit"
                        class="w-full inline-flex justify-center items-center px-3 py-2 rounded-md bg-gray-900 text-white text-sm font-semibold shadow-sm hover:bg-black">
                    Save location
                </button>
            </form>
        </section>
    </div>
@endsection

