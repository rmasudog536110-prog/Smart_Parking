@extends('layouts.app')

@section('title', 'Book a Reservation')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Reserve a Spot</h1>
        <p class="text-sm text-gray-500">at {{ $parkingLocation->name }}</p>
    </div>

    {{-- Error Dialogue for Missing Vehicle --}}
    @if(auth()->user()->vehicles->isEmpty())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-red-800">No Vehicle Found</h3>
                    <p class="text-xs text-red-700">You need to register a vehicle before you can make a reservation.</p>
                </div>
            </div>
            <a href="{{ route('vehicles.index') }}" class="px-4 py-2 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 transition">
                Add Vehicle Now
            </a>
        </div>
    @endif

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="parking_location_id" value="{{ $parkingLocation->id }}">
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4">
                {{-- Slot Selection --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select a Slot</label>
                    <select name="parking_slot_id" required class="w-full h-10 px-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($slots as $slot)
                            <option value="{{ $slot->id }}">Slot #{{ $slot->slot_number }} ({{ ucfirst($slot->type) }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Vehicle Selection --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Your Vehicle</label>
                    @if(auth()->user()->vehicles->isEmpty())
                        <div class="p-3 bg-gray-50 border border-gray-200 rounded-md text-gray-400 text-sm italic">
                            No vehicles available.
                        </div>
                    @else
                        <select name="vehicle_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach(auth()->user()->vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->plate_num }} - {{ $vehicle->model }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                        <input type="datetime-local" name="start_time" required class="w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                        <input type="datetime-local" name="end_time" required class="w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" 
                    @if(auth()->user()->vehicles->isEmpty()) disabled @endif
                    class="w-full py-3 rounded-lg font-bold transition {{ auth()->user()->vehicles->isEmpty() ? 'bg-gray-300 cursor-not-allowed text-gray-500' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                    Confirm Reservation
                </button>
            </div>

            {{-- Sidebar Info --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-dashed border-gray-300">
                <h3 class="font-semibold text-gray-900 mb-2">Pricing Information</h3>
                <p class="text-sm text-gray-600 mb-4">You are booking at {{ $parkingLocation->name }}.</p>
                
                <div class="space-y-2">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Hourly Rate</span>
                        {{-- Logic to ensure it shows at least 20.00 --}}
                        <span class="font-bold">₱{{ number_format(max(20.00, $parkingLocation->hourly_rate), 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center py-2">
                        <span class="text-xs text-gray-500 italic">Minimum charge applied</span>
                        <span class="text-xs font-semibold text-gray-700">₱20.00</span>
                    </div>
                </div>
                
                <div class="mt-4 p-3 bg-blue-50 text-blue-700 rounded-md text-[11px] leading-relaxed">
                    <i class="fa-solid fa-circle-info mr-1"></i> 
                    Your total is calculated based on duration. A minimum fee of <strong>₱20.00</strong> applies to all bookings at this location.
                </div>
            </div>
        </div>
    </form>
</div>
@endsection