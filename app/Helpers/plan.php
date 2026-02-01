<?php

use App\Models\Shop;

function current_plan()
{
    if (!auth()->check()) {
        return null;
    }

    $shop = Shop::with('shopPlan.plan')
        ->where('owner_id', auth()->id())
        ->first();

    return $shop?->shopPlan?->plan?->name;
}
