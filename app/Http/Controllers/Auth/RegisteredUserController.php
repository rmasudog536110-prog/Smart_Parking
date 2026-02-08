<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        $selectedPlan = SubscriptionPlan::find($selectedPlanId);
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
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

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
        $user = Auth::user(); // get the logged-in user

        if ($user->trashed() || $user->subscriptions()->where('status', 'cancelled')->exists()) {
            Auth::logout();
            return redirect()->route('landing')
                ->with('error', 'Your registration/payment was cancelled.');
        }
        
        if ($user->hasAdminAccess()) {
            return redirect()->route('admin.dashboard');
        }
    
        $subscription = $user->subscriptions()->latest()->first();
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