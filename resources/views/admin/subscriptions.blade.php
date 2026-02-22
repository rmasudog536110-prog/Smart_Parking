@extends('layouts.app')

@section('title', 'Subscription Approvals')

@section('content')
<div class="px-6 py-4 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Subscription Approvals</h2>
            <p class="text-xs text-gray-500 mt-0.5">Manually approve or reject pending subscription payments.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-blue-600 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i> Dashboard
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Pending</p>
                <p class="text-xs text-gray-400">Awaiting approval</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">
                {{ $pendingSubscriptions->where('status', 'pending')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Basic Plans</p>
                <p class="text-xs text-gray-400">Pending</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">
                {{ $pendingSubscriptions->where('plan.name', 'Basic Plan')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Premium Plans</p>
                <p class="text-xs text-gray-400">Pending</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">
                {{ $pendingSubscriptions->where('plan.name', 'Premium Plan')->count() }}
            </p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">Pending Subscriptions</h3>
        </div>

        @if ($pendingSubscriptions->isEmpty())
            <div class="px-5 py-10 text-center">
                <p class="text-3xl mb-2">✅</p>
                <p class="text-sm font-medium text-gray-500">No pending subscriptions.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-[10px]">
                        <tr>
                            <th class="px-5 py-3 text-left">Customer</th>
                            <th class="px-5 py-3 text-left">Plan</th>
                            <th class="px-5 py-3 text-left">Amount</th>
                            <th class="px-5 py-3 text-left">Payment Method</th>
                            <th class="px-5 py-3 text-left">Submitted</th>
                            <th class="px-5 py-3 text-left">Period</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($pendingSubscriptions as $subscription)
                            @php
                                $payment = \App\Models\Payment::whereNull('reservation_id')
                                    ->where('user_id', $subscription->user_id)
                                    ->where('payment_status', 'processing')
                                    ->latest()
                                    ->first();
                            @endphp
                            <tr class="hover:bg-gray-50 transition align-top">
                                <td class="px-5 py-3">
                                    <p class="font-medium text-gray-900">{{ $subscription->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $subscription->user->email }}</p>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold
                                        {{ $subscription->plan->name === 'Premium Plan' ? 'bg-blue-50 text-blue-700' : 'bg-emerald-50 text-emerald-700' }}">
                                        {{ $subscription->plan->name }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 font-semibold text-gray-900">
                                    ₱{{ number_format($subscription->price, 2) }}
                                </td>
                                <td class="px-5 py-3 text-gray-700">
                                    {{ $payment ? ucfirst($payment->payment_method) : '—' }}
                                </td>
                                <td class="px-5 py-3 text-gray-500 text-xs">
                                    {{ $subscription->created_at->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-5 py-3 text-gray-500 text-xs">
                                    <span class="block">{{ $subscription->starts_at?->format('M d, Y') }}</span>
                                    <span class="text-gray-400">to</span>
                                    <span class="block">{{ $subscription->ends_at?->format('M d, Y') }}</span>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <div class="flex flex-col items-end gap-1">
                                        <form method="POST"
                                            action="{{ route('admin.subscriptions.approve', $subscription->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-xs font-semibold text-emerald-600 hover:underline cursor-pointer">
                                                ✓ Approve
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('admin.subscriptions.reject', $subscription->id) }}"
                                            onsubmit="return confirm('Reject this subscription?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-xs font-semibold text-red-500 hover:underline cursor-pointer">
                                                ✕ Reject
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection