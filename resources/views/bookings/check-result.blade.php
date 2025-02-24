@php
    $layout = auth()->check() ? 'app-layout' : 'guest-layout';
@endphp

<x-dynamic-component :component="$layout">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Booking #{{ $booking->booking_code }}</h3>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($booking->status === 'completed') bg-green-100 text-green-800 
                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800 
                                    @else bg-gray-100 text-gray-800 
                                    @endif">
                                    {{ $booking->status }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Package</p>
                            <p class="mt-1">{{ optional($booking->package)->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Weight</p>
                            <p class="mt-1">{{ $booking->estimated_weight }} kg</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Amount</p>
                            <p class="mt-1">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Pickup Time</p>
                            <p class="mt-1">{{ $booking->pickup_time }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Address</p>
                            <p class="mt-1">{{ $booking->address }}</p>
                        </div>

                        @if($booking->photos->isNotEmpty())
                        <div class="col-span-2 mt-4">
                            <p class="text-sm font-medium text-gray-500">Laundry Photos</p>
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($booking->photos as $photo)
                                    <div>
                                        <img src="{{ Storage::url($photo->path) }}" 
                                             alt="Laundry Photo" 
                                             class="rounded-lg w-full h-48 object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('bookings.check') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            {{ __('Check Another Booking') }}
                        </a>
                        @auth
                            @can('view', $booking)
                            <a href="{{ route('bookings.show', $booking->booking_code) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                {{ __('View Details') }}
                            </a>
                            @endcan
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                {{ __('Login') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component> 