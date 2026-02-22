@extends('layouts.app')

@section('title', 'Payment Management')

@section('content')
<div class="px-6 py-4 space-y-6">

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Total Paid</p>
                <p class="text-xs text-gray-400 mt-1">All time</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">
                ₱{{ number_format($reservations->where('payment_status', 'paid')->sum('total_amount'), 2) }}
            </p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Unpaid</p>
                <p class="text-xs text-gray-400 mt-1">Pending collection</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">
                {{ $reservations->where('payment_status', 'unpaid')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Paid</p>
                <p class="text-xs text-gray-400 mt-1">Completed</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">
                {{ $reservations->where('payment_status', 'paid')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Refunded</p>
                <p class="text-xs text-gray-400 mt-1">Returned</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">
                {{ $reservations->where('payment_status', 'refunded')->count() }}
            </p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-900">Reservations & Payments</h3>

            {{-- Filter --}}
            <form method="GET" class="flex items-center gap-2">
                <select name="status" onchange="this.form.submit()"
                    class="text-xs border border-gray-300 rounded-md px-2 py-1.5 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All</option>
                    <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase text-[10px]">
                    <tr>
                        <th class="px-5 py-3 text-left">Reservation</th>
                        <th class="px-5 py-3 text-left">Customer</th>
                        <th class="px-5 py-3 text-left">Slot</th>
                        <th class="px-5 py-3 text-left">Duration</th>
                        <th class="px-5 py-3 text-left">Amount</th>
                        <th class="px-5 py-3 text-left">Payment</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($reservations as $reservation)
                        @php
                            $paymentColor = [
                                'unpaid'   => 'bg-yellow-50 text-yellow-700',
                                'paid'     => 'bg-emerald-50 text-emerald-700',
                                'refunded' => 'bg-red-50 text-red-700',
                            ][$reservation->payment_status] ?? 'bg-gray-100 text-gray-700';

                            $statusColor = [
                                'pending'   => 'bg-yellow-50 text-yellow-700',
                                'active'    => 'bg-blue-50 text-blue-700',
                                'completed' => 'bg-gray-100 text-gray-700',
                                'cancelled' => 'bg-red-50 text-red-700',
                            ][$reservation->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <tr class="hover:bg-gray-50 transition align-top">
                            <td class="px-5 py-3 font-medium text-gray-900">#{{ $reservation->id }}</td>
                            <td class="px-5 py-3 text-gray-700">{{ $reservation->user?->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-700">
                                #{{ $reservation->slot?->slot_number ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-gray-700 text-xs">
                                <span class="block">{{ $reservation->start_time?->format('M d, h:i A') }}</span>
                                <span class="text-gray-400">to</span>
                                <span class="block">{{ $reservation->end_time?->format('M d, h:i A') }}</span>
                            </td>
                            <td class="px-5 py-3 font-semibold text-gray-900">
                                ₱{{ number_format($reservation->total_amount, 2) }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium {{ $paymentColor }}">
                                    {{ ucfirst($reservation->payment_status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium {{ $statusColor }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex flex-col items-end gap-1">
                                    @if ($reservation->payment_status === 'unpaid')
                                        <form method="POST" action="{{ route('staff.payments.markPaid', $reservation->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-xs font-medium text-emerald-600 hover:underline cursor-pointer">
                                                Mark Paid
                                            </button>
                                        </form>
                                    @endif
                                    @if ($reservation->payment_status === 'paid')
                                        <form method="POST" action="{{ route('staff.payments.refund', $reservation->id) }}"
                                            onsubmit="return confirm('Refund this payment?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-xs font-medium text-red-500 hover:underline cursor-pointer">
                                                Refund
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-6 text-center text-sm text-gray-400">
                                No reservations found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 border-t border-gray-100">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection