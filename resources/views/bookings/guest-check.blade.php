<x-guest-layout>
    <div class="pt-4 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
                <x-authentication-card-logo />
            </div>

            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                <h2 class="text-center">{{ __('Check Booking Status') }}</h2>

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('bookings.check.submit') }}">
                    @csrf
                    <div>
                        <x-label for="booking_code" value="{{ __('Booking Code') }}" />
                        <x-input id="booking_code" class="block mt-1 w-full" type="text" name="booking_code" :value="old('booking_code')" required autofocus />
                        @error('booking_code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <x-button>
                            {{ __('Check Status') }}
                        </x-button>
                        
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                            {{ __('Have an account? Login') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout> 