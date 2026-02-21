@extends('layouts.app')

@section('title', 'Payment')

@section('content')
<section class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-2xl mx-auto space-y-4">

        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Complete Your Payment</h1>
            <p class="text-sm text-gray-500 mt-1">Secure checkout for your subscription plan.</p>
        </div>

        <div class="text-left">
            <a href="{{ route('subscription.index') }}" class="text-sm text-gray-600 hover:bg-red-500 hover:text-white hover:p-2 rounded transition">
                <i class="fa-solid fa-arrow-left"></i> Back to Plans
            </a>
        </div>

        {{-- Order Summary --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-700 mb-4 uppercase tracking-wide">Order Summary</h2>

            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                <div>
                    <p class="font-semibold text-gray-900">{{ $plan->name }}</p>
                    <p class="text-xs text-gray-400">
                        {{ $plan->duration }} day{{ $plan->duration > 1 ? 's' : '' }} access
                        @if(!empty($plan->trial))
                            &mdash; {{ $plan->trial }}
                        @endif
                    </p>
                </div>
            </div>

            {{-- Features --}}
            <ul class="mt-4 space-y-2">
                @foreach($plan->features as $feature)
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <span class="text-green-500 font-bold">✔</span>
                        {{ $feature }}
                    </li>
                @endforeach
            </ul>

            <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-500">Total Due</p>
                <p class="text-2xl font-extrabold text-gray-900">₱{{ number_format($plan->price, 2) }}</p>
            </div>
        </div>

        {{-- Payment Form --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-700 mb-6 uppercase tracking-wide">Payment Details</h2>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('payment.store') }}">
                @csrf

                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                <input type="hidden" name="amount" value="{{ $plan->price }}">
                <input type="hidden" name="status" value="pending">

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method</label>

                    <div class="grid grid-cols-3 gap-3" id="payment-methods">

                        @php
                            $methods = [
                                ['value' => 'gcash',    'label' => 'GCash',     'icon' => '📱'],
                                ['value' => 'maya',     'label' => 'Maya',      'icon' => '💳'],
                                ['value' => 'bank',     'label' => 'Bank',      'icon' => '💵'],
                            ];
                        @endphp

                        @foreach($methods as $method)
                            <label class="payment-option relative flex flex-col items-center justify-center gap-1 border-2 border-gray-200 rounded-xl p-4 cursor-pointer transition-all hover:border-blue-400 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-300">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="{{ $method['value'] }}"
                                    class="sr-only peer"
                                    {{ old('payment_method') === $method['value'] ? 'checked' : '' }}
                                    required
                                >
                                <span class="text-2xl">{{ $method['icon'] }}</span>
                                <span class="text-sm font-medium text-gray-700">{{ $method['label'] }}</span>
                            </label>
                        @endforeach

                    </div>
                    @error('payment_method')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6" id="reference-field">
                    <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-1">
                        Reference Number <span class="text-gray-400 font-normal">(for GCash / Maya)</span>
                    </label>
                    <input
                        type="text"
                        id="reference_number"
                        name="reference_number"
                        value="{{ old('reference_number') }}"
                        placeholder="e.g. 1234567890"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 transition-all text-white font-bold py-3 px-6 rounded-xl text-base shadow-md cursor-pointer">
                    Confirm & Pay ₱{{ number_format($plan->price, 2) }}
                </button>

                <p class="text-xs text-center text-gray-400 mt-3">
                    🔒 Your payment is now being processed. You will receive a confirmation email shortly.
                </p>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('input[name="payment_method"]');
        const referenceField = document.getElementById('reference-field');

        function toggleReference() {
            const selected = document.querySelector('input[name="payment_method"]:checked');
            if (selected && selected.value === 'cash') {
                referenceField.style.display = 'none';
            } else {
                referenceField.style.display = 'block';
            }
        }

        radios.forEach(r => r.addEventListener('change', toggleReference));
        toggleReference();
    });
</script>
@endsection