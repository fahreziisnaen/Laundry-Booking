<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    public function sendBookingNotification(Booking $booking)
    {
        try {
            $statusMessages = [
                Booking::STATUS_CONFIRMED => '✅ Booking Anda telah dikonfirmasi',
                Booking::STATUS_COMPLETED => '🎉 Laundry telah selesai',
                Booking::STATUS_PENDING => '⏳ Booking sedang menunggu konfirmasi',
            ];

            $statusMessage = $statusMessages[$booking->status] ?? "Status: {$booking->status}";

            $message = "*UPDATE BOOKING*\n\n"
                . "Kode Booking: *{$booking->booking_code}*\n"
                . "{$statusMessage}\n\n"
                . "Customer: *{$booking->user->name}*\n"
                . "Paket: {$booking->package->name}\n"
                . "Total: Rp " . number_format($booking->total_amount, 0, ',', '.');

            $response = Http::post(config('webhook.whatsapp_api_url'), [
                'message' => $message,
                'id' => config('webhook.whatsapp_recipient')
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('WhatsApp notification error', [
                'booking_code' => $booking->booking_code,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
} 