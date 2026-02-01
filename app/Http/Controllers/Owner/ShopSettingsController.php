<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\ShopSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopSettingsController extends Controller
{
    public function index()
    {
        $shop = Shop::where('owner_id', auth()->id())->first();

        if (!$shop) {
            return redirect()->route('owner.dashboard')->with('error', 'Shop not found.');
        }

        // Check if user has Pro plan with branding feature
        $plan = $shop->shopPlan?->plan;
        if (!$plan || !$plan->branding) {
            return redirect()->route('owner.dashboard')->with('error', 'Shop Settings is only available for Pro plan.');
        }

        $settings = $shop->settings ?? new ShopSetting(['shop_id' => $shop->id]);

        return view('owner.settings', compact('shop', 'settings'));
    }

    public function update(Request $request)
    {
        $shop = Shop::where('owner_id', auth()->id())->first();

        if (!$shop) {
            return redirect()->route('owner.dashboard')->with('error', 'Shop not found.');
        }

        // Check if user has Pro plan with branding feature
        $plan = $shop->shopPlan?->plan;
        if (!$plan || !$plan->branding) {
            return redirect()->route('owner.dashboard')->with('error', 'Shop Settings is only available for Pro plan.');
        }

        $validated = $request->validate([
            'language_code' => 'required|string|max:5',
            'currency_code' => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:5',
            'primary_color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'accent_color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'remove_branding' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $settings = $shop->settings ?? new ShopSetting(['shop_id' => $shop->id]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
                Storage::disk('public')->delete($settings->logo_path);
            }

            $logoPath = $request->file('logo')->store('shop-logos', 'public');
            $settings->logo_path = $logoPath;
        }

        // Handle logo removal
        if ($request->has('remove_logo') && $request->remove_logo) {
            if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $settings->logo_path = null;
        }

        $settings->shop_id = $shop->id;
        $settings->language_code = $validated['language_code'];
        $settings->currency_code = $validated['currency_code'];
        $settings->currency_symbol = $validated['currency_symbol'];
        $settings->primary_color = $validated['primary_color'];
        $settings->accent_color = $validated['accent_color'];
        $settings->remove_branding = $request->boolean('remove_branding');
        $settings->save();

        return redirect()->route('owner.settings')->with('success', 'Shop settings updated successfully.');
    }
}
