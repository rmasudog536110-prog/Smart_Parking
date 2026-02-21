<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscription = auth()->user()->subscription;
        $plans = SubscriptionPlan::where('is_active', true)->get();
        $plan = $request->plan_id ? SubscriptionPlan::find($request->plan_id) : null;

        $hasUsedFreePlan = Subscription::where('user_id', auth()->id())
            ->whereHas('plan', fn($q) => $q->where('price', 0))
            ->exists();

        return view('subscription.index', compact('subscription', 'plans', 'plan', 'hasUsedFreePlan'));
    }

    public function show(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        if ($plan->price == 0) {
            $hasUsedFreePlan = Subscription::where('user_id', auth()->id())
                ->whereHas('plan', fn($q) => $q->where('price', 0))
                ->exists();

            if ($hasUsedFreePlan) {
                return redirect()->route('subscription.index')
                    ->with('error', 'You have already used your free plan. Please choose a paid plan.');
            }

            Subscription::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'plan_id'   => $plan->id,
                    'plan_name' => $plan->name,
                    'price'     => $plan->price,
                    'starts_at' => now(),
                    'ends_at'   => now()->addDays($plan->duration),
                    'status'    => 'active',
                ]
            );

            return redirect()->route('subscription.index')
                ->with('success', 'You have successfully subscribed to the free plan!');
        }

        return view('subscription.show', compact('plan'));
    }

    public function cancel()
    {
        $subscription = auth()->user()->subscription;

        if ($subscription) {
            $subscription->update(['status' => 'cancelled']);
        }

        return back()->with('success', 'Subscription cancelled.');
    }
}