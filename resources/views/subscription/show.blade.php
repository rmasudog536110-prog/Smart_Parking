@extends('layouts.app')

@section('title', 'Subscription Details')

@section('content')
<section class="space-y-6 p-6">

    <div class="bg-white rounded-lg border border-gray-200 p-6">  

        <h1 class="text-3xl font-semibold">Plan Details</h1>
        <p class="text-md text-gray-500 mb-4">
            Manage or upgrade your subscription for smart parking.
        </p>
        <div class="text-lg space-y-2">
            <p><strong>Plan:</strong> {{ ucfirst($plan->name) }}</p>
            <p><strong>Price:</strong> ₱{{ number_format($plan->price, 2) }}</p>
            @if (!empty($plan->trial))
                <p><strong>Trial:</strong> {{ $plan->trial }}</p>
            @endif
        </div>

        {{-- Features --}}
        <ul class="text-md space-y-2 mt-4">
            @foreach ($plan->features as $feature)
                <li>✔ {{ $feature }}</li>
            @endforeach
        </ul>

        {{-- Action Button --}}
        <div class="mt-6">
            @if ($plan->price > 0)
                
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('subscription.index') }}" 
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded transition cursor-pointer">
                        <i class="fa-solid fa-arrow-left"></i> Back to Plans
                    </a>

                    <form method="GET" action="{{ route('payment.form', ['plan' => $plan->id]) }}">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded transition cursor-pointer">
                            Proceed to Payment <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>

                </div>
            @else
                <form method="POST" action="{{ route('subscription.show') }}">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    <button class="w-full bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded cursor-pointer">
                        Activate Free Plan
                    </button>
                </form>
            @endif
        </div>
    </div>

</section>
@endsection