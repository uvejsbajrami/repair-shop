<?php

use App\Models\ShopSetting;

function shop_settings()
{
    if (!auth()->check()) {
        return null;
    }

    $shop = ShopSetting::whereHas('shop', function ($query) {
        $query->where('owner_id', auth()->id());
    })->first();

    // Temporary debug - remove this after viewing

    return $shop;
}