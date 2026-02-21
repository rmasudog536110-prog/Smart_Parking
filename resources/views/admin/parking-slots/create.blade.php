@extends('layouts.app')

@section('title', 'Admin – New parking slot')

@section('content')
<div class="flex justify-center mt-10 mb-10">
    <div class="bg-white rounded-lg border border-gray-200 p-8 w-full max-w-2xl shadow-lg">
        <h1 class="text-2xl font-bold text-gray-900 text-center mb-6">Add New Parking Slot</h1>

        <form action="{{ route('admin.parking-slots.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Location -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2" for="location_id">Location</label>
                <select
                    id="location_id"
                    name="location_id"
                    required
                    class="block w-full h-12 px-4 rounded-lg border border-gray-300 text-base shadow-sm focus:border-orange-500 focus:ring-orange-500"
                >
                    <option value="">Select a location</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Slot number & Type -->
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="slot_number">Slot number</label>
                    <input
                        id="slot_number"
                        type="number"
                        name="slot_number"
                        min="1"
                        required
                        value="{{ old('slot_number') }}"
                        class="block w-full h-12 px-4 rounded-lg border border-gray-300 text-base shadow-sm focus:border-orange-500 focus:ring-orange-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="type">Type</label>
                    <select
                        id="type"
                        name="type"
                        required
                        class="block w-full h-12 px-4 rounded-lg border border-gray-300 text-base shadow-sm focus:border-orange-500 focus:ring-orange-500"
                    >
                        @foreach (['compact', 'large', 'handicapped', 'electric'] as $type)
                            <option value="{{ $type }}" @selected(old('type') === $type)>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2" for="status">Status</label>
                <select
                    id="status"
                    name="status"
                    required
                    class="block w-full h-12 px-4 rounded-lg border border-gray-300 text-base shadow-sm focus:border-orange-500 focus:ring-orange-500"
                >
                    @foreach (['available', 'reserved', 'occupied', 'maintenance'] as $status)
                        <option value="{{ $status }}" @selected(old('status') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('admin.parking-slots.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center px-5 py-3 rounded-lg bg-blue-400 text-white text-sm font-semibold shadow hover:bg-blue-600 cursor-pointer">
                    Create slot
                </button>
            </div>
        </form>
    </div>
</div>
@endsection