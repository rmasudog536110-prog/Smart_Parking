<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $pendingSubscriptions = Subscription::with(['user', 'plan'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.subscriptions', compact('pendingSubscriptions'));
    }

    public function approve(Subscription $subscription)
    {
        $subscription->update(['status' => 'active']);

        Payment::whereNull('reservation_id')
            ->where('user_id', $subscription->user_id)
            ->where('payment_status', 'processing')
            ->latest()
            ->first()
            ?->update(['payment_status' => 'paid']);

        return back()->with('success', "Subscription activated for {$subscription->user->name}.");
    }

    public function reject(Subscription $subscription)
    {
        $subscription->update(['status' => 'cancelled']);

        Payment::whereNull('reservation_id')
            ->where('user_id', $subscription->user_id)
            ->where('payment_status', 'processing')
            ->latest()
            ->first()
            ?->update(['payment_status' => 'failed']);

        return back()->with('success', "Subscription rejected for {$subscription->user->name}.");
    }
}