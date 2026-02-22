<div style="font-family: sans-serif; max-width: 520px; margin: 0 auto; padding: 24px; color: #111827;">
    <div style="background: #1d4ed8; padding: 20px 24px; border-radius: 12px 12px 0 0;">
        <h2 style="color: white; margin: 0; font-size: 20px;">Smart Parking</h2>
        <p style="color: #bfdbfe; margin: 4px 0 0; font-size: 13px;">Parking Receipt</p>
    </div>

    <div style="border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 12px 12px; padding: 24px;">
        <p style="margin: 0 0 16px; font-size: 14px;">
            Hi <strong>{{ $reservation->user->name }}</strong>, thank you for parking with us!
        </p>

        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 8px 0; color: #6b7280;">Reservation</td>
                <td style="padding: 8px 0; font-weight: 600; text-align: right;">#{{ $reservation->id }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 8px 0; color: #6b7280;">Location</td>
                <td style="padding: 8px 0; text-align: right;">{{ $reservation->slot?->location?->name ?? '—' }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 8px 0; color: #6b7280;">Slot</td>
                <td style="padding: 8px 0; text-align: right;">#{{ $reservation->slot?->slot_number }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 8px 0; color: #6b7280;">Vehicle</td>
                <td style="padding: 8px 0; text-align: right;">{{ $reservation->vehicle?->plate_num }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 8px 0; color: #6b7280;">Check In</td>
                <td style="padding: 8px 0; text-align: right;">{{ $reservation->start_time?->format('M d, Y h:i A') }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 8px 0; color: #6b7280;">Check Out</td>
                <td style="padding: 8px 0; text-align: right;">{{ $reservation->end_time?->format('M d, Y h:i A') }}</td>
            </tr>

            @if ($reservation->free_hours > 0)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 8px 0; color: #6b7280;">Free Hours (Subscription)</td>
                    <td style="padding: 8px 0; text-align: right; color: #10b981; font-weight: 600;">
                        {{ $reservation->free_hours }} hr(s)
                    </td>
                </tr>
            @endif

            @if ($reservation->paid_hours > 0)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 8px 0; color: #6b7280;">Paid Hours</td>
                    <td style="padding: 8px 0; text-align: right;">{{ $reservation->paid_hours }} hr(s)</td>
                </tr>
            @endif

            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 8px 0; color: #6b7280;">Payment Method</td>
                <td style="padding: 8px 0; text-align: right;">{{ ucfirst($reservation->payment?->payment_method ?? '—') }}</td>
            </tr>
            <tr>
                <td style="padding: 12px 0; font-weight: 700; font-size: 15px;">Total Charged</td>
                <td style="padding: 12px 0; text-align: right; font-weight: 700; font-size: 15px; color: {{ $reservation->total_amount == 0 ? '#10b981' : '#1d4ed8' }};">
                    {{ $reservation->total_amount == 0 ? 'FREE' : '₱' . number_format($reservation->total_amount, 2) }}
                </td>
            </tr>
        </table>

        <p style="margin-top: 24px; font-size: 12px; color: #9ca3af; text-align: center;">
            Thank you for using Smart Parking. See you next time!
        </p>
    </div>
</div>