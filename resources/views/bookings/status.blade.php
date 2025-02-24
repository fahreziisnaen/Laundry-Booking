<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Status') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Booking Information</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Booking Code: <span class="font-mono">{{ $booking->booking_code }}</span>
                        </p>
                    </div>

                    <dl class="grid grid-cols-1 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($booking->status === 'completed') bg-green-100 text-green-800 
                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800 
                                    @else bg-gray-100 text-gray-800 
                                    @endif">
                                    {{ $booking->status }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Package</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->package->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Pickup Time</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->pickup_time->format('d M Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 