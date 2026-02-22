<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ParkingSlot;
use App\Models\ParkingLocation;
use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $totalReserved = Reservation::whereIn('status', ['pending', 'active'])->count();
        $totalActive = Reservation::where('status', 'active')->count();
        $totalCompleted = Reservation::where('status', 'completed')->whereDate('updated_at', today())->count();
        $totalCancelled = Reservation::where('status', 'cancelled')->whereDate('updated_at', today())->count();

        $slotStats = ParkingSlot::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $reservations = Reservation::with(['slot.location', 'vehicle', 'user'])
            ->whereIn('status', ['pending', 'active'])
            ->latest()
            ->get();

        $slotTypes = ParkingSlot::selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type');

        return view('staff.dashboard', compact(
            'totalReserved',
            'totalActive',
            'totalCompleted',
            'totalCancelled',
            'slotStats',
            'reservations',
            'slotTypes',
        ));
    }

    public function scan(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        $data = json_decode($request->qr_data, true);

        if (!$data || !isset($data['reservation_id'], $data['token'])) {
            return response()->json(['success' => false, 'message' => 'Invalid QR code.'], 422);
        }

        $expected = hash_hmac('sha256', $data['reservation_id'], config('app.key'));

        if (!hash_equals($expected, $data['token'])) {
            return response()->json(['success' => false, 'message' => 'QR code verification failed.'], 403);
        }

        $reservation = Reservation::with(['slot.location', 'vehicle', 'user'])
            ->find($data['reservation_id']);

        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Reservation not found.'], 404);
        }

        return response()->json([
            'success'     => true,
            'reservation' => [
                'id'           => $reservation->id,
                'status'       => $reservation->status,
                'user'         => $reservation->user?->name,
                'vehicle'      => $reservation->vehicle?->plate_num,
                'slot'         => $reservation->slot ? '#' . $reservation->slot->slot_number . ' (' . ucfirst($reservation->slot->type) . ')' : '—',
                'location'     => $reservation->slot?->location?->name,
                'start_time'   => $reservation->start_time?->format('M d, Y h:i A'),
                'end_time'     => $reservation->end_time?->format('M d, Y h:i A'),
                'is_free'      => $reservation->is_free,
                'total_amount' => $reservation->total_amount,
                'free_hours'   => $reservation->free_hours,
                'paid_hours'   => $reservation->paid_hours,
            ],
        ]);
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:active,completed',
        ]);

        $reservation->update(['status' => $request->status]);

        if ($request->status === 'completed') {
            $reservation->slot->update(['status' => 'available']);
        } elseif ($request->status === 'active') {
            $reservation->slot->update(['status' => 'occupied']);
        }

        return response()->json(['success' => true, 'status' => $request->status]);
    }
}