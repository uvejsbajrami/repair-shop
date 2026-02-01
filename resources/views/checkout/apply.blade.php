<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Apply for {{ $plan->name }} Plan</title>

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
                    <a href="/" class="text-white hover:text-blue-200 transition">
                        &larr; Back to Home
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-12">
            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Apply for {{ ucfirst($plan->name) }} Plan</h1>
                    <p class="text-gray-600">Pay via Cash or Bank Transfer</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8">
                    <!-- Plan Summary -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ ucfirst($plan->name) }} Plan</h3>
                                <p class="text-sm text-gray-600">Starting at <span class="font-bold text-blue-600">&euro;{{ number_format($plan->price_monthly, 2) }}</span>/month</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <!-- Bank Icon -->
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                    </svg>
                                </div>
                                <!-- Cash Icon -->
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Banner -->
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-amber-800">
                                <p class="font-medium mb-1">How it works:</p>
                                <ol class="list-decimal list-inside space-y-1 text-amber-700">
                                    <li>Submit your application below</li>
                                    <li>We'll contact you with payment details</li>
                                    <li>Once payment is confirmed, your account will be activated</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Application Form -->
                    <form action="{{ route('plan.apply.submit') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                        <!-- Duration -->
                        <div>
                           <livewire:update-price-plan :slug="$plan->slug" :price-per-month="$plan->price_monthly" />
                        </div>

                        <!-- Shop Name -->
                        <div>
                            <label for="shop_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Shop Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="shop_name" name="shop_name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Your shop name" value="{{ old('shop_name') }}">
                            @error('shop_name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <hr class="my-6">
                        <h3 class="text-lg font-medium text-gray-800">Contact Information</h3>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Your Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="John Doe" value="{{ old('name', auth()->user()?->name) }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="john@example.com" value="{{ old('email', auth()->user()?->email) }}">
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                Phone Number
                            </label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="+383 44 123 456" value="{{ old('phone') }}">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                                Additional Message (Optional)
                            </label>
                            <textarea id="message" name="message" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Any questions or special requests...">{{ old('message') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full py-4 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Submit Application
                        </button>

                        <p class="text-xs text-gray-500 text-center">
                            We'll contact you within 24 hours with payment instructions.
                        </p>
                    </form>
                </div>

                <!-- Alternative Option -->
                <div class="text-center mt-6">
                    <p class="text-gray-600 mb-2">Want instant access?</p>
                    <a href="{{ route('checkout', $plan->slug) }}" class="inline-flex items-center gap-2 text-blue-600 font-medium hover:text-blue-700 transition">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z"/>
                        </svg>
                        Pay with PayPal or Card instead
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
