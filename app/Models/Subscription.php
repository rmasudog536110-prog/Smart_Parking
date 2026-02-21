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
        return auth()->user()->reservations()
            ->where('is_free', true)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->get()
            ->sum(fn($r) => $r->start_time->diffInHours($r->end_time));
    }

    public function hasFreeHoursLeft(): bool
    {
        return $this->status === 'active' && $this->freeHoursUsedThisWeek() < 5;
    }

    public function freeHoursLeft(): float
    {
        return max(0, 5 - $this->freeHoursUsedThisWeek());
    }

}
