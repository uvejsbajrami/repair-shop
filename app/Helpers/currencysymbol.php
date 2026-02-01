<?php
function currency_symbol()
{
    $settings = shop_settings();

    if (!$settings) return '';

    return match ($settings->currency_code) {
        'USD' => '$',
        'EUR' => '€',
        'MKD' => 'ден',
        default => '',
    };
}