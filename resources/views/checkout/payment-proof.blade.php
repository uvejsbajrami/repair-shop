<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Upload Payment Proof - MobileShop</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }
        .upload-area {
            border: 2px dashed #d1d5db;
            transition: all 0.3s ease;
        }
        .upload-area:hover, .upload-area.dragover {
            border-color: #2563eb;
            background-color: #eff6ff;
        }
        .preview-image {
            max-height: 300px;
            object-fit: contain;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="gradient-bg text-white py-6">
            <div class="container mx-auto px-6">
                <div class="flex items-center justify-between">
                    <a href="/" class="flex items-center">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-xl font-bold">MobileShop</span>
                    </a>
                    <a href="{{ route('owner.dashboard') }}" class="text-white hover:text-blue-200 transition">
                        &larr; Back to Dashboard
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-12">
            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Upload Payment Proof</h1>
                    <p class="text-gray-600">Upload a screenshot or photo of your payment receipt</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8">
                    <!-- Application Summary -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3">Application Summary</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-gray-500">Plan:</span>
                                <span class="font-medium text-gray-800 ml-1">{{ ucfirst($application->plan->name) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Duration:</span>
                                <span class="font-medium text-gray-800 ml-1">{{ $application->duration_months }} month(s)</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Shop:</span>
                                <span class="font-medium text-gray-800 ml-1">{{ $application->shop_name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Amount:</span>
                                <span class="font-bold text-blue-600 ml-1">&euro;{{ number_format($application->plan->calculatePrice($application->duration_months), 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer Details -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                            </svg>
                            <div class="text-sm">
                                <p class="font-medium text-blue-800 mb-2">Bank Transfer Details</p>
                                <div class="space-y-1 text-blue-700">
                                    <p><span class="font-medium">IBAN:</span> XX00 0000 0000 0000 0000</p>
                                    <p><span class="font-medium">Bank:</span> Your Bank Name</p>
                                    <p><span class="font-medium">Reference:</span> <span class="bg-blue-100 px-2 py-0.5 rounded font-mono">APP-{{ $application->id }}</span></p>
                                    <p><span class="font-medium">Amount:</span> &euro;{{ number_format($application->plan->calculatePrice($application->duration_months), 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($application->hasPaymentProof())
                        <!-- Already Uploaded -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center gap-2 text-green-700 mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="font-medium">Payment proof already uploaded</span>
                            </div>
                            <p class="text-sm text-green-600">You can upload a new image to replace the existing one.</p>
                        </div>
                    @endif

                    <!-- Upload Form -->
                    <form action="{{ route('plan.payment-proof.upload', $application) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Payment Receipt Image <span class="text-red-500">*</span>
                            </label>

                            <!-- Upload Area -->
                            <div class="upload-area rounded-lg p-8 text-center cursor-pointer" id="dropZone" onclick="document.getElementById('payment_proof').click()">
                                <input type="file" id="payment_proof" name="payment_proof" accept="image/*" class="hidden" required>

                                <div id="uploadPlaceholder">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-600 font-medium">Click to upload or drag and drop</p>
                                    <p class="text-gray-400 text-sm mt-1">PNG, JPG, GIF up to 5MB</p>
                                </div>

                                <div id="imagePreview" class="hidden">
                                    <img id="previewImg" src="" alt="Preview" class="preview-image mx-auto rounded-lg shadow">
                                    <p id="fileName" class="text-sm text-gray-600 mt-2"></p>
                                </div>
                            </div>

                            @error('payment_proof')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn"
                            class="w-full py-4 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg flex items-center justify-center gap-2 disabled:bg-gray-400 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload Payment Proof
                        </button>
                    </form>
                </div>

                <!-- Help Text -->
                <div class="text-center mt-6 text-sm text-gray-500">
                    <p>Need help? Contact us at <a href="mailto:info@mobileshop.com" class="text-blue-600 hover:underline">info@mobileshop.com</a></p>
                </div>
            </div>
        </main>
    </div>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('payment_proof');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const fileName = document.getElementById('fileName');

        // Drag and drop handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
        });

        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                showPreview(files[0]);
            }
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                showPreview(e.target.files[0]);
            }
        });

        function showPreview(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    fileName.textContent = file.name;
                    uploadPlaceholder.classList.add('hidden');
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>
