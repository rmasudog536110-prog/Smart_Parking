<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    
    public function showRegister(Request $request) {

        $selectedPlanId = $request->query('plan');
         
        $selectedPlan = null;

    if ($selectedPlanId) {
        $selectedPlan = Subscription::find($selectedPlan);
    }

        return view('auth.register', [
        'selectedPlan' => $selectedPlan,
        'selectedPlanId' => $selectedPlanId,
        ]);

    }
 
 
public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:user',
        'phone_number' => 'required|max:10|unique:user',
        'password' => 'required|min:6|confirmed',
        'plan_id' => ['nullable', 'integer'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'password' => Hash::make($request->password),
    ]);

    $user->profile()->create([]);

    if ($request->filled('plan_id')) {
        $plan = Subscription::find($request->plan_id);

        if ($plan) {
            Auth::login($user);

            return redirect()
                ->route('subscription.payment.form', ['plan' => $plan->id])
                ->with('success', 'Please upload your payment proof to activate your subscription.');
        }
    }

    $subscription = $user->subscription()->latest()->first();

    if ($subscription && $subscription->status === 'pending') {
        Auth::login($user);
        return redirect()->route('landing')->with('success', 'Thank you for registering. Your subscription is pending approval.');
    }

    if ($subscription && $subscription->status === 'null') {
        Auth::login($user);
        return redirect()->route('subscription.payment.form');
    }


    return redirect('home')->with('success', 'Registered successfully.');
}

    public function showLogin() {
        return view('auth.login');
    }
 
 
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
 
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user(); 
        
        if ($user->hasAdminAccess()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasOperatorAccess()) {
            return redirect()->route('staff.dashboard');
        }
    
        $subscription = $user->subscription()->latest()->first();
        if ($subscription && $subscription->status === 'pending') {
            return redirect()->route('landing')->with('success', 'Thank you for registering. Your subscription is pending approval.');
        }

        return redirect()->route('home');
    }

    // Login failed
    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ]);
}
 
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }

}