@extends('layouts.app')

@section('title', 'Admin – Parking slots')

@section('content')

    <div class="px-6 mt-5 mb-1 flex items-center justify-between gap-4">
        <a href="{{ route('admin.dashboard') }}"
        class="text-blue-300 hover:text-blue-500 text-sm inline-flex items-center gap-1 hover:underline">
            <i class="fa-solid fa-arrow-left text-sm mr-1"></i> Back to Dashboard
        </a>

        <a href="{{ route('admin.parking-slots.create') }}"
        class="inline-flex gap-1 items-center px-3 py-2 rounded-md text-black text-xs font-semibold hover:text-white shadow-sm hover:bg-blue-600">
            Add new slot <i class="fa-solid fa-plus text-[10px]"></i>
        </a>
    </div>


    <div class="bg-white rounded-lg border border-gray-200 px-6 mb-6    ">
        @if ($slots->isEmpty())
            <p class="text-md text-gray-500">
                No parking slots have been created yet.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-md">
                    <thead>
                    <tr class="text-left text-gray-900 border-b">
                        <th class="py-2 pr-4">Location</th>
                        <th class="py-2 pr-4">Slot #</th>
                        <th class="py-2 pr-4">Type</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2 pr-4 ml-4"></th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
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
                            <td class="py-2 pr-4 text-right space-x-2">
                                <a href="{{ route('admin.parking-slots.edit', $slot) }}"
                                   class="text-[16px] text-blue-600 hover:text-blue-700 hover:underline">
                                    Edit
                                </a>
                                <form action="{{ route('admin.parking-slots.destroy', $slot) }}" method="POST"
                                      onsubmit="return confirm('Delete this slot?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-[16px] text-red-600 hover:text-red-700 font-medium cursor-pointer hover:underline">
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

