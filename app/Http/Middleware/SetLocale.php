<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * Set the application locale based on the shop's language preference.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            $shop = null;

            // Get shop based on user role
            if ($user->isOwner() && $user->shop) {
                $shop = $user->shop;
            } elseif ($user->isEmployee() && $user->employee?->shop) {
                $shop = $user->employee->shop;
            }

            // Set locale from shop settings if available
            if ($shop && $shop->settings?->language_code) {
                App::setLocale($shop->settings->language_code);
            }
        }

        return $next($request);
    }
}
