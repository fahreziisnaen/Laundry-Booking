<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use App\Services\WebhookService;

class BookingController extends Controller
{
    use AuthorizesRequests;

    protected $webhookService;

    public function __construct(WebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function create()
    {
        $packages = Package::where('is_active', true)->get();
        return view('bookings.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'package_id' => 'required|exists:packages,id',
            'estimated_weight' => 'required|numeric|min:1',
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required',
            'notes' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $pickup_datetime = $validated['pickup_date'] . ' ' . $validated['pickup_time'];
        $package = Package::findOrFail($validated['package_id']);
        $total_amount = $validated['estimated_weight'] * $package->price;

        $booking = auth()->user()->bookings()->create([
            'booking_code' => Booking::generateBookingCode(),
            'address' => $validated['address'],
            'package_id' => $validated['package_id'],
            'estimated_weight' => $validated['estimated_weight'],
            'pickup_time' => $pickup_datetime,
            'notes' => $validated['notes'],
            'status' => 'pending',
            'total_amount' => $total_amount,
        ]);

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('booking-photos', 'public');
                $booking->photos()->create([
                    'path' => $path
                ]);
            }
        }

        // Send webhook notification
        $this->webhookService->sendBookingNotification($booking);

        return redirect()->route('dashboard')->with('success', 'Booking created successfully!');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        
        return view('bookings.show', [
            'booking' => $booking->load(['package', 'photos']),
        ]);
    }

    public function edit(Booking $booking)
    {
        $this->authorize('update', $booking);
        $packages = Package::where('is_active', true)->get();
        return view('bookings.edit', compact('booking', 'packages'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'package_id' => 'required|exists:packages,id',
            'estimated_weight' => 'required|numeric|min:1',
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        // Gabungkan date dan time
        $pickup_datetime = $validated['pickup_date'] . ' ' . $validated['pickup_time'];

        $package = Package::findOrFail($validated['package_id']);
        $total_amount = $validated['estimated_weight'] * $package->price;

        $booking->update([
            'address' => $validated['address'],
            'package_id' => $validated['package_id'],
            'estimated_weight' => $validated['estimated_weight'],
            'pickup_time' => $pickup_datetime,
            'notes' => $validated['notes'],
            'total_amount' => $total_amount,
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->delete();
        return redirect()->route('dashboard')->with('success', 'Booking deleted successfully!');
    }
} 