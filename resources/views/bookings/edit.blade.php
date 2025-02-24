<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Booking') }} #{{ $booking->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Address -->
                        <div class="mb-4">
                            <x-label for="address" value="{{ __('Address') }}" />
                            <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', $booking->address)" required />
                            <x-input-error for="address" class="mt-2" />
                        </div>

                        <!-- Package -->
                        <div class="mb-4">
                            <x-label for="package" value="{{ __('Package') }}" />
                            <select id="package" name="package_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="">Select Package</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->id }}" {{ $booking->package_id == $package->id ? 'selected' : '' }}>
                                        {{ $package->name }} - Rp {{ number_format($package->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error for="package_id" class="mt-2" />
                        </div>

                        <!-- Estimated Weight -->
                        <div class="mb-4">
                            <x-label for="estimated_weight" value="{{ __('Estimated Weight (kg)') }}" />
                            <x-input id="estimated_weight" class="block mt-1 w-full" type="number" name="estimated_weight" :value="old('estimated_weight', $booking->estimated_weight)" required />
                            <x-input-error for="estimated_weight" class="mt-2" />
                        </div>

                        <!-- Pickup Date -->
                        <div class="mb-4">
                            <x-label for="pickup_date" value="{{ __('Pickup Date') }}" />
                            <x-input id="pickup_date" 
                                class="block mt-1 w-full" 
                                type="date" 
                                name="pickup_date" 
                                :value="old('pickup_date', $booking->pickup_time->format('Y-m-d'))" 
                                min="{{ date('Y-m-d') }}"
                                required />
                            <x-input-error for="pickup_date" class="mt-2" />
                        </div>

                        <!-- Pickup Time -->
                        <div class="mb-4">
                            <x-label for="pickup_time" value="{{ __('Pickup Time') }}" />
                            <select id="pickup_time" 
                                name="pickup_time" 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                                required>
                                <option value="">Select Time</option>
                                @for ($hour = 8; $hour <= 20; $hour++)
                                    @foreach(['00', '30'] as $minute)
                                        @php
                                            $time = sprintf('%02d:%s', $hour, $minute);
                                            $selected = $booking->pickup_time->format('H:i') === $time ? 'selected' : '';
                                        @endphp
                                        <option value="{{ $time }}" {{ $selected }}>
                                            {{ $time }}
                                        </option>
                                    @endforeach
                                @endfor
                            </select>
                            <x-input-error for="pickup_time" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <x-label for="notes" value="{{ __('Notes') }}" />
                            <textarea id="notes" name="notes" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3">{{ old('notes', $booking->notes) }}</textarea>
                            <x-input-error for="notes" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('bookings.show', $booking) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 mr-4">
                                Cancel
                            </a>
                            <x-button>
                                {{ __('Update Booking') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 