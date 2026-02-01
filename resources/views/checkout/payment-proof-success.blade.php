<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Payment Proof Uploaded - MobileShop</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="gradient-bg text-white py-6">
            <div class="container mx-auto px-6">
                <div class="flex items-center justify-center">
                    <a href="/" class="flex items-center">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-xl font-bold">MobileShop</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center px-6 py-12">
            <div class="max-w-md w-full text-center">
                <!-- Success Icon -->
                <div class="mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Success Message -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Payment Proof Uploaded!</h1>
                    <p class="text-gray-600 mb-6">
                        Thank you! We've received your payment proof and will verify it shortly.
                    </p>

                    <!-- Application Summary -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                        <h3 class="font-medium text-gray-800 mb-2">Application Details</h3>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="text-gray-500">Plan:</span> {{ ucfirst($application->plan->name) }}</p>
                            <p><span class="text-gray-500">Shop:</span> {{ $application->shop_name }}</p>
                            <p><span class="text-gray-500">Reference:</span> <span class="font-mono bg-gray-200 px-1 rounded">APP-{{ $application->id }}</span></p>
                        </div>
                    </div>

                    <!-- What's Next -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-6 text-left">
                        <h3 class="font-semibold text-blue-800 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            What happens next?
                        </h3>
                        <ul class="space-y-2 text-sm text-blue-700">
                            <li class="flex items-start gap-2">
                                <span class="w-5 h-5 bg-blue-200 text-blue-800 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold">1</span>
                                <span>Our team will review your payment proof</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-5 h-5 bg-blue-200 text-blue-800 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold">2</span>
                                <span>Once verified, we'll activate your account</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-5 h-5 bg-blue-200 text-blue-800 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold">3</span>
                                <span>You'll receive an email confirmation</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Status Badge -->
                    <div class="mb-6">
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Awaiting Verification
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('owner.dashboard') }}" class="flex-1 inline-flex items-center justify-center gap-2 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Go to Dashboard
                        </a>
                        <a href="{{ route('plan.payment-proof', $application) }}" class="flex-1 inline-flex items-center justify-center gap-2 py-3 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload Different Image
                        </a>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="mt-6 text-sm text-gray-500">
                    <p>Questions? Contact us at <a href="mailto:info@mobileshop.com" class="text-blue-600 hover:underline">info@mobileshop.com</a></p>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
