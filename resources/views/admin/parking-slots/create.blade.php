@extends('layouts.app')

@section('title', 'Admin – New parking slot')

@section('content')
    <div class="mb-4">
        <h1 class="text-xl font-semibold text-gray-900">
            New parking slot
        </h1>
        <p class="text-xs text-gray-500">
            Create a new slot for a specific parking location.
        </p>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4 max-w-xl">
        <form action="{{ route('admin.parking-slots.store') }}" method="POST" class="space-y-3">
            @csrf

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1" for="location_id">
                    Location
                </label>
                <select
                    id="location_id"
                    name="location_id"
                    required
                    class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                >
                    <option value="">Select a location</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1" for="slot_number">
                        Slot number
                    </label>
                    <input
                        id="slot_number"
                        type="number"
                        name="slot_number"
                        min="1"
                        required
                        class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                        value="{{ old('slot_number') }}"
                    >
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1" for="type">
                        Type
                    </label>
                    <select
                        id="type"
                        name="type"
                        required
                        class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                    >
                        @foreach (['compact', 'large', 'handicapped', 'electric'] as $type)
                            <option value="{{ $type }}" @selected(old('type') === $type)>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1" for="status">
                    Status
                </label>
                <select
                    id="status"
                    name="status"
                    required
                    class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                >
                    @foreach (['available', 'reserved', 'occupied', 'maintenance'] as $status)
                        <option value="{{ $status }}" @selected(old('status') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <a href="{{ route('admin.parking-slots.index') }}"
                   class="text-xs text-gray-500 hover:text-gray-700">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center px-3 py-2 rounded-md bg-gray-900 text-white text-xs font-semibold shadow-sm hover:bg-black">
                    Create slot
                </button>
            </div>
        </form>
    </div>
@endsection

