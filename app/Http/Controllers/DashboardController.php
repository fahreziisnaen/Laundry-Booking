<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        // Get bookings with pagination
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['package'])
            ->latest()
            ->paginate(10);
        
        // Get statistics
        $totalBookings = Booking::where('user_id', Auth::id())->count();
        $completedBookings = Booking::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->count();
        $pendingBookings = Booking::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        return view('dashboard', compact(
            'bookings',
            'totalBookings',
            'completedBookings',
            'pendingBookings'
        ));
    }
} 