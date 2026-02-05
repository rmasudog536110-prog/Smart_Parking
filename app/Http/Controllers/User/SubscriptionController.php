<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscription = auth()->user()->subscription;
        return view('subscription.index', compact('subscription'));
    }

    public function subscribe(Request $request)
    {
        Subscription::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'plan' => $request->plan,
                'price' => $request->price,
                'starts_at' => now(),
                'ends_at' => now()->addDays($request->duration)
            ]
        );

        return back()->with('success', 'Subscribed successfully');
    }

    public function cancel()
    {
        auth()->user()->subscription()?->delete();
        return back()->with('success', 'Subscription cancelled');
    }
}
