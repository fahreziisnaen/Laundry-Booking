<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Services\WebhookService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookingStatusController extends Controller
{
    use AuthorizesRequests;

    protected $webhookService;

    public function __construct(WebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Booking::getStatusList()))
        ]);

        $oldStatus = $booking->status;
        $booking->update([
            'status' => $validated['status']
        ]);

        // Kirim notifikasi WhatsApp
        $this->webhookService->sendBookingNotification($booking);

        return back()->with('success', 'Booking status updated successfully');
    }
} 