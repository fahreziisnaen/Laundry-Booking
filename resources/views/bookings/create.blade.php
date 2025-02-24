<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Address Input Section -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Location Details') }}</h3>
                            
                            <!-- Address Input -->
                            <div class="mb-4">
                                <x-label for="address" value="{{ __('Address') }}" />
                                <x-input id="address" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    name="address" 
                                    :value="old('address')" 
                                    required 
                                    placeholder="Masukkan alamat lengkap..." />
                                <x-input-error for="address" class="mt-2" />
                            </div>
                        </div>

                        <!-- Package -->
                        <div class="mb-4">
                            <x-label for="package" value="{{ __('Package') }}" />
                            <select id="package" name="package_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="">Select Package</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->id }}">
                                        {{ $package->name }} - Rp {{ number_format($package->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error for="package_id" class="mt-2" />
                        </div>

                        <!-- Estimated Weight -->
                        <div class="mb-4">
                            <x-label for="estimated_weight" value="{{ __('Estimated Weight (kg)') }}" />
                            <x-input id="estimated_weight" class="block mt-1 w-full" type="number" name="estimated_weight" :value="old('estimated_weight')" required />
                            <x-input-error for="estimated_weight" class="mt-2" />
                        </div>

                        <!-- Pickup Date -->
                        <div class="mb-4">
                            <x-label for="pickup_date" value="{{ __('Pickup Date') }}" />
                            <x-input id="pickup_date" 
                                class="block mt-1 w-full" 
                                type="date" 
                                name="pickup_date" 
                                :value="old('pickup_date')" 
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
                                        <option value="{{ sprintf('%02d:%s', $hour, $minute) }}">
                                            {{ sprintf('%02d:%s', $hour, $minute) }}
                                        </option>
                                    @endforeach
                                @endfor
                            </select>
                            <x-input-error for="pickup_time" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <x-label for="notes" value="{{ __('Notes') }}" />
                            <textarea id="notes" name="notes" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3">{{ old('notes') }}</textarea>
                            <x-input-error for="notes" class="mt-2" />
                        </div>

                        <!-- Photos -->
                        <div class="mb-4">
                            <x-label for="photos" value="{{ __('Photos') }}" />
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex flex-col space-y-2">
                                        <!-- Upload File Button -->
                                        <div class="flex justify-center">
                                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload photos</span>
                                                <input id="photos" name="photos[]" type="file" class="sr-only" multiple accept="image/*" capture="environment">
                                            </label>
                                        </div>

                                        <!-- Take Photo Button -->
                                        <div class="flex justify-center">
                                            <button type="button" 
                                                id="takePhotoBtn"
                                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                Take Photo
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                            
                            <!-- Camera Modal -->
                            <div id="cameraModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
                                <div class="flex items-center justify-center min-h-screen">
                                    <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-lg font-medium">Take Photo</h3>
                                            <button type="button" id="closeCameraBtn" class="text-gray-400 hover:text-gray-500">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="relative">
                                            <video id="camera" class="w-full rounded-lg" autoplay playsinline></video>
                                            <canvas id="canvas" class="hidden"></canvas>
                                        </div>
                                        <div class="mt-4 flex justify-end space-x-3">
                                            <button type="button" 
                                                id="captureBtn"
                                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                                </svg>
                                                Capture
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                            <x-input-error for="photos" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Create Booking') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
    .camera-modal {
        z-index: 50;
    }
    .preview-image {
        height: 6rem;
        width: 100%;
        object-fit: cover;
        border-radius: 0.5rem;
    }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Flatpickr initialization
        flatpickr("#pickup_time", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minTime: "08:00",
            maxTime: "20:00",
            minDate: "today",
            time_24hr: true,
            minuteIncrement: 30
        });

        // Camera functionality
        document.addEventListener('DOMContentLoaded', function() {
            let stream;
            const cameraModal = document.getElementById('cameraModal');
            const video = document.getElementById('camera');
            const canvas = document.getElementById('canvas');
            const preview = document.getElementById('preview');
            const capturedPhotos = new DataTransfer();

            // Handle file input change
            document.getElementById('photos').addEventListener('change', handleFileSelect);

            // Open camera modal
            document.getElementById('takePhotoBtn').addEventListener('click', async () => {
                try {
                    stream = await navigator.mediaDevices.getUserMedia({ 
                        video: { facingMode: 'environment' } 
                    });
                    video.srcObject = stream;
                    cameraModal.classList.remove('hidden');
                } catch (err) {
                    alert('Could not access camera: ' + err.message);
                }
            });

            // Close camera modal
            document.getElementById('closeCameraBtn').addEventListener('click', () => {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
                cameraModal.classList.add('hidden');
            });

            // Capture photo
            document.getElementById('captureBtn').addEventListener('click', () => {
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                
                canvas.toBlob(blob => {
                    const file = new File([blob], `photo_${Date.now()}.jpg`, { type: 'image/jpeg' });
                    capturedPhotos.items.add(file);
                    
                    // Update file input
                    const photoInput = document.getElementById('photos');
                    photoInput.files = capturedPhotos.files;
                    
                    // Trigger change event to update preview
                    const event = new Event('change');
                    photoInput.dispatchEvent(event);
                    
                    // Close camera
                    if (stream) {
                        stream.getTracks().forEach(track => track.stop());
                    }
                    cameraModal.classList.add('hidden');
                }, 'image/jpeg');
            });

            function handleFileSelect(event) {
                preview.innerHTML = '';
                
                Array.from(event.target.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative group';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="h-24 w-full object-cover rounded-lg">
                            <div class="absolute inset-0 ring-1 ring-inset ring-black/10 rounded-lg"></div>
                            <button type="button" class="absolute top-0 right-0 p-1 bg-red-500 text-white rounded-full m-1 opacity-0 group-hover:opacity-100 transition-opacity" onclick="removePhoto(this)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        `;
                        preview.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            }

            window.removePhoto = function(button) {
                const photoDiv = button.parentElement;
                const index = Array.from(preview.children).indexOf(photoDiv);
                
                const dt = new DataTransfer();
                const input = document.getElementById('photos');
                
                Array.from(input.files)
                    .filter((_, i) => i !== index)
                    .forEach(file => dt.items.add(file));
                    
                input.files = dt.files;
                photoDiv.remove();
            }
        });
    </script>
    @endpush
</x-app-layout> 