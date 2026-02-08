@extends('layouts.app')

@section('title', 'Parking locations')

@section('content')

    <section class="space-y-6 p-6 mb-0">
        <div class=" bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4 py-2 border-b">
                <div class="space-y-1">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        Parking locations
                    </h1>
                    <p class="text-xs text-gray-500">
                        Browse all available parking areas in the system.
                    </p>
                </div>
            </div>

            <div>
                <form method="GET" class="flex flex-wrap gap-3 items-center">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Search by name or address"
                        class="w-full h-10 p-2 md:w-72 rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                    >
                    <button type="submit"
                            class="inline-flex items-center px-3 py-2 rounded-md bg-gray-900 text-white text-xs font-semibold shadow-sm hover:bg-black">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </section>  

    <section class="space-y-6 p-6">
        @if ($locations->isEmpty())
            <div class="bg-white rounded-lg border border-dashed border-gray-300 text-sm text-gray-500">
                No parking locations found.
            </div>
        @else
            <div class="grid gap-1 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($locations as $location)
                    <a href="{{ route('parking.show', $location) }}"
                    class="group bg-white rounded-lg border border-gray-200 p-4 shadow-sm transition hover:border-blue-400 hover:bg-blue-50 hover:shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h2 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600">
                                    {{ $location->name }}
                                </h2>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $location->address }}
                                </p>
                            </div>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium
                                {{ $location->is_available ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $location->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>

                        <div class="mt-3 flex items-center justify-between text-xs text-gray-500">
                            <span>
                                Capacity: {{ $location->capacity }} slots
                            </span>
                            <span class="font-semibold text-gray-900 group-hover:text-blue-600">
                                ₱{{ number_format($location->hourly_rate, 2) }}/hour
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection

