<?php
function currency_symbol()
{
    $settings = shop_settings();

    if (!$settings) return '';

    return match ($settings->currency_code) {
        'EUR' => '€',
        'MKD' => 'ден',
        // 'USD' => '$', // Uncomment when needed
        default => '',
    };
}