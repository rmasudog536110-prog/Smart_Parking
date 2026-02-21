@extends('layouts.app')

@section('title', 'Admin – Parking locations')

@section('content')
<div class="grid gap-6 lg:grid-cols-[3fr,2fr] items-start p-6">

    <!-- All Locations -->
    <section class="bg-white rounded-lg border border-gray-200 p-4 shadow-lg">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">
            All Locations
        </h2>

        @if ($locations->isEmpty())
            <p class="text-sm text-gray-500">
                No parking locations have been created yet.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-600 border-b">
                            <th class="py-3 pr-6">Name</th>
                            <th class="py-3 pr-6">Address</th>
                            <th class="py-3 pr-6">Capacity</th>
                            <th class="py-3 pr-6">Rate</th>
                            <th class="py-3 pr-6">Status</th>
                            <th class="py-3 pr-0"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($locations as $location)
                            <tr>
                                <td class="py-3 pr-6 text-gray-900 font-medium">
                                    {{ $location->name }}
                                </td>
                                <td class="py-3 pr-6 text-gray-700">
                                    {{ $location->address }}
                                </td>
                                <td class="py-3 pr-6 text-gray-700">
                                    {{ $location->capacity }}
                                </td>
                                <td class="py-3 pr-6 text-gray-700">
                                    ₱{{ number_format($location->hourly_rate, 2) }}/hour
                                </td>
                                <td class="py-3 pr-6">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium
                                        {{ $location->is_available ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $location->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </td>
                                <td class="py-3 pr-0 text-right">
                                    <form action="{{ route('admin.parking-locations.destroy', $location) }}" method="POST"
                                          onsubmit="return confirm('Delete this location? This cannot be undone.');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-sm text-white bg-red-500 hover:bg-red-600 font-medium px-3 py-1 rounded cursor-pointer">
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

    <!-- Add a Location -->
    <section class="bg-white rounded-lg border border-gray-200 p-6 shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            Add a Location
        </h2>

        <form action="{{ route('admin.parking-locations.store') }}" method="POST" class="space-y-2">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700" for="name">
                    Name
                </label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    required
                    class="block w-full h-10 px-4 rounded-lg border border-gray-300 text-base shadow-sm focus:border-orange-500 focus:ring-orange-500"
                    value="{{ old('name') }}"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mt-5" for="address">
                    Address
                </label>
                <input
                    id="address"
                    type="text"
                    name="address"
                    required
                    class="block w-full h-10 px-4 rounded-lg border border-gray-300 text-base shadow-sm focus:border-orange-500 focus:ring-orange-500"
                    value="{{ old('address') }}"
                >
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mt-2" for="capacity">
                        Capacity
                    </label>
                    <input
                        id="capacity"
                        type="number"
                        name="capacity"
                        min="1"
                        required
                        class="block w-full h-10 px-4 rounded-lg border border-gray-300 text-base shadow-sm focus:border-orange-500 focus:ring-orange-500"
                        value="{{ old('capacity') }}"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mt-2" for="hourly_rate">
                        Hourly rate (₱)
                    </label>
                    <input
                        id="hourly_rate"
                        type="number"
                        name="hourly_rate"
                        step="0.01"
                        min="0"
                        required
                        class="block w-full h-10 px-4 rounded-lg border border-gray-300 text-base shadow-sm focus:border-orange-500 focus:ring-orange-500"
                        value="{{ old('hourly_rate') }}"
                    >
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mt-2" for="latitude">
                        Latitude
                    </label>
                    <input
                        id="latitude"
                        type="number"
                        name="latitude"
                        step="0.000001"
                        required
                        class="block w-full h-10 px-4 rounded-lg border border-gray-300 text-base shadow-sm focus:border-orange-500 focus:ring-orange-500"
                        value="{{ old('latitude') }}"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mt-2" for="longitude">
                        Longitude
                    </label>
                    <input
                        id="longitude"
                        type="number"
                        name="longitude"
                        step="0.000001"
                        required
                        class="block w-full h-10 px-4 rounded-lg border border-gray-300 text-base shadow-sm focus:border-orange-500 focus:ring-orange-500"
                        value="{{ old('longitude') }}"
                    >
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input id="is_available" type="checkbox" name="is_available" value="1"
                       class="h-5 w-5 rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                       {{ old('is_available', true) ? 'checked' : '' }}>
                <label for="is_available" class="text-gray-700 text-sm">
                    Location is currently available
                </label>
            </div>

            <div class="text-right">        
                 <button type="submit"
                        class="w-50 inline-flex justify-center items-center h-10 px-3 rounded-lg bg-blue-400 text-white text-base font-semibold shadow hover:bg-blue-600 cursor-pointer">
                    Save Location
                </button>
            </div>
   
        </form>
    </section>

</div>
@endsection