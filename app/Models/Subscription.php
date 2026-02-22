<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'plan_id', 'price', 'starts_at', 'ends_at', 'status'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function freeHoursUsedThisWeek(): float
    {
        return $this->user->reservations()
            ->where('is_free', true)
            ->where('status', 'completed')
            ->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])
            ->get()
            ->sum(fn($r) => (float) $r->free_hours);
    }

    public function freeHoursLeft(): float
    {
        $weeklyLimit = $this->plan->free_hours_per_week ?? 0;
        return max(0, $weeklyLimit - $this->freeHoursUsedThisWeek());
    }

    public function hasFreeHoursLeft(): bool
    {
        return $this->status === 'active' && $this->freeHoursLeft() > 0;
    }
}
