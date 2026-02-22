@extends('layouts.app')

@section('title', 'My Reservations')

@section('content')
<section class="space-y-6 p-6">
    <div class="grid grid-cols-2 bg-white rounded-lg border border-gray-200 p-6 ml-6">
        @if ($reservations->isEmpty())
            <p class="text-md text-gray-500">You have no reservations yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="py-2 pr-4">Location</th>
                            <th class="py-2 pr-4">Slot</th>
                            <th class="py-2 pr-4">Vehicle</th>
                            <th class="py-2 pr-4">Time</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2 pr-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($reservations as $reservation)
                            @php
                                $slot = $reservation->slot;
                                $location = $slot?->location;
                                $status = $reservation->status;
                                $color = [
                                    'pending'   => 'bg-yellow-50 text-yellow-700',
                                    'active'    => 'bg-green-50 text-green-700',
                                    'completed' => 'bg-gray-100 text-gray-700',
                                    'cancelled' => 'bg-red-50 text-red-700',
                                ][$status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <tr>
                                <td class="py-2 pr-4 text-gray-900">
                                    {{ $location?->name ?? '—' }}
                                </td>
                                <td class="py-2 pr-4 text-gray-700">
                                    @if ($slot)
                                        #{{ $slot->slot_number }} ({{ ucfirst($slot->type) }})
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="py-2 pr-4 text-gray-700">
                                    {{ $reservation->vehicle?->plate_num ?? '—' }}
                                </td>
                                <td class="py-2 pr-4 text-gray-700">
                                    {{ $reservation->start_time?->format('M d, Y h:i A') }}
                                    –
                                    {{ $reservation->end_time?->format('M d, Y h:i A') }}
                                </td>
                                <td class="py-2 pr-4">
                                    <span class="inline-flex items-center rounded-full py-0.5 text-[11px] font-medium {{ $color }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="py-2 pr-5 text-right">
                                    @if (in_array($status, ['pending', 'active']))
                                        <button
                                            onclick="showQr('qr-modal-{{ $reservation->id }}')"
                                            class="text-[11px] ml-0 mr-2text-blue-600 hover:text-blue-700 hover:underline font-medium cursor-pointer">
                                            Show QR
                                        </button>
                                        <form method="POST" action="{{ route('reservations.destroy', $reservation->id) }}" class="mt-3"
                                            onsubmit="return confirm('Are you sure you want to cancel your reservation?')">
                                            @csrf
                                            <div class="text-right">
                                                <button class="w-40 bg-red-600 hover:bg-red-400 text-white text-sm py-2 px-4 rounded cursor-pointer">
                                                    Cancel Reservation
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <div class="text-right">
            <button>
                <a href="{{ route('parking.index') }}"
                    class="inline-flex items-center px-3 py-2 rounded-md bg-blue-600 text-white text-xs font-semibold shadow-sm hover:bg-blue-700">
                    Browse Parking Locations
                </a>
            </button>
        </div>
    </div>
</section>

{{-- Modals rendered outside the table --}}
@foreach ($reservations as $reservation)
    @if (in_array($reservation->status, ['pending', 'active']))
        @php
            $slot = $reservation->slot;
            $location = $slot?->location;
            $status = $reservation->status;
        @endphp
        <div id="qr-modal-{{ $reservation->id }}"
            class="fixed inset-0 z-50 hidden"
            style="display:none">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">

                    <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="text-white font-bold text-base">Reservation #{{ $reservation->id }}</p>
                            <p class="text-blue-100 text-xs mt-0.5">{{ $location?->name ?? '—' }}</p>
                        </div>
                        <button onclick="hideQr('qr-modal-{{ $reservation->id }}')"
                            class="text-white hover:text-blue-200 transition text-xl font-bold">✕</button>
                    </div>

                    <div class="p-6 flex flex-col items-center gap-4">
                        <p class="text-xs text-gray-500 text-center">Show this QR code to the parking staff to check in or out.</p>

                        <div class="p-3 border-2 border-gray-100 rounded-xl bg-white shadow-inner">
                            {!! QrCode::size(200)->generate(
                                json_encode([
                                    'reservation_id' => $reservation->id,
                                    'token' => hash_hmac('sha256', $reservation->id, config('app.key')),
                                ])
                            ) !!}
                        </div>

                        <div class="w-full text-xs text-gray-600 space-y-1.5 border-t pt-4">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Slot</span>
                                <span class="font-medium">
                                    @if ($slot) #{{ $slot->slot_number }} ({{ ucfirst($slot->type) }}) @else — @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Vehicle</span>
                                <span class="font-medium">{{ $reservation->vehicle?->plate_num ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Start</span>
                                <span class="font-medium">{{ $reservation->start_time?->format('M d, Y h:i A') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">End</span>
                                <span class="font-medium">{{ $reservation->end_time?->format('M d, Y h:i A') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Status</span>
                                <span class="font-medium capitalize">{{ $status }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<script>
    function showQr(id) {
        const modal = document.getElementById(id);
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function hideQr(id) {
        const modal = document.getElementById(id);
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="qr-modal-"]').forEach(el => {
                el.style.display = 'none';
            });
            document.body.style.overflow = '';
        }
    });
</script>
@endsection