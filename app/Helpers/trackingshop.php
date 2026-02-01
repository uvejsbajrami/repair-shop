<?php 

use App\Models\Shop;
use App\Models\ShopSetting;

function trackingshop($shop_id)
{
    if (!$shop_id) {
        return null;
    }
    $shopSetting = ShopSetting::where('shop_id', $shop_id)->first();
    return $shopSetting;
}

function getCurrencySymbol($shop_id)
{
    if (!$shop_id) {
        return '€';
    }
    $shopSetting = ShopSetting::where('shop_id', $shop_id)->first();
    return $shopSetting && $shopSetting->currency_symbol ? $shopSetting->currency_symbol : '€';
}