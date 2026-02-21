@extends('layouts.app')

@section('title', $parkingLocation->name)

@section('content')
    <div class="grid gap-3 lg:grid-cols-[3fr,2fr] items-start p-6">
        <div>
            <p class="text-xs text-gray-500">
                {{ $parkingLocation->address }}
            </p>
        </div>
        <section class="space-y-2">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <details class="group">
                    <summary class="flex items-center justify-between p-4 cursor-pointer list-none hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-square-p text-blue-500"></i>
                            <h2 class="text-sm font-semibold text-gray-900">Slots at this location</h2>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full font-bold">
                                {{ $parkingLocation->slots->count() }} Total
                            </span>
                        </div>
                        <span class="transition-transform duration-300 group-open:rotate-180 text-gray-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </span>
                    </summary>

                    <div class="px-4 pb-4 border-t border-gray-50">
                        @if ($parkingLocation->slots->isEmpty())
                            <div class="py-4 text-center">
                                <p class="text-xs text-gray-500 italic">
                                    No individual slots have been configured for this location yet.
                                </p>
                            </div>
                        @else
                            <div class="overflow-x-auto mt-2">
                                <table class="min-w-full text-xs">
                                    <thead>
                                        <tr class="text-left text-gray-400 border-b border-gray-100 uppercase tracking-wider text-[10px]">
                                            <th class="py-3 pr-4 font-bold">Slot #</th>
                                            <th class="py-3 pr-4 font-bold">Type</th>
                                            <th class="py-3 pr-4 font-bold">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach ($parkingLocation->slots as $slot)
                                            @php
                                                $colors = [
                                                    'available'   => 'bg-green-50 text-green-700 ring-1 ring-green-600/20',
                                                    'reserved'    => 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-600/20',
                                                    'occupied'    => 'bg-red-50 text-red-700 ring-1 ring-red-600/20',
                                                    'maintenance' => 'bg-gray-100 text-gray-600 ring-1 ring-gray-600/20',
                                                ];
                                                $colorClass = $colors[$slot->status] ?? 'bg-gray-100 text-gray-600';
                                                $dotClass = explode(' ', $colorClass)[1];
                                            @endphp
                                            <tr class="hover:bg-gray-50/50 transition-colors">
                                                <td class="py-3 pr-4 font-bold text-gray-900">
                                                    {{ str_pad($slot->slot_number, 2, '0', STR_PAD_LEFT) }}
                                                </td>
                                                <td class="py-3 pr-4 text-gray-600">
                                                    {{ ucfirst($slot->type) }}
                                                </td>
                                                <td class="py-3 pr-4">
                                                    <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-bold uppercase tracking-tight {{ $colorClass }}">
                                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ str_replace('text', 'bg', $dotClass) }}"></span>
                                                        {{ $slot->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </details>
            </div>
        </section>

        <section class="space-y-3">
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900">Location Overview</h2>
                        <div class="text-[10px] text-gray-500 mt-1">
                            <p>Coordinates:</p>
                            <p class="font-mono text-gray-700">
                                {{ number_format($parkingLocation->latitude, 4) }}, {{ number_format($parkingLocation->longitude, 4) }}
                            </p>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="text-lg font-bold text-gray-900">
                            ₱{{ number_format($parkingLocation->hourly_rate, 2) }}
                            <span class="text-[10px] font-normal text-gray-500 uppercase">/ hr</span>
                        </p>
                        <p class="text-[11px] text-gray-500">
                            Capacity: <span class="font-semibold text-gray-700">{{ $parkingLocation->capacity }} slots</span>
                        </p>
                    </div>
                </div>

                <div id="map"
                     class="mt-3 rounded-md border border-gray-200 overflow-hidden"
                     style="height: 400px;">
                </div>
            </div>

            <div class="mt-2 flex items-center justify-end gap-4 mb-2">
                @if (auth()->user()->subscription?->status === 'active' && auth()->user()->subscription?->ends_at->isFuture())
                    <a href="{{ route('reservations.create', $parkingLocation) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                        Reserve a spot <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('subscription.index') }}"
                    class="bg-gray-400 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-500 transition-colors">
                        Subscribe to Reserve <i class="fa-solid fa-lock"></i>
                    </a>
                @endif
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

            setTimeout(() => map.invalidateSize(), 0);
        })();
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush