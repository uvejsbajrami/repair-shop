<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     * Ensures the user is an employee with an active account.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user is an employee
        if ($user->role !== 'employee' || !$user->employee) {
            abort(403, 'Access denied. This area is for employees only.');
        }

        // Check if employee account is active
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Your employee account has been deactivated. Please contact your shop owner.');
        }

        // Check if employee's shop exists and is active
        $shop = $user->employee->shop;
        if (!$shop || !$shop->is_active) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'The shop you work for is no longer active.');
        }

        return $next($request);
    }
}
