@php
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Details') }} #{{ $booking->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Booking Information</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->address }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Package</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->package->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Estimated Weight</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->estimated_weight }} kg</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Pickup Time</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->pickup_time->format('d M Y H:i') }}</dd>
                                </div>
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
                                @if($booking->notes)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->notes }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    @if($booking->photos->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Photos</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($booking->photos as $photo)
                                <div class="relative group">
                                    <div class="cursor-pointer" onclick="openPhotoModal('{{ Storage::url($photo->path) }}')">
                                        <img src="{{ Storage::url($photo->path) }}" 
                                             alt="Booking photo" 
                                             class="h-24 w-full object-cover rounded-lg hover:opacity-75 transition-opacity">
                                        <div class="absolute inset-0 ring-1 ring-inset ring-black/10 rounded-lg"></div>
                                        <!-- Icon untuk menandakan bisa diklik -->
                                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-5 h-5 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Modal untuk preview foto -->
                    <div id="photoModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50" onclick="closePhotoModal()">
                        <div class="absolute top-4 right-4">
                            <button onclick="closePhotoModal()" class="text-white hover:text-gray-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center justify-center h-full p-4">
                            <img id="modalImage" src="" alt="Preview" class="max-h-[90vh] max-w-[90vw] object-contain" onclick="event.stopPropagation()">
                        </div>
                    </div>

                    @push('scripts')
                    <script>
                    function openPhotoModal(src) {
                        const modal = document.getElementById('photoModal');
                        const modalImage = document.getElementById('modalImage');
                        modalImage.src = src;
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden'; // Mencegah scroll
                    }

                    function closePhotoModal() {
                        const modal = document.getElementById('photoModal');
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto'; // Mengembalikan scroll
                    }

                    // Menangani tombol ESC untuk menutup modal
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            closePhotoModal();
                        }
                    });
                    </script>
                    @endpush
                    @endif

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Booking Code</h3>
                        <div class="flex items-center space-x-4">
                            <div class="bg-gray-100 px-4 py-2 rounded-lg">
                                <span class="font-mono text-lg">{{ $booking->booking_code }}</span>
                            </div>
                            <div class="qr-code">
                                @php
                                    $options = new QROptions([
                                        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
                                        'eccLevel' => QRCode::ECC_L,
                                        'imageBase64' => false,
                                    ]);
                                    
                                    $qrcode = new QRCode($options);
                                    $qrcode_svg = $qrcode->render(route('bookings.check') . '?code=' . $booking->booking_code);
                                @endphp
                                <div class="w-24 h-24">
                                    {!! $qrcode_svg !!}
                                </div>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            Use this code or scan QR code to check your booking status
                        </p>
                    </div>

                    @if($booking->latitude && $booking->longitude)
                    <div class="mt-4">
                        <h3 class="text-lg font-medium text-gray-900">Pickup Location</h3>
                        <div id="map" class="h-96 w-full rounded-lg mt-2"></div>
                    </div>

                    @push('scripts')
                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

                    <script>
                        // Initialize map
                        const map = L.map('map').setView([{{ $booking->latitude }}, {{ $booking->longitude }}], 15);
                        
                        // Add OpenStreetMap tiles
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(map);

                        // Add marker
                        L.marker([{{ $booking->latitude }}, {{ $booking->longitude }}])
                            .addTo(map)
                            .bindPopup("{{ $booking->address }}");
                    </script>
                    @endpush
                    @endif

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Back to Dashboard
                        </a>
                        <a href="{{ route('bookings.edit', $booking) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Edit Booking
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 