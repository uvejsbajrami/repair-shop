@extends('layouts.owner')

@section('title', 'Shop Settings')

@section('content')
    <div class="max-w-4xl">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Shop Settings</h1>
            <p class="text-gray-600 mt-1">Customize your shop's appearance and regional settings.</p>
        </div>

        <form action="{{ route('owner.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Regional Settings Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    Regional Settings
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Language -->
                    <div>
                        <label for="language_code" class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                        <select name="language_code" id="language_code"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="en" {{ old('language_code', $settings->language_code) == 'en' ? 'selected' : '' }}>English</option>
                            <option value="mk" {{ old('language_code', $settings->language_code) == 'mk' ? 'selected' : '' }}>Macedonian (Македонски)</option>
                            <option value="sq" {{ old('language_code', $settings->language_code) == 'sq' ? 'selected' : '' }}>Albanian (Shqip)</option>
                            <option value="de" {{ old('language_code', $settings->language_code) == 'de' ? 'selected' : '' }}>German (Deutsch)</option>
                            <option value="fr" {{ old('language_code', $settings->language_code) == 'fr' ? 'selected' : '' }}>French (Français)</option>
                            <option value="es" {{ old('language_code', $settings->language_code) == 'es' ? 'selected' : '' }}>Spanish (Español)</option>
                            <option value="it" {{ old('language_code', $settings->language_code) == 'it' ? 'selected' : '' }}>Italian (Italiano)</option>
                            <option value="tr" {{ old('language_code', $settings->language_code) == 'tr' ? 'selected' : '' }}>Turkish (Türkçe)</option>
                            <option value="sr" {{ old('language_code', $settings->language_code) == 'sr' ? 'selected' : '' }}>Serbian (Srpski)</option>
                            <option value="bg" {{ old('language_code', $settings->language_code) == 'bg' ? 'selected' : '' }}>Bulgarian (Български)</option>
                            <option value="el" {{ old('language_code', $settings->language_code) == 'el' ? 'selected' : '' }}>Greek (Ελληνικά)</option>
                        </select>
                        @error('language_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Currency -->
                    <div>
                        <label for="currency_code" class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                        <select name="currency_code" id="currency_code"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            onchange="updateCurrencySymbol(this.value)">
                            <option value="EUR" data-symbol="€" {{ old('currency_code', $settings->currency_code) == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                            <option value="USD" data-symbol="$" {{ old('currency_code', $settings->currency_code) == 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                            <option value="GBP" data-symbol="£" {{ old('currency_code', $settings->currency_code) == 'GBP' ? 'selected' : '' }}>British Pound (GBP)</option>
                            <option value="MKD" data-symbol="ден" {{ old('currency_code', $settings->currency_code) == 'MKD' ? 'selected' : '' }}>Macedonian Denar (MKD)</option>
                            <option value="ALL" data-symbol="L" {{ old('currency_code', $settings->currency_code) == 'ALL' ? 'selected' : '' }}>Albanian Lek (ALL)</option>
                            <option value="RSD" data-symbol="дин" {{ old('currency_code', $settings->currency_code) == 'RSD' ? 'selected' : '' }}>Serbian Dinar (RSD)</option>
                            <option value="BGN" data-symbol="лв" {{ old('currency_code', $settings->currency_code) == 'BGN' ? 'selected' : '' }}>Bulgarian Lev (BGN)</option>
                            <option value="TRY" data-symbol="₺" {{ old('currency_code', $settings->currency_code) == 'TRY' ? 'selected' : '' }}>Turkish Lira (TRY)</option>
                            <option value="CHF" data-symbol="CHF" {{ old('currency_code', $settings->currency_code) == 'CHF' ? 'selected' : '' }}>Swiss Franc (CHF)</option>
                        </select>
                        @error('currency_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Currency Symbol -->
                    <div>
                        <label for="currency_symbol" class="block text-sm font-medium text-gray-700 mb-2">Currency Symbol</label>
                        <input type="text" name="currency_symbol" id="currency_symbol"
                            value="{{ old('currency_symbol', $settings->currency_symbol ?? '€') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            maxlength="5">
                        <p class="mt-1 text-sm text-gray-500">The symbol shown next to prices (e.g., €, $, ден)</p>
                        @error('currency_symbol')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Branding Settings Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01">
                        </path>
                    </svg>
                    Branding & Appearance
                </h2>

                {{-- Shop Logo - Coming Soon
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Shop Logo</label>
                    <div class="flex items-start space-x-6">
                        <div class="flex-shrink-0">
                            @if($settings->logo_path)
                                <img src="{{ Storage::url($settings->logo_path) }}" alt="Shop Logo"
                                    class="w-24 h-24 object-contain rounded-lg border border-gray-200 bg-gray-50">
                            @else
                                <div class="w-24 h-24 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="logo" id="logo" accept="image/jpeg,image/png,image/jpg,image/svg+xml"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            <p class="mt-2 text-sm text-gray-500">PNG, JPG, or SVG. Max 2MB. Recommended: 200x200px</p>
                            @if($settings->logo_path)
                                <label class="mt-2 flex items-center">
                                    <input type="checkbox" name="remove_logo" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span class="ml-2 text-sm text-red-600">Remove current logo</span>
                                </label>
                            @endif
                            @error('logo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                --}}

                <!-- Colors -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Primary Color -->
                    <div>
                        <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-2">Primary Color</label>
                        <div class="flex items-center space-x-3">
                            <input type="color" name="primary_color" id="primary_color"
                                value="{{ old('primary_color', $settings->primary_color ?? '#2563eb') }}"
                                class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                            <input type="text" id="primary_color_text"
                                value="{{ old('primary_color', $settings->primary_color ?? '#2563eb') }}"
                                class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition uppercase"
                                maxlength="7" pattern="^#[0-9A-Fa-f]{6}$"
                                onchange="document.getElementById('primary_color').value = this.value">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Used for buttons and main accents</p>
                        @error('primary_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Accent Color -->
                    <div>
                        <label for="accent_color" class="block text-sm font-medium text-gray-700 mb-2">Accent Color</label>
                        <div class="flex items-center space-x-3">
                            <input type="color" name="accent_color" id="accent_color"
                                value="{{ old('accent_color', $settings->accent_color ?? '#22c55e') }}"
                                class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                            <input type="text" id="accent_color_text"
                                value="{{ old('accent_color', $settings->accent_color ?? '#22c55e') }}"
                                class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition uppercase"
                                maxlength="7" pattern="^#[0-9A-Fa-f]{6}$"
                                onchange="document.getElementById('accent_color').value = this.value">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Used for success states and highlights</p>
                        @error('accent_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Remove Branding Toggle -->
                <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg p-4 border border-purple-100">
                    <label class="flex items-start cursor-pointer">
                        <input type="checkbox" name="remove_branding" value="1"
                            {{ old('remove_branding', $settings->remove_branding) ? 'checked' : '' }}
                            class="mt-1 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <div class="ml-3">
                            <span class="text-sm font-medium text-gray-900">Remove Platform Branding</span>
                            <p class="text-sm text-gray-600 mt-0.5">Hide "Powered by {{ config('app.name') }}" from your customer-facing pages like repair tracking.</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    Preview
                </h2>
                <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                    <p class="text-sm text-gray-600 mb-3">Sample price display:</p>
                    <div class="flex items-center space-x-4">
                        <span id="preview_price" class="text-2xl font-bold text-gray-800">
                            <span id="preview_symbol">{{ $settings->currency_symbol ?? '€' }}</span>99.99
                        </span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium" id="preview_badge"
                            style="background-color: {{ $settings->primary_color ?? '#2563eb' }}20; color: {{ $settings->primary_color ?? '#2563eb' }};">
                            Primary Color
                        </span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium" id="preview_accent_badge"
                            style="background-color: {{ $settings->accent_color ?? '#22c55e' }}20; color: {{ $settings->accent_color ?? '#22c55e' }};">
                            Accent Color
                        </span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Settings
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    // Update currency symbol when currency is changed
    function updateCurrencySymbol(currencyCode) {
        const select = document.getElementById('currency_code');
        const selectedOption = select.options[select.selectedIndex];
        const symbol = selectedOption.dataset.symbol;
        document.getElementById('currency_symbol').value = symbol;
        document.getElementById('preview_symbol').textContent = symbol;
    }

    // Sync color pickers with text inputs
    document.getElementById('primary_color').addEventListener('input', function() {
        document.getElementById('primary_color_text').value = this.value.toUpperCase();
        updatePreviewColors();
    });

    document.getElementById('accent_color').addEventListener('input', function() {
        document.getElementById('accent_color_text').value = this.value.toUpperCase();
        updatePreviewColors();
    });

    document.getElementById('primary_color_text').addEventListener('input', function() {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            document.getElementById('primary_color').value = this.value;
            updatePreviewColors();
        }
    });

    document.getElementById('accent_color_text').addEventListener('input', function() {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            document.getElementById('accent_color').value = this.value;
            updatePreviewColors();
        }
    });

    document.getElementById('currency_symbol').addEventListener('input', function() {
        document.getElementById('preview_symbol').textContent = this.value;
    });

    function updatePreviewColors() {
        const primaryColor = document.getElementById('primary_color').value;
        const accentColor = document.getElementById('accent_color').value;

        const primaryBadge = document.getElementById('preview_badge');
        primaryBadge.style.backgroundColor = primaryColor + '20';
        primaryBadge.style.color = primaryColor;

        const accentBadge = document.getElementById('preview_accent_badge');
        accentBadge.style.backgroundColor = accentColor + '20';
        accentBadge.style.color = accentColor;
    }
</script>
@endpush
