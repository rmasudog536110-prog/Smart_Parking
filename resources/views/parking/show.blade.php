@extends('layouts.app')

@section('title', $parkingLocation->name . 'Parking location')

@section('content')
    <div class="mb-4 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">
                {{ $parkingLocation->name }}
            </h1>
            <p class="text-xs text-gray-500">
                {{ $parkingLocation->address }}
            </p>
        </div>
        <div class="text-right text-sm">
            <p class="font-semibold text-gray-900">
                ₱{{ number_format($parkingLocation->hourly_rate, 2) }} <span class="text-xs text-gray-500">/ hour</span>
            </p>
            <p class="text-xs text-gray-500">
                Capacity: {{ $parkingLocation->capacity }} slots
            </p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[3fr,2fr] items-start">
        <section class="space-y-4">
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h2 class="text-sm font-semibold text-gray-900 mb-3">
                    Slots at this location
                </h2>

                @if ($parkingLocation->slots->isEmpty())
                    <p class="text-xs text-gray-500">
                        No individual slots have been configured for this location yet.
                    </p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs">
                            <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="py-2 pr-4">Slot #</th>
                                <th class="py-2 pr-4">Type</th>
                                <th class="py-2 pr-4">Status</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                            @foreach ($parkingLocation->slots as $slot)
                                <tr>
                                    <td class="py-2 pr-4 font-medium text-gray-900">
                                        {{ $slot->slot_number }}
                                    </td>
                                    <td class="py-2 pr-4 text-gray-700">
                                        {{ ucfirst($slot->type) }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        @php
                                            $colors = [
                                                'available' => 'bg-green-50 text-green-700',
                                                'reserved' => 'bg-yellow-50 text-yellow-700',
                                                'occupied' => 'bg-red-50 text-red-700',
                                                'maintenance' => 'bg-gray-100 text-gray-600',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium {{ $colors[$slot->status] ?? 'bg-gray-100 text-gray-600' }}">
                                            {{ ucfirst($slot->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </section>

        <section class="space-y-4">
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h2 class="text-sm font-semibold text-gray-900 mb-2">
                    Location overview
                </h2>
                <div class="text-xs text-gray-500 mb-3">
                    <p>Approximate coordinates:</p>
                    <p class="mt-1 font-mono text-gray-700">
                        Lat: {{ $parkingLocation->latitude }}<br>
                        Lng: {{ $parkingLocation->longitude }}
                    </p>
                </div>

                <div id="map"
                     class="mt-3 rounded-md border border-gray-200 overflow-hidden"
                     style="height: 300px;">
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h2 class="text-sm font-semibold text-gray-900 mb-2">
                    Reservations
                </h2>
                <p class="text-xs text-gray-500">
                    Reservation booking from this page will be added in a later step.
                    For now, you can see slot availability and choose a location.
                </p>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        (function () {
            const lat = {{ (float) $parkingLocation->latitude }};
            const lng = {{ (float) $parkingLocation->longitude }};
            const name = @json($parkingLocation->name);

            const map = L.map('map').setView([lat, lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map).bindPopup(name).openPopup();

            // Fix rendering if the map is inside a flex/grid layout
            setTimeout(() => map.invalidateSize(), 0);
        })();
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

