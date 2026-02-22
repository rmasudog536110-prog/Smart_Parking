<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reservation;
use App\Models\ParkingSlot;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'customer')->count(),
            'total_revenue' => Payment::where('payment_status', 'paid')->sum('amount'),
            'revenue_this_month' => Payment::where('payment_status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
        ];

        // Active parkers (those currently in a spot)
        $stats['active_parking'] = Reservation::where('status', 'parked')
            ->where('end_time', '>', now())
            ->count();

        $stats['new_users_today'] = User::where('role', 'customer')
                ->whereDate('created_at', today())
                ->count();

        // Check availability of slots (using your ParkingSlot status field)
        $stats['available_spots'] = ParkingSlot::where('status', 'available')->count();
        $stats['total_spots'] = ParkingSlot::count();

        // Oldest pending reservation request
        $stats['oldest_pending'] = Reservation::where('status', 'pending')
            ->oldest()
            ->first()
            ?->created_at?->diffForHumans() ?? 'N/A';

        $recentUsers = User::where('role', 'customer')
            ->latest()
            ->take(5)
            ->get();

        $staff = User::where('role', 'staff')
            ->latest()
            ->take(5)
            ->get();

        $pendingPayments = Reservation::where('status', 'pending')
            ->with(['user', 'slot', 'payment'])
            ->latest()
            ->get();
        
        $users = User::latest()->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'pendingPayments', 'staff', 'users'));
    }

    public function charts()
    {
        $revenueMonthly = Payment::where('payment_status', 'paid')
        ->selectRaw('SUM(amount) as total, MONTHNAME(created_at) as month')
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('created_at')
        ->get();

        // Data for Pie Chart: Slot Occupancy
        $occupancyData = [
            'Available' => ParkingSlot::where('status', 'available')->count(),
            'Occupied' => Reservation::where('status', 'parked')->count(),
            'Reserved' => Reservation::where('status', 'confirmed')->count(),
        ];

        return view('admin.charts', compact('revenueMonthly', 'occupancyData'));
    }

    public function users()
    {
        // Changed 'reservations.spot' to 'reservations.slot' to match your model
        $users = User::where('role', 'customer')
            ->with(['reservations.slot', 'vehicles']) 
            ->latest()
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function editUser(User $user)
    {
        $slots = ParkingSlot::all(); // Changed from $spots to $slots
        
        // Get current active reservation
        $currentReservation = $user->reservations()
            ->whereIn('status', ['confirmed', 'parked'])
            ->where('end_time', '>', now())
            ->latest()
            ->first();

        return view('admin.edit-user', compact('user', 'slots', 'currentReservation'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'is_active' => 'required|boolean',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'User profile updated!');
    }

    public function manageReservation(Request $request, User $user)
    {
        $validated = $request->validate([
            'slot_id' => 'required|exists:parking_slots,id', // Changed from spot_id
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'action' => 'required|in:create,update',
            'reservation_id' => 'nullable|exists:reservations,id',
        ]);

        if ($validated['action'] === 'update' && $validated['reservation_id']) {
            $reservation = Reservation::findOrFail($validated['reservation_id']);
            
            if ($reservation->user_id !== $user->id) {
                return back()->with('error', 'Unauthorized action!');
            }

            $reservation->update([
                'slot_id' => $validated['slot_id'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
            ]);

            $message = 'Reservation updated!';
        } else {
            // Cancel other active reservations
            Reservation::where('user_id', $user->id)
                ->where('status', 'confirmed')
                ->update(['status' => 'cancelled']);

            Reservation::create([
                'user_id' => $user->id,
                'slot_id' => $validated['slot_id'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'status' => 'confirmed',
            ]);

            $message = 'Parking slot reserved successfully!';
        }

        return redirect()->route('admin.edit-user', $user)
            ->with('success', $message);
    }

    public function cancelReservation(User $user, Reservation $reservation)
    {
        if ($reservation->user_id !== $user->id) {
            return back()->with('error', 'Invalid request!');
        }

        $reservation->update(['status' => 'cancelled']);

        return back()->with('success', 'Reservation cancelled.');
    }
}