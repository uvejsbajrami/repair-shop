<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('checkout.checkout_title', ['plan' => ucfirst($plan->name)]) }}</title>

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
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <span class="ml-3 text-xl font-bold">MobileShop</span>
                    </a>
                    <a href="/" class="text-white hover:text-blue-200 transition">
                        &larr; {{ __('checkout.back_to_home') }}
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-12">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">{{ __('checkout.complete_purchase') }}</h1>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Order Summary -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('checkout.order_summary') }}</h2>

                        <div class="border-b pb-4 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">{{ __('checkout.plan') }}</span>
                                <span class="font-semibold text-blue-600">{{ ucfirst($plan->name) }}</span>
                            </div>
                            <ul class="text-sm text-gray-500 space-y-1 mt-3">
                                <li>{{ __('checkout.active_repairs', ['count' => $plan->max_active_repairs]) }}</li>
                                <li>{{ $plan->max_employees == 0 ? __('checkout.no_employees') : __('checkout.employees', ['count' => $plan->max_employees]) }}</li>
                                <li>{{ $plan->drag_and_drop ? __('checkout.drag_drop_board') : __('checkout.basic_board') }}</li>
                                @if ($plan->exports)
                                    <li>{{ __('checkout.export_reports') }}</li>
                                @endif
                            </ul>
                        </div>

                        <!-- Duration Selector -->
                        <div class="mb-4">
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('checkout.subscription_duration') }}
                            </label>
                            <select id="duration" name="duration"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @foreach ($durations as $months => $label)
                                    <option value="{{ $months }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">{{ __('checkout.monthly_price') }}</span>
                                <span id="monthly-price">&euro;{{ number_format($plan->price_monthly, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-2" id="original-price-row"
                                style="display: none;">
                                <span class="text-gray-600">{{ __('checkout.original_price') }}</span>
                                <span id="original-price" class="line-through text-gray-400"></span>
                            </div>
                            <div class="flex justify-between items-center mb-2" id="savings-row" style="display: none;">
                                <span class="text-green-600 font-medium">{{ __('checkout.you_save') }}</span>
                                <span id="savings" class="text-green-600 font-medium"></span>
                            </div>
                            <div class="border-t pt-2 mt-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-800">{{ __('checkout.total') }}</span>
                                    <span id="total-price" class="text-2xl font-bold text-blue-600">
                                        &euro;{{ number_format($priceBreakdown['total_price'], 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Form -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('checkout.your_details') }}</h2>

                        <form id="checkout-form" class="space-y-4">
                            @csrf

                            <!-- Shop Details -->
                            <div>
                                <label for="shop_name" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('checkout.shop_name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="shop_name" name="shop_name" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="{{ __('checkout.shop_name_placeholder') }}">
                            </div>

                            <div>
                                <label for="shop_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('checkout.phone_number') }}
                                </label>
                                <input type="tel" id="shop_phone" name="shop_phone"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="+1 (555) 000-0000">
                            </div>

                            <div>
                                <label for="shop_address" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('checkout.address') }}
                                </label>
                                <input type="text" id="shop_address" name="shop_address"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="123 Business St.">
                            </div>

                            <div>
                                <label for="language_code" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('checkout.language') }} <span class="text-red-500">*</span>
                                </label>
                                <select id="language_code" name="language_code" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="en" selected>English</option>
                                    <option value="sq">Shqip (Albanian)</option>
                                </select>
                            </div>

                            <div>
                                <label for="currency_code" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('checkout.currency') }} <span class="text-red-500">*</span>
                                </label>
                                <select id="currency_code" name="currency_code" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="EUR" selected>EUR (&euro;)</option>
                                    <option value="MKD">MKD (ден)</option>
                                </select>
                            </div>

                            @guest
                                <hr class="my-4">
                                <h3 class="text-lg font-medium text-gray-800">{{ __('checkout.account_details') }}</h3>

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ __('checkout.your_name') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="John Doe">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ __('checkout.email') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="john@example.com">
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ __('checkout.password') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="password" name="password" required minlength="8"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="{{ __('checkout.min_characters') }}">
                                </div>
                            @endguest
                        </form>

                        <hr class="my-6">

                        <!-- Error Messages -->
                        <div id="error-message"
                            class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                        </div>

                        <!-- PayPal Buttons -->
                        <div id="paypal-button-container"></div>

                        <p class="text-xs text-gray-500 text-center mt-4">
                            {{ __('checkout.terms_agreement') }}
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency=EUR"></script>

    <script>
        const planId = {{ $plan->id }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Duration change handler
        document.getElementById('duration').addEventListener('change', async function() {
            const durationMonths = this.value;

            try {
                const response = await fetch('{{ route('checkout.calculate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        plan_id: planId,
                        duration_months: durationMonths,
                    }),
                });

                const data = await response.json();

                // Update price display
                document.getElementById('total-price').innerHTML = '&euro;' + data.total_price.toFixed(2);

                // Show/hide savings
                if (data.savings > 0) {
                    document.getElementById('original-price-row').style.display = 'flex';
                    document.getElementById('savings-row').style.display = 'flex';
                    document.getElementById('original-price').innerHTML = '&euro;' + data.original_price
                        .toFixed(2);
                    document.getElementById('savings').innerHTML = '&euro;' + data.savings.toFixed(2) +
                    ' (15%)';
                } else {
                    document.getElementById('original-price-row').style.display = 'none';
                    document.getElementById('savings-row').style.display = 'none';
                }
            } catch (error) {
                console.error('Error calculating price:', error);
            }
        });

        // Validate form
        function validateForm() {
            const shopName = document.getElementById('shop_name').value.trim();
            if (!shopName) {
                showError('Please enter your shop name.');
                return false;
            }

            @guest
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            if (!name) {
                showError('Please enter your name.');
                return false;
            }
            if (!email) {
                showError('Please enter your email.');
                return false;
            }
            if (!password || password.length < 8) {
                showError('Please enter a password with at least 8 characters.');
                return false;
            }
        @endguest

        return true;
        }

        function showError(message) {
            const errorDiv = document.getElementById('error-message');
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
        }

        function hideError() {
            document.getElementById('error-message').classList.add('hidden');
        }

        // PayPal Buttons
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'blue',
                shape: 'rect',
                label: 'paypal',
            },

            createOrder: async function(data, actions) {
                hideError();

                if (!validateForm()) {
                    return Promise.reject();
                }

                const formData = {
                    plan_id: planId,
                    duration_months: document.getElementById('duration').value,
                    shop_name: document.getElementById('shop_name').value,
                    shop_phone: document.getElementById('shop_phone').value,
                    shop_address: document.getElementById('shop_address').value,
                    language_code: document.getElementById('language_code').value,
                    currency_code: document.getElementById('currency_code').value,
                    @guest
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value,
                @endguest
            };

            try {
                const response = await fetch('{{ route('checkout.create-order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(formData),
                });

                const order = await response.json();

                if (order.error) {
                    showError(order.error);
                    return Promise.reject(order.error);
                }

                return order.id;
            } catch (error) {
                showError('An error occurred. Please try again.');
                return Promise.reject(error);
            }
        },

        onApprove: async function(data, actions) {
                try {
                    const response = await fetch('{{ route('checkout.capture-order') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            order_id: data.orderID,
                        }),
                    });

                    const result = await response.json();

                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful!',
                            text: result.message || 'Your subscription is now active.',
                            confirmButtonText: 'Go to Dashboard',
                            confirmButtonColor: '#2563eb',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(() => {
                            window.location.href = result.redirect;
                        });
                    } else {
                        showError(result.error || 'Payment failed. Please try again.');
                    }
                } catch (error) {
                    showError('An error occurred while processing your payment.');
                }
            },

            onError: function(err) {
                console.error('PayPal error:', err);
                let errorMessage = 'An error occurred with PayPal. Please try again.';
                if (err && err.message) {
                    errorMessage = err.message;
                }
                showError(errorMessage);
            },

            onCancel: function() {
                showError('Payment was cancelled. You can try again when ready.');
            }
        }).render('#paypal-button-container');
    </script>
</body>

</html>
