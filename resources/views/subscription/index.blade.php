@extends('layouts.app')

@section('title', 'Subscription')

@section('content')

    <section class="space-y-6 p-6 mb-0">
        <div class="mb-1 flex items-center justify-between gap-4 p-6">
            <div>
                <h1 class="text-4xl font-semibold text-gray-900">
                    Subscription
                </h1>
                <p class="text-sm text-gray-500">
                    View your current subscription status for the smart parking system.
                </p>
            </div>
        </div>

        <div class="p-6 grid gap-6 lg:grid-cols-[2fr,3fr] items-start">
            <section class="bg-white rounded-lg border border-gray-200 p-4">
                <h2 class="text-m font-semibold text-gray-900 mb-2">
                    Current subscription
                </h2>

                @if ($subscription)
                    <dl class="space-y-2 text-xs text-gray-700">
                        <div>
                            <dt class="text-gray-500">Plan type</dt>
                            <dd class="font-medium">
                                {{ ucfirst($subscription->plan_type ?? 'unknown') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Status</dt>
                            <dd class="font-medium">
                                {{ ucfirst($subscription->status ?? 'active') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Start date</dt>
                            <dd class="font-medium">
                                {{ $subscription->start_date ?? optional($subscription->starts_at)->toDateString() ?? '—' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">End date</dt>
                            <dd class="font-medium">
                                {{ $subscription->end_date ?? optional($subscription->ends_at)->toDateString() ?? '—' }}
                            </dd>
                        </div>
                    </dl>

                    <p class="mt-3 text-[11px] text-gray-500">
                        Subscription management (changing plans, canceling, and billing details)
                        can be further refined in the controller and database schema.
                    </p>
                @else
                    <p class="text-xs text-gray-500">
                        You do not have an active subscription yet.
                    </p>
                @endif
            </section>

            <section class="bg-white rounded-lg border border-gray-200 p-4">
                <h2 class="text-sm font-semibold text-gray-900 mb-2">
                    Plans (UI only)
                </h2>
                <p class="text-xs text-gray-500 mb-3">
                    The subscription backend (fields and pricing) still needs to be aligned
                    between the controller, model, and database. For now, this section only
                    illustrates what the UI could look like.
                </p>

                <div class="grid gap-3 md:grid-cols-3 text-xs">
                    <div class="border border-gray-200 rounded-lg p-3">
                        <h3 class="font-semibold text-gray-900 mb-1">Basic</h3>
                        <p class="text-gray-500 mb-2">Ideal for occasional drivers.</p>
                    </div>
                    <div class="border border-orange-300 rounded-lg p-3 bg-orange-50">
                        <h3 class="font-semibold text-gray-900 mb-1">Premium</h3>
                        <p class="text-gray-500 mb-2">Frequent use with extra perks.</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-3">
                        <h3 class="font-semibold text-gray-900 mb-1">VIP</h3>
                        <p class="text-gray-500 mb-2">Reserved slots in prime areas.</p>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection

