<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingCheckController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return view('bookings.check');
        }
        return view('bookings.guest-check');
    }

    public function check(Request $request)
    {
        $request->validate([
            'booking_code' => [
                'required',
                'string',
                'min:8',
                'max:20'
            ]
        ], [
            'booking_code.required' => 'Please enter a booking code.',
            'booking_code.min' => 'Booking code should be at least :min characters.',
            'booking_code.max' => 'Booking code should not exceed :max characters.'
        ]);

        $booking = Booking::where('booking_code', $request->booking_code)
            ->with(['package', 'photos'])
            ->select(['id', 'booking_code', 'status', 'estimated_weight', 'total_amount', 'pickup_time', 'address', 'package_id', 'latitude', 'longitude'])
            ->first();

        if (!$booking) {
            return back()
                ->withInput()
                ->with('error', 'Booking not found. Please check your booking code and try again.');
        }

        return view('bookings.check-result', compact('booking'));
    }
} 