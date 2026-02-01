<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Renew Subscription - {{ $plan->name }} Plan</title>

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
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center">
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">Renew Your Subscription</h1>
                <p class="text-gray-600 text-center mb-8">Keep your shop running without interruption</p>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <!-- Current Plan Info -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $shop->name }}</h3>
                                <p class="text-sm text-gray-600">Current Plan: <span class="font-medium text-blue-600">{{ ucfirst($plan->name) }}</span></p>
                            </div>
                            @if($shopPlan->status === 'grace')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Grace Period</span>
                            @elseif($shopPlan->status === 'expired')
                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Expired</span>
                            @else
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Active</span>
                            @endif
                        </div>
                        @if($shopPlan->ends_at)
                        <p class="text-sm text-gray-500 mt-2">
                            @if($shopPlan->status === 'expired' || $shopPlan->status === 'grace')
                            Ended on: {{ \Carbon\Carbon::parse($shopPlan->ends_at)->format('M d, Y') }}
                            @else
                            Expires on: {{ \Carbon\Carbon::parse($shopPlan->ends_at)->format('M d, Y') }}
                            @endif
                        </p>
                        @endif
                    </div>

                    <!-- Plan Features -->
                    <div class="border-b pb-4 mb-4">
                        <h4 class="font-medium text-gray-700 mb-2">Plan Features</h4>
                        <ul class="text-sm text-gray-500 space-y-1">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $plan->max_active_repairs }} active repairs
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $plan->max_employees == 0 ? 'No' : $plan->max_employees }} employees
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $plan->drag_and_drop ? 'Drag & Drop board' : 'Basic board' }}
                            </li>
                            @if($plan->exports)
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Export reports
                            </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Duration Selector -->
                    <div class="mb-4">
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                            Renewal Duration
                        </label>
                        <select id="duration" name="duration"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @foreach($durations as $months => $label)
                            <option value="{{ $months }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Monthly Price</span>
                            <span id="monthly-price">&euro;{{ number_format($plan->price_monthly, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-2" id="original-price-row" style="display: none;">
                            <span class="text-gray-600">Original Price</span>
                            <span id="original-price" class="line-through text-gray-400"></span>
                        </div>
                        <div class="flex justify-between items-center mb-2" id="savings-row" style="display: none;">
                            <span class="text-green-600 font-medium">You Save</span>
                            <span id="savings" class="text-green-600 font-medium"></span>
                        </div>
                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-800">Total</span>
                                <span id="total-price" class="text-2xl font-bold text-blue-600">
                                    &euro;{{ number_format($priceBreakdown['total_price'], 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Error Messages -->
                    <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    </div>

                    <!-- PayPal Buttons -->
                    <div id="paypal-button-container"></div>

                    <p class="text-xs text-gray-500 text-center mt-4">
                        Your subscription will be extended from your current end date (or from today if expired).
                    </p>
                </div>

                <!-- Alternative Option: Apply for Renewal -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-gray-100 text-gray-500">or</span>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-gray-600 mb-3">Prefer to pay via cash or bank transfer?</p>
                        <a href="{{ route('renew.apply') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition border border-gray-300">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                            </svg>
                            Apply for Renewal
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <p class="text-xs text-gray-500 mt-2">Submit an application and we'll contact you with payment details</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency=EUR"></script>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Duration change handler
        document.getElementById('duration').addEventListener('change', async function() {
            const durationMonths = this.value;

            try {
                const response = await fetch('{{ route("renew.calculate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
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
                    document.getElementById('original-price').innerHTML = '&euro;' + data.original_price.toFixed(2);
                    document.getElementById('savings').innerHTML = '&euro;' + data.savings.toFixed(2) + ' (15%)';
                } else {
                    document.getElementById('original-price-row').style.display = 'none';
                    document.getElementById('savings-row').style.display = 'none';
                }
            } catch (error) {
                console.error('Error calculating price:', error);
            }
        });

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

                const formData = {
                    duration_months: document.getElementById('duration').value,
                };

                try {
                    const response = await fetch('{{ route("renew.create-order") }}', {
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
                    const response = await fetch('{{ route("renew.capture-order") }}', {
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
                            title: 'Renewal Successful!',
                            text: result.message || 'Your subscription has been renewed.',
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
                showError('An error occurred with PayPal. Please try again.');
                console.error('PayPal error:', err);
            },

            onCancel: function() {
                showError('Payment was cancelled. You can try again when ready.');
            }
        }).render('#paypal-button-container');
    </script>
</body>

</html>
