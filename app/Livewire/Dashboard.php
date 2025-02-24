<?php

namespace App\Livewire;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public $status = '';
    public $perPage = 10;

    // Reset pagination when filters change
    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = auth()->user()->isAdmin() 
            ? Booking::query() 
            : auth()->user()->bookings();

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $bookings = $query->latest()->paginate($this->perPage);
        
        // Update statistik dengan query yang benar
        $baseQuery = auth()->user()->isAdmin() 
            ? Booking::query() 
            : Booking::where('user_id', auth()->id());
        
        $stats = [
            [
                'label' => 'Total Bookings',
                'count' => $baseQuery->count(),
                'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                'bg_color' => 'bg-indigo-600'
            ],
            [
                'label' => 'Pending',
                'count' => (clone $baseQuery)->where('status', Booking::STATUS_PENDING)->count(),
                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                'bg_color' => 'bg-yellow-600'
            ],
            [
                'label' => 'Confirmed',
                'count' => (clone $baseQuery)->where('status', Booking::STATUS_CONFIRMED)->count(),
                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'bg_color' => 'bg-blue-600'
            ],
            [
                'label' => 'Processing',
                'count' => (clone $baseQuery)
                    ->whereIn('status', [
                        Booking::STATUS_PICKUP_IN_PROGRESS,
                        Booking::STATUS_PICKED_UP,
                        Booking::STATUS_PROCESSING,
                        Booking::STATUS_READY_FOR_DELIVERY
                    ])->count(),
                'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                'bg_color' => 'bg-orange-600'
            ],
            [
                'label' => 'Completed',
                'count' => (clone $baseQuery)->where('status', Booking::STATUS_COMPLETED)->count(),
                'icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4',
                'bg_color' => 'bg-green-600'
            ],
        ];

        return view('livewire.dashboard', [
            'bookings' => $bookings,
            'stats' => $stats
        ]);
    }
} 