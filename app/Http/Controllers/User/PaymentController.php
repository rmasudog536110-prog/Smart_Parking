<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function paymentForm(Request $request, $plan)
    {
        $plan = SubscriptionPlan::findOrFail($plan);

        return view('payment.index', compact('plan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_id'        => 'required|exists:subscription_plans,id',
            'amount'         => 'required|numeric|min:0',
            'payment_method' => 'required|in:credit_card,debit_card,paypal,gcash,cash',
        ]);

        Payment::create([
            'amount'         => $request->amount,
            'payment_method' => $request->payment_method,
            'status'         => 'pending',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        Subscription::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'plan_id'   => $plan->id,
                'plan_name' => $plan->name,
                'price'     => $plan->price,
                'starts_at' => now(),
                'ends_at'   => now()->addDays($plan->duration),
                'status'    => 'pending',
            ]
        );

        return redirect()->route('subscription.index')
            ->with('success', 'Payment submitted. Your subscription will be activated once payment is confirmed.');
    }
}