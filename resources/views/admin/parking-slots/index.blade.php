@extends('layouts.app')

@section('title', 'Admin – Parking slots')

@section('content')
    <div class="mb-4 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">
                Parking slots
            </h1>
            <p class="text-xs text-gray-500">
                Manage individual parking slots for each location.
            </p>
        </div>

        <a href="{{ route('admin.parking-slots.create') }}"
           class="inline-flex items-center px-3 py-2 rounded-md bg-orange-500 text-white text-xs font-semibold shadow-sm hover:bg-orange-600">
            New slot
        </a>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        @if ($slots->isEmpty())
            <p class="text-xs text-gray-500">
                No parking slots have been created yet.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2 pr-4">Location</th>
                        <th class="py-2 pr-4">Slot #</th>
                        <th class="py-2 pr-4">Type</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2 pr-4"></th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @foreach ($slots as $slot)
                        <tr>
                            <td class="py-2 pr-4 text-gray-900">
                                {{ $slot->location?->name ?? '—' }}
                            </td>
                            <td class="py-2 pr-4 text-gray-700">
                                #{{ $slot->slot_number }}
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
                            <td class="py-2 pr-0 text-right space-x-2">
                                <a href="{{ route('admin.parking-slots.edit', $slot) }}"
                                   class="text-[11px] text-orange-600 hover:text-orange-700 font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('admin.parking-slots.destroy', $slot) }}" method="POST"
                                      onsubmit="return confirm('Delete this slot?');"
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
    </div>
@endsection

