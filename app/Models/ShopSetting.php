<?php

namespace App\Models;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'logo_path',
        'primary_color',
        'accent_color',
        'currency_code',
        'currency_symbol',
        'remove_branding',
        'language_code',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
