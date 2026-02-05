@extends('layouts.app')

@section('title', 'My reservations')

@section('content')
    <div class="mb-4 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">
                My reservations
            </h1>
            <p class="text-xs text-gray-500">
                Track your current and past parking reservations.
            </p>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        @if ($reservations->isEmpty())
            <p class="text-xs text-gray-500">
                You have no reservations yet.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2 pr-4">Location</th>
                        <th class="py-2 pr-4">Slot</th>
                        <th class="py-2 pr-4">Vehicle</th>
                        <th class="py-2 pr-4">Time</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2 pr-4"></th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @foreach ($reservations as $reservation)
                        @php
                            $slot = $reservation->slot;
                            $location = $slot?->location;
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
                                {{ optional($reservation->vehicle)->plate_num ?? '—' }}
                            </td>
                            <td class="py-2 pr-4 text-gray-700">
                                {{ $reservation->start_time }} – {{ $reservation->end_time }}
                            </td>
                            <td class="py-2 pr-4">
                                @php
                                    $status = $reservation->status;
                                    $color = [
                                        'pending' => 'bg-yellow-50 text-yellow-700',
                                        'active' => 'bg-green-50 text-green-700',
                                        'completed' => 'bg-gray-100 text-gray-700',
                                        'canceled' => 'bg-red-50 text-red-700',
                                    ][$status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium {{ $color }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="py-2 pr-0 text-right">
                                <a href="{{ route('reservations.show', $reservation) }}"
                                   class="text-[11px] text-orange-600 hover:text-orange-700 font-medium">
                                    Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

